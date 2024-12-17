<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipocomponente
 *
 * @ORM\Table(name="tipoComponente")
 * @ORM\Entity
 */
#[ORM\Table(name:'tipoComponente')]
#[ORM\Entity]
class Tipocomponente
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
     * Set descricao
     *
     * @param string $descricao
     * @return Tipocomponente
     */
    public function setDescricao($descricao): Tipocomponente
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

    public function __toString()
    {
        return $this->getDescricao();
    }

}
