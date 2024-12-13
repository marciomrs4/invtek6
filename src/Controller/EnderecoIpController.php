<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\EnderecoIp;

use App\Form\EnderecoIpType;
use App\Entity\StatusIp;
use App\Entity\TipoAcessoIp;
use App\Entity\Unidade;

use Doctrine\ORM\EntityManagerInterface;

/**
 * EnderecoIp controller.
 *
 * @Route("/cadastro/enderecoip")
 */
#[Route('/cadastro/enderecoip')]
class EnderecoIpController extends AbstractController
{
    /**
     * Lists all EnderecoIp entities.
     *
     * @Route("/", name="cadastro_enderecoip_index")
     * @Method({"GET","POST"})
     */
    #[Route('/', name:'cadastro_enderecoip_index', methods:['GET','POST'])]
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        //$em = $this->getDoctrine()->getManager();

        $enderecoIps = $em->getRepository(EnderecoIp::class)
            ->findBy(array(),array('enderecoIp'=>'ASC'));

        $file = '';
        $posicao = '';
        if($request->files->get('ip_csv')){

            $file = $request->files->get('ip_csv');

            $file = file($file);


            foreach($file as $item){

            $posicao = explode(',',$item);

                //dump($posicao); die();

                $enderecoIp = new EnderecoIp();

                $TipoAcessoIp = $em->getRepository('MRSInventarioBundle:TipoAcessoIp')
                    ->find($posicao['3']);

                $Status = $em->getRepository('MRSInventarioBundle:StatusIp')
                    ->find($posicao['4']);

                $Unidade = $em->getRepository('MRSInventarioBundle:Unidade')
                    ->find($posicao['5']);


                $enderecoIp->setEnderecoIp($posicao['0'])
                    ->setNome($posicao['1'])
                    ->setObservacao($posicao['2'])
                    ->setTipoAcessoIp($TipoAcessoIp)
                    ->setStatus($Status)
                    ->setUnidade($Unidade);

                $em->persist($enderecoIp);
            }

            $em->flush();

            return $this->redirectToRoute('cadastro_enderecoip_index');

        }

        $status = $em->getRepository(StatusIp::class)
            ->findAll();

        $tipoAcessos= $em->getRepository(TipoAcessoIp::class)
            ->findAll();

        $unidades = $em->getRepository(Unidade::class)
            ->findAll();

        return $this->render('enderecoip/index.html.twig', array(
            'enderecoIps' => $enderecoIps,
            'tiposAcessos' => $tipoAcessos,
            'status' => $status,
            'unidades' => $unidades
        ));
    }

    /**
     * Creates a new EnderecoIp entity.
     *
     * @Route("/new", name="cadastro_enderecoip_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_enderecoip_new', methods:['GET','POST'])]
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $enderecoIp = new EnderecoIp();
        $form = $this->createForm(EnderecoIpType::class, $enderecoIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($enderecoIp);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_enderecoip_show', array('id' => $enderecoIp->getId()));
        }

        return $this->render('enderecoip/new.html.twig', array(
            'enderecoIp' => $enderecoIp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EnderecoIp entity.
     *
     * @Route("/{id}", name="cadastro_enderecoip_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_enderecoip_show', methods:['GET'])]
    public function showAction(EnderecoIp $enderecoIp)
    {
        $ping = false; 

        if($enderecoIp->isDoPing() && ($this->getParameter('do_ping') == "true")) {
            $ip = escapeshellarg($enderecoIp->getEnderecoIp());

            $ping = shell_exec("ping -c 4 {$ip}");
        }

        return $this->render('enderecoip/show.html.twig', array(
            'enderecoIp' => $enderecoIp,
            'ping' => $ping
        ));
    }

    /**
     * Displays a form to edit an existing EnderecoIp entity.
     *
     * @Route("/{id}/edit", name="cadastro_enderecoip_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_enderecoip_edit', methods:['GET','POST'])]
    public function editAction(Request $request, EnderecoIp $enderecoIp, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($enderecoIp);
        $editForm = $this->createForm('App\Form\EnderecoIpType', $enderecoIp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($enderecoIp);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_enderecoip_show', array('id' => $enderecoIp->getId()));
        }

        return $this->render('enderecoip/edit.html.twig', array(
            'enderecoIp' => $enderecoIp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EnderecoIp entity.
     *
     * @Route("/{id}", name="cadastro_enderecoip_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_enderecoip_delete', methods:['POST'])]
    public function deleteAction(Request $request, EnderecoIp $enderecoIp, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($enderecoIp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->remove($enderecoIp);
            $em->flush();
            
            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_enderecoip_index');
    }

    /**
     * Creates a form to delete a EnderecoIp entity.
     *
     * @param EnderecoIp $enderecoIp The EnderecoIp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnderecoIp $enderecoIp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_enderecoip_delete', array('id' => $enderecoIp->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }

}
