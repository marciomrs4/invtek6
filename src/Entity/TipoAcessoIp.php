<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;

#[Audit\Auditable()]
#[ORM\Table(name:'tipo_acesso_ip')]
#[ORM\Entity]
class TipoAcessoIp
{

    #[ORM\Column(name:'nome', length:45, nullable: false)]
    private ?string $nome;


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
    public function setNome($nome): TipoAcessoIp
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

    public function __toString()
    {
        return $this->getNome();
    }
}
