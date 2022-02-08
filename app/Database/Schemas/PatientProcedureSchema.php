<?php

declare(strict_types=1);

namespace App\Database\Schemas;

trait PatientProcedureSchema
{
    /**
     * @ORM\Column(name="created_by_id", type="integer")
     */
    protected int $createdById;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="description", type="text", nullable="true")
     */
    protected ?string $description = null;

    /**
     * @ORM\Column(name="patient_visit_id", type="integer")
     */
    protected int $patientVisitId;

    /**
     * @ORM\Column(name="package_procedure_id", type="integer", nullable="true")
     */
    protected int $packageProcedureId;

    /**
     * @ORM\Column(name="procedure_id", type="integer")
     */
    protected int $procedureId;

    /**
     * @ORM\Column(name="updated_by_id", type="integer", nullable="true")
     */
    protected int $updatedById;
}
