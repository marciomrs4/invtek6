<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Equipamento;

/**
 * EquipamentoTag
 *
 * @ORM\Table(name="equipamento_tag", indexes={@ORM\Index(name="fk_equipamento_tag_equipamento1_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'equipamento_tag')]
#[ORM\Entity]
class EquipamentoTag
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Este campo não deve ser vazio")
     */
    #[ORM\Column(name:'descricao', length:255, nullable: false)]
    #[Assert\NotBlank(message: 'Este campo não deve ser vazio')]
    private ?string $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="Este campo não deve ser vazio")
     */
    #[ORM\Column(name:'nome', length:45, nullable: false)]
    #[Assert\NotBlank(message: 'Este campo não deve ser vazio')]    
    private ?string $nome;

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
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class )]
    #[ORM\JoinColumn(name: 'equipamento_id', referencedColumnName: 'id')]    
    private $equipamento;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return EquipamentoTag
     */
    public function setDescricao($descricao): EquipamentoTag
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
     * Set nome
     *
     * @param string $nome
     * @return EquipamentoTag
     */
    public function setNome($nome): EquipamentoTag
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
     * Set equipamento
     *
     * @param App\Entity\Equipamento $equipamento
     * @return EquipamentoTag
     */
    public function setEquipamento(Equipamento $equipamento = null): EquipamentoTag
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
