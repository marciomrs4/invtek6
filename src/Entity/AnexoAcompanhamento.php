<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;

use App\Entity\Acompanhamento;

/**
 * AnexoAcompanhamento
 *
 * @ORM\Table(name="anexo_acompanhamento", indexes={@ORM\Index(name="fk_anexo_acompanhamento_acompanhamento1_idx", columns={"acompanhamento_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
#[ORM\Table(name:'anexo_acompanhamento')]
#[ORM\Entity]
#[Vich\Uploadable]
class AnexoAcompanhamento
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime", nullable=false)
     */
    #[ORM\Column(name:'data_criacao', type: Types::DATETIME_MUTABLE , nullable: false)]
    private $dataCriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_alteracao", type="datetime", nullable=false)
     */
    #[ORM\Column(name: 'data_alteracao', type: Types::DATETIME_MUTABLE, nullable: false)]
    private $dataAlteracao;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="mapeamento_acompanhamento", fileNameProperty="imageName")
     * @Assert\File(maxSize="2M",maxSizeMessage="O tamanho excede o limite de {{ limit }}")
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
    #[Vich\UploadableField(mapping:'mapeamento_acompanhamento', fileNameProperty:'imageName')]
    #[Assert\File(mimeTypes: ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
          "application/msword",
          "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
          "text/plain",
          "application/vnd.ms-excel",
          "application/vnd.ms-office",
          "application/pdf",
          "text/html"],
          mimeTypesMessage: 'Por favor envie o tipo de arquivo correto! tipo enviado {{ type }} Os tipos suportados são ({{ types }})')]
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: 'image_name', length:255, nullable: true)]
    private ?string $imageName;

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
     * @var \MRS\InventarioBundle\Entity\Acompanhamento
     *
     * @ORM\ManyToOne(targetEntity="MRS\InventarioBundle\Entity\Acompanhamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="acompanhamento_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(targetEntity: Acompanhamento::class)]
    #[ORM\JoinColumn(name:'acompanhamento_id', referencedColumnName: 'id')]
    private $acompanhamento;

    public function __construct()
    {
        $this->dataCriacao = new \DateTime('now');
    }


    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     * @return AnexoAcompanhamento
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        if($imageFile){
            $this->dataAlteracao = new \DateTime('now');
        }

        return $this;
    }



    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return AnexoAcompanhamento
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set dataAlteracao
     *
     * @param \DateTime $dataAlteracao
     *
     * @return AnexoAcompanhamento
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;

        return $this;
    }

    /**
     * Get dataAlteracao
     *
     * @return \DateTime
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return AnexoAcompanhamento
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
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
     * Set acompanhamento
     *
     * @param App\Entity\Acompanhamento $acompanhamento
     *
     * @return AnexoAcompanhamento
     */
    public function setAcompanhamento(Acompanhamento $acompanhamento = null)
    {
        $this->acompanhamento = $acompanhamento;

        return $this;
    }

    /**
     * Get acompanhamento
     *
     * @return App\Entity\Acompanhamento
     */
    public function getAcompanhamento()
    {
        return $this->acompanhamento;
    }
}
