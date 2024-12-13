<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
/**
 * Fornecedor
 *
 * @ORM\Table(name="fornecedor")
 * @ORM\Entity
 */
#[Audit\Auditable()]
#[ORM\Table(name:'fornecedor')]
#[ORM\Entity]
class Fornecedor
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name:'nome', length:255, nullable: false)]    
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
     * @return Fornecedor
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
