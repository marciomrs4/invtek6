<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Equipamento;
use App\Form\Report\PainelEquipamentoReportType;
use App\Form\Report\EquipamentoReportType;
use App\Form\Report\ListInventarioReportType;
use App\Form\Report\EquipamentoCompradoReportType;
use App\Form\Report\EquipamentoExperiedType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Tipoequipamento;

/**
 * Equipamento controller.
 *
 * @Route("/report/equipamento")
 */
#[Route('/report/equipamento')]
class EquipamentoReportController extends AbstractController
{
    /**
     * Lists all Equipamento entities.
     *
     * @Route("/painel", name="report_painel_equipamento")
     * @Method("GET|POST")
     */
    #[Route('/painel', name:'report_painel_equipamento', methods:['GET','POST'])]
    public function painelEquipamentoAction(Request $request, EntityManagerInterface $em)
    {

        //$em = $this->getDoctrine()->getManager();

        $tipoEquipamento = [];

        if($request->getMethod() == 'POST') {
            
            //print_r($request->request); exit(1);

            $valoresRequest = $request->getPayload()->all();
            
            $tipocomponente = $valoresRequest['painel_equipamento_report']['tipoequipamento'];

            $tipoEquipamento = $em->getRepository(Tipoequipamento::class)
                ->findBy(array('id' => $tipocomponente));
        }

        $form = $this->createForm(PainelEquipamentoReportType::class);

        $form->handleRequest($request);

        $equipamentos = $em->getRepository(Equipamento::class)
            ->findBy(array('tipoequipamento'=> $tipoEquipamento));

        return $this->render('equipamentoreport/index.html.twig', array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()

        ));
    }

    /**
     * Lists all Equipamento entities.
     *
     * @Route("/qrcode", name="report_qrcode_equipamento")
     * @Method("GET|POST")
     */
    #[Route('/qrcode', name:'report_qrcode_equipamento', methods:['GET','POST'])]
    public function qrcodeEquipamentoAction(Request $request, EntityManagerInterface $em)
    {
        $equipamentos = [];

        if($request->isMethod('POST')) {

            $result = $request->request->all();
            
            //var_dump($result); exit(1);

            $tipocomponente = $result['painel_equipamento_report']['tipoequipamento'];
            
            //$em = $this->getDoctrine()->getManager();

            $tipoEquipamento = $em->getRepository(Tipoequipamento::class)
                ->findBy(array('id' => $tipocomponente));

            $equipamentos = $em->getRepository(Equipamento::class)
                ->findBy(array('tipoequipamento' => $tipoEquipamento));
        }

        $form = $this->createForm(PainelEquipamentoReportType::class);

        $form->handleRequest($request);

        return $this->render('equipamentoqrcode/index.html.twig', array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()

        ));
    }

    /**
     * Lists all Equipamento entities.
     *
     * @Route("/moreinformation/{equipamento}", name="report_equipamento_moreinformation")
     * @Method("GET|POST")
     */
    #[Route('/moreinformation/{equipamento}', name:'report_equipamento_moreinformation', methods:['GET'])]    
    public function moreInformationAction(Equipamento $equipamento, EntityManagerInterface $em)
    {

        $manyequipamentos = $em->getRepository(\App\Entity\EquipamentoHasEquipamento::class)
            ->findBy(array('equipamentoPai' => $equipamento));

        $equipamentosFilho = $em->getRepository(\App\Entity\EquipamentoHasEquipamento::class)
            ->findBy(array('equipamentoFilho' => $equipamento));

        $tags = $em->getRepository(\App\Entity\EquipamentoTag::class)
            ->findBy(array('equipamento'=>$equipamento),
                array('descricao'=>'DESC'));

        $softwares = $em->getRepository(\App\Entity\EquipamentoHasSoftware::class)
            ->findBy(array('equipamento'=>$equipamento));

        $componentes = $em->getRepository(\App\Entity\EquipamentoHasComponente::class)
            ->findBy(array('equipamento'=>$equipamento),
                array('componente'=>'DESC'));

        $acompanhamentos = $em->getRepository(\App\Entity\Acompanhamento::class)
            ->findBy(array('equipamento'=>$equipamento),
                array('datahora'=>'DESC'),
                3);

        return $this->render('equipamentoreport/moreinformation.html.twig', array(
            'equipamento' => $equipamento,
            'tags'=>$tags,
            'softwares'=>$softwares,
            'componentes'=>$componentes,
            'manyequipamentos' => $manyequipamentos,
            'equipamentosFilho' => $equipamentosFilho,
            'acompanhamentos' => $acompanhamentos,
        ));

    }

    /**
     * @Route("/movimentacoes/{equipamento}", name="report_movimentacoes_equipamento")
     * @Method("GET")
     */
    #[Route('/movimentacoes/{equipamento}', name:'report_movimentacoes_equipamento', methods:['GET'])]        
    public function movimentacoesEquipamentoAction(Equipamento $equipamento, EntityManagerInterface $em)
    {
        $movimentacoes = $em->getRepository(\App\Entity\ItensMovimentacao::class)
            ->findBy(array('equipamento'=>$equipamento),
                array('id'=>'DESC'));

        return $this->render('equipamentoreport/movimentacoes.html.twig', array(
            'movimentacoes' => $movimentacoes
        ));

    }


    /**
     * @Route("/equipamentos",name="report_relatorio_equipamentos")
     * @Method("GET|POST")
     */
    #[Route('/equipamentos', name:'report_relatorio_equipamentos', methods:['GET','POST'])]            
    public function relatorioEquipamentoAction(Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(EquipamentoReportType::class);

        $date = new \DateTime('now');

        $form->get('dataCompraA')->setData($date->modify('-240 day'));

        $form->get('dataCompraB')->setData($date->modify('+240 day'));


        if($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        $equipamentos = [];

        if($request->getMethod() == 'POST') {
            $equipamentosForm = $request->request->all();
            
            //dump($equipamentosForm['report_equipamentos']);exit(1);

            $equipamentos = $em->getRepository(Equipamento::class)
                ->reportEquipamentos($equipamentosForm['report_equipamentos']);
        }

        return $this->render('equipamentoreport/equipamentos.html.twig',array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/export/equipamentos",name="report_export_relatorio_equipamentos")
     * @Method("GET")
     */
    #[Route('/export/equipamentos', name:'report_export_relatorio_equipamentos', methods:['GET','POST'])]                
    public function relatorioEquipamentoExportToExcelAction(Request $request, EntityManagerInterface $em)
    {

        $dataForm['tipoequipamento'] = $request->query->get('tipoEquipamento');
        $dataForm['fornecedor'] = $request->query->get('fornecedor');
        $dataForm['marca'] = $request->query->get('marca');
        $dataForm['patrimonio'] = $request->query->get('patrimonio');
        $dataForm['dataCompraA'] = $request->query->get('dataCompraA');
        $dataForm['dataCompraB'] = $request->query->get('dataCompraB');
        $dataForm['numeroserie'] = $request->query->get('numeroserie');
        $dataForm['status'] = $request->query->get('status');
        $dataForm['centroMovimentacao'] = $request->query->get('centroMovimentacao');

        $equipamentos = $em->getRepository(Equipamento::class)
            ->reportEquipamentos($dataForm);

        $response =  $this->render('equipamentoreport/exportequipamentos.html.twig',array(
            'equipamentos' => $equipamentos
        ));


        $response->headers->set('Content-Type', 'text/csv');

        $response->headers->set('Content-Disposition', 'attachment; filename=Equipamentos.csv');

        return $response;

    }

    /**
     * @Route("/listinventario",name="report_list_inventario")
     * @Method("GET|POST")
     */
    #[Route('/listinventario', name:'report_list_inventario', methods:['GET','POST'])]                    
    public function listInventarioAction(Request $request, EntityManagerInterface $em)
    {

        $equipamentos = [];
        
        $form = $this->createForm(ListInventarioReportType::class);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
        
        $equipamentosForm = $request->request->all();
                
        $equipamentos = $em->getRepository(Equipamento::class)
            ->listInventario($equipamentosForm['report_equipamentos']);
        
        }
        
        return $this->render('equipamentoreport/listinventario.html.twig',array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/export/listequipamento",name="report_export_list_equipamento")
     * @Method("GET")
     */
    #[Route('/export/listequipamento', name:'report_export_list_equipamento', methods:['GET','POST'])]                        
    public function listInventarioExportToExcelAction(Request $request, EntityManagerInterface $em)
    {

        $dataForm['tipoequipamento'] = $request->query->get('tipoequipamento');
        $dataForm['status'] = $request->query->get('status');
        $dataForm['centroMovimentacao'] = $request->query->get('centroMovimentacao');

        $equipamentos = $em->getRepository(Equipamento::class)
            ->listInventario($dataForm);

        $response =  $this->render('equipamentoreport/exportlistinventario.html.twig',array(
            'equipamentos' => $equipamentos
        ));


        $response->headers->set('Content-Type', 'text/csv');

        $response->headers->set('Content-Disposition', 'attachment; filename=ListaInventario.csv');

        return $response;

    }


    /**
     * @Route("/comprados",name="report_comprados")
     * @Method("GET|POST")
     */
    #[Route('/comprados', name:'report_comprados', methods:['GET','POST'])]                            
    public function equipamentosCompradosAction(Request $request, EntityManagerInterface $em)
    {

        $equipamentos = [];
        $form = $this->createForm(EquipamentoCompradoReportType::class);

        $date = new \DateTime('now');

        $form->get('dataCompraA')->setData($date->modify('-240 day'));

        $form->get('dataCompraB')->setData($date->modify('+240 day'));

        if($request->isMethod('POST')) {
            $form->handleRequest($request);

        $equipamentosForm = $request->request->all();

        $equipamentos = $em->getRepository(Equipamento::class)
            ->equipamentosComprados($equipamentosForm['report_equipamentos']);
        }
        
        return $this->render('equipamentoreport/equipamentoscomprados.html.twig',array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/export/equipamentocomprados",name="report_export_equipamentos_comprados")
     * @Method("GET")
     */
    #[Route('/export/equipamentocomprados', name:'report_export_equipamentos_comprados', methods:['GET','POST'])]                                
    public function equipamentoCompradosExportToExcelAction(Request $request, EntityManagerInterface $em)
    {

        $dataForm['tipoequipamento'] = $request->query->get('tipoEquipamento');
        $dataForm['dataCompraA'] = $request->query->get('dataCompraA');
        $dataForm['dataCompraB'] = $request->query->get('dataCompraB');

        $equipamentos = $em->getRepository(Equipamento::class)
            ->equipamentosComprados($dataForm);

        $response =  $this->render('equipamentoreport/exportequipamentoscomprados.html.twig',array(
            'equipamentos' => $equipamentos
        ));


        $response->headers->set('Content-Type', 'text/csv');

        $response->headers->set('Content-Disposition', 'attachment; filename=EquipamentosComprados.csv');

        return $response;

    }

    /**
     * @Route("/experied",name="report_experied")
     * @Method("GET|POST")
     */
    #[Route('/experied', name:'report_experied', methods:['GET','POST'])]                                    
    public function equipamentosSemGarantiaAction(Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(EquipamentoExperiedType::class);

        $date = new \DateTime('now');

        $form->get('dataExperiedA')->setData($date->modify('-240 day'));

        $form->get('dataExperiedB')->setData($date->modify('+240 day'));

        $equipamentos = array();

        if($request->isMethod('POST')) {

            $form->handleRequest($request);

            $equipamentosForm = $request->request->all();

            $equipamentos = $em->getRepository(Equipamento::class)
                                 ->equipamentosSemGarantia($equipamentosForm['report_equipamentos']);
        }

        return $this->render('equipamentoreport/equipamentos_experied.html.twig',array(
            'equipamentos' => $equipamentos,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/modal/equipamentosSemGarantia",name="report_modal_equipamentos_sem_garantia")
     * @Method("GET")
     */
    #[Route('/modal/equipamentosSemGarantia', name:'report_modal_equipamentos_sem_garantia', methods:['GET'])]    
    public function equipamentosSemGarantiaModalAction(EntityManagerInterface $em)
    {

        $dataMinima = $em->getRepository(Equipamento::class)
            ->createQueryBuilder('EQUI')
            ->select('min(EQUI.validade)')
            ->getQuery()
            ->getSingleResult();


        $date = new \DateTime('now');

        $dateInicio = new \DateTime($dataMinima['1']);

        //dump($dateInicio); exit();

        $dataForm = array('tipoequipamento' => '%',
                          'centroMovimentacao' => '%',
                          'dataExperiedA' => $dateInicio->format('Y-m-d'),
                          'dataExperiedB' => $date->format('Y-m-d'),
                          'status' => '%');

        //dump($dataForm); exit();

        $equipamentos = $em->getRepository(Equipamento::class)
                             ->equipamentosSemGarantia($dataForm);

        return $this->render('equipamentoreport/semgarantia_modal.html.twig',array(
            'equipamentos' => $equipamentos
        ));

    }


}
