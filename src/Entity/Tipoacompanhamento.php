<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Tipoacompanhamento
 *
 * @ORM\Table(name="tipoAcompanhamento", uniqueConstraints={@ORM\UniqueConstraint(name="unique_nome", columns={"nome"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'tipoAcompanhamento')]
#[ORM\Entity]
#[UniqueEntity(fields: ['nome'], message: 'Esse nome já foi usado',errorPath: 'nome')]
class Tipoacompanhamento
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    #[ORM\Column(name:'nome', length:45, nullable:false)]
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
     * Set nome
     *
     * @param string $nome
     * @return Tipoacompanhamento
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
