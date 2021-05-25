<?php

namespace App\Rules;

use App\Models\Property;
use Illuminate\Contracts\Validation\Rule;

class PurchasedIsNotPermittedIfFalseAndMoreThan implements Rule
{
    /**
     * @var int|null
     */
    private ?int $propertyId;

    /**
     * @var int|null
     */
    private ?int $userId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(?int $propertyId, ?int $userId, int $maxTimes)
    {
        $this->propertyId = $propertyId;
        $this->userId = $userId;
        $this->maxTimes = $maxTimes;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ((!$this->propertyId && !$this->userId) || $value) {
            return true;
        }

        $ownerId = $this->userId;

        if ($this->propertyId) {
            $property = Property::findOrFail($this->propertyId);
            $ownerId = $property->owner_id;
        }

        $quantity = Property::where('purchased', false)
            ->where('owner_id', $ownerId)
            ->get()
            ->count();

        return $this->maxTimes > $quantity;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'It is not possible have more than 3 properties with purchased equal false.';
    }
}
