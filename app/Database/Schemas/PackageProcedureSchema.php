<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Database\Entities\Package;
use App\Database\Entities\Procedure;
use DateTimeInterface;

/**
 * @method DateTimeInterface getCreatedAt()
 * @method DateTimeInterface getDeletedAt()
 * @method DateTimeInterface getUpdatedAt()
 * @method string getPrice()
 * @method Package getPackage()
 * @method Procedure getProcedure()
 * @method self setPrice(string $price)
 * @method self setProcedure(Procedure $procedure)
 * @method self setPackage(Package $package)
 * @method self setDeletedAt(DateTimeInterface $deletedAt)
 * @method self setUpdatedAt(DateTimeInterface $updatedAt)
 */
trait PackageProcedureSchema
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="deleted_at", type="date"  , nullable="true")
     */
    protected DateTimeInterface $deletedAt;

    /**
     * @ORM\Column(name="package_id", type="integer")
     */
    protected int $packageId;

    /**
     * @ORM\Column(name="price", type="string")
     */
    protected string $price;

    /**
     * @ORM\Column(name="procedure_id", type="integer")
     */
    protected int $procedureId;

    /**
     * @ORM\Column(name="updated_at", type="date"  , nullable="true")
     */
    protected DateTimeInterface $updatedAt;
}
