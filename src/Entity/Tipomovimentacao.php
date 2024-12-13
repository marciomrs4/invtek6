<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipomovimentacao
 *
 * @ORM\Table(name="tipoMovimentacao")
 * @ORM\Entity
 */
#[ORM\Table(name:'tipoMovimentacao')]
#[ORM\Entity]
class Tipomovimentacao
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
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
     * Set nome
     *
     * @param string $nome
     * @return Tipomovimentacao
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getNome();
    }
}
