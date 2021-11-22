<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Enum\UserTypeEnum;

/**
 * @method string getFormat()
 * @method string getName()
 * @method string getFileTypeId()
 * @method string getPath()
 * @method self setFormat(string $format)
 * @method self setName(string $name)
 * @method self setPath(string $path)
 */
trait FileUploadSchema
{
    /**
     * @ORM\Column(name="description", type="text")
     */
    protected string $description;

    /**
     * @ORM\Column(name=" format", type="string")
     */
    protected string $format;

    /**
     * @ORM\Column(name="file_type_id", type="integer")
     */
    protected int $fileTypeId;


    /**
     * @ORM\Column(name="patient_visit_id", type="integer")
     */
    protected int $patientVisitId;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected string $id;

    /**
     * @ORM\Column(name="name", type="text")
     */
    protected string $name;

    /**
     * @ORM\Column(name="path", type="string")
     */
    protected string $path;
}
