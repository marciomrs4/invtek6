<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\CentroMovimentacao;
use App\Form\CentroMovimentacaoType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * CentroMovimentacao controller.
 *
 * @Route("/cadastro/centromovimentacao")
 */
#[Route('/cadastro/centromovimentacao')]
class CentroMovimentacaoController extends AbstractController
{
    /**
     * Lists all CentroMovimentacao entities.
     *
     * @Route("/", name="cadastro_centromovimentacao_index")
     * @Method("GET|POST")
     */
    #[Route('/', name:'cadastro_centromovimentacao_index', methods:['GET','POST'])]    
    public function indexAction(Request $request, EntityManagerInterface $em)
    {

        $centroMovimentacaos = $em->getRepository(CentroMovimentacao::class)
            ->findBy(array(),array('nome' => 'ASC'));


        $file = '';
        $posicao = '';
        if($request->files->get('file_csv')) {

            $file = $request->files->get('file_csv');

            $file = file($file);

            foreach($file as $item){

                $posicao = explode(',',$item);


                $centroMovimentacao = new CentroMovimentacao();


                $centroMovimentacao->setNome($posicao['0']);

                $em->persist($centroMovimentacao);
            }

            $em->flush();

            return $this->redirectToRoute('cadastro_centromovimentacao_index');
        }


            return $this->render('centromovimentacao/index.html.twig', array(
            'centroMovimentacaos' => $centroMovimentacaos,
        ));
    }

    /**
     * Creates a new CentroMovimentacao entity.
     *
     * @Route("/new", name="cadastro_centromovimentacao_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_centromovimentacao_new', methods:['GET','POST'])]    
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $centroMovimentacao = new CentroMovimentacao();
        $form = $this->createForm(CentroMovimentacaoType::class, $centroMovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($centroMovimentacao);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_centromovimentacao_show', array('id' => $centroMovimentacao->getId()));
        }

        return $this->render('centromovimentacao/new.html.twig', array(
            'centroMovimentacao' => $centroMovimentacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CentroMovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_centromovimentacao_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_centromovimentacao_show', methods:['GET','POST'])]    
    public function showAction(CentroMovimentacao $centroMovimentacao)
    {
        $deleteForm = $this->createDeleteForm($centroMovimentacao);

        return $this->render('centromovimentacao/show.html.twig', array(
            'centroMovimentacao' => $centroMovimentacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CentroMovimentacao entity.
     *
     * @Route("/{id}/edit", name="cadastro_centromovimentacao_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_centromovimentacao_edit', methods:['GET','POST'])]    
    public function editAction(Request $request, CentroMovimentacao $centroMovimentacao, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($centroMovimentacao);
        $editForm = $this->createForm(CentroMovimentacaoType::class, $centroMovimentacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($centroMovimentacao);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_centromovimentacao_show', array('id' => $centroMovimentacao->getId()));
        }

        return $this->render('centromovimentacao/edit.html.twig', array(
            'centroMovimentacao' => $centroMovimentacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CentroMovimentacao entity.
     *
     * @Route("/{id}", name="cadastro_centromovimentacao_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_centromovimentacao_delete', methods:['POST'])]    
    public function deleteAction(Request $request, CentroMovimentacao $centroMovimentacao, EntityManagerInterface $entityManager)
    {
        if ($this->isCsrfTokenValid('delete'.$centroMovimentacao->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($centroMovimentacao);
            $entityManager->flush();
        }

        //return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
        return $this->redirectToRoute('cadastro_centromovimentacao_index',[],Response::HTTP_SEE_OTHER);
        
        /*
        $form = $this->createDeleteForm($centroMovimentacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($centroMovimentacao);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_centromovimentacao_index');
         
        */
    }

    /**
     * Creates a form to delete a CentroMovimentacao entity.
     *
     * @param CentroMovimentacao $centroMovimentacao The CentroMovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CentroMovimentacao $centroMovimentacao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_centromovimentacao_delete', array('id' => $centroMovimentacao->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
       
}
