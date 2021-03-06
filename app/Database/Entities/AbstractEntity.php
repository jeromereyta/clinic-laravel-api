<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Exceptions\EntityValidationFailedException;
use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use EoneoPay\Externals\ORM\Entity as BaseEntity;
use EoneoPay\Externals\ORM\Interfaces\ValidatableInterface;
use EoneoPay\Utils\Str;
use EonX\EasyCore\Bridge\Laravel\ApiFormats\Interfaces\SerializableInterface;

abstract class AbstractEntity extends BaseEntity implements
    ValidatableInterface,
    SerializableInterface
{
    public DateTimeInterface $createdAt;

    /**
     * AbstractEntity constructor.
     *
     * @param null|mixed[] $data
     *
     * @throws \Exception If error with DateTime objects
     */
    public function __construct(?array $data = null)
    {
        $this->createdAt = new DateTime();

        parent::__construct($data);
    }

    public function getCreatedAtAsString(): string
    {
        if ($this->getCreatedAt() !== null){
            return $this->dateTimeToZuluFormat($this->getCreatedAt());
        }

        return (Carbon::now())->toIso8601ZuluString();
    }

    /**
     * Get validation rules.
     *
     * @return mixed[]
     */
    public function getRules(): array
    {
        $rules = [
            'createdAt' => 'required|date',
            'updatedAt' => 'required|date',
        ];

        return $rules + $this->doGetRules();
    }

    /**
     * Get update at as string.
     */
    public function getUpdatedAtAsString(): ?string
    {
        return $this->dateTimeToZuluFormat($this->getUpdatedAt());
    }

    /**
     * Get validation failed exception class.
     */
    public function getValidationFailedException(): string
    {
        return EntityValidationFailedException::class;
    }

    /**
     * Return entity's array representation.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        $idGetter = \sprintf('get%s', (new Str())->studly($this->getIdProperty()));

        $array = [
            'created_at' => $this->getCreatedAtAsString(),
            'id' => $this->{$idGetter}(),
            'updated_at' => $this->getUpdatedAtAsString(),
        ];

        return $array + $this->doToArray();
    }

    /**
     * Return child entities validation rules.
     *
     * @return mixed[]
     */
    abstract protected function doGetRules(): array;

    /**
     * Return child entities array representation.
     *
     * @return mixed[]
     */
    abstract protected function doToArray(): array;

    /**
     * Transform array to json string.
     *
     * @param null|mixed[] $array
     */
    protected function arrayToString(?array $array): ?string
    {
        return $array ? (string)\json_encode($array) : null;
    }

    /**
     * Transform datetime object to Zulu formatted string.
     */
    protected function dateTimeToZuluFormat(?\DateTimeInterface $dateTime = null): ?string
    {
        return $dateTime ? $dateTime->format('Y-m-d\TH:i:s\Z') : null;
    }

    /**
     * @param string[] $inString
     */
    protected function inRuleString(array $inString): string
    {
        return 'in:' . \implode(',', $inString);
    }
}
