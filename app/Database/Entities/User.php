<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Interfaces\UserTypes;
use App\Database\Schemas\UserSchema;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="users"
 * )
 */
class User extends AbstractEntity implements JWTSubject, AuthContract
{
    use UserSchema, Authenticatable;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public ?DateTimeInterface $updatedAt;

    /**
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\UserGuest",
     *     mappedBy="user",
     *     cascade={"persist"}
     * )
     */
    public $userGuest;

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): string
    {
        return $this->getId();
    }

    public function getAuthPassword(): string
    {
        return $this->getPassword();
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailVerifiedAt(): ?DateTimeInterface
    {
        return $this->emailVerifiedAt;
    }

    public function getEmailVerifiedAtAsString(): ?string
    {
        if ($this->emailVerifiedAt === null) {
            return null;
        }

        return $this->dateTimeToZuluFormat($this->emailVerifiedAt);
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getJWTIdentifier()
    {
        return $this->getId();
    }

    /**
     * @return mixed[]
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setRememberToken($value): self
    {
        // TODO: Implement setRememberToken() method.
        return $this;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt = null): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    protected function getIdProperty(): string
    {
        return 'userId';
    }

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'active' => 'nullable|boolean',
            'email' => 'required|email|' . $this->uniqueRuleAsString('email'),
            'emailVerifiedAt' => 'date',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'type' => \sprintf('nullable|string|%s', $this->inRuleString(UserTypes::TYPES)),
        ];
    }

    protected function doToArray(): array
    {
        return [
            'active' => $this->isActive(),
            'email' => $this->getEmail(),
            'email_verified_at' => $this->getEmailVerifiedAt(),
            'fullName' => $this->getFullName(),
            'type' => $this->getType(),
        ];
    }

    private function isActive(): bool
    {
        return $this->active;
    }
}
