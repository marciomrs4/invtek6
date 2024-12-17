<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Tiposoftware;
use App\Entity\FornecedorSoftware;
use App\Repository\SoftwareRepository;
/**
 * Software
 *
 * @ORM\Table(name="software", indexes={@ORM\Index(name="fk_software_tipoSoftware1_idx", columns={"tipoSoftware_id"})})
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\SoftwareRepository")
 */
#[ORM\Table(name:'software')]
#[ORM\Entity(repositoryClass: SoftwareRepository::class)]
class Software
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     */
    #[ORM\Column(name:'descricao', length:255, nullable: false)]
    #[Assert\NotBlank(message: 'Este campo não deve ser vazio')]    
    private ?string $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="numerolicensa", type="integer", nullable=true)
     */
    #[ORM\Column(name:'numerolicensa', nullable: true)]    
    private ?int $numerolicensa;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroreserva", type="integer", nullable=true)
     */
    #[ORM\Column(name:'numeroreserva',  nullable: true)]    
    private ?int $numeroreserva;

    /**
     * @var string
     *
     * @ORM\Column(name="versao", type="string", length=45, nullable=true)
     */
    #[ORM\Column(name:'versao', length:45, nullable: true)]    
    private ?string $versao;

    /**
     * @var string
     *
     * @ORM\Column(name="serial", type="string", length=45, nullable=true)
     */
    #[ORM\Column(name:'serial', length:45, nullable: true)]    
    private ?string $serial;

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
     * @var \MRS\InventarioBundle\Entity\Tiposoftware
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tiposoftware")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoSoftware_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Tiposoftware::class)]
    #[ORM\JoinColumn(name: 'tipoSoftware_id', referencedColumnName:'id')]
    private $tiposoftware;


    /**
     * @var \MRS\InventarioBundle\Entity\FornecedorSoftware
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\FornecedorSoftware")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fornecedor_software_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Fornecedor é obrigatório")
     */
    #[ORM\ManyToOne(targetEntity: FornecedorSoftware::class)]
    #[ORM\JoinColumn(name: 'fornecedor_software_id', referencedColumnName:'id')]    
    #[Assert\NotBlank(message:'Fornecedor é obrigatório')]
    private $fornecedor;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Software
     */
    public function setDescricao($descricao): Software
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
     * Set numerolicensa
     *
     * @param string $numerolicensa
     * @return Software
     */
    public function setNumerolicensa($numerolicensa): Software
    {
        $this->numerolicensa = $numerolicensa;

        return $this;
    }

    /**
     * Get numerolicensa
     *
     * @return string
     */
    public function getNumerolicensa(): string
    {
        return $this->numerolicensa;
    }

    /**
     * Set numeroreserva
     *
     * @param string $numeroreserva
     * @return Software
     */
    public function setNumeroReserva($numeroreserva): Software
    {
        $this->numeroreserva = $numeroreserva;

        return $this;
    }

    /**
     * Get numeroreserva
     *
     * @return string
     */
    public function getNumeroReserva(): string
    {
        return $this->numeroreserva;
    }

    /**
     * Set versao
     *
     * @param string $versao
     * @return Software
     */
    public function setVersao($versao): Software
    {
        $this->versao = $versao;

        return $this;
    }

    /**
     * Get versao
     *
     * @return string 
     */
    public function getVersao(): string
    {
        return $this->versao;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return Software
     */
    public function setSerial($serial): Software
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial(): string
    {
        return $this->serial;
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
     * Set tiposoftware
     *
     * @param App\Entity\Tiposoftware $tiposoftware
     * @return Software
     */
    public function setTiposoftware(Tiposoftware $tiposoftware = null): Software
    {
        $this->tiposoftware = $tiposoftware;

        return $this;
    }

    /**
     * Get tiposoftware
     *
     * @return App\Entity\Tiposoftware 
     */
    public function getTiposoftware(): App\Entity\Tiposoftware
    {
        return $this->tiposoftware;
    }

    public function __toString()
    {
        return $this->getDescricao();
    }

    /**
     * Set fornecedor
     *
     * @param App\Entity\FornecedorSoftware $fornecedor
     *
     * @return Software
     */
    public function setFornecedor(FornecedorSoftware $fornecedor = null): Software
    {
        $this->fornecedor = $fornecedor;

        return $this;
    }

    /**
     * Get fornecedor
     *
     * @return App\Entity\FornecedorSoftware
     */
    public function getFornecedor(): App\Entity\FornecedorSoftware
    {
        return $this->fornecedor;
    }
}
