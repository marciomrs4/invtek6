<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Unidade;

/**
 * CentroMovimentacao
 *
 * @ORM\Table(name="centro_movimentacao", indexes={@ORM\Index(name="fk_departamento_unidade1_idx", columns={"unidade_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'centro_movimentacao')]
#[ORM\Entity]
class CentroMovimentacao
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    #[ORM\Column(name:'nome', length:45, nullable: false)]
    private ?string $nome;

    /**
     * @var integer
     * @ORM\Column(name="tempo_prevencao", type="integer", nullable=true)
     */
    #[ORM\Column(name: 'tempo_prevencao', nullable:true)]
    private ?int $tempoPrevencao;

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
     * @var \MRS\InventarioBundle\Entity\Unidade
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Unidade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidade_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Unidade::class)]
    #[ORM\JoinColumn(name:'unidade_id', referencedColumnName:'id')]
    private $unidade;



    /**
     * Set nome
     *
     * @param string $nome
     * @return CentroMovimentacao
     */
    public function setNome($nome): CentroMovimentacao
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
     * Set unidade
     *
     * @param App\Entity\Unidade $unidade
     * @return CentroMovimentacao
     */
    public function setUnidade(Unidade $unidade = null): CentroMovimentacao
    {
        $this->unidade = $unidade;

        return $this;
    }

    /**
     * Get unidade
     *
     * @return App\Entity\Unidade 
     */
    public function getUnidade()
    {
        return $this->unidade;
    }

    public function __toString()
    {
        return $this->getNome() .' | '. $this->getUnidade();
    }

    /**
     * Set tempoPrevencao
     *
     * @param integer $tempoPrevencao
     *
     * @return CentroMovimentacao
     */
    public function setTempoPrevencao($tempoPrevencao): CentroMovimentacao
    {
        $this->tempoPrevencao = $tempoPrevencao;

        return $this;
    }

    /**
     * Get tempoPrevencao
     *
     * @return integer
     */
    public function getTempoPrevencao(): int
    {
        return $this->tempoPrevencao;
    }
}
