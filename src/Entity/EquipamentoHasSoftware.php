<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Software;

/**
 * EquipamentoHasSoftware
 *
 * @ORM\Table(name="equipamento_has_software", indexes={@ORM\Index(name="fk_equipamento_has_software_software1_idx", columns={"software_id"}), @ORM\Index(name="fk_equipamento_has_software_equipamento1_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'equipamento_has_software')]
#[ORM\Entity]
class EquipamentoHasSoftware
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
     * @var \MRS\InventarioBundle\Entity\Software
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Software")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="software_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O software deve ser informado")
     */
    #[ORM\ManyToOne(targetEntity: Software::class )]
    #[ORM\JoinColumn(name: 'software_id', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: 'O software deve ser informado')]    
    private $software;

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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set software
     *
     * @param App\Entity\Software $software
     * @return EquipamentoHasSoftware
     */
    public function setSoftware(Software $software = null): EquipamentoHasSoftware
    {
        $this->software = $software;

        return $this;
    }

    /**
     * Get software
     *
     * @return App\Entity\Software 
     */
    public function getSoftware()
    {
        return $this->software;
    }

    /**
     * Set equipamento
     *
     * @param App\Entity\Equipamento $equipamento
     * @return EquipamentoHasSoftware
     */
    public function setEquipamento(Equipamento $equipamento = null): EquipamentoHasSoftware
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
