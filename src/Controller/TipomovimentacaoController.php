<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Tipomovimentacao;
use App\Form\TipomovimentacaoType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Tipomovimentacao controller.
 *
 * @Route("/cadastro/tipomovimentacao")
 */
#[Route('/cadastro/tipomovimentacao')]
class TipomovimentacaoController extends AbstractController
{
    /**
     * Lists all Tipomovimentacao entities.
     *
     * @Route("/", name="cadastro_tipomovimentacao_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_tipomovimentacao_index', methods:['GET'])]    
    public function indexAction(EntityManagerInterface $em)
    {

        $tipomovimentacaos = $em->getRepository(Tipomovimentacao::class)->findAll();

        return $this->render('tipomovimentacao/index.html.twig', array(
            'tipomovimentacaos' => $tipomovimentacaos,
        ));
    }

    /**
     * Creates a new Tipomovimentacao entity.
     *
     * @Route("/new", name="cadastro_tipomovimentacao_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_tipomovimentacao_new', methods:['GET','POST'])]    
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $tipomovimentacao = new Tipomovimentacao();
        $form = $this->createForm(TipomovimentacaoType::class, $tipomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tipomovimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipomovimentacao_show', array('id' => $tipomovimentacao->getId()));
        }

        return $this->render('tipomovimentacao/new.html.twig', array(
            'tipomovimentacao' => $tipomovimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_tipomovimentacao_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_tipomovimentacao_show', methods:['GET'])]    
    public function showAction(Tipomovimentacao $tipomovimentacao)
    {
        $deleteForm = $this->createDeleteForm($tipomovimentacao);

        return $this->render('tipomovimentacao/show.html.twig', array(
            'tipomovimentacao' => $tipomovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipomovimentacao entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipomovimentacao_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_tipomovimentacao_edit', methods:['GET','POST'])]    
    public function editAction(Request $request, Tipomovimentacao $tipomovimentacao, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($tipomovimentacao);
        $editForm = $this->createForm(TipomovimentacaoType::class, $tipomovimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($tipomovimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipomovimentacao_show', array('id' => $tipomovimentacao->getId()));
        }

        return $this->render('tipomovimentacao/edit.html.twig', array(
            'tipomovimentacao' => $tipomovimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_tipomovimentacao_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_tipomovimentacao_delete', methods:['POST'])]    
    public function deleteAction(Request $request, Tipomovimentacao $tipomovimentacao, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($tipomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($tipomovimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipomovimentacao_index');
    }

    /**
     * Creates a form to delete a Tipomovimentacao entity.
     *
     * @param Tipomovimentacao $tipomovimentacao The Tipomovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipomovimentacao $tipomovimentacao): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipomovimentacao_delete', array('id' => $tipomovimentacao->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
