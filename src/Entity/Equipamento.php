<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use App\Repository\EquipamentoRepository;

use App\Entity\CentroMovimentacao;
use App\Entity\Marca;
use App\Entity\Fornecedor;
use App\Entity\Tipoequipamento;

use Doctrine\DBAL\Types\Types;

/**
 * Equipamento
 *
 * @ORM\Table(name="equipamento", indexes={@ORM\Index(name="fk_equipamento_tipoEquipamento1_idx", columns={"tipoEquipamento_id"}), @ORM\Index(name="fk_equipamento_forcedor1_idx", columns={"fornecedor_id"}), @ORM\Index(name="fk_equipamento_marca1_idx", columns={"marca_id"}), @ORM\Index(name="fk_equipamento_centro_movimentacao1_idx", columns={"centro_movimentacao_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\EquipamentoRepository")
 * @UniqueEntity(fields={"patrimonio"},ignoreNull=true,message="Já existe um registro como este")
 * @UniqueEntity(fields={"numeroserie"},ignoreNull=true,message="Já existe um registro como este")
 *
 * @Gedmo\Loggable
 */
#[Audit\Auditable()]
#[ORM\Table(name:'equipamento')]
#[ORM\Entity(repositoryClass: EquipamentoRepository::class)]
#[UniqueEntity(fields: 'patrimonio', ignoreNull: true, message: 'Já existe um registro como este')]
#[UniqueEntity(fields: 'numeroserie', ignoreNull: true, message: 'Já existe um registro como este')]
class Equipamento
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="O nome do equipamento é obrigatório.")
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'nome', length:255, nullable:false)]
    #[Assert\NotBlank(message: 'O nome do equipamento é obrigatório.')]
    private ?string $nome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validade", type="date", nullable=false)
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'validade', type: Types::DATETIME_MUTABLE, nullable:false)]    
    private $validade;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_compra", type="date", nullable=true)
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'data_compra', type: Types::DATETIME_MUTABLE , nullable:false)]    
    private $dataCompra;


    /**
     * @var string
     *
     * @ORM\Column(name="valor_compra", type="decimal", precision=10, scale=2 ,nullable=false)
     * @Assert\NotBlank(message="O campo valor de compra é obrigatorio.")
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'valor_compra', type: Types::DECIMAL, precision: 10, scale: 2, nullable:false)]    
    #[Assert\NotBlank(message: 'O campo valor de compra é obrigatorio.')]
    private $valorCompra;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroSerie", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="O campo Numero de Série é obrigatório.")
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'numeroSerie', length:255, nullable:false)]    
    #[Assert\NotBlank(message: 'O campo Numero de Série é obrigatório.')]
    private ?string $numeroserie;

    /**
     * @var boolean
     * @ORM\Column(name="status", type="boolean", nullable=false)
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'status', type: Types::BOOLEAN, nullable:false)]    
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="patrimonio", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="O campo patrimônio é obrigatório")
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'patrimonio', length:255, nullable:false)]    
    #[Assert\NotBlank(message: 'O campo patrimônio é obrigatório')]
    private ?string $patrimonio;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="O campo descrição é obrigatório")
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'descricao', length:255, nullable:false)]    
    #[Assert\NotBlank(message: 'O campo descrição é obrigatório')]
    private ?string $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
     * @Gedmo\Versioned()
     */
    #[ORM\Column(name:'observacao', length:255, nullable:true)]    
    private $observacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private $id;

    /**
     * @var \MRS\InventarioBundle\Entity\CentroMovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\CentroMovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="centro_movimentacao_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O centro de movimentação do equipamento é obrigatório.")
     * @Gedmo\Versioned()
     */
    #[ORM\ManyToOne(targetEntity: CentroMovimentacao::class)]
    #[ORM\JoinColumn(name:'centro_movimentacao_id', referencedColumnName:'id')]
    #[Assert\NotBlank(message:'O centro de movimentação do equipamento é obrigatório.')]
    private $centroMovimentacao;

    /**
     * @var \MRS\InventarioBundle\Entity\CentroMovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\CentroMovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comprado_para", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Este campo é obrigatório.")
     * @Gedmo\Versioned()
     */
    #[ORM\ManyToOne(targetEntity: CentroMovimentacao::class )]
    #[ORM\JoinColumn(name:'comprado_para', referencedColumnName:'id')]
    #[Assert\NotBlank(message: 'Este campo é obrigatório.')]
    private $compradoPara;

    /**
     * @var \MRS\InventarioBundle\Entity\Marca
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Marca")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="A marca do equipamento é obrigatório.")
     * @Gedmo\Versioned()
     */
    #[ORM\ManyToOne(targetEntity: Marca::class)]
    #[ORM\JoinColumn(name:'marca_id', referencedColumnName:'id')]
    #[Assert\NotBlank(message: 'A marca do equipamento é obrigatório.')]
    private $marca;

    /**
     * @var \MRS\InventarioBundle\Entity\Fornecedor
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Fornecedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fornecedor_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O fornecedor do equipamento é obrigatório.")
     * @Gedmo\Versioned()
     */
    #[ORM\ManyToOne(targetEntity: Fornecedor::class)]
    #[ORM\JoinColumn(name:'fornecedor_id', referencedColumnName:'id')]
    #[NotBlank(message: 'O fornecedor do equipamento é obrigatório.')]
    private $fornecedor;
    /**
     * @var \MRS\InventarioBundle\Entity\Tipoequipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipoequipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoEquipamento_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="O tipo de equipamento do equipamento é obrigatório.")
     * @Gedmo\Versioned()
     */
    #[ORM\ManyToOne(targetEntity: Tipoequipamento::class)]
    #[ORM\JoinColumn(name:'', referencedColumnName:'id')]
    #[Assert\NotBlank(message: 'O tipo de equipamento do equipamento é obrigatório.')]
    private $tipoequipamento;

    public function __construct()
    {
        $this->status = true;

        $date = new \DateTime('now');

        $this->validade = $date;

        $this->dataCompra = $date;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Equipamento
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }


    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }


    /**
     * @return CentroMovimentacao
     */
    public function getCompradoPara()
    {
        return $this->compradoPara;
    }

    /**
     * @param CentroMovimentacao $compradoPara
     * @return Equipamento
     */
    public function setCompradoPara($compradoPara)
    {
        $this->compradoPara = $compradoPara;
        return $this;
    }

    /**
     * Set validade
     *
     * @param \DateTime $validade
     * @return Equipamento
     */
    public function setValidade($validade)
    {
        $this->validade = $validade;

        return $this;
    }


    /**
     * Get validade
     *
     * @return \DateTime
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * @return \DateTime
     */
    public function getDataCompra()
    {
        return $this->dataCompra;
    }

    /**
     * @param \DateTime $dataCompra
     * @return Equipamento
     */
    public function setDataCompra($dataCompra)
    {
        $this->dataCompra = $dataCompra;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorCompra()
    {
        return $this->valorCompra;
    }

    /**
     * @param string $valorCompra
     * @return Equipamento
     */
    public function setValorCompra($valorCompra)
    {
        $this->valorCompra = $valorCompra;
        return $this;
    }


    /**
     * Set numeroserie
     *
     * @param string $numeroserie
     * @return Equipamento
     */
    public function setNumeroserie($numeroserie)
    {
        $this->numeroserie = $numeroserie;

        return $this;
    }

    /**
     * Get numeroserie
     *
     * @return string
     */
    public function getNumeroserie()
    {
        return $this->numeroserie;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Equipamento
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set patrimonio
     *
     * @param string $patrimonio
     * @return Equipamento
     */
    public function setPatrimonio($patrimonio)
    {
        $this->patrimonio = $patrimonio;

        return $this;
    }

    /**
     * Get patrimonio
     *
     * @return string
     */
    public function getPatrimonio()
    {
        return $this->patrimonio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Equipamento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Equipamento
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

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
     * Set centroMovimentacao
     *
     * @param App\Entity\CentroMovimentacao $centroMovimentacao
     * @return Equipamento
     */
    public function setCentroMovimentacao(CentroMovimentacao $centroMovimentacao = null)
    {
        $this->centroMovimentacao = $centroMovimentacao;

        return $this;
    }

    /**
     * Get centroMovimentacao
     *
     * @return App\Entity\CentroMovimentacao
     */
    public function getCentroMovimentacao()
    {
        return $this->centroMovimentacao;
    }

    /**
     * Set marca
     *
     * @param App\Entity\Marca $marca
     * @return Equipamento
     */
    public function setMarca(Marca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return App\Entity\Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set fornecedor
     *
     * @param App\Entity\Fornecedor $fornecedor
     * @return Equipamento
     */
    public function setFornecedor(Fornecedor $fornecedor = null)
    {
        $this->fornecedor = $fornecedor;

        return $this;
    }

    /**
     * Get fornecedor
     *
     * @return App\Entity\Fornecedor
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * Set tipoequipamento
     *
     * @param App\Entity\Tipoequipamento $tipoequipamento
     * @return Equipamento
     */
    public function setTipoequipamento(Tipoequipamento $tipoequipamento = null)
    {
        $this->tipoequipamento = $tipoequipamento;

        return $this;
    }

    /**
     * Get tipoequipamento
     *
     * @return App\Entity\Tipoequipamento
     */
    public function getTipoequipamento()
    {
        return $this->tipoequipamento;
    }

    public function __toString()
    {
        return $this->getPatrimonio(). ' | ' . $this->getNome();
    }
}
