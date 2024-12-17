<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Movimentacao;
use App\Entity\Equipamento;

/**
 * ItensMovimentacao
 *
 * @ORM\Table(name="itens_movimentacao", indexes={@ORM\Index(name="fk_intens_movimentadocao_equipamento1_idx", columns={"equipamento_id"}), @ORM\Index(name="fk_intens_movimentadocao_movimentacao1_idx", columns={"movimentacao_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'itens_movimentacao')]
#[ORM\Entity]
class ItensMovimentacao
{
    /**
     * @var string
     *
     * @ORM\Column(name="numero_chamado", type="string", length=45, nullable=true)
     */
    #[ORM\Column(name:'numero_chamado', length:45, nullable: true)]    
    private ?string $numeroChamado;

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
     * @var \MRS\InventarioBundle\Entity\Movimentacao
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Movimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movimentacao_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Movimentacao::class )]
    #[ORM\JoinColumn(name: 'movimentacao_id', referencedColumnName: 'id')]     
    private $movimentacao;

    /**
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Deve ser informado um equipamento")
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class )]
    #[ORM\JoinColumn(name: 'equipamento_id', referencedColumnName: 'id')]     
    #[Assert\NotBlank(message: 'Deve ser informado um equipamento')]
    private $equipamento;



    /**
     * Set numeroChamado
     *
     * @param string $numeroChamado
     * @return ItensMovimentacao
     */
    public function setNumeroChamado($numeroChamado): ItensMovimentacao
    {
        $this->numeroChamado = $numeroChamado;

        return $this;
    }

    /**
     * Get numeroChamado
     *
     * @return string 
     */
    public function getNumeroChamado(): string
    {
        return $this->numeroChamado;
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
     * Set movimentacao
     *
     * @param App\Entity\Movimentacao $movimentacao
     * @return ItensMovimentacao
     */
    public function setMovimentacao(Movimentacao $movimentacao = null): ItensMovimentacao
    {
        $this->movimentacao = $movimentacao;

        return $this;
    }

    /**
     * Get movimentacao
     *
     * @return App\Entity\Movimentacao 
     */
    public function getMovimentacao(): App\Entity\Movimentacao
    {
        return $this->movimentacao;
    }

    /**
     * Set equipamento
     *
     * @param App\Entity\Equipamento $equipamento
     * @return ItensMovimentacao
     */
    public function setEquipamento(Equipamento $equipamento = null): ItensMovimentacao
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
