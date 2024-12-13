<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Tipoacompanhamento;
use App\Form\TipoacompanhamentoType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Tipoacompanhamento controller.
 *
 * @Route("/cadastro/tipoacompanhamento")
 */
#[Route('/cadastro/tipoacompanhamento')]             
class TipoacompanhamentoController extends AbstractController
{
    /**
     * Lists all Tipoacompanhamento entities.
     *
     * @Route("/", name="cadastro_tipoacompanhamento_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_tipoacompanhamento_index', methods:['GET'])]             
    public function indexAction(EntityManagerInterface $em)
    {

        $tipoacompanhamentos = $em->getRepository(Tipoacompanhamento::class)
                ->findAll();

        return $this->render('tipoacompanhamento/index.html.twig', array(
            'tipoacompanhamentos' => $tipoacompanhamentos,
        ));
    }

    /**
     * Creates a new Tipoacompanhamento entity.
     *
     * @Route("/new", name="cadastro_tipoacompanhamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_tipoacompanhamento_new', methods:['GET','POST'])]             
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $tipoacompanhamento = new Tipoacompanhamento();
        $form = $this->createForm(TipoacompanhamentoType::class, $tipoacompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tipoacompanhamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoacompanhamento_show', array('id' =>$tipoacompanhamento->getId()));
        }

        return $this->render('tipoacompanhamento/new.html.twig', array(
            'tipoacompanhamento' => $tipoacompanhamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipoacompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoacompanhamento_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_tipoacompanhamento_show', methods:['GET'])]             
    public function showAction(Tipoacompanhamento $tipoacompanhamento)
    {
        $deleteForm = $this->createDeleteForm($tipoacompanhamento);

        return $this->render('tipoacompanhamento/show.html.twig', array(
            'tipoacompanhamento' => $tipoacompanhamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipoacompanhamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_tipoacompanhamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_tipoacompanhamento_edit', methods:['GET','POST'])]             
    public function editAction(Request $request, Tipoacompanhamento $tipoacompanhamento, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($tipoacompanhamento);
        $editForm = $this->createForm(TipoacompanhamentoType::class, $tipoacompanhamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($tipoacompanhamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_tipoacompanhamento_show', array('id' => $tipoacompanhamento->getId()));
        }

        return $this->render('tipoacompanhamento/edit.html.twig', array(
            'tipoacompanhamento' => $tipoacompanhamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tipoacompanhamento entity.
     *
     * @Route("/{id}", name="cadastro_tipoacompanhamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_tipoacompanhamento_delete', methods:['POST'])]             
    public function deleteAction(Request $request, Tipoacompanhamento $tipoacompanhamento, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($tipoacompanhamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($tipoacompanhamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_tipoacompanhamento_index');
    }

    /**
     * Creates a form to delete a Tipoacompanhamento entity.
     *
     * @param Tipoacompanhamento $tipoacompanhamento The Tipoacompanhamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipoacompanhamento $tipoacompanhamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_tipoacompanhamento_delete', array('id' => $tipoacompanhamento->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
