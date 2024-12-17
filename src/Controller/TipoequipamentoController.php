<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Tipoequipamento;
use App\Form\TipoequipamentoType;

use Doctrine\ORM\EntityManagerInterface;
/**
 * Tipoequipamento controller.
 *
 * @Route("/cadastro/tipoequipamento")
 */
#[Route('/cadastro/tipoequipamento')]    
class TipoequipamentoController extends AbstractController
{
    /**
     * Lists all Tipoequipamento entities.
     *
     * @Route("/", name="cadastro_tipoequipamento_index")
     * @Method("GET|POST")
     */
    #[Route('/', name:'cadastro_tipoequipamento_index', methods:['GET','POST'])]        
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        //$em = $this->getDoctrine()->getManager();

        $tipoequipamentos = $em->getRepository(Tipoequipamento::class)
            ->getAllOrderByDescricao();

        $file = '';
        $posicao = '';
        if($request->files->get('file_csv')) {

            $file = $request->files->get('file_csv');

            $file = file($file);

            foreach($file as $item){

                $posicao = explode(',',$item);

                $tipoequipamento = new Tipoequipamento();

                $tipoequipamento->setDescricao($posicao['0']);

                $em->persist($tipoequipamento);
            }

            $em->flush();

            return $this->redirectToRoute('cadastro_tipoequipamento_index');
        }


        return $this->render('tipoequipamento/index.html.twig', array(
            'tipoequipamentos' => $tipoequipamentos,
        ));
    }

    /**
     * Creates a new Tipoequipamento entity.
     *
     * @Route("/new", name="cadastro_tipoequipamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_tipoequipamento_new', methods:['GET','POST'])]        
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $tipoequipamento = new Tipoequipamento();
        $form = $this->createForm(TipoequipamentoType::class, $tipoequipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($tipoequipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoequipamento_show', array('id' => $tipoequipamento->getId()));
        }

        return $this->render('tipoequipamento/new.html.twig', array(
            'tipoequipamento' => $tipoequipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipoequipamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoequipamento_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_tipoequipamento_show', methods:['GET'])]        
    public function showAction(Tipoequipamento $tipoequipamento)
    {
        $deleteForm = $this->createDeleteForm($tipoequipamento);

        return $this->render('tipoequipamento/show.html.twig', array(
            'tipoequipamento' => $tipoequipamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipoequipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipoequipamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_tipoequipamento_edit', methods:['GET','POST'])]        
    public function editAction(Request $request, Tipoequipamento $tipoequipamento, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($tipoequipamento);
        $editForm = $this->createForm(TipoequipamentoType::class, $tipoequipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($tipoequipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoequipamento_show', array('id' => $tipoequipamento->getId()));
        }

        return $this->render('tipoequipamento/edit.html.twig', array(
            'tipoequipamento' => $tipoequipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipoequipamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoequipamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_tipoequipamento_delete', methods:['POST'])]        
    public function deleteAction(Request $request, Tipoequipamento $tipoequipamento, EntityManagerInterface $em)
    {
        
        $form = $this->createDeleteForm($tipoequipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->remove($tipoequipamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipoequipamento_index');
    }

    /**
     * Creates a form to delete a Tipoequipamento entity.
     *
     * @param Tipoequipamento $tipoequipamento The Tipoequipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipoequipamento $tipoequipamento): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipoequipamento_delete', array('id' => $tipoequipamento->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
