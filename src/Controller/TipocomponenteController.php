<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Tipocomponente;
use App\Form\TipocomponenteType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Tipocomponente controller.
 *
 * @Route("/cadastro/tipocomponente")
 */
 #[Route('/cadastro/tipocomponente')]        
class TipocomponenteController extends AbstractController
{
    /**
     * Lists all Tipocomponente entities.
     *
     * @Route("/", name="cadastro_tipocomponente_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_tipocomponente_index', methods:['GET'])]             
    public function indexAction(EntityManagerInterface $em)
    {

        $tipocomponentes = $em->getRepository(Tipocomponente::class)->findAll();

        return $this->render('tipocomponente/index.html.twig', array(
            'tipocomponentes' => $tipocomponentes,
        ));
    }

    /**
     * Creates a new Tipocomponente entity.
     *
     * @Route("/new", name="cadastro_tipocomponente_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_tipocomponente_new', methods:['GET','POST'])]            
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $tipocomponente = new Tipocomponente();
        $form = $this->createForm(TipocomponenteType::class, $tipocomponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tipocomponente);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipocomponente_show', array('id' => $tipocomponente->getId()));
        }

        return $this->render('tipocomponente/new.html.twig', array(
            'tipocomponente' => $tipocomponente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipocomponente entity.
     *
     * @Route("/{id}", name="cadastro_tipocomponente_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_tipocomponente_show', methods:['GET'])]            
    public function showAction(Tipocomponente $tipocomponente)
    {
        $deleteForm = $this->createDeleteForm($tipocomponente);

        return $this->render('tipocomponente/show.html.twig', array(
            'tipocomponente' => $tipocomponente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipocomponente entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipocomponente_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_tipocomponente_edit', methods:['GET','POST'])]            
    public function editAction(Request $request, Tipocomponente $tipocomponente, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($tipocomponente);
        $editForm = $this->createForm(TipocomponenteType::class, $tipocomponente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($tipocomponente);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipocomponente_show', array('id' => $tipocomponente->getId()));
        }

        return $this->render('tipocomponente/edit.html.twig', array(
            'tipocomponente' => $tipocomponente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipocomponente entity.
     *
     * @Route("/{id}", name="cadastro_tipocomponente_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_tipocomponente_delete', methods:['POST'])]            
    public function deleteAction(Request $request, Tipocomponente $tipocomponente, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($tipocomponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($tipocomponente);
            $em->flush();
            
            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_tipocomponente_index');
    }

    /**
     * Creates a form to delete a Tipocomponente entity.
     *
     * @param Tipocomponente $tipocomponente The Tipocomponente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipocomponente $tipocomponente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipocomponente_delete', array('id' => $tipocomponente->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
