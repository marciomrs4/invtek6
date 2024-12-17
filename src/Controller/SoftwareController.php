<?php

namespace App\Controller;

use App\Entity\Equipamento;
use App\Entity\EquipamentoHasSoftware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Software;
use App\Form\SoftwareType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Software controller.
 *
 * @Route("/cadastro/software")
 */
#[Route('/cadastro/software')]
class SoftwareController extends AbstractController
{
    /**
     * Lists all Software entities.
     *
     * @Route("/", name="cadastro_software_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_software_index', methods:['GET'])]
    public function indexAction(EntityManagerInterface $em)
    {

        $softwares = $em->getRepository(Software::class)
                        ->listAllSoftware();

        return $this->render('software/index.html.twig', array(
            'softwares' => $softwares,
        ));
    }

    /**
     * Creates a new Software entity.
     *
     * @Route("/new", name="cadastro_software_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_software_new', methods:['GET','POST'])]
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $software = new Software();

        $form = $this->createForm(SoftwareType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($software);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_software_show', array('id' => $software->getId()));
        }

        return $this->render('software/new.html.twig', array(
            'software' => $software,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Software entity.
     *
     * @Route("/{id}", name="cadastro_software_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_software_show', methods:['GET'])]
    public function showAction(Software $software, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($software);

        $tags = $em->getRepository(\App\Entity\SoftwareTag::class)
            ->findBy(array('software'=>$software));

        $quantidadeEquipamento = $em->getRepository(Software::class)
            ->countSoftwareOnEquipamento($software->getId());

        return $this->render('software/show.html.twig', array(
            'software' => $software,
            'quantidadeEquipamento' => $quantidadeEquipamento,
            'tags' => $tags,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Software entity.
     *
     * @Route("/{id}/edit", name="cadastro_software_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_software_edit', methods:['GET','POST'])]
    public function editAction(Request $request, Software $software, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($software);
        $editForm = $this->createForm(SoftwareType::class, $software);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($software);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_software_show', array('id' => $software->getId()));
        }

        return $this->render('software/edit.html.twig', array(
            'software' => $software,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Software entity.
     *
     * @Route("/{id}", name="cadastro_software_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_software_delete', methods:['POST'])]
    public function deleteAction(Request $request, Software $software, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($software);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_software_index');
    }

    /**
     * Creates a form to delete a Software entity.
     *
     * @param Software $software The Software entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Software $software): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_software_delete', array('id' => $software->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
