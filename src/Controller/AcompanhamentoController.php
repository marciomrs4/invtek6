<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;


use App\Entity\Equipamento;
use App\Entity\Acompanhamento;
use App\Form\AcompanhamentoType;
use App\Entity\CustoEquipamento;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;

/**
 *
 * @Route("/cadastro/acompanhamento")
 */

#[Route('/cadastro/acompanhamento')]
class AcompanhamentoController extends AbstractController
{
    /**
     * Lists all Acompanhamento entities.
     *
     * @Route("/{equipamento}", name="cadastro_acompanhamento_index")
     * @Method("GET")
     */
    
    #[Route('/{equipamento}', name: 'cadastro_acompanhamento_index', methods: ['GET'])]
    public function indexAction(Equipamento $equipamento, EntityManagerInterface $em)
    {
        //$em = $this->getDoctrine()->getManager();

        $acompanhamentos = $em->getRepository(Acompanhamento::class)
            ->findBy(array('equipamento' => $equipamento));

        return $this->render('acompanhamento/index.html.twig', array(
            'acompanhamentos' => $acompanhamentos,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new Acompanhamento entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_acompanhamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{equipamento}', name:'cadastro_acompanhamento_new', methods:['GET','POST'])]
    public function newAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $acompanhamento = new Acompanhamento();
        $acompanhamento->setEquipamento($equipamento);
        $form = $this->createForm(AcompanhamentoType::class, $acompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            
            $em->persist($acompanhamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_acompanhamento_show', array('id' => $acompanhamento->getId()));
        }

        return $this->render('acompanhamento/new.html.twig', array(
            'acompanhamento' => $acompanhamento,
            'form' => $form->createView(),
            'equipamento' => $equipamento
        ));
    }

    /**
     * Finds and displays a Acompanhamento entity.
     *
     * @Route("/show/{id}", name="cadastro_acompanhamento_show")
     * @Method("GET")
     */
    #[Route('/show/{id}', name:'cadastro_acompanhamento_show', methods:['GET'])]
    public function showAction(Acompanhamento $acompanhamento, EntityManagerInterface $em)
    {

        $custos = $em->getRepository(CustoEquipamento::class)
            ->findBy(array('acompanhamento'=>$acompanhamento));

        return $this->render('acompanhamento/show.html.twig', array(
            'acompanhamento' => $acompanhamento,
            'custos' => $custos,
            'equipamento' => $acompanhamento->getEquipamento()
        ));
    }

    /**
     * Displays a form to edit an existing Acompanhamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_acompanhamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_acompanhamento_edit', methods:['GET','POST'])]
    public function editAction(Request $request, Acompanhamento $acompanhamento, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($acompanhamento);
        $editForm = $this->createForm(AcompanhamentoType::class, $acompanhamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($acompanhamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_acompanhamento_show', array('id' => $acompanhamento->getId()));
        }

        return $this->render('acompanhamento/edit.html.twig', array(
            'acompanhamento' => $acompanhamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'equipamento' => $acompanhamento->getEquipamento()
        ));
    }

    /**
     * Deletes a Acompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_acompanhamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_acompanhamento_delete', methods:['POST'])]
    public function deleteAction(Request $request, Acompanhamento $acompanhamento, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($acompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->remove($acompanhamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_acompanhamento_index');
    }

    /**
     * Creates a form to delete a Acompanhamento entity.
     *
     * @param Acompanhamento $acompanhamento The Acompanhamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Acompanhamento $acompanhamento): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_acompanhamento_delete', array('id' => $acompanhamento->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
    
}
