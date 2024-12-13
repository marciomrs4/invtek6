<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Software;

/**
 * SoftwareTag
 *
 * @ORM\Table(name="software_tag", indexes={@ORM\Index(name="fk_software_tag_software1_idx", columns={"software_id"})})
 * @ORM\Entity
 */
#[ORM\Table(name:'software_tag')]
#[ORM\Entity]
class SoftwareTag
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=true)
     * @Assert\NotBlank(message="O campo descricao não pode ser vazio")
     */
    #[ORM\Column(name:'descricao', length:255, nullable: false)]
    #[Assert\NotBlank(message: 'O campo descricao não pode ser vazio')]    
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=true)
     * @Assert\NotBlank(message="O campo descricao não pode ser vazio")
     */
    #[ORM\Column(name:'nome', length:45, nullable: false)]
    #[Assert\NotBlank(message: 'O campo descricao não pode ser vazio')]        
    private $nome;

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
     * @var \MRS\InventarioBundle\Entity\Software
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Software")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="software_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Software::class)]
    #[ORM\JoinColumn(name: 'software_id', referencedColumnName:'id')]
    private $software;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SoftwareTag
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return SoftwareTag
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

    /**
     * Set software
     *
     * @param App\Entity\Software $software
     * @return SoftwareTag
     */
    public function setSoftware(Software $software = null)
    {
        $this->software = $software;

        return $this;
    }

    /**
     * Get software
     *
     * @return App\Entity\Software 
     */
    public function getSoftware()
    {
        return $this->software;
    }

    public function __toString()
    {
        return $this->getNome();
    }
}
