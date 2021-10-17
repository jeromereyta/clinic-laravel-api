<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\UserGuestSchema;
use App\Enum\UserTypeEnum;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \Doctrine\Common\Collections\Collection getCreatedPatients()
 * @method \Doctrine\Common\Collections\Collection getUpdatedPatients()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="user_guests"
 * )
 */
class UserGuest extends AbstractEntity
{
    use UserGuestSchema;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $createdAt;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\Patient",
     *     mappedBy="createdBy",
     *     cascade={"persist"}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected Collection $createdPatients;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\PatientVisit",
     *     mappedBy="createdBy",
     *     cascade={"persist"}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $patientVisits;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\Patient",
     *     mappedBy="updatedBy",
     *     cascade={"persist"}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected Collection $updatedPatients;

    /**
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\User",
     *     inversedBy="userGuest",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var \App\Database\Entities\User
     */
    protected $user;

    public function __construct() {
        $this->createdPatients = new ArrayCollection();
        $this->updatedPatients = new ArrayCollection();
        $this->patientVisits = new ArrayCollection();
        parent::__construct();
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->type = $name;

        return $this;
    }

    public function setType(UserTypeEnum $type): self
    {
        $this->type = $type->getValue();

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->userId = (string) $user->getUserId();
        $this->user = $user;

        return $this;
    }
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'active' => 'nullable|boolean',
            'type' => \sprintf('nullable|string|%s', $this->inRuleString(UserTypeEnum::toArray())),
            'userId' => \sprintf('required|%s', $this->instanceOfRuleAsString(User::class)),
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'active' => $this->isActive(),
            'user_guest_id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'user_id' => $this->getUserId(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'userGuestId';
    }
}
