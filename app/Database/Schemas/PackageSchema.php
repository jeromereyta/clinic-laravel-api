<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use DateTimeInterface;

/**
 * @method DateTimeInterface getCreatedAt()
 * @method string getName()
 * @method DateTimeInterface getDeletedAt()
 * @method DateTimeInterface getUpdatedAt()
 * @method null|string getDescription()
 * @method self setName(string $name)
 * @method self setDescription(string $description)
 * @method self setDeletedAt(DateTimeInterface $deletedAt)
 * @method self setCreatedAt(DateTimeInterface $createdAt)
 * @method self setUpdatedAt(DateTimeInterface $updatedAt)
 */
trait PackageSchema
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="deleted_at", type="date", nullable="true")
     */
    protected DateTimeInterface $deletedAt;

    /**
     * @ORM\Column(name="description", type="text")
     */
    protected string $description;

    /**
     * @ORM\Column(name="name", type="text")
     */
    protected string $name;

    /**
     * @ORM\Column(name="updated_at", type="date" , nullable="true")
     */
    protected DateTimeInterface $updatedAt;
}
