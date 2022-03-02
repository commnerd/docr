<?php

namespace App\Validators;

use \Illuminate\Validation\Validator;

class DBConnectionValidator extends Validator {
 
    public function validateConnection($attribute, $value, $parameters): bool
    {
        dd("FUCK YEAH!");
        try {
            DB::connection()->getPDO();
            DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
 
}