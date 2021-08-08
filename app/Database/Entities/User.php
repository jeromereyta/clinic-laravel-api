<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Interfaces\UserTypes;
use App\Database\Schemas\UserSchema;
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
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'active' => 'nullable|boolean',
            'email' => 'required|email|' . $this->uniqueRuleAsString('email'),
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
            'fullName' => $this->getFullName(),
            'type' => $this->getType(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'userId';
    }

    public function getJWTIdentifier()
    {
        return $this->getId();
    }

    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
    }

    public function getAuthIdentifierName()
    {
        // TODO: Implement getAuthIdentifierName() method.
    }

    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }

    public function getAuthPassword(): string
    {
        return $this->getPassword();
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    private function getEmail(): string
    {
        return $this->email;
    }

    private function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    private function getType(): string
    {
        return $this->type;
    }

    private function isActive(): bool
    {
        return $this->active;
    }
}
