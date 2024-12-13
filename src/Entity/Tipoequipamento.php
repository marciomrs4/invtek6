<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\TipoequipamentoRepository;

/**
 * Tipoequipamento
 *
 * @ORM\Table(name="tipoEquipamento")
 * @ORM\Entity(repositoryClass="MRS\InventarioBundle\Repository\TipoequipamentoRepository")
 */
#[ORM\Table(name: 'tipoEquipamento')]
#[ORM\Entity(repositoryClass: TipoequipamentoRepository::class )]
class Tipoequipamento
{

    /**
     * @var string
     *
     * @ORM\Column(name="icone", type="string", length=45, nullable=true)
     */
    #[ORM\Column(name:'icone', length:45, nullable:true)]
    private ?string $icone;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     * @Assert\NotBlank(message="O campo descrição é obrigatório")
     */
    #[ORM\Column(name: 'descricao', length:45, nullable:false)]
    #[Assert\NotBlank(message:'O campo descrição é obrigatório')]
    private ?string $descricao;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Id]
    #[ORM\Column(name:'id')]
    #[ORM\GeneratedValue]
    private ?int $id;

    /**
     * @return string
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * @param string $icone
     * @return Tipoequipamento
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;
        return $this;
    }



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Tipoequipamento
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
        return $this->getDescricao();
    }
}
