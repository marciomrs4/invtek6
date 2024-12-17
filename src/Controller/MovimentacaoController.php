<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Movimentacao;
use App\Entity\ItensMovimentacao;
use App\Form\MovimentacaoType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Movimentacao controller.
 *
 * @Route("/movimentacao")
 */
#[Route('/movimentacao')]
class MovimentacaoController extends AbstractController
{
    
    /**
     * Lists all Movimentacao entities.
     *
     * @Route("/", name="movimentacao_index")
     * @Method("GET")
     */
    #[Route('/', name:"movimentacao_index", methods:['GET'])]
    public function indexAction(EntityManagerInterface $em)
    {

        $movimentacaos = $em->getRepository(Movimentacao::class)
            ->findBy(array(),array('datahora'=>'DESC'));

        return $this->render('movimentacao/index.html.twig', array(
            'movimentacaos' => $movimentacaos,
        ));
    }

    /**
     * Creates a new Movimentacao entity.
     *
     * @Route("/new", name="movimentacao_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:"movimentacao_new", methods:['GET','POST'])]    
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $movimentacao = new Movimentacao();

        $movimentacao->setUsuarioCriador($this->getUser())
                     ->setStatus(false);

        $form = $this->createForm(MovimentacaoType::class, $movimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($movimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));
        }

        return $this->render('movimentacao/new.html.twig', array(
            'movimentacao' => $movimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Movimentacao entity.
     *
     * @Route("/{id}", name="movimentacao_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:"movimentacao_show", methods:['GET'])]    
    public function showAction(Movimentacao $movimentacao, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($movimentacao);

        $itensMovimentacao = $em->getRepository(ItensMovimentacao::class)
            ->findBy(array('movimentacao'=>$movimentacao));

        return $this->render('movimentacao/show.html.twig', array(
            'movimentacao' => $movimentacao,
            'itensMovimentacao' => $itensMovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movimentacao entity.
     *
     * @Route("/{id}/edit", name="movimentacao_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:"movimentacao_edit", methods:['GET','POST'])]    
    public function editAction(Request $request, Movimentacao $movimentacao, EntityManagerInterface $em)
    {
        $itensMovimentacao = $em->getRepository(ItensMovimentacao::class)
                    ->findBy(array('movimentacao'=>$movimentacao));

        if($itensMovimentacao){

            $this->addFlash('notice','Não é possivel alterar, pois já existem iten(s) associado!');
            return $this->redirectToRoute('movimentacao_show',array('id'=>$movimentacao));
        }

        $deleteForm = $this->createDeleteForm($movimentacao);
        $editForm = $this->createForm(MovimentacaoType::class, $movimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($movimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));
        }

        return $this->render('movimentacao/edit.html.twig', array(
            'movimentacao' => $movimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movimentacao entity.
     *
     * @Route("/{id}/createmove", name="movimentacao_createmove")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/createmove', name:'movimentacao_createmove', methods:['GET','POST'])]    
    public function createMoveAction(Request $request, Movimentacao $movimentacao, EntityManagerInterface $em)
    {

        if($movimentacao) {

            if($movimentacao->getStatus()){

                $this->addFlash('notice','Essa movimentação já está finalizado!');
                return $this->redirectToRoute('movimentacao_show',array(
                    'id'=>$movimentacao->getId()));

            }

            $movimentacao->setStatus(true);

            $itensMovimentacao = $em->getRepository(ItensMovimentacao::class)
                ->findBy(array('movimentacao'=>$movimentacao));

            $centroMovimentacaoDestino = $movimentacao->getUsuarioDestino()->getDepartamento();

            foreach($itensMovimentacao as $item){

                $idEquipamento = $item->getEquipamento()->getId();

                $equipamento = $em->getRepository(\App\Entity\Equipamento::class)
                    ->find($idEquipamento);

                $equipamento->setCentroMovimentacao($centroMovimentacaoDestino);

                $em->persist($equipamento);
                $em->flush();
               

            }



            $em->persist($movimentacao);
            $em->flush();


            $this->addFlash('notice','Movimentação Efetuada com sucesso!');

            return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));

        }

        $this->addFlash('notice','Movimentação Efetuada com sucesso!');

        return $this->redirectToRoute('movimentacao_show', array('id' => $movimentacao->getId()));

    }


    /**
     * Deletes a Movimentacao entity.
     *
     * @Route("/{id}", name="movimentacao_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:"movimentacao_delete", methods:['POST'])]    
    public function deleteAction(Request $request, Movimentacao $movimentacao, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($movimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($movimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('movimentacao_index');
    }

    /**
     * Creates a form to delete a Movimentacao entity.
     *
     * @param Movimentacao $movimentacao The Movimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movimentacao $movimentacao): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimentacao_delete', array('id' => $movimentacao->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }
}
