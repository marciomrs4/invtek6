<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Tipocomponente;

/**
 * Componente
 *
 * @ORM\Table(name="componente", indexes={@ORM\Index(name="fk_componente_tipoComponente_idx", columns={"tipoComponente_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'componente')]
#[ORM\Entity]
class Componente
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name:'descricao', length: 255, nullable: false)]
    private $descricao;

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
     * @var \MRS\InventarioBundle\Entity\Tipocomponente
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Tipocomponente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoComponente_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Tipocomponente::class)]
    #[ORM\JoinColumn(name:'tipoComponente_id' , referencedColumnName:'id')]
    private $tipocomponente;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Componente
     */
    public function setDescricao($descricao): Componente
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
     * Set tipocomponente
     *
     * @param App\Tipocomponente $tipocomponente
     * @return Componente
     */
    public function setTipocomponente(Tipocomponente $tipocomponente = null): Componente
    {
        $this->tipocomponente = $tipocomponente;

        return $this;
    }

    /**
     * Get tipocomponente
     *
     * @return App\Entity\Tipocomponente 
     */
    public function getTipocomponente()
    {
        return $this->tipocomponente;
    }

    public function __toString()
    {
        return $this->getDescricao();
    }

}
