<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\StatusIp;
use App\Form\StatusIpType;

/**
 * StatusIp controller.
 *
 * @Route("/cadastro/statusip")
 */
#[Route('/cadastro/statusip')]             
class StatusIpController extends AbstractController
{
    /**
     * Lists all StatusIp entities.
     *
     * @Route("/", name="cadastro_statusip_index")
     * @Method("GET")
     */
    #[Route('/', name:'cadastro_statusip_index', methods:['GET'])]             
    public function indexAction(EntityManagerInterface $em)
    {
        //$em = $this->getDoctrine()->getManager();

        $statusIps = $em->getRepository(StatusIp::class)->findAll();

        return $this->render('statusip/index.html.twig', array(
            'statusIps' => $statusIps,
        ));
    }

    /**
     * Creates a new StatusIp entity.
     *
     * @Route("/new", name="cadastro_statusip_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_statusip_new', methods:['GET','POST'])]             
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $statusIp = new StatusIp();
        $form = $this->createForm(StatusIpType::class, $statusIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($statusIp);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_statusip_show', array('id' => $statusIp->getId()));
        }

        return $this->render('statusip/new.html.twig', array(
            'statusIp' => $statusIp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a StatusIp entity.
     *
     * @Route("/{id}", name="cadastro_statusip_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_statusip_show', methods:['GET'])]             
    public function showAction(StatusIp $statusIp)
    {
        $deleteForm = $this->createDeleteForm($statusIp);

        return $this->render('statusip/show.html.twig', array(
            'statusIp' => $statusIp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing StatusIp entity.
     *
     * @Route("/{id}/edit", name="cadastro_statusip_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_statusip_edit', methods:['GET','POST'])]             
    public function editAction(Request $request, StatusIp $statusIp, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($statusIp);
        $editForm = $this->createForm(StatusIpType::class, $statusIp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($statusIp);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_statusip_show', array('id' => $statusIp->getId()));
        }

        return $this->render('statusip/edit.html.twig', array(
            'statusIp' => $statusIp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a StatusIp entity.
     *
     * @Route("/{id}", name="cadastro_statusip_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_statusip_delete', methods:['POST'])]             
    public function deleteAction(Request $request, StatusIp $statusIp)
    {
        $form = $this->createDeleteForm($statusIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {

                $em = $this->getDoctrine()->getManager();
                $em->remove($statusIp);
                $em->flush();

            }catch(\Exception $e){

                $message = ['tipo_message' => 'danger',
                            'message' =>'Não é possivel Excluir, este registro deve estar em uso no sistema!'];

            $this->addFlash('notice',$message);

            return $this->redirectToRoute('cadastro_statusip_edit', array('id' => $statusIp->getId()));

            }
        }

        return $this->redirectToRoute('cadastro_statusip_index');
    }

    /**
     * Creates a form to delete a StatusIp entity.
     *
     * @param StatusIp $statusIp The StatusIp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(StatusIp $statusIp): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_statusip_delete', array('id' => $statusIp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
