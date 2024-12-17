<?php

namespace App\Controller;

use App\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\EquipamentoTag;
use App\Form\EquipamentoTagType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * EquipamentoTag controller.
 *
 * @Route("/cadastro/equipamentotag")
 */
#[Route('/cadastro/equipamentotag')]     
class EquipamentoTagController extends AbstractController
{
    /**
     * Lists all EquipamentoTag entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentotag_index")
     * @Method("GET")
     */
    #[Route('/{equipamento}', name:'cadastro_equipamentotag_index', methods:['GET'])]     
    public function indexAction(Equipamento $equipamento, EntityManagerInterface $em)
    {

        $equipamentoTags = $em->getRepository(EquipamentoTag::class)
            ->findBy(array('equipamento'=>$equipamento));

        return $this->render('equipamentotag/index.html.twig', array(
            'equipamentoTags' => $equipamentoTags,
            'equipamento'=>$equipamento
        ));
    }

    /**
     * Creates a new EquipamentoTag entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentotag_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{equipamento}', name:'cadastro_equipamentotag_new', methods:['GET','POST'])]     
    public function newAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $equipamentoTag = new EquipamentoTag();

        $equipamentoTag->setEquipamento($equipamento);

        $form = $this->createForm(EquipamentoTagType::class, $equipamentoTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($equipamentoTag);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentotag_index',
                array('equipamento' => $equipamento->getId()));
        }

        return $this->render('equipamentotag/new.html.twig', array(
            'equipamentoTag' => $equipamentoTag,
            'form' => $form->createView(),
            'equipamento' => $equipamento
        ));
    }

    /**
     * Finds and displays a EquipamentoTag entity.
     *
     * @Route("/{id}", name="cadastro_equipamentotag_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_equipamentotag_show', methods:['GET'])]     
    public function showAction(EquipamentoTag $equipamentoTag)
    {
        $deleteForm = $this->createDeleteForm($equipamentoTag);

        return $this->render('equipamentotag/show.html.twig', array(
            'equipamentoTag' => $equipamentoTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoTag entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentotag_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_equipamentotag_edit', methods:['GET','POST'])]     
    public function editAction(Request $request, EquipamentoTag $equipamentoTag, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($equipamentoTag);
        $editForm = $this->createForm('App\Form\EquipamentoTagType', $equipamentoTag);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($equipamentoTag);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentotag_index',
                array('equipamento' => $equipamentoTag->getEquipamento()->getId()));
        }

        return $this->render('equipamentotag/edit.html.twig', array(
            'equipamentoTag' => $equipamentoTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'equipamento' => $equipamentoTag->getEquipamento()
        ));
    }

    /**
     * Deletes a EquipamentoTag entity.
     *
     * @Route("/{id}", name="cadastro_equipamentotag_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_equipamentotag_delete', methods:['POST'])]     
    public function deleteAction(Request $request, EquipamentoTag $equipamentoTag, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($equipamentoTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($equipamentoTag);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_equipamentotag_index',
            array('equipamento'=>$equipamentoTag->getEquipamento()->getId()));
    }

    /**
     * Creates a form to delete a EquipamentoTag entity.
     *
     * @param EquipamentoTag $equipamentoTag The EquipamentoTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoTag $equipamentoTag): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentotag_delete', array('id' => $equipamentoTag->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
