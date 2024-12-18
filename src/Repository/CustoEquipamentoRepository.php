<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 03/08/16
 * Time: 18:26
 */
namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use App\Entity\Equipamento;

class CustoEquipamentoRepository extends EntityRepository
{

    public function countTotalCusto(Equipamento $equipamento)
    {
        return $this->createQueryBuilder('c')
            ->where('c.equipamento = :equipamento')
            ->setParameter('equipamento',$equipamento)
            ->select('SUM(c.valor) AS total, AVG(c.valor) AS media')
            ->getQuery()
            ->getSingleResult();

    }

}