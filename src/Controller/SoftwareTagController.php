<?php

namespace App\Controller;

use App\Entity\Software;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\SoftwareTag;
use App\Form\SoftwareTagType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * SoftwareTag controller.
 *
 * @Route("/cadastro/softwaretag")
 */
#[Route('/cadastro/softwaretag')]             
class SoftwareTagController extends AbstractController
{
    /**
     * Lists all SoftwareTag entities.
     *
     * @Route("/{software}", name="cadastro_softwaretag_index")
     * @Method("GET")
     */
    #[Route('/{software}', name:'cadastro_softwaretag_index', methods:['GET'])]             
    public function indexAction(Software $software, EntityManagerInterface $em)
    {

        $softwareTags = $em->getRepository(SoftwareTag::class)
            ->findBy(array('software'=>$software));

        return $this->render('softwaretag/index.html.twig', array(
            'softwareTags' => $softwareTags,
            'software' => $software
        ));
    }

    /**
     * Creates a new SoftwareTag entity.
     *
     * @Route("/new/{software}", name="cadastro_softwaretag_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{software}', name:'cadastro_softwaretag_new', methods:['GET','POST'])]             
    public function newAction(Request $request, Software $software, EntityManagerInterface $em)
    {
        $softwareTag = new SoftwareTag();

        $softwareTag->setSoftware($software);

        $form = $this->createForm(SoftwareTagType::class, $softwareTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($softwareTag);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_softwaretag_index', array('software' => $software->getId()));
        }

        return $this->render('softwaretag/new.html.twig', array(
            'softwareTag' => $softwareTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SoftwareTag entity.
     *
     * @Route("/{id}", name="cadastro_softwaretag_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_softwaretag_show', methods:['GET'])]             
    public function showAction(SoftwareTag $softwareTag)
    {
        $deleteForm = $this->createDeleteForm($softwareTag);

        return $this->render('softwaretag/show.html.twig', array(
            'softwareTag' => $softwareTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SoftwareTag entity.
     *
     * @Route("/{id}/edit", name="cadastro_softwaretag_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_softwaretag_edit', methods:['GET','POST'])]             
    public function editAction(Request $request, SoftwareTag $softwareTag, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($softwareTag);
        $editForm = $this->createForm(SoftwareTagType::class, $softwareTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($softwareTag);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_softwaretag_index', array(
                'software' => $softwareTag->getSoftware()->getId()));
        }

        return $this->render('softwaretag/edit.html.twig', array(
            'softwareTag' => $softwareTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SoftwareTag entity.
     *
     * @Route("/{id}", name="cadastro_softwaretag_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_softwaretag_delete', methods:['POST'])]             
    public function deleteAction(Request $request, SoftwareTag $softwareTag, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($softwareTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($softwareTag);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_softwaretag_index',array(
            'software' => $softwareTag->getSoftware()->getId()
        ));
    }

    /**
     * Creates a form to delete a SoftwareTag entity.
     *
     * @param SoftwareTag $softwareTag The SoftwareTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SoftwareTag $softwareTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_softwaretag_delete', array('id' => $softwareTag->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
