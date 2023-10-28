<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\TeacherAvailability;

class AvailabilityTypeMatchesUser implements Rule
{
    private $userId;
    private $errorMessage;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function passes($attribute, $value)
    {
        $availability = TeacherAvailability::where('user_id', $this->userId)->first();

        if (!$availability) {
            $this->errorMessage = 'O tipo de disponibilidade não é compativél com este utilizador.';
            return false;
        }

        // If the user's availability_type_id is 4, any value is acceptable
        if ($availability->availability_type_id == 4) {
            return true;
        }

        if ($availability->availability_type_id != $value) {
            if ($availability->availability_type_id == 2) {
                $this->errorMessage = 'Só aulas online.';
            } elseif ($availability->availability_type_id == 3) {
                $this->errorMessage = 'Só presencial.';
            } else {
                $this->errorMessage = 'O tipo de disponibilidade não é compativél com este utilizador.';
            }
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}