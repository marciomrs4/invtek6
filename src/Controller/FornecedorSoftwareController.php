<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\FornecedorSoftware;
use App\Form\FornecedorSoftwareType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * FornecedorSoftware controller.
 *
 * @Route("/cadastro/fornecedorsoftware")
 */
#[Route('/cadastro/fornecedorsoftware')]     
class FornecedorSoftwareController extends AbstractController
{
    /**
     * Lists all FornecedorSoftware entities.
     *
     * @Route("/", name="cadastro_fornecedorsoftware_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_fornecedorsoftware_index', methods:['GET'])]     
    public function indexAction(EntityManagerInterface $em)
    {

        $fornecedorSoftwares = $em->getRepository(FornecedorSoftware::class)->findAll();

        return $this->render('fornecedorsoftware/index.html.twig', array(
            'fornecedorSoftwares' => $fornecedorSoftwares,
        ));
    }

    /**
     * Creates a new FornecedorSoftware entity.
     *
     * @Route("/new", name="cadastro_fornecedorsoftware_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_fornecedorsoftware_new', methods:['GET','POST'])]     
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $fornecedorSoftware = new FornecedorSoftware();
        $form = $this->createForm(FornecedorSoftwareType::class, $fornecedorSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($fornecedorSoftware);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_fornecedorsoftware_show', array('id' => $fornecedorSoftware->getId()));
        }

        return $this->render('fornecedorsoftware/new.html.twig', array(
            'fornecedorSoftware' => $fornecedorSoftware,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FornecedorSoftware entity.
     *
     * @Route("/{id}", name="cadastro_fornecedorsoftware_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_fornecedorsoftware_show', methods:['GET'])]     
    public function showAction(FornecedorSoftware $fornecedorSoftware)
    {
        $deleteForm = $this->createDeleteForm($fornecedorSoftware);

        return $this->render('fornecedorsoftware/show.html.twig', array(
            'fornecedorSoftware' => $fornecedorSoftware,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FornecedorSoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_fornecedorsoftware_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_fornecedorsoftware_edit', methods:['GET','POST'])]         
    public function editAction(Request $request, FornecedorSoftware $fornecedorSoftware, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($fornecedorSoftware);
        $editForm = $this->createForm(FornecedorSoftwareType::class, $fornecedorSoftware);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($fornecedorSoftware);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_fornecedorsoftware_show', array('id' => $fornecedorSoftware->getId()));
        }

        return $this->render('fornecedorsoftware/edit.html.twig', array(
            'fornecedorSoftware' => $fornecedorSoftware,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FornecedorSoftware entity.
     *
     * @Route("/{id}", name="cadastro_fornecedorsoftware_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_fornecedorsoftware_delete', methods:['POST'])]     
    public function deleteAction(Request $request, FornecedorSoftware $fornecedorSoftware, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($fornecedorSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($fornecedorSoftware);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
            
        }

        return $this->redirectToRoute('cadastro_fornecedorsoftware_index');
    }

    /**
     * Creates a form to delete a FornecedorSoftware entity.
     *
     * @param FornecedorSoftware $fornecedorSoftware The FornecedorSoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FornecedorSoftware $fornecedorSoftware)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_fornecedorsoftware_delete', array('id' => $fornecedorSoftware->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
