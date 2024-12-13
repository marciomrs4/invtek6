<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Tiposoftware;
use App\Form\TiposoftwareType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Tiposoftware controller.
 *
 * @Route("/cadastro/tiposoftware")
 */
#[Route('/cadastro/tiposoftware')]    
class TiposoftwareController extends AbstractController
{
    /**
     * Lists all Tiposoftware entities.
     *
     * @Route("/", name="cadastro_tiposoftware_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_tiposoftware_index', methods:['GET'])]            
    public function indexAction(EntityManagerInterface $em)
    {

        $tiposoftwares = $em->getRepository(Tiposoftware::class)->findAll();

        return $this->render('tiposoftware/index.html.twig', array(
            'tiposoftwares' => $tiposoftwares,
        ));
    }

    /**
     * Creates a new Tiposoftware entity.
     *
     * @Route("/new", name="cadastro_tiposoftware_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_tiposoftware_new', methods:['GET','POST'])]        
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $tiposoftware = new Tiposoftware();
        $form = $this->createForm(TiposoftwareType::class, $tiposoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tiposoftware);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tiposoftware_index', array('id' => $tiposoftware->getId()));
        }

        return $this->render('tiposoftware/new.html.twig', array(
            'tiposoftware' => $tiposoftware,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tiposoftware entity.
     *
     * @Route("/{id}", name="cadastro_tiposoftware_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_tiposoftware_show', methods:['GET'])]        
    public function showAction(Tiposoftware $tiposoftware)
    {
        $deleteForm = $this->createDeleteForm($tiposoftware);

        return $this->render('tiposoftware/show.html.twig', array(
            'tiposoftware' => $tiposoftware,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tiposoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_tiposoftware_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_tiposoftware_edit', methods:['GET','POST'])]        
    public function editAction(Request $request, Tiposoftware $tiposoftware, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($tiposoftware);
        $editForm = $this->createForm(TiposoftwareType::class, $tiposoftware);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($tiposoftware);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tiposoftware_show', array('id' => $tiposoftware->getId()));
        }

        return $this->render('tiposoftware/edit.html.twig', array(
            'tiposoftware' => $tiposoftware,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tiposoftware entity.
     *
     * @Route("/{id}", name="cadastro_tiposoftware_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_tiposoftware_delete', methods:['POST'])]        
    public function deleteAction(Request $request, Tiposoftware $tiposoftware, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($tiposoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($tiposoftware);
            $em->flush();
            
            $this->addFlash('notice','Removido com sucesso!');
            
        }

        return $this->redirectToRoute('cadastro_tiposoftware_index');
    }

    /**
     * Creates a form to delete a Tiposoftware entity.
     *
     * @param Tiposoftware $tiposoftware The Tiposoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tiposoftware $tiposoftware)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tiposoftware_delete', array('id' => $tiposoftware->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
