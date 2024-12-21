<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Types\Types;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use App\Entity\StatusIp;
use App\Entity\TipoAcessoIp;

/**
 * EnderecoIp
 *
 * @ORM\Table(name="endereco_ip", indexes={@ORM\Index(name="categoria_ip_fk_idx", columns={"status_id"}), @ORM\Index(name="tipo_acesso_ip_fk_idx", columns={"tipo_acesso_ip_id"})})
 * @ORM\Entity
 * @UniqueEntity(fields={"enderecoIp"},ignoreNull=true,message="Já existe um registro como este IP")

 */
#[Audit\Auditable()]
#[Audit\Security(view: ['ROLE_ADMIN'] )]
#[ORM\Table(name:'endereco_ip')]
#[ORM\Entity]
#[UniqueEntity(fields: ['enderecoIp'], message: 'Já existe um registro como este IP',errorPath: 'enderecoIp')]    
class EnderecoIp
{
    /**
     * @var string
     *
     * @ORM\Column(name="endereco_ip", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Campo Obrigatório")
     * @Assert\Ip(message="Deve ser um IP valido")
     */
    #[ORM\Column(name:'endereco_ip', length: 45, nullable: false)]
    #[Assert\Ip(message:'Deve ser um IP valido')]
    #[Assert\NotBlank(message:'Campo Obrigatório')]
    private ?string $enderecoIp;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=true)
     * @Assert\NotBlank(message="Campo Obrigatório")
     */
    #[ORM\Column(name:'nome', length: 45, nullable: true)]
    #[Assert\NotBlank(message:"O Campo Host Name é Obrigatório")]
    private ?string $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
     */
    #[ORM\Column(name: 'observacao', length: 255, nullable: true)]
    #[Assert\Length(max:255, maxMessage:'Ultrapassou 255 caracteres')]
    private ?string $observacao;

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
     * @var \MRS\InventarioBundle\Entity\TipoAcessoIp
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\TipoAcessoIp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_acesso_ip_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Campo Obrigatório")
     */
    #[ORM\ManyToOne(targetEntity: TipoAcessoIp::class)]
    #[ORM\JoinColumn(name: 'tipo_acesso_ip_id', referencedColumnName:'id')]
    #[Assert\NotBlank(message:'Campo Obrigatório')]
    private $tipoAcessoIp;

    /**
     * @var \MRS\InventarioBundle\Entity\StatusIp
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\StatusIp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Campo Obrigatório")
     */
    #[ORM\ManyToOne(targetEntity: StatusIp::class )]
    #[ORM\JoinColumn(name:'status_id', referencedColumnName:'id')]
    private $status;

    /**
     * @var \MRS\InventarioBundle\Entity\Unidade
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidade_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Campo Obrigatório")
     */
    #[ORM\ManyToOne(targetEntity: Unidade::class)]
    #[ORM\JoinColumn(name:'unidade_id', referencedColumnName:'id')]
    private $unidade;

    /**
     * @var boolean
     * @ORM\Column(name="do_ping", type="boolean", nullable=true)
     */
    #[ORM\Column(name:'do_ping', type: Types::BOOLEAN )]
    private $doPing;

    /**
     * Set enderecoIp
     *
     * @param string $enderecoIp
     *
     * @return EnderecoIp
     */
    public function setEnderecoIp($enderecoIp): EnderecoIp
    {
        $this->enderecoIp = $enderecoIp;

        return $this;
    }


    /**
     * Get enderecoIp
     *
     * @return string
     */
    public function getEnderecoIp(): string
    {
        return $this->enderecoIp;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return EnderecoIp
     */
    public function setNome($nome): EnderecoIp
    {
        $this->nome = strtoupper($nome);

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome(): string
    {
        return strtoupper($this->nome);
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     *
     * @return EnderecoIp
     */
    public function setObservacao($observacao): EnderecoIp
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao(): string
    {
        return $this->observacao;
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
     * Set tipoAcessoIp
     *
     * @param App\Entity\TipoAcessoIp $tipoAcessoIp
     *
     * @return EnderecoIp
     */
    public function setTipoAcessoIp(TipoAcessoIp $tipoAcessoIp): EnderecoIp
    {
        $this->tipoAcessoIp = $tipoAcessoIp;

        return $this;
    }

    /**
     * Get tipoAcessoIp
     *
     * @return App\Entity\TipoAcessoIp
     */
    public function getTipoAcessoIp(): ?TipoAcessoIp
    {
        return $this->tipoAcessoIp;
    }

    /**
     * Set categoria
     *
     * @param App\Entity\StatusIp $status
     *
     * @return EnderecoIp
     */
    public function setStatus(StatusIp $status): EnderecoIp
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return App\Entity\StatusIp
     */
    public function getStatus(): ?App\Entity\StatusIp
    {
        return $this->status;
    }

    /**
     * Set unidade
     *
     * @param App\Entity\Unidade $unidade
     *
     * @return EnderecoIp
     */
    public function setUnidade(Unidade $unidade = null): EnderecoIp
    {
        $this->unidade = $unidade;

        return $this;
    }

    /**
     * Get unidade
     *
     * @return App\Entity\Unidade
     */
    public function getUnidade(): ?App\Entity\Unidade
    {
        return $this->unidade;
    }

    /**
     * @return boolean
     */
    public function isDoPing(): bool
    {
        return $this->doPing;
    }

    /**
     * @param boolean $doPing
     * @return EnderecoIp
     */
    public function setDoPing($doPing): EnderecoIp
    {
        $this->doPing = $doPing;
        return $this;
    }
    
}
