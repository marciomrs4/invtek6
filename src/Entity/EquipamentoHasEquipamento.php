<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Equipamento;

/**
 * EquipamentoHasEquipamento
 *
 * @ORM\Table(name="equipamento_has_equipamento", indexes={@ORM\Index(name="fk_equipamento_has_equipamento_equipamento2_idx", columns={"equipamento_filho_id"}), @ORM\Index(name="fk_equipamento_has_equipamento_equipamento1_idx", columns={"equipamento_pai_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'equipamento_has_equipamento')]
#[ORM\Entity]
class EquipamentoHasEquipamento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Column(name: 'id')]
    #[ORM\Id]
    #[ORM\GeneratedValue]    
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_filho_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="É necessario informar um equipamento")
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class )]
    #[ORM\JoinColumn(name: 'equipamento_filho_id', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: 'É necessario informar um equipamento')]
    private $equipamentoFilho;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_pai_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class )]
    #[ORM\JoinColumn(name: 'equipamento_pai_id', referencedColumnName: 'id')]
    private $equipamentoPai;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set equipamentoFilho
     *
     * @param App\Entity\Equipamento $equipamentoFilho
     * @return EquipamentoHasEquipamento
     */
    public function setEquipamentoFilho(Equipamento $equipamentoFilho = null): EquipamentoHasEquipamento
    {
        $this->equipamentoFilho = $equipamentoFilho;

        return $this;
    }

    /**
     * Get equipamentoFilho
     *
     * @return App\Entity\Equipamento 
     */
    public function getEquipamentoFilho()
    {
        return $this->equipamentoFilho;
    }

    /**
     * Set equipamentoPai
     *
     * @param App\Entity\Equipamento $equipamentoPai
     * @return EquipamentoHasEquipamento
     */
    public function setEquipamentoPai(Equipamento $equipamentoPai = null): EquipamentoHasEquipamento
    {
        $this->equipamentoPai = $equipamentoPai;

        return $this;
    }

    /**
     * Get equipamentoPai
     *
     * @return \MRS\InventarioBundle\Entity\Equipamento 
     */
    public function getEquipamentoPai()
    {
        return $this->equipamentoPai;
    }
}
