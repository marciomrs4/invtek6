<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use App\Entity\Equipamento;

/**
 * Anexo
 *
 * @ORM\Table(name="anexo", indexes={@ORM\Index(name="fk_anexo_equipamento1_idx", columns={"equipamento_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
#[ORM\Table(name:'anexo')]
#[ORM\Entity]
#[Vich\Uploadable]
class Anexo
{

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_equipamento", fileNameProperty="imageName")
     * @Assert\File(mimeTypes={"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *     "application/msword",
     *     "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *     "text/plain",
     *     "application/vnd.ms-excel",
     *     "application/vnd.ms-office",
     *     "application/pdf",
     *     "text/html"},
     *     mimeTypesMessage="Por favor envie o tipo de arquivo correto! tipo enviado {{ type }}
     *                       Os tipos suportados são ({{ types }})")
     */
    #[Vich\UploadableField(mapping: 'mapeamento_equipamento', fileNameProperty:'imageName')]
    #[Assert\File(mimeTypes: [
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "text/plain",
        "application/vnd.ms-excel",
        "application/vnd.ms-office",
        "application/pdf",
        "text/html"
    ],
    mimeTypesMessage: 'Por favor envie o tipo de arquivo correto! tipo enviado {{ type }} Os tipos suportados são ({{ types }})')]
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255, nullable=true)
      */
    #[ORM\Column(name:'imageName', length: 255, nullable:true)]
    private ?string $imageName;
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name:'nome', length: 255, nullable: true)]
    private ?string $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="datacriacao", type="datetime", nullable=true)
     */
    #[ORM\Column(name:'datacriacao', type: Types::DATETIME_MUTABLE, nullable:true)]
    private $datacriacao;

    /**
     * @var string
     *
     * @ORM\Column(name="dataalteracao", type="datetime", nullable=true)
     */
    #[ORM\Column(name:'dataalteracao', type: Types::DATETIME_MUTABLE, nullable: true)]
    private $dataalteracao;

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
     * @var \MRS\InventarioBundle\Entity\Equipamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Equipamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Equipamento::class)]
    #[ORM\JoinColumn(name: 'equipamento_id', referencedColumnName: 'id')]
    private $equipamento;

    public function __construct()
    {
        $this->datacriacao = new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getDataalteracao(): string
    {
        return $this->dataalteracao;
    }

    /**
     * @param string $dataalteracao
     * @return Anexo
     */
    public function setDataalteracao($dataalteracao): Anexo
    {
        $this->dataalteracao = $dataalteracao;
        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile(): File
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     * @return Anexo
     */
    public function setImageFile(File $imageFile): Anexo
    {
        $this->imageFile = $imageFile;

        if($imageFile){
            $this->dataalteracao = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName(): string
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     * @return Anexo
     */
    public function setImageName($imageName): Anexo
    {
        $this->imageName = $imageName;
        return $this;
    }




    /**
     * Set nome
     *
     * @param string $nome
     * @return Anexo
     */
    public function setNome($nome): Anexo
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
     * Set datacriacao
     *
     * @param string $datacriacao
     * @return Anexo
     */
    public function setDatacriacao($datacriacao): Anexo
    {
        $this->datacriacao = $datacriacao;

        return $this;
    }

    /**
     * Get datacriacao
     *
     * @return string 
     */
    public function getDatacriacao(): string
    {
        return $this->datacriacao;
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
     * Set equipamento
     *
     * @param App\Entity\Equipamento $equipamento
     * @return Anexo
     */
    public function setEquipamento(Equipamento $equipamento = null): Anexo
    {
        $this->equipamento = $equipamento;

        return $this;
    }

    /**
     * Get equipamento
     *
     * @return App\Entity\Equipamento 
     */
    public function getEquipamento(): App\Entity\Equipamento
    {
        return $this->equipamento;
    }
}
