<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Marca;
use App\Form\MarcaType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Marca controller.
 *
 * @Route("/cadastro/marca")
 */
#[Route('/cadastro/marca')]    
class MarcaController extends AbstractController
{
    /**
     * Lists all Marca entities.
     *
     * @Route("/", name="cadastro_marca_index")
     * @Method("GET|POST")
     */
    #[Route('/', name:'cadastro_marca_index', methods:['GET','POST'])]    
    public function indexAction(Request $request, EntityManagerInterface $em)
    {

        $marcas = $em->getRepository(Marca::class)->findAll();

        $file = '';
        $posicao = '';
        if($request->files->get('file_csv')) {

            $file = $request->files->get('file_csv');

            $file = file($file);

            foreach($file as $item){

                $posicao = explode(',',$item);


                $marca = new Marca();


                $marca->setNome($posicao['0']);

                $em->persist($marca );
            }

            $em->flush();

            return $this->redirectToRoute('cadastro_marca_index');
        }


        return $this->render('marca/index.html.twig', array(
            'marcas' => $marcas,
        ));
    }

    /**
     * Creates a new Marca entity.
     *
     * @Route("/new", name="cadastro_marca_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_marca_new', methods:['GET','POST'])]    
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $marca = new Marca();
        $form = $this->createForm(MarcaType::class, $marca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($marca);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_marca_show', array('id' => $marca->getId()));
        }

        return $this->render('marca/new.html.twig', array(
            'marca' => $marca,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Marca entity.
     *
     * @Route("/{id}", name="cadastro_marca_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_marca_show', methods:['GET'])]    
    public function showAction(Marca $marca)
    {
        $deleteForm = $this->createDeleteForm($marca);

        return $this->render('marca/show.html.twig', array(
            'marca' => $marca,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Marca entity.
     *
     * @Route("/{id}/edit", name="cadastro_marca_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_marca_edit', methods:['GET','POST'])]    
    public function editAction(Request $request, Marca $marca, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($marca);
        $editForm = $this->createForm(MarcaType::class, $marca);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($marca);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_marca_show', array('id' => $marca->getId()));
        }

        return $this->render('marca/edit.html.twig', array(
            'marca' => $marca,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Marca entity.
     *
     * @Route("/{id}", name="cadastro_marca_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_marca_delete', methods:['POST'])]    
    public function deleteAction(Request $request, Marca $marca, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($marca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($marca);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_marca_index');
    }

    /**
     * Creates a form to delete a Marca entity.
     *
     * @param Marca $marca The Marca entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Marca $marca)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_marca_delete', array('id' => $marca->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
