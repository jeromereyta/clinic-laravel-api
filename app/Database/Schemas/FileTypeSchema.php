<?php

declare(strict_types=1);

namespace App\Database\Schemas;

/**
 * @method null|string getName()
 * @method null|string getDescription()
 * @method null|string getType()
 */
trait FileTypeSchema
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(name="description", type="text")
     */
    protected string $description;

    /**
     * @ORM\Column(name="type", type="text")
     */
    protected string $type;
}
