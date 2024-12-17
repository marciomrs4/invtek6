<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Unidade;
use App\Form\UnidadeType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Unidade controller.
 *
 * @Route("/cadastro/unidade")
 */
#[Route('/cadastro/unidade')]    
class UnidadeController extends AbstractController
{
    /**
     * Lists all Unidade entities.
     *
     * @Route("/", name="cadastro_unidade_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_unidade_index', methods:['GET'])]        
    public function indexAction(EntityManagerInterface $em)
    {

        $unidades = $em->getRepository(Unidade::class)->findAll();

        return $this->render('unidade/index.html.twig', array(
            'unidades' => $unidades,
        ));
    }

    /**
     * Creates a new Unidade entity.
     *
     * @Route("/new", name="cadastro_unidade_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_unidade_new', methods:['GET','POST'])]        
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $unidade = new Unidade();
        $form = $this->createForm(UnidadeType::class, $unidade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($unidade);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_unidade_show', array('id' => $unidade->getId()));
        }

        return $this->render('unidade/new.html.twig', array(
            'unidade' => $unidade,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Unidade entity.
     *
     * @Route("/{id}", name="cadastro_unidade_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_unidade_show', methods:['GET'])]        
    public function showAction(Unidade $unidade)
    {
        $deleteForm = $this->createDeleteForm($unidade);

        return $this->render('unidade/show.html.twig', array(
            'unidade' => $unidade,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Unidade entity.
     *
     * @Route("/{id}/edit", name="cadastro_unidade_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_unidade_edit', methods:['GET','POST'])]        
    public function editAction(Request $request, Unidade $unidade, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($unidade);
        $editForm = $this->createForm(UnidadeType::class, $unidade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($unidade);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_unidade_show', array('id' => $unidade->getId()));
        }

        return $this->render('unidade/edit.html.twig', array(
            'unidade' => $unidade,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Unidade entity.
     *
     * @Route("/{id}", name="cadastro_unidade_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_unidade_delete', methods:['POST'])]        
    public function deleteAction(Request $request, Unidade $unidade, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($unidade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($unidade);
            $em->flush();
            
              $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_unidade_index');
    }

    /**
     * Creates a form to delete a Unidade entity.
     *
     * @param Unidade $unidade The Unidade entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Unidade $unidade): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_unidade_delete', array('id' => $unidade->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
