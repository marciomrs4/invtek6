<?php

namespace App\Controller;

use App\Entity\Equipamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Anexo;
use App\Form\AnexoType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Anexo controller.
 *
 * @Route("/cadastro/anexoequipamento")
 */
#[Route('/cadastro/anexoequipamento')]
class AnexoController extends AbstractController
{
    /**
     * Lists all Anexo entities.
     *
     * @Route("/{equipamento}", name="cadastro_anexoequipamento_index")
     * @Method("GET")
     */
    #[Route('/{equipamento}', name:'cadastro_anexoequipamento_index', methods:['GET'])]        
    public function indexAction(Equipamento $equipamento, EntityManagerInterface $em)
    {
        //$em = $this->getDoctrine()->getManager();

        $anexos = $em->getRepository(Anexo::class)
            ->findBy(array('equipamento'=>$equipamento));

        return $this->render('anexo/index.html.twig', array(
            'anexos' => $anexos,
            'equipamento'=> $equipamento
        ));
    }

    /**
     * Creates a new Anexo entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_anexoequipamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{equipamento}', name:'cadastro_anexoequipamento_new', methods:['GET','POST'])]    
    public function newAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $anexo = new Anexo();
        $anexo->setEquipamento($equipamento);
        $form = $this->createForm(AnexoType::class, $anexo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($anexo);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoequipamento_show', array('id' => $anexo->getId()));
        }

        return $this->render('anexo/new.html.twig', array(
            'anexo' => $anexo,
            'form' => $form->createView(),
            'equipamento' => $equipamento
        ));
    }

    /**
     * Finds and displays a Anexo entity.
     *
     * @Route("/{id}/show", name="cadastro_anexoequipamento_show")
     * @Method("GET")
     */
    #[Route('/{id}/show', name:'cadastro_anexoequipamento_show', methods:['GET'])]    
    public function showAction(Anexo $anexo)
    {
        $deleteForm = $this->createDeleteForm($anexo);

        return $this->render('anexo/show.html.twig', array(
            'anexo' => $anexo,
            'delete_form' => $deleteForm->createView(),
            'equipamento' => $anexo->getEquipamento()
        ));
    }

    /**
     * Displays a form to edit an existing Anexo entity.
     *
     * @Route("/{id}/edit", name="cadastro_anexoequipamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_anexoequipamento_edit', methods:['GET','POST'])]    
    public function editAction(Request $request, Anexo $anexo, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($anexo);
        $editForm = $this->createForm(AnexoType::class, $anexo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($anexo);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoequipamento_show', array('id' => $anexo->getId()));
        }

        return $this->render('anexo/edit.html.twig', array(
            'anexo' => $anexo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'equipamento' => $anexo->getEquipamento()
        ));
    }

    /**
     * Deletes a Anexo entity.
     *
     * @Route("/{id}", name="cadastro_anexoequipamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}/edit', name:'cadastro_anexoequipamento_delete', methods:['POST'])]    
    public function deleteAction(Request $request, Anexo $anexo, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($anexo);
        $form->handleRequest($request);

        $equipamento = $anexo->getEquipamento()->getId();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($anexo);
            $em->flush();
            
           $this->addFlash('notice','Removido com sucesso!');
        
           
        }

        return $this->redirectToRoute('cadastro_anexoequipamento_index', array(
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a form to delete a Anexo entity.
     *
     * @param Anexo $anexo The Anexo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Anexo $anexo): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_anexoequipamento_delete', array('id' => $anexo->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
    

}
