<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Entities\AbstractEntity;
use App\Database\Schemas\FileUploadSchema;
use App\Database\Schemas\ProcedureSchema;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \App\Database\Entities\UserGuest getCreatedBy()
 * @method null|\App\Database\Entities\UserGuest getUpdatedBy()
 * @method null|\App\Database\Entities\PatientVisit getPatientVisit()
 * @method null|\App\Database\Entities\FileType getFileType()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="file_uploads"
 * )
 */
class FileUpload extends AbstractEntity
{
    use FileUploadSchema;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\FileType",
     *     inversedBy="fileType",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="file_type_id", referencedColumnName="id")
     */
    protected FileType $fileType;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\PatientVisit",
     *     inversedBy="fileUploads",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="patient_visit_id", referencedColumnName="id")
     */
    protected PatientVisit $patientVisit;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $updatedAt;

    /*
     * @ORM\Column(type="datetime", nullable="true")
     */
    public ?DateTimeInterface $deletedAt = null;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDeletedAt(): DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt = null): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path
        ;
        return $this;
    }

    public function getFileTypeId(): int
    {
        return $this->fileType->getId();
    }

    public function getPatientVisitId(): int
    {
        return $this->patientVisit->getId();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFileType(FileType $fileType): self
    {
        $this->fileTypeId =  $fileType->getId();
        $this->fileType = $fileType;

        return $this;
    }

    public function setPatientVisit(PatientVisit $patientVisit): self
    {
        $this->patientVisitId =  $patientVisit->getId();
        $this->patientVisit = $patientVisit;

        return $this;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    protected function doGetRules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'path' => 'required|string',
            'format' => 'required|string',
            'fileType' => \sprintf('required|%s', $this->instanceOfRuleAsString(FileType::class)),
            'patientVisit' => \sprintf('required|%s', $this->instanceOfRuleAsString(PatientVisit::class)),
        ];
    }

    protected function doToArray(): array
    {
        return [
            'path' => $this->getPath(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'format' => $this->getFormat(),
            'file_type_id' => $this->getFileTypeId(),
            'patient_visit_id' => $this->getPatientVisitId(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
