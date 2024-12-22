<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\MovimentacaoRepository;

use App\Entity\Usuario;
use App\Entity\User;
use App\Entity\Motivomovimentacao;
use App\Entity\Tipomovimentacao;

use Doctrine\DBAL\Types\Types;

use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

/**
 * Movimentacao
 *
 * @ORM\Table(name="movimentacao", indexes={@ORM\Index(name="fk_movimentacao_tipoMovimentacao1_idx", columns={"tipoMovimentacao_id"}), @ORM\Index(name="fk_movimentacao_motivoMovimentacao1_idx", columns={"motivoMovimentacao_id"}), @ORM\Index(name="fk_movimentacao_usuario1_idx", columns={"usuario_id_criador"}), @ORM\Index(name="fk_movimentacao_usuario2_idx", columns={"usuario_id_origem"}), @ORM\Index(name="fk_movimentacao_usuario3_idx", columns={"usuario_id_destino"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\MovimentacaoRepository")
 */
#[Audit\Auditable()]
#[ORM\Table(name:'movimentacao')]
#[ORM\Entity(repositoryClass: MovimentacaoRepository::class)]
class Movimentacao
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataHora", type="datetime", nullable=false)
     * @Assert\NotBlank(message="O campo Data e Hora é obrigatório")
     */
    #[ORM\Column(name:'dataHora', type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Assert\NotBlank(message: 'O campo Data e Hora é obrigatório')]    
    private $datahora;

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
     * @var \MRS\InventarioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id_destino", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um usuário Destino")
     */
    #[ORM\ManyToOne(targetEntity: Usuario::class )]
    #[ORM\JoinColumn(name: 'usuario_id_destino', referencedColumnName: 'id')]        
    #[Assert\NotBlank(message: 'Deve haver um usuário Destino')]
    private $usuarioDestino;

    /**
     * @var \MRS\InventarioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id_origem", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um usuário Origem")
     */
    #[ORM\ManyToOne(targetEntity: Usuario::class )]
    #[ORM\JoinColumn(name: 'usuario_id_origem', referencedColumnName: 'id')]        
    #[Assert\NotBlank(message: 'Deve haver um usuário Origem')]
    private $usuarioOrigem;

    /**
     * @var \MRS\InventarioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id_criador", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um usuário Criador")
     */
    #[ORM\ManyToOne(targetEntity: User::class )]
    #[ORM\JoinColumn(name: 'usuario_id_criador', referencedColumnName: 'id')]        
    #[Assert\NotBlank(message:'Deve haver um usuário Criador')]
    private $usuarioCriador;

    /**
     * @var \MRS\InventarioBundle\Entity\Motivomovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Motivomovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="motivoMovimentacao_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um motivo de movimentação")
     */
    #[ORM\ManyToOne(targetEntity: Motivomovimentacao::class )]
    #[ORM\JoinColumn(name: 'motivoMovimentacao_id', referencedColumnName: 'id')]        
    #[Assert\NotBlank(message: 'Deve haver um motivo de movimentação')]
    private $motivomovimentacao;

    /**
     * @var \MRS\InventarioBundle\Entity\Tipomovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipomovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoMovimentacao_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve haver um tipo de movimentação")
     */
    #[ORM\ManyToOne(targetEntity: Tipomovimentacao::class )]
    #[ORM\JoinColumn(name: 'tipoMovimentacao_id', referencedColumnName: 'id')]        
    #[Assert\NotBlank(message: 'Deve haver um tipo de movimentação')]
    private $tipomovimentacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="status", type="boolean")
     */
    #[ORM\Column(name:'status', type: Types::BOOLEAN)]
    private $status;

    public function __construct()
    {
        $this->datahora = new \DateTime('now');
    }



    /**
     * @return boolean
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     * @return Movimentacao
     */
    public function setStatus($status): Movimentacao
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set datahora
     *
     * @param \DateTime $datahora
     * @return Movimentacao
     */
    public function setDatahora($datahora): Movimentacao
    {
        $this->datahora = $datahora;

        return $this;
    }

    /**
     * Get datahora
     *
     * @return \DateTime 
     */
    public function getDatahora()
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
     * Set usuarioDestino
     *
     * @param App\Entity\Usuario $usuarioDestino
     * @return Movimentacao
     */
    public function setUsuarioDestino(Usuario $usuarioDestino = null): Movimentacao
    {
        $this->usuarioDestino = $usuarioDestino;

        return $this;
    }

    /**
     * Get usuarioDestino
     *
     * @return App\Entity\Usuario 
     */
    public function getUsuarioDestino()
    {
        return $this->usuarioDestino;
    }

    /**
     * Set usuarioOrigem
     *
     * @param App\Entity\Usuario $usuarioOrigem
     * @return Movimentacao
     */
    public function setUsuarioOrigem(Usuario $usuarioOrigem = null): Movimentacao
    {
        $this->usuarioOrigem = $usuarioOrigem;

        return $this;
    }

    /**
     * Get usuarioOrigem
     *
     * @return App\Entity\Usuario 
     */
    public function getUsuarioOrigem()
    {
        return $this->usuarioOrigem;
    }

    /**
     * Set usuarioCriador
     *
     * @param App\Entity\Usuario $usuarioCriador
     * @return Movimentacao
     */
    public function setUsuarioCriador(User $usuarioCriador = null): Movimentacao
    {
        $this->usuarioCriador = $usuarioCriador;

        return $this;
    }

    /**
     * Get usuarioCriador
     *
     * @return App\Entity\Usuario 
     */
    public function getUsuarioCriador()
    {
        return $this->usuarioCriador;
    }

    /**
     * Set motivomovimentacao
     *
     * @param App\Entity\Motivomovimentacao $motivomovimentacao
     * @return Movimentacao
     */
    public function setMotivomovimentacao(Motivomovimentacao $motivomovimentacao = null): Movimentacao
    {
        $this->motivomovimentacao = $motivomovimentacao;

        return $this;
    }

    /**
     * Get motivomovimentacao
     *
     * @return App\Entity\Motivomovimentacao 
     */
    public function getMotivomovimentacao()
    {
        return $this->motivomovimentacao;
    }

    /**
     * Set tipomovimentacao
     *
     * @param App\Entity\Tipomovimentacao $tipomovimentacao
     * @return Movimentacao
     */
    public function setTipomovimentacao(Tipomovimentacao $tipomovimentacao = null): Movimentacao
    {
        $this->tipomovimentacao = $tipomovimentacao;

        return $this;
    }

    /**
     * Get tipomovimentacao
     *
     * @return App\Entity\Tipomovimentacao 
     */
    public function getTipomovimentacao()
    {
        return $this->tipomovimentacao;
    }

    public function __toString()
    {
        return (string) $this->getId() . '  | ' . $this->getDatahora()->format('d-m-Y H:i:s');
    }
}
