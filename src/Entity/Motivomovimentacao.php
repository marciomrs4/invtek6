<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Tipomovimentacao;

/**
 * Motivomovimentacao
 *
 * @ORM\Table(name="motivoMovimentacao", indexes={@ORM\Index(name="fk_motivoMovimentacao_tipoMovimentacao1_idx", columns={"tipoMovimentacao_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'motivoMovimentacao')]
#[ORM\Entity]
class Motivomovimentacao
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     */
    #[ORM\Column(name:'descricao', length:255, nullable: false)]    
    private ?string $descricao;

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
     * @var \MRS\InventarioBundle\Entity\Tipomovimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipomovimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoMovimentacao_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Tipomovimentacao::class )]
    #[ORM\JoinColumn(name: 'tipoMovimentacao_id', referencedColumnName: 'id')]        
    private $tipomovimentacao;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Motivomovimentacao
     */
    public function setDescricao($descricao): Motivomovimentacao
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
     * Get id
     *
     * @return integer 
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set tipomovimentacao
     *
     * @param App\Entity\Tipomovimentacao $tipomovimentacao
     * @return Motivomovimentacao
     */
    public function setTipomovimentacao(Tipomovimentacao $tipomovimentacao = null): Motivomovimentacao
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
        return $this->getDescricao() . ' | ' . $this->getTipomovimentacao()->getNome();
    }
}
