<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CustoEquipamentoRepository;
use App\Entity\Equipamento;
use App\Entity\Acompanhamento;
use App\Entity\Usuario;
use Doctrine\DBAL\Types\Types;
/**
 * Equipamento
 *
 * @ORM\Table(name="custo_equipamento", indexes={@ORM\Index(name="fk_equipamento_custo", columns={"equipamento_id"}), @ORM\Index(name="fk_usuario_id", columns={"usuario_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\CustoEquipamentoRepository")
 */
#[ORM\Table(name:'custo_equipamento')]
#[ORM\Entity(repositoryClass:CustoEquipamentoRepository::class)]
class CustoEquipamento
{
    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="decimal", precision=10, scale=2 ,nullable=false)
     * @Assert\NotBlank(message="O campo valor é obrigatorio.")
     */
    #[ORM\Column(name:'valor' , type: Types::DECIMAL, scale:2, nullable:false)]
    #[Assert\NotBlank(message:'O campo valor é obrigatorio.')]
    private $valor;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class)]
    #[ORM\JoinColumn(name:'equipamento_id', referencedColumnName:'id')]
    private $equipamento;

    /**
     * @var \MRS\InventarioBundle\Entity\Acompanhamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Acompanhamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="acompanhamento_id", referencedColumnName="id", nullable=true)
     * })
     */
    #[ORM\ManyToOne(targetEntity: Acompanhamento::class)]
    #[ORM\JoinColumn(name:'acompanhamento_id', referencedColumnName:'id')]    
    private $acompanhamento;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535,nullable=true)
     */
    #[ORM\Column(name:'descricao', length:255, nullable:true)]
    private ?string $descricao;

    /**
     * @var \DateTime
     * @ORM\Column(name="data_criacao", type="date", nullable=false)
     */
    #[ORM\Column(name:'data_criacao', type: Types::DATE_MUTABLE, nullable:false)]
    private $data_criacao;


    /**
     * @var \MRS\InventarioBundle\Entity\Usuario
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName:'id')]
    private $usuario;

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
    private ?int $id;


    public function __construct() 
    {
        $this->data_criacao = new \DateTime('now');
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return CustoEquipamento
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return CustoEquipamento
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set equipamento
     *
     * @param App\Entity\Equipamento $equipamento
     *
     * @return CustoEquipamento
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

    /**
     * Set usuario
     *
     * @param App\Entity\Usuario $usuario
     *
     * @return CustoEquipamento
     */
    public function setUsuario(User $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return App\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return CustoEquipamento
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->data_criacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * Set acompanhamento
     *
     * @param App\Entity\Acompanhamento $acompanhamento
     *
     * @return CustoEquipamento
     */
    public function setAcompanhamento(Acompanhamento $acompanhamento = null)
    {
        $this->acompanhamento = $acompanhamento;

        return $this;
    }

    /**
     * Get acompanhamento
     *
     * @return App\Entity\Acompanhamento
     */
    public function getAcompanhamento()
    {
        return $this->acompanhamento;
    }
}
