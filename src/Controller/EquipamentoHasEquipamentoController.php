<?php

namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\EquipamentoHasEquipamento;
use App\Entity\Equipamento;

use Doctrine\ORM\EntityManagerInterface;

/**
 * EquipamentoHasEquipamento controller.
 *
 * @Route("/cadastro/equipamentoaddequipamento")
 */
#[Route('/cadastro/equipamentoaddequipamento')]
class EquipamentoHasEquipamentoController extends AbstractController
{
    /**
     * Lists all EquipamentoHasEquipamento entities.
     *
     * @Route("/{equipamento}", name="cadastro_equipamentoaddequipamento_index")
     * @Method("GET")
     */
    #[Route('/{equipamento}', name:'cadastro_equipamentoaddequipamento_index', methods:['GET'])]
    public function indexAction(Equipamento $equipamento, EntityManagerInterface $em)
    {

        $equipamentoHasEquipamentos = $em->getRepository(EquipamentoHasEquipamento::class)
            ->findBy(array('equipamentoPai' => $equipamento));

        return $this->render('equipamentohasequipamento/index.html.twig', array(
            'equipamentoHasEquipamentos' => $equipamentoHasEquipamentos,
            'equipamento' => $equipamento
        ));
    }

    /**
     * Creates a new EquipamentoHasEquipamento entity.
     *
     * @Route("/new/{equipamento}", name="cadastro_equipamentoaddequipamento_new")
     * @Method({"GET", "POST"})
     */
    #[Route('/new/{equipamento}', name:'cadastro_equipamentoaddequipamento_new', methods:['GET','POST'])]
    public function newAction(Request $request, Equipamento $equipamento, EntityManagerInterface $em)
    {
        $equipamentoHasEquipamento = new EquipamentoHasEquipamento();

        $equipamentoHasEquipamento->setEquipamentoPai($equipamento);

        $equipamentos = $em->getRepository(EquipamentoHasEquipamento::class)
            ->findBy(array('equipamentoPai' => $equipamento));


        if(!$equipamentos){
            $itensId[] = 'null';
        }

        foreach($equipamentos as $item){
            $itensId[] = $item->getEquipamentoFilho();
        }

        $form = $this->createForm(\App\Form\EquipamentoHasEquipamentoType::class, $equipamentoHasEquipamento);

        $form->add('equipamentoFilho',EntityType::class,array('label'=>'Equipamento',
            'attr'=>array('class'=>'form-control'),
            'placeholder' => 'Selecione',
            'class' => Equipamento::class,
            'query_builder' => function(EntityRepository $er)use($equipamento, $itensId){
                return $er->createQueryBuilder('e')
                    ->where('e.id != :equipamento')
                    ->andWhere('e.id NOT IN (:itens)')
                    ->setParameter('equipamento',$equipamento)
                    ->setParameter('itens',$itensId)
                    ->orderBy('e.descricao');
            }));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($equipamentoHasEquipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddequipamento_index', array(
                'equipamento' => $equipamento->getId()));
        }

        return $this->render('equipamentohasequipamento/new.html.twig', array(
            'equipamentoHasEquipamento' => $equipamentoHasEquipamento,
            'equipamento' => $equipamento,
            'itens' => $itensId,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EquipamentoHasEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamentoaddequipamento_show")
     * @Method("GET")
     */
    #[Route('/{id}', name:'cadastro_equipamentoaddequipamento_show', methods:['GET'])]
    public function showAction(EquipamentoHasEquipamento $equipamentoHasEquipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasEquipamento);

        return $this->render('equipamentohasequipamento/show.html.twig', array(
            'equipamentoHasEquipamento' => $equipamentoHasEquipamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EquipamentoHasEquipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamentoaddequipamento_edit")
     * @Method({"GET", "POST"})
     */
    #[Route('/{id}/edit', name:'cadastro_equipamentoaddequipamento_edit', methods:['GET','POST'])]
    public function editAction(Request $request, EquipamentoHasEquipamento $equipamentoHasEquipamento, EntityManagerInterface $em)
    {
        $deleteForm = $this->createDeleteForm($equipamentoHasEquipamento);

        $equipamento = $equipamentoHasEquipamento->getEquipamentoPai();

        $equipamentos = $em->getRepository(EquipamentoHasEquipamento::class)
            ->findBy(array('equipamentoPai' => $equipamento));

        if(!$equipamentos){
            $itensId[] = 'null';
        }

        foreach($equipamentos as $item){
            $itensId[] = $item->getEquipamentoFilho();
        }

        $editForm = $this->createForm(\App\Form\EquipamentoHasEquipamentoType::class, $equipamentoHasEquipamento);

        $editForm->add('equipamentoFilho',EntityType::class,array('label'=>'Equipamento',
            'attr'=>array('class'=>'form-control'),
            'class' => 'App\Entity\Equipamento',
            'query_builder' => function(EntityRepository $er)use($equipamento, $itensId){
                return $er->createQueryBuilder('e')
                    ->where('e.id != :equipamento')
                    ->andWhere('e.id NOT IN (:itens)')
                    ->setParameter('equipamento',$equipamento)
                    ->setParameter('itens',$itensId)
                    ->orderBy('e.descricao');
            }));



        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($equipamentoHasEquipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamentoaddequipamento_index', array(
                'equipamento' => $equipamentoHasEquipamento->getEquipamentoPai()->getId()));
        }

        return $this->render('equipamentohasequipamento/edit.html.twig', array(
            'equipamentoHasEquipamento' => $equipamentoHasEquipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'equipamento' => $equipamentoHasEquipamento->getEquipamentoPai()
        ));
    }

    /**
     * Deletes a EquipamentoHasEquipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamentoaddequipamento_delete")
     * @Method("DELETE")
     */
    #[Route('/{id}', name:'cadastro_equipamentoaddequipamento_delete', methods:['POST'])]
    public function deleteAction(Request $request, EquipamentoHasEquipamento $equipamentoHasEquipamento, EntityManagerInterface $em)
    {
        $equipamentoId = $equipamentoHasEquipamento->getEquipamentoPai()->getId();

        $form = $this->createDeleteForm($equipamentoHasEquipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($equipamentoHasEquipamento);
            $em->flush();
            
            $this->addFlash('notice','Removido com sucesso!');
        }

        return $this->redirectToRoute('cadastro_equipamentoaddequipamento_index',array(
            'equipamento' => $equipamentoId
        ));
    }

    /**
     * Creates a form to delete a EquipamentoHasEquipamento entity.
     *
     * @param EquipamentoHasEquipamento $equipamentoHasEquipamento The EquipamentoHasEquipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EquipamentoHasEquipamento $equipamentoHasEquipamento): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamentoaddequipamento_delete', array('id' => $equipamentoHasEquipamento->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
