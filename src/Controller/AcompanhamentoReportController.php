<?php

namespace App\Controller;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Attribute\Route;

use App\Form\Report\AcompanhamentoReportType;
use App\Entity\Acompanhamento;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Acompanhamento controller.
 *
 * @Route("/report/acompanhamento")
 */
#[Route('/report/acompanhamento')]
class AcompanhamentoReportController extends AbstractController
{
    /**
     * Lists all Acompanhamento entities.
     *
     * @Route("/equipamento", name="report_acompanhamento_equipamento")
     * @Method("GET|POST")
     */
    #[Route('/equipamento', name:'report_acompanhamento_equipamento', methods:['GET','POST'])]    
    public function reportAcompanhamentoAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AcompanhamentoReportType::class);

        $form->add('tipoAcompanhamento',EntityType::class,array('label'=>'Tipo de Acompanhamento',
        'attr'=>array('class'=>'form-control'),
        'class'=> \App\Entity\Tipoacompanhamento::class,
        'placeholder'=>'Todos'));

        $acompanhamentos = [];

//        $equipamentosNoAcompanhamento = $em->getRepository('MRSInventarioBundle:Acompanhamento')
//            ->getAllEquipamentoNoAcompanhamento(null);

        if($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            $acompanhamento = $request->request->all();
            $acompanhamentos = $em->getRepository(Acompanhamento::class)
                ->getAllAcompanhamento($acompanhamento['report_acompanhamento']);
        }

        return $this->render('acompanhamentoreport/reportacompanhamento.html.twig', array(
            'acompanhamentos' => $acompanhamentos,
            //'equipamentoNoAcompanhamento' => $equipamentosNoAcompanhamento,
            'form_acompanhamento' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/equipamentonoacompanhamento", name="report_equipamento_no_acompanhamento")
     * @Method("GET|POST")
     */
    #[Route('/equipamentonoacompanhamento', name:'report_equipamento_no_acompanhamento', methods:['GET','POST'])]    
    public function reportEquipamentoNoAcompanhamentoAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AcompanhamentoReportType::class);

        $acompanhamentos = [];

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            $acompanhamento = $request->request->all();
            
        $acompanhamentos = $em->getRepository(Acompanhamento::class)
            ->getAllEquipamentoNoAcompanhamento($acompanhamento['report_acompanhamento']);
        }
        
        return $this->render('acompanhamentoreport/reportequipamentonoacompanhamento.html.twig', array(
            'acompanhamentos' => $acompanhamentos,
            'form_acompanhamento' => $form->createView()
        ));
    }

}
