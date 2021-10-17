<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method bool isActive()
 * @method null|string getEmail()
 * @method null|DateTimeInterface getEmailVerifiedAt()
 * @method null|string getFirstName()
 * @method null|string getLastName()
 * @method null|string getUserId()
 * @method self setActive(bool $active)
 * @method self setEmail(string $email)
 * @method self setEmailVerifiedAt(DateTimeInterface $emailVerifiedAt)
 * @method self setFirstName(string $firstName)
 * @method self setPassword(string $password)
 * @method self setType(string $type)
 * @method self setLastName(string $lastName)
 */
trait UserSchema
{
    /**
     * @ORM\Column(name="`active`", type="boolean")
     *
     * @var bool
     */
    protected $active = true;

    /**
     * @ORM\Column(name="email", nullable=true, type="string", length=191)
     *
     * @var string
     */
    protected string $email;

    /**
     * @ORM\Column(name="email_verified_at", nullable=true, type="datetime")
     *
     * @var DateTimeInterface
     */
    protected $emailVerifiedAt;

    /**
     * @ORM\Column(name="first_name", nullable=true, type="string", length=191)
     *
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", nullable=true, type="string", length=191)
     *
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\Column(name="password", nullable=false, type="string", length=191)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(name="type", nullable=false, type="string", length=191)
     *
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    protected $userId;
}
