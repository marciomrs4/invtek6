<?php

namespace App\Controller;

use App\Entity\Movimentacao;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Report\MovimentacoesReportType;

use App\Entity\ItensMovimentacao;

use Doctrine\ORM\EntityManagerInterface;
/**
 * Equipamento controller.
 *
 * @Route("/report/movimentacao")
 */
#[Route('/report/movimentacao')]
class MovimentacaoReportController extends AbstractController
{

    /**
     * @Route("/doc/{movimentacao}",name="report_doc_movimentacao")
     * @Method("GET")
     */
    #[Route('/doc/{movimentacao}', name:'report_doc_movimentacao', methods:['GET'])]    
    public function docMovimentacaoAction(Movimentacao $movimentacao, EntityManagerInterface $em)
    {

        if(!$movimentacao) {
            throw $this->createNotFoundException('Movimentacao não encontrada!');
        }

        $itensMovimentacao = $em->getRepository(ItensMovimentacao::class)
            ->findBy(array('movimentacao'=>$movimentacao));


        return $this->render('movimentacaoreport/docmovimentacao.html.twig',array(
            'movimentacao' => $movimentacao,
            'itensMovimentacao' => $itensMovimentacao
        ));

    }

    /**
     * @Route("/",name="report_movimentacoes")
     * @Method("GET|POST")
     */
    #[Route('/', name:'report_movimentacoes', methods:['GET','POST'])]    
    public function relatorioMovimentacaoAction(Request $request, EntityManagerInterface $em)
    {
        $movimentacoes = [];

        $form = $this->createForm(MovimentacoesReportType::class);

        $date = new \DateTime('now');

        $form->get('dataMovimentacaoA')->setData($date->modify('-240 day'));

        $form->get('dataMovimentacaoB')->setData($date->modify('+240 day'));
        
        //dump($form); exit(1);


        if($request->isMethod('POST')) {
            $form->handleRequest($request);
        

        $movimentacaoForm = $request->request->all();

        $movimentacoes = $em->getRepository(Movimentacao::class)
            ->reportMovimentacao($movimentacaoForm['report_movimentacoes']);
        }
        
        return $this->render('movimentacaoreport/movimentacoes.html.twig',array(
            'movimentacoes' => $movimentacoes,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/export/movimentacoes",name="report_export_relatorio_movimentacoes")
     * @Method("GET")
     */
    #[Route('/export/movimentacoes', name:'report_export_relatorio_movimentacoes', methods:['GET'])]    
    public function relatorioMovimentacaoExportToExcelAction(Request $request, EntityManagerInterface $em)
    {
        $dataForm['dataMovimentacaoA'] = $request->query->get('dataCompraA');
        $dataForm['dataMovimentacaoB'] = $request->query->get('dataCompraB');


        $movimentacoes = $em->getRepository(Movimentacao::class)
            ->reportMovimentacao($dataForm);

        $response =  $this->render('movimentacaoreport/exportmovimentacoes.html.twig',array(
            'movimentacoes' => $movimentacoes
        ));


        $response->headers->set('Content-Type', 'text/csv');

        $response->headers->set('Content-Disposition', 'attachment; filename=Movimentacoes.csv');

        return $response;

    }

}
