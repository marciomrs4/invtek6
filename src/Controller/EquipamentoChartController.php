<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Report\EquipamentoChartType;

use App\Entity\Equipamento;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Equipamento controller.
 *
 * @Route("/report/charts")
 */
#[Route('/report/charts')]
class EquipamentoChartController extends AbstractController
{

    /**
     * @Route("/equipamentobycentromovimentacao", name="report_chart_equipamento_by_centro_movimentacao")
     * @Method("POST|GET")
     */
    #[Route('/equipamentobycentromovimentacao', name:'report_chart_equipamento_by_centro_movimentacao', methods:['GET','POST'])]        
    public function equipamentoByCentroMovimentacaoAction(Request $request, EntityManagerInterface $em)
    {
        $formEquipamento = $this->createForm(EquipamentoChartType::class);

        $dadosRequest = $request->request->all();

        $equipamentos = [];
        $quantidade = 0;

        if ($request->isMethod('POST')) {

            $formEquipamento->handleRequest($request);

            $equipamentos = $em->getRepository(Equipamento::class)
                ->chartEquipamentoByCentroMotivacao($dadosRequest['chart_equipamentos']);

            foreach($equipamentos as $equipamento) {
                $quantidade += $equipamento['quantidade'];
            }

        }

        return $this->render('EquipamentoChart/index.html.twig',[
            'form' => $formEquipamento->createView(),
            'quantidadeEquipamentos' => $quantidade,
            'equipamentos' => json_encode($equipamentos)
        ]);

    }


}
