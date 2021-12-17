<?php

declare(strict_types=1);

namespace App\Database\Schemas;
/**
 * @method string getStatus()
 * @method string getQueueNumber()
 * @method self setStatus(string $status)
 * @method self setQueueNumber(int $queueNumber)
 */
trait ProcedureQueueSchema
{
    /**
     * @ORM\Column(name="created_by_id", type="integer")
     */
    protected int $createdById;

    /**
     * @ORM\Column(name="date", type="string")
     */
    protected string $date;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="patient_procedure_id", type="integer")
     */
    protected int $patientProcedureId;

    /**
     * @ORM\Column(name="status", type="text")
     */
    protected string $status;

    /**
     * @ORM\Column(name="queue_number", type="integer")
     */
    protected int $queueNumber;

    /**
     * @ORM\Column(name="updated_by_id", type="integer", nullable="true")
     */
    protected int $updatedById;
}
