<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AcompanhamentoRepository;
use Doctrine\DBAL\Types\Types;
use App\Entity\Tipoacompanhamento;
use App\Entity\Equipamento;

/**
 * Acompanhamento
 *
 * @ORM\Table(name="acompanhamento", indexes={@ORM\Index(name="fk_companhamento_equipamento1_idx", columns={"equipamento_id"}), @ORM\Index(name="fk_acompanhamento_tipoAcompanhamento1_idx", columns={"tipoAcompanhamento_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\AcompanhamentoRepository")
 */
#[ORM\Table(name:'acompanhamento')]
#[ORM\Entity(repositoryClass: AcompanhamentoRepository::class)]
class Acompanhamento
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=false)
     */
    #[ORM\Column(name:'descricao', type: 'text', length:255, nullable: false)]
    private $descricao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataHora", type="datetime", nullable=true)
     */
    #[ORM\Column(name:'dataHora', type: Types::DATETIME_MUTABLE , nullable: true)]
    private $datahora;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Column(name:'id')]
    #[ORM\Id]
    #[ORM\GeneratedValue] 
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\Tipoacompanhamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipoacompanhamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoAcompanhamento_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity:Tipoacompanhamento::class)]
    #[JoinColumn(name: 'tipoAcompanhamento_id', referenceColumnName: 'id' )]
    private $tipoacompanhamento;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class)]
    #[ORM\JoinColumn(name: 'equipamento_id', referencedColumnName: 'id' )]
    private $equipamento;


    public function __construct()
    {
        $this->datahora = new \DateTime('now');
    }


    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Acompanhamento
     */
    public function setDescricao($descricao): Acompanhamento
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * Set datahora
     *
     * @param \DateTime $datahora
     * @return Acompanhamento
     */
    public function setDatahora($datahora): Acompanhamento
    {
        $this->datahora = $datahora;

        return $this;
    }

    /**
     * Get datahora
     *
     * @return \DateTime 
     */
    public function getDatahora(): \DateTime
    {
        return $this->datahora;
    }

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
     * Set tipoacompanhamento
     *
     * @param App\Entity\Tipoacompanhamento $tipoacompanhamento
     * @return Acompanhamento
     */
    public function setTipoacompanhamento(Tipoacompanhamento $tipoacompanhamento = null): Acompanhamento
    {
        $this->tipoacompanhamento = $tipoacompanhamento;

        return $this;
    }

    /**
     * Get tipoacompanhamento
     *
     * @return App\Entity\Tipoacompanhamento 
     */
    public function getTipoacompanhamento(): App\Entity\Tipoacompanhamento
    {
        return $this->tipoacompanhamento;
    }

    /**
     * Set equipamento
     *
     * @param Equipamento $equipamento
     * @return Acompanhamento
     */
    public function setEquipamento(Equipamento $equipamento = null): Acompanhamento
    {
        $this->equipamento = $equipamento;

        return $this;
    }

    /**
     * Get equipamento
     *
     * @return App\Entity\Equipamento 
     */
    public function getEquipamento(): App\Entity\Equipamento
    {
        return $this->equipamento;
    }
}
