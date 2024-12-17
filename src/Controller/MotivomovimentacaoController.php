<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Motivomovimentacao;
use App\Form\MotivomovimentacaoType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Motivomovimentacao controller.
 *
 * @Route("/cadastro/motivomovimentacao")
 */
#[Route('/cadastro/motivomovimentacao')]    
class MotivomovimentacaoController extends AbstractController
{
    /**
     * Lists all Motivomovimentacao entities.
     *
     * @Route("/", name="cadastro_motivomovimentacao_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_motivomovimentacao_index', methods:['GET'])]    
    public function indexAction(EntityManagerInterface $em)
    {
        $motivomovimentacaos = $em->getRepository(Motivomovimentacao::class)
                                   ->findAll();

        return $this->render('motivomovimentacao/index.html.twig', array(
            'motivomovimentacaos' => $motivomovimentacaos,
        ));
    }

    /**
     * Creates a new Motivomovimentacao entity.
     *
     * @Route("/new", name="cadastro_motivomovimentacao_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_motivomovimentacao_new', methods:['GET','POST'])]    
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $motivomovimentacao = new Motivomovimentacao();
        $form = $this->createForm(MotivomovimentacaoType::class, $motivomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($motivomovimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_motivomovimentacao_show', 
                        array('id' => $motivomovimentacao->getId())
                    );
        }

        return $this->render('motivomovimentacao/new.html.twig', array(
            'motivomovimentacao' => $motivomovimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Motivomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_motivomovimentacao_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_motivomovimentacao_show', methods:['GET'])]    
    public function showAction(Motivomovimentacao $motivomovimentacao)
    {
        $deleteForm = $this->createDeleteForm($motivomovimentacao);

        return $this->render('motivomovimentacao/show.html.twig', array(
            'motivomovimentacao' => $motivomovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Motivomovimentacao entity.
     *
     * @Route("/{id}/edit", name="cadastro_motivomovimentacao_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_motivomovimentacao_edit', methods:['GET','POST'])]    
    public function editAction(Request $request, Motivomovimentacao $motivomovimentacao, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($motivomovimentacao);
        $editForm = $this->createForm(MotivomovimentacaoType::class, $motivomovimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($motivomovimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_motivomovimentacao_show', array('id' => $motivomovimentacao->getId()));
        }

        return $this->render('motivomovimentacao/edit.html.twig', array(
            'motivomovimentacao' => $motivomovimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Motivomovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_motivomovimentacao_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_motivomovimentacao_delete', methods:['POST'])]    
    public function deleteAction(Request $request, Motivomovimentacao $motivomovimentacao, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($motivomovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($motivomovimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_motivomovimentacao_index');
    }

    /**
     * Creates a form to delete a Motivomovimentacao entity.
     *
     * @param Motivomovimentacao $motivomovimentacao The Motivomovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Motivomovimentacao $motivomovimentacao): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_motivomovimentacao_delete', array('id' => $motivomovimentacao->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
