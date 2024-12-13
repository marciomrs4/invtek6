<?php

namespace App\Controller;

use App\Entity\Acompanhamento;
use App\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\CustoEquipamento;
use App\Form\CustoEquipamentoType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * CustoEquipamento controller.
 *
 * @Route("/cadastro/custoequipamento")
 */
#[Route('/cadastro/custoequipamento')]
class CustoEquipamentoController extends AbstractController {

    /**
     * Lists all CustoEquipamento entities.
     *
     * @Route("/{equipamento}", name="cadastro_custoequipamento_index")
     * @Method("GET")
     */
    #[Route('/{equipamento}', name: 'cadastro_custoequipamento_index', methods: ['GET'])]
    public function indexAction(Equipamento $equipamento, EntityManagerInterface $em) {
        $er = $em->getRepository(CustoEquipamento::class);

        $custoEquipamentos = $er->findBy(array('equipamento' => $equipamento),
                array('data_criacao' => 'DESC'));

        $custo = $er->countTotalCusto($equipamento);

        return $this->render('custoequipamento/index.html.twig', array(
                    'custoEquipamentos' => $custoEquipamentos,
                    'custo' => $custo,
                    'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new CustoEquipamento entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_custoequipamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{equipamento}', name: 'cadastro_custoequipamento_new', methods: ['GET', 'POST'])]
    public function newAction(Equipamento $equipamento, Request $request, EntityManagerInterface $em) {
        $custoEquipamento = new CustoEquipamento();

        $custoEquipamento->setEquipamento($equipamento);
        $custoEquipamento->setUsuario($this->getUser());

        $form = $this->createForm(CustoEquipamentoType::class, $custoEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($custoEquipamento);
            $em->flush();

            $this->addFlash('notice', 'Criado custo equipamento com sucesso!');

            return $this->redirectToRoute('cadastro_custoequipamento_show', array('id' => $custoEquipamento->getId()));
        }

        return $this->render('custoequipamento/new.html.twig', array(
                    'custoEquipamento' => $custoEquipamento,
                    'equipamento' => $equipamento,
                    'form' => $form->createView(),
                    'acompanhamento' => null,
        ));
    }

    /**
     * Creates a new CustoEquipamento entity.
     *
     * @Route("/new/{acompanhamento}/acompanhamento", name="cadastro_custoequipamento_acompanhamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{acompanhamento}/acompanhamento', name: 'cadastro_custoequipamento_acompanhamento_new', methods: ['GET', 'POST'])]
    public function newCustoAcompanhametnoAction(Acompanhamento $acompanhamento, Request $request, EntityManagerInterface $em) {
        $custoEquipamento = new CustoEquipamento();

        $equipamento = $acompanhamento->getEquipamento();

        $custoEquipamento->setAcompanhamento($acompanhamento);
        $custoEquipamento->setEquipamento($equipamento);
        $custoEquipamento->setUsuario($this->getUser());

        $form = $this->createForm(CustoEquipamentoType::class, $custoEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($custoEquipamento);
            $em->flush();

            $this->addFlash('notice', 'Criado custo acompanhamento com sucesso!');

            return $this->redirectToRoute('cadastro_acompanhamento_show', array('id' => $acompanhamento->getId()));
        }

        return $this->render('custoequipamento/new.html.twig', array(
                    'custoEquipamento' => $custoEquipamento,
                    'equipamento' => $equipamento,
                    'acompanhamento' => $acompanhamento,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CustoEquipamento entity.
     *
     * @Route("/{id}/show", name="cadastro_custoequipamento_show")
     * @Method("GET")
     */
    #[Route('/{id}/show', name: 'cadastro_custoequipamento_show', methods: ['GET'])]
    public function showAction(CustoEquipamento $custoEquipamento) {
        return $this->render('custoequipamento/show.html.twig', array(
                    'custoEquipamento' => $custoEquipamento,
                    'acompanhamento' => $custoEquipamento->getAcompanhamento(),
                    'equipamento' => $custoEquipamento->getEquipamento()
        ));
    }

    /**
     * Displays a form to edit an existing CustoEquipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_custoequipamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name: 'cadastro_custoequipamento_edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, CustoEquipamento $custoEquipamento, EntityManagerInterface $em) {
        $deleteForm = $this->createDeleteForm($custoEquipamento);
        $editForm = $this->createForm(CustoEquipamentoType::class, $custoEquipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($custoEquipamento);
            $em->flush();

            $this->addFlash('notice', 'Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_custoequipamento_show', array('id' => $custoEquipamento->getId()));
        }

        return $this->render('custoequipamento/edit.html.twig', array(
                    'custoEquipamento' => $custoEquipamento,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'acompanhamento' => $custoEquipamento->getAcompanhamento()
        ));
    }

    /**
     * Deletes a CustoEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_custoequipamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name: 'cadastro_custoequipamento_delete', methods: ['POST'])]
    public function deleteAction(Request $request, CustoEquipamento $custoEquipamento, EntityManagerInterface $em) {
        
        $equipamento = $custoEquipamento->getEquipamento();
        
        $form = $this->createDeleteForm($custoEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($custoEquipamento);
            $em->flush();

            $this->addFlash('notice', 'Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_custoequipamento_index', [
                    'equipamento' => $equipamento->getId()
                        ]
                );
    }

    /**
     * Creates a form to delete a CustoEquipamento entity.
     *
     * @param CustoEquipamento $custoEquipamento The CustoEquipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CustoEquipamento $custoEquipamento) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('cadastro_custoequipamento_delete', array('id' => $custoEquipamento->getId())))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
}
