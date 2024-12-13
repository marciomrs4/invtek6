<?php

namespace App\Controller;

use App\Entity\Acompanhamento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AnexoAcompanhamento;
use App\Form\AnexoAcompanhamentoType;


/**
 * AnexoAcompanhamento controller.
 *
 * @Route("/cadastro/anexoacompanhamento")
 */
#[Route('/cadastro/anexoacompanhamento')]
class AnexoAcompanhamentoController extends AbstractController
{
    /**
     * Lists all AnexoAcompanhamento entities.
     *
     * @Route("/{acompanhamento}", name="cadastro_anexoacompanhamento_index")
     * @Method("GET")
     */
    #[Route('/{acompanhamento}', name:'cadastro_anexoacompanhamento_index', methods:['GET'])]
    public function indexAction(Acompanhamento $acompanhamento, EntityManagerInterface $em)
    {
        //$em = $this->getDoctrine()->getManager();

        $anexoAcompanhamentos = $em->getRepository(AnexoAcompanhamento::class)
            ->findBy(array('acompanhamento'=>$acompanhamento));

        return $this->render('anexoacompanhamento/index.html.twig', array(
            'anexoAcompanhamentos' => $anexoAcompanhamentos,
            'acompanhamento' => $acompanhamento
        ));
    }

    /**
     * Creates a new AnexoAcompanhamento entity.
     *
     * @Route("/new/{acompanhamento}", name="cadastro_anexoacompanhamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{acompanhamento}', name:'cadastro_anexoacompanhamento_new', methods:['GET','POST'])]    
    public function newAction(Request $request, Acompanhamento $acompanhamento, EntityManagerInterface $em)
    {
        $anexoAcompanhamento = new AnexoAcompanhamento();

        $anexoAcompanhamento->setAcompanhamento($acompanhamento);

        $form = $this->createForm(AnexoAcompanhamentoType::class, $anexoAcompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($anexoAcompanhamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoacompanhamento_show', array(
                'id' => $anexoAcompanhamento->getId()));
        }

        return $this->render('anexoacompanhamento/new.html.twig', array(
            'anexoAcompanhamento' => $anexoAcompanhamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AnexoAcompanhamento entity.
     *
     * @Route("/show/{id}", name="cadastro_anexoacompanhamento_show")
     * @Method("GET")
     */
    #[Route('/show/{id}', name:'cadastro_anexoacompanhamento_show', methods:['GET'])]    
    public function showAction(AnexoAcompanhamento $anexoAcompanhamento)
    {
        $deleteForm = $this->createDeleteForm($anexoAcompanhamento);

        return $this->render('anexoacompanhamento/show.html.twig', array(
            'anexoAcompanhamento' => $anexoAcompanhamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AnexoAcompanhamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_anexoacompanhamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_anexoacompanhamento_edit', methods:['GET','POST'])]    
    public function editAction(Request $request, AnexoAcompanhamento $anexoAcompanhamento, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($anexoAcompanhamento);
        $editForm = $this->createForm(AnexoAcompanhamentoType::class, $anexoAcompanhamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($anexoAcompanhamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_anexoacompanhamento_show', array('id' => $anexoAcompanhamento->getId()));
        }

        return $this->render('anexoacompanhamento/edit.html.twig', array(
            'anexoAcompanhamento' => $anexoAcompanhamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AnexoAcompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_anexoacompanhamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_anexoacompanhamento_delete', methods:['POST'])]    
    public function deleteAction(Request $request, AnexoAcompanhamento $anexoAcompanhamento, EntityManagerInterface $em)
    {
        $acompanhamento = $anexoAcompanhamento->getAcompanhamento();

        $form = $this->createDeleteForm($anexoAcompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->remove($anexoAcompanhamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_anexoacompanhamento_index',
                        array('acompanhamento' => $acompanhamento->getId()));
    }

    /**
     * Creates a form to delete a AnexoAcompanhamento entity.
     *
     * @param AnexoAcompanhamento $anexoAcompanhamento The AnexoAcompanhamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnexoAcompanhamento $anexoAcompanhamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_anexoacompanhamento_delete', array('id' => $anexoAcompanhamento->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
