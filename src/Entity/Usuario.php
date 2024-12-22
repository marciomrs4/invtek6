<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\CentroMovimentacao;
use Doctrine\DBAL\Types\Types;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
//use User;
/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="fk_usuario_departamento1_idx", columns={"departamento_id"})})
 * @ORM\Entity
 */
#[Audit\Auditable()]
#[ORM\Table(name:'usuario')]
#[ORM\Entity]
class Usuario
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomeCompleto", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Este campo deve ser preenchido")
     */
    #[ORM\Column(name:'nomeCompleto', length:255, nullable:false)]
    #[Assert\NotBlank(message:'Este campo deve ser preenchido')]
    private ?string $nomecompleto;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_identificacao", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Este campo deve ser preenchido")
     */
    #[ORM\Column(name:'numero_identificacao', length:255, nullable:true)]
    #[Assert\NotBlank(message:'Este campo deve ser preenchido')]
    private ?string $numeroIdentificacao;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    #[ORM\Column(name:'observacao', nullable:true)]
    private ?string $observacao;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Este campo deve ser preenchido")
     */
    #[ORM\Column(name:'nome', length:45, nullable:false)]
    #[Assert\NotBlank(message:'Este campo deve ser preenchido')]
    private ?string $nome;

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

    /**
     * @var \MRS\InventarioBundle\Entity\CentroMovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\CentroMovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Este campo deve ser preenchido")
     */
    #[ORM\ManyToOne(targetEntity: CentroMovimentacao::class)]
    #[ORM\JoinColumn(name:'departamento_id', referencedColumnName:'id')]
    #[Assert\NotBlank(message:'Este campo deve ser preenchido')]
    private $departamento;

    /**
     * @var \MRS\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="MRS\UserBundle\Entity\User", inversedBy="usuario")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */

    private $user_id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    #[ORM\Column(name:'status', type: Types::BOOLEAN)]
    private $status;


    public function __construct()
    {
        $this->status = true;
    }

    /**
     * @return string
     */
    public function getNumeroIdentificacao(): string
    {
        return $this->numeroIdentificacao;
    }

    /**
     * @param string $numeroIdentificacao
     * @return Usuario
     */
    public function setNumeroIdentificacao($numeroIdentificacao): Usuario
    {
        $this->numeroIdentificacao = $numeroIdentificacao;
        return $this;
    }


    /**
     * @return string
     */
    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    /**
     * @param string $observacao
     * @return Usuario
     */
    public function setObservacao($observacao): Usuario
    {
        $this->observacao = $observacao;
        return $this;
    }


    /**
     * @return boolean
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     * @return Usuario
     */
    public function setStatus($status): Usuario
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \MRS\UserBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param \MRS\UserBundle\Entity\User
     * @return Usuario
     */
    public function setUserId(\MRS\UserBundle\Entity\User $user_id = null): Usuario
    {
        $this->user_id = $user_id;
        return $this;
    }


    /**
     * Set nomecompleto
     *
     * @param string $nomecompleto
     * @return Usuario
     */
    public function setNomecompleto($nomecompleto): Usuario
    {
        $this->nomecompleto = $nomecompleto;

        return $this;
    }

    /**
     * Get nomecompleto
     *
     * @return string 
     */
    public function getNomecompleto(): string
    {
        return $this->nomecompleto;
    }



    /**
     * Set nome
     *
     * @param string $nome
     * @return Usuario
     */
    public function setNome($nome): Usuario
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome(): string
    {
        return $this->nome;
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
     * Set departamento
     *
     * @param App\Entity\CentroMovimentacao $departamento
     * @return Usuario
     */
    public function setDepartamento(CentroMovimentacao $departamento = null): Usuario
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \MRS\InventarioBundle\Entity\CentroMovimentacao 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function __toString()
    {
        return $this->getNomecompleto() . ' | ' .  $this->getDepartamento()->getNome();
    }
}
