<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Enum\UserTypeEnum;

/**
 * @method bool isActive()
 * @method string getName()
 * @method string getUserGuestId()
 * @method string getType()
 * @method self setActive(bool $active)
 * @method self setName(string $name)
 * @method self setType(UserTypeEnum $type)
 */
trait UserGuestSchema
{
    /**
     * @ORM\Column(name="`active`", type="boolean")
     *
     * @var bool
     */
    protected bool $active = true;

    /**
     * @ORM\Column(name="`name`", type="string")
     *
     * @var string
     */
    protected string $name;

    /**
     * @ORM\Column(name="`type`", type="string")
     *
     * @var string
     */
    protected string $type;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var string
     */
    protected string $userGuestId;
}
