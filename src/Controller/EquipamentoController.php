<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Equipamento;
use App\Form\EquipamentoType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Equipamento controller.
 *
 * @Route("/cadastro/equipamento")
 */
#[Route('/cadastro/equipamento')]
class EquipamentoController extends AbstractController
{
    /**
     * Lists all Equipamento entities.
     *
     * @Route("/", name="cadastro_equipamento_index")
     * @Method("GET|POST")
     */
    #[Route('/', name:'cadastro_equipamento_index', methods:['GET','POST'])]
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        //$em = $this->getDoctrine()->getManager();

        $equipamentos = $em->getRepository(Equipamento::class)
                           ->findBy(array(),array('id' => 'DESC'));

        $file = '';
        $posicao = '';
        if($request->files->get('file_csv')) {

            $file = $request->files->get('file_csv');

            $file = file($file);

            //dump($file); exit();

            $equip = [];

            foreach($file as $item){


                $posicao = explode(';',$item);


                $equipamento = new Equipamento();

                $centroMovimentacao = $em->getRepository('MRSInventarioBundle:CentroMovimentacao')
                    ->findOneBy(['id' => $posicao[1]]);

                $fornecedor = $em->getRepository('MRSInventarioBundle:Fornecedor')
                    ->findOneBy(['id' => $posicao[2]]);

                $marca = $em->getRepository('MRSInventarioBundle:Marca')
                    ->findOneBy(['id' => $posicao[3]]);

                $tipoEquipamento = $em->getRepository('MRSInventarioBundle:Tipoequipamento')
                    ->findOneBy(['id' => $posicao[4]]);

                $compradoPara = $em->getRepository('MRSInventarioBundle:CentroMovimentacao')
                    ->findOneBy(['id' => $posicao[13]]);



                $equipamento->setNome($posicao['0'])
                            ->setCentroMovimentacao($centroMovimentacao)
                            ->setFornecedor($fornecedor)
                            ->setMarca($marca)
                            ->setTipoequipamento($tipoEquipamento)
                            ->setDataCompra(new \DateTime($posicao[5]))
                            ->setValidade(new \DateTime($posicao[6]))
                            ->setValorCompra($posicao[7])
                            ->setNumeroserie($posicao[8])
                            ->setStatus($posicao[9])
                            ->setPatrimonio($posicao[10])
                            ->setDescricao($posicao[11])
                            ->setObservacao($posicao[12])
                            ->setCompradoPara($compradoPara);

                //$equip[] = $equipamento;
                $em->persist($equipamento);
            }

            $em->flush();

            //dump($equip); exit();


            return $this->redirectToRoute('cadastro_equipamento_index');
        }

        return $this->render('equipamento/index.html.twig', array(
            'equipamentos' => $equipamentos,
        ));
    }

    /**
     * Creates a new Equipamento entity.
     *
     * @Route("/new", name="cadastro_equipamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new', name:'cadastro_equipamento_new', methods:['GET','POST'])]
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $equipamento = new Equipamento();
        $form = $this->createForm(EquipamentoType::class, $equipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($equipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamento_show', array('id' => $equipamento->getId()));
        }

        return $this->render('equipamento/new.html.twig', array(
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Equipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamento_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_equipamento_show', methods:['GET'])]
    public function showAction(Equipamento $equipamento)
    {

        return $this->render('equipamento/show.html.twig', array(
            'equipamento' => $equipamento
        ));
    }

    /**
     * Displays a form to edit an existing Equipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_equipamento_edit', methods:['GET','POST'])]
    public function editAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($equipamento);
        $editForm = $this->createForm(EquipamentoType::class, $equipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->persist($equipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamento_show', array('id' => $equipamento->getId()));
        }

        return $this->render('equipamento/edit.html.twig', array(
            'equipamento' => $equipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Equipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_equipamento_delete', methods:['POST'])]
    public function deleteAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $form = $this->createDeleteForm($equipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->remove($equipamento);
            $em->flush();

            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_equipamento_index');
    }

    /**
     * Creates a form to delete a Equipamento entity.
     *
     * @param Equipamento $equipamento The Equipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipamento $equipamento): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamento_delete', array('id' => $equipamento->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }

    /**
     * @param Equipamento $equipamento
     * @Route("/view/log/{equipamento}",name="equipamento_view_log")
     */
    #[Route('/view/log/{equipamento}', name:'equipamento_view_log', methods:['GET'])]
    public function viewLogEntryAction(Equipamento $equipamento)
    {

        $gedmo = $this->getDoctrine()->getRepository('Gedmo:LogEntry');

        $logs = $gedmo->getLogEntries($equipamento);

        //dump($logs); exit();

        return $this->render('logentry/logentry.html.twig',array(
            'logs' => $logs,
        ));

    }
}
