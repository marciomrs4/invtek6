<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\DBAL\Types\Types;

/**
 * FornecedorSoftware
 *
 * @ORM\Table(name="fornecedor_software")
 * @ORM\Entity
 */
#[ORM\Table(name:'fornecedor_software')]
#[ORM\Entity]
class FornecedorSoftware
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    #[ORM\Column(name:'nome', length:45, nullable: false)]    
    private ?string $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
     */
    #[ORM\Column(name:'descricao', length:255, nullable: true)]    
    private ?string $descricao;

    /**
     * @var boolean
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    #[ORM\Column(name:'status', type: Types::BOOLEAN , nullable: false)]    
    private $status;

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

    public function __construct()
    {
        $this->status = true;
    }

    public function __toString()
    {
        return $this->getNome();
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return FornecedorSoftware
     */
    public function setNome($nome): FornecedorSoftware
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
     * Set descricao
     *
     * @param string $descricao
     *
     * @return FornecedorSoftware
     */
    public function setDescricao($descricao): FornecedorSoftware
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
     * Set status
     *
     * @param boolean $status
     *
     * @return FornecedorSoftware
     */
    public function setStatus($status): FornecedorSoftware
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus(): bool
    {
        return $this->status;
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
}
