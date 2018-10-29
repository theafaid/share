<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Inspections\Spam;
class FreeSpam implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        try{

            (new Spam())->detect($value);

        } catch(\Exception $ex){

            return false;

        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your Reply Contains Spam Or You Held a Key Down !!';
    }
}
