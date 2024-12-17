<?php

namespace App\Controller;

use App\Entity\Software;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\LicencaSoftware;
use App\Form\LicencaSoftwareType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * LicencaSoftware controller.
 *
 * @Route("/cadastro/licencasoftware")
 */
#[Route('/cadastro/licencasoftware')]    
class LicencaSoftwareController extends AbstractController
{
    /**
     * Lists all LicencaSoftware entities.
     *
     * @Route("/{software}", name="cadastro_licencasoftware_index")
     * @Method("GET")
     */
    #[Route('/{software}', name:'cadastro_licencasoftware_index', methods:['GET'])]    
    public function indexAction(Software $software, EntityManagerInterface $em)
    {

        $licencaSoftwares = $em->getRepository(LicencaSoftware::class)
                               ->findBy(array('software' => $software));

        return $this->render('licencasoftware/index.html.twig', array(
            'licencaSoftwares' => $licencaSoftwares,
            'software' => $software
        ));
    }

    /**
     * Creates a new LicencaSoftware entity.
     *
     * @Route("/new/{software}", name="cadastro_licencasoftware_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{software}', name:'cadastro_licencasoftware_new', methods:['GET','POST'])]     
    public function newAction(Request $request, Software $software, EntityManagerInterface $em)
    {
        $licencaSoftware = new LicencaSoftware();
        $licencaSoftware->setSoftware($software);
        $form = $this->createForm(LicencaSoftwareType::class, $licencaSoftware);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($licencaSoftware);
            $em->flush();


            $licencaSoftwareQuantidade = $em->getRepository(LicencaSoftware::class);
            $quantidadeTotal = $licencaSoftwareQuantidade->countLicenca($software->getId());


            $software->setNumerolicensa($quantidadeTotal);
            $em->persist($software);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_licencasoftware_show', array('id' => $licencaSoftware->getId()));
        }

        return $this->render('licencasoftware/new.html.twig', array(
            'licencaSoftware' => $licencaSoftware,
            'software' => $software,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LicencaSoftware entity.
     *
     * @Route("/show/{id}", name="cadastro_licencasoftware_show")
     * @Method("GET")
     */
    #[Route('/show/{id}', name:'cadastro_licencasoftware_show', methods:['GET'])]    
    public function showAction(LicencaSoftware $licencaSoftware)
    {

        $deleteForm = $this->createDeleteForm($licencaSoftware);

        return $this->render('licencasoftware/show.html.twig', array(
            'licencaSoftware' => $licencaSoftware,
            'software' => $licencaSoftware->getSoftware(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LicencaSoftware entity.
     *
     * @Route("/{id}/edit", name="cadastro_licencasoftware_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_licencasoftware_edit', methods:['GET','POST'])]    
    public function editAction(Request $request, LicencaSoftware $licencaSoftware, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($licencaSoftware);
        $editForm = $this->createForm(LicencaSoftwareType::class, $licencaSoftware);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($licencaSoftware);
            $em->flush();

            $software = $licencaSoftware->getSoftware();

            $licencaSoftwareQuantidade = $em->getRepository(LicencaSoftware::class);
            $quantidadeTotal = $licencaSoftwareQuantidade->countLicenca($software->getId());

            $software->setNumerolicensa($quantidadeTotal);
            $em->persist($software);


            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_licencasoftware_show', array('id' => $licencaSoftware->getId()));
        }

        return $this->render('licencasoftware/edit.html.twig', array(
            'licencaSoftware' => $licencaSoftware,
            'software' => $licencaSoftware->getSoftware(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LicencaSoftware entity.
     *
     * @Route("/{id}", name="cadastro_licencasoftware_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_licencasoftware_delete', methods:['POST'])]        
    public function deleteAction(Request $request, LicencaSoftware $licencaSoftware)
    {
        $form = $this->createDeleteForm($licencaSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($licencaSoftware);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_licencasoftware_index');
    }

    /**
     * Creates a form to delete a LicencaSoftware entity.
     *
     * @param LicencaSoftware $licencaSoftware The LicencaSoftware entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LicencaSoftware $licencaSoftware): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_licencasoftware_delete', array('id' => $licencaSoftware->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
