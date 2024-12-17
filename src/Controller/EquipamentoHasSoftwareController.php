<?php

namespace App\Controller;

use App\Entity\Equipamento;
use App\Entity\Software;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\EquipamentoHasSoftware;
use App\Form\EquipamentoHasSoftwareType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * EquipamentoHasSoftware controller.
 *
 * @Route("/cadastro/equipamentoaddsoftware")
 */
#[Route('/cadastro/equipamentoaddsoftware')]
class EquipamentoHasSoftwareController extends AbstractController
{
    /**
     * Lists all EquipamentoHasSoftware entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentoaddsoftware_index")
     * @Method("GET")
     */
    #[Route('/{equipamento}', name:'cadastro_equipamentoaddsoftware_index', methods:['GET'])]
    public function indexAction(Equipamento $equipamento, EntityManagerInterface $em)
    {

        $equipamento = $em->getRepository(Equipamento::class)
            ->find($equipamento);

        $equipamentoHasSoftwares = $em->getRepository(EquipamentoHasSoftware::class)
            ->findBy(array('equipamento'=>$equipamento));

        return $this->render('equipamentohassoftware/index.html.twig', array(
            'equipamentoHasSoftwares' => $equipamentoHasSoftwares,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new EquipamentoHasSoftware entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentoaddsoftware_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{equipamento}', name:'cadastro_equipamentoaddsoftware_new', methods:['GET','POST'])]
    public function newAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $equipamentoHasSoftware = new EquipamentoHasSoftware();

        $equipamento = $em->getRepository(Equipamento::class)
            ->find($equipamento);

        $equipamentoHasSoftware->setEquipamento($equipamento);

        $form = $this->createForm(EquipamentoHasSoftwareType::class, $equipamentoHasSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($equipamentoHasSoftware);
            $em->flush();

            $this->addFlash('notice','Adicionado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddsoftware_index',
                array('equipamento' => $equipamentoHasSoftware->getEquipamento()->getId()));
        }

        return $this->render('equipamentohassoftware/new.html.twig', array(
            'equipamentoHasSoftware' => $equipamentoHasSoftware,
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EquipamentoHasSoftware entity.
     *
     * @Route("/show/{software}", name="cadastro_equipamentoaddsoftware_show")
     * @Method("GET")
     */
    #[Route('/show/{software}', name:'cadastro_equipamentoaddsoftware_show', methods:['GET'])]
    public function showAction(Software $software, EntityManagerInterface $em)
    {

        $equipamentoHasSoftware = $em->getRepository(EquipamentoHasSoftware::class)
                           ->findBy(array('software' => $software));

        return $this->render('equipamentohassoftware/show.html.twig', array(
            'equipamentoHasSoftware' => $equipamentoHasSoftware,
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoHasSoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentoaddsoftware_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_equipamentoaddsoftware_edit', methods:['GET','POST'])]
    public function editAction(Request $request, EquipamentoHasSoftware $equipamentoHasSoftware, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasSoftware);
        $editForm = $this->createForm(EquipamentoHasSoftwareType::class, $equipamentoHasSoftware);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($equipamentoHasSoftware);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddsoftware_index',
                array('equipamento' => $equipamentoHasSoftware->getEquipamento()->getId()));
        }

        return $this->render('equipamentohassoftware/edit.html.twig', array(
            'equipamentoHasSoftware' => $equipamentoHasSoftware,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'equipamento' => $equipamentoHasSoftware->getEquipamento()
        ));
    }

    /**
     * Deletes a EquipamentoHasSoftware entity.
     *
     * @Route("/{id}", name="cadastro_equipamentoaddsoftware_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_equipamentoaddsoftware_delete', methods:['POST'])]
    public function deleteAction(Request $request, EquipamentoHasSoftware $equipamentoHasSoftware, EntityManagerInterface $em)
    {
        $id = $equipamentoHasSoftware->getEquipamento()->getId();

        $form = $this->createDeleteForm($equipamentoHasSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($equipamentoHasSoftware);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');

        }

        return $this->redirectToRoute('cadastro_equipamentoaddsoftware_index',
            array('equipamento' => $id));
    }

    /**
     * Creates a form to delete a EquipamentoHasSoftware entity.
     *
     * @param EquipamentoHasSoftware $equipamentoHasSoftware The EquipamentoHasSoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoHasSoftware $equipamentoHasSoftware): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentoaddsoftware_delete', array('id' => $equipamentoHasSoftware->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
