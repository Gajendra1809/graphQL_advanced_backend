<?php

namespace App\Policies;

use App\Models\User;
use GraphQL\Error\Error;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function createUpdateDelete(User $authuser){
        if($authuser->role!='1'){
            throw new Error('Unauthorized, you are not a Product Manager');
        }
        return true;
    }
    
}
