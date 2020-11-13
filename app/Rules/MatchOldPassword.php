<?php

namespace App\Rules;

use Hash;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class MatchOldPassword implements Rule
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->user->password);
    }

    public function message()
    {
        return 'Old password is not correct';
    }
}
