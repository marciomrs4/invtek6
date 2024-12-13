<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Equipamento;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Equipamento controller.
 *
 * @Route("/qrcode/equipamento")
 */
#[Route('/qrcode/equipamento')]     
class EquipamentoQrCodeController extends AbstractController
{
    /**
     * Lists all Equipamento entities.
     *
     * @Route("/generate/{equipamento}", name="equipamento_qrcode_generate")
     * @Method("GET")
     */
    #[Route('/generate/{equipamento}', name:'equipamento_qrcode_generate', methods:['GET'])]     
    public function indexAction(Equipamento $equipamento)
    {

        return $this->render('equipamentoqrcode/qrcodeshow.html.twig', array(
            'equipamento' => $equipamento,
        ));
    }

    /**
     * Finds and displays a Equipamento entity.
     *
     * @Route("/{equipamento}/show", name="equipamento_qrcode_show")
     * @Method("GET")
     */
    #[Route('/{equipamento}/show', name:'equipamento_qrcode_show', methods:['GET'])]     
    public function showAction(Equipamento $equipamento)
    {

        return $this->render('equipamentoqrcode/show.html.twig', array(
            'equipamento' => $equipamento,
        ));
    }

    /**
     * Lists all Equipamento entities.
     *
     * @Route("/moreinformation/{equipamento}", name="qrcode_equipamento_moreinformation_qrcode")
     * @Method("GET|POST")
     */
    #[Route('/moreinformation/{equipamento}', name:'qrcode_equipamento_moreinformation_qrcode', methods:['GET','POST'])]     
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

        return $this->render('equipamentoqrcode/moreinformationqrcode.html.twig', array(
            'equipamento' => $equipamento,
            'tags'=>$tags,
            'softwares'=>$softwares,
            'componentes'=>$componentes,
            'manyequipamentos' => $manyequipamentos,
            'equipamentosFilho' => $equipamentosFilho,
            'acompanhamentos' => $acompanhamentos
        ));

    }


}
