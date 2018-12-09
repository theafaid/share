<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Zttp\Zttp;

class Recaptcha implements Rule
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
        if(app()->runningUnitTests()){
            return true;
        }

        request()->validate(['g-recaptcha-response' => 'required']);

        $response = Zttp::asFormParams()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip()
        ]);

        return (bool) $response->json()['success'] && request()->has('g-recaptcha-response');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Recaptcha is invalid.';
    }
}
