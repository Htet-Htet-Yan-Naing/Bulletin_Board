<?php

namespace App\Rules;

use App\Models\Posts;
use Illuminate\Contracts\Validation\Rule;
use App\Models\User; // Adjust the model as per your application
use Illuminate\Contracts\Validation\ValidationRule;

class ActiveUser implements Rule
{
    protected $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function passes($attribute, $value)
    {
        $post = Posts::where('title', $this->title)
                    ->whereNull('deleted_at')
                    ->whereNull('deleted_user_id')
                    ->first();

        return $post !== null;
    }

    public function message()
    {
        return 'This title is already taken';
    }
}
