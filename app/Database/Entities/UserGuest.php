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
final class UserGuest extends AbstractEntity
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
     *     targetEntity="App\Database\Entities\Patient",
     *     mappedBy="updatedBy",
     *     cascade={"persist"}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected Collection $updatedPatients;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\PatientVisit",
     *     mappedBy="createdBy",
     *     cascade={"persist"}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private ArrayCollection $patientVisits;

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
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'active' => $this->isActive(),
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'userGuestId';
    }
}
