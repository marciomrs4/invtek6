<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Usuario;
use App\Form\UsuarioType;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Usuario controller.
 *
 * @Route("/cadastro/usuario")
 */
#[Route('/cadastro/usuario')]
class UsuarioController extends AbstractController
{
    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="cadastro_usuario_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_usuario_index', methods:['GET'])]
    public function indexAction(EntityManagerInterface $em)
    {

        $usuarios = $em->getRepository(Usuario::class)->findAll();

        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/new", name="cadastro_usuario_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_usuario_new', methods:['GET','POST'])]    
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_usuario_show', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="cadastro_usuario_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_usuario_show', methods:['GET'])]        
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="cadastro_usuario_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_usuario_edit', methods:['GET','POST'])]            
    public function editAction(Request $request, Usuario $usuario, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm(UsuarioType::class, $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($usuario);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_usuario_show', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}", name="cadastro_usuario_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_usuario_delete', methods:['POST'])]                
    public function deleteAction(Request $request, Usuario $usuario, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em->remove($usuario);
                $em->flush();
            }catch(\Exception $e){

                $message = ['message' => 'Não é possivel remover o usuário, pois já foi usado em outro registro',
                            'tipo_message' => 'danger',
                            'trace_error' => $e->getMessage()];

                $this->addFlash('notice',$message);

                return $this->redirectToRoute('cadastro_usuario_edit',['id' => $usuario->getId()]);
            }
        }

        return $this->redirectToRoute('cadastro_usuario_index');
    }

    /**
     * Creates a form to delete a Usuario entity.
     *
     * @param Usuario $usuario The Usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
