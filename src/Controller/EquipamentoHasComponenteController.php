<?php

namespace App\Controller;

use App\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\EquipamentoHasComponente;
use App\Form\EquipamentoHasComponenteType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * EquipamentoHasComponente controller.
 *
 * @Route("/cadastro/equipamentocomponente")
 */
#[Route('/cadastro/equipamentocomponente')]
class EquipamentoHasComponenteController extends AbstractController
{
    /**
     * Lists all EquipamentoHasComponente entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentocomponente_index")
     * @Method("GET")
     */
    #[Route('/{equipamento}', name:'cadastro_equipamentocomponente_index', methods:['GET'])]
    public function indexAction(Equipamento $equipamento, EntityManagerInterface $em)
    {

        $equipamentoHasComponentes = $em->getRepository(EquipamentoHasComponente::class)
            ->findBy(array('equipamento'=>$equipamento),
                array('componente'=>'ASC'));

        return $this->render('equipamentohascomponente/index.html.twig', array(
            'equipamentoHasComponentes' => $equipamentoHasComponentes,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new EquipamentoHasComponente entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentocomponente_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{equipamento}', name:'cadastro_equipamentocomponente_new', methods:['GET','POST'])]
    public function newAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $equipamentoHasComponente = new EquipamentoHasComponente();

        $equipamento = $em->getRepository(Equipamento::class)
            ->find($equipamento);

        $equipamentoHasComponente->setEquipamento($equipamento);

        $form = $this->createForm(EquipamentoHasComponenteType::class, $equipamentoHasComponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($equipamentoHasComponente);
            $em->flush();

            $this->addFlash('notice','Adicionado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentocomponente_index',
                array('equipamento' => $equipamentoHasComponente->getEquipamento()->getId()));
        }

        return $this->render('equipamentohascomponente/new.html.twig', array(
            'equipamentoHasComponente' => $equipamentoHasComponente,
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EquipamentoHasComponente entity.
     *
     * @Route("/{id}", name="cadastro_equipamentocomponente_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_equipamentocomponente_show', methods:['GET'])]
    public function showAction(EquipamentoHasComponente $equipamentoHasComponente)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasComponente);

        return $this->render('equipamentohascomponente/show.html.twig', array(
            'equipamentoHasComponente' => $equipamentoHasComponente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoHasComponente entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentocomponente_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_equipamentocomponente_edit', methods:['GET','POST'])]
    public function editAction(Request $request, EquipamentoHasComponente $equipamentoHasComponente, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasComponente);
        $editForm = $this->createForm(EquipamentoHasComponenteType::class, $equipamentoHasComponente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($equipamentoHasComponente);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentocomponente_index',
                array('equipamento' => $equipamentoHasComponente->getEquipamento()->getId()));
        }

        return $this->render('equipamentohascomponente/edit.html.twig', array(
            'equipamentoHasComponente' => $equipamentoHasComponente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'equipamento' => $equipamentoHasComponente->getEquipamento()
        ));
    }

    /**
     * Deletes a EquipamentoHasComponente entity.
     *
     * @Route("/{id}", name="cadastro_equipamentocomponente_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_equipamentocomponente_delete', methods:['POST'])]
    public function deleteAction(Request $request, EquipamentoHasComponente $equipamentoHasComponente, EntityManagerInterface $em)
    {
        $id = $equipamentoHasComponente->getEquipamento()->getId();
        $form = $this->createDeleteForm($equipamentoHasComponente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($equipamentoHasComponente);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_equipamentocomponente_index',
                    array( 'equipamento' => $id));
    }

    /**
     * Creates a form to delete a EquipamentoHasComponente entity.
     *
     * @param EquipamentoHasComponente $equipamentoHasComponente The EquipamentoHasComponente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoHasComponente $equipamentoHasComponente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentocomponente_delete', array('id' => $equipamentoHasComponente->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
