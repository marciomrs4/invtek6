<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
/**
 * TipoAcessoIp
 *
 * @ORM\Table(name="tipo_acesso_ip")
 * @ORM\Entity
 */
#[Audit\Auditable()]
#[ORM\Table(name:'tipo_acesso_ip')]
#[ORM\Entity]
class TipoAcessoIp
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
     * Set nome
     *
     * @param string $nome
     *
     * @return TipoAcessoIp
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