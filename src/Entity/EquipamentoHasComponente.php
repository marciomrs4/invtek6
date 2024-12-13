<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Componente;
use App\Entity\Equipamento;

/**
 * EquipamentoHasComponente
 *
 * @ORM\Table(name="equipamento_has_componente", indexes={@ORM\Index(name="fk_equipamento_has_componente_componente1_idx", columns={"componente_id"}), @ORM\Index(name="fk_equipamento_has_componente_equipamento1_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'equipamento_has_componente')]
#[ORM\Entity]
//#[ORM\Index(name: '', columns: '', fields: '')]
class EquipamentoHasComponente
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
     * @var \MRS\InventarioBundle\Entity\Componente
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Componente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="componente_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Selecione um componente")
     */
    #[ORM\ManyToOne(targetEntity: Componente::class )]
    #[ORM\JoinColumn(name: 'componente_id', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: 'Selecione um componente')]
    private $componente;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class )]
    #[ORM\JoinColumn(name: 'equipamento_id', referencedColumnName: 'id')]    
    private $equipamento;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set componente
     *
     * @param App\Entity\Componente $componente
     * @return EquipamentoHasComponente
     */
    public function setComponente(Componente $componente = null)
    {
        $this->componente = $componente;

        return $this;
    }

    /**
     * Get componente
     *
     * @return App\Entity\Componente 
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set equipamento
     *
     * @param App\Entity\Equipamento $equipamento
     * @return EquipamentoHasComponente
     */
    public function setEquipamento(Equipamento $equipamento = null)
    {
        $this->equipamento = $equipamento;

        return $this;
    }

    /**
     * Get equipamento
     *
     * @return App\Entity\Equipamento 
     */
    public function getEquipamento()
    {
        return $this->equipamento;
    }
}
