<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Enum\UserTypeEnum;

/**
 * @method bool isActive()
 * @method string getName()
 * @method string getCategoryProcedureId()
 * @method self setActive(bool $active)
 * @method self setName(string $name)
 */
trait ProcedureSchema
{
    /**
     * @ORM\Column(name="active", type="boolean")
     */
    protected bool $active = true;

    /**
     * @ORM\Column(name="category_procedure_id", type="integer")
     */
    protected int $categoryProcedureId;

    /**
     * @ORM\Column(name="description", type="text")
     */
    protected string $description;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected string $id;

    /**
     * @ORM\Column(name="test", type="text")
     */
    protected string $name;

    /**
     * @ORM\Column(name="price", type="string")
     */
    protected string $price;
}
