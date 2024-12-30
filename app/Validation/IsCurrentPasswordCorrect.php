<?php

namespace App\Validation;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\AdminUser;
use App\Models\User;

class IsCurrentPasswordCorrect
{
    public function check_current_password($password): bool
    {
        $password = trim($password);
        $user_id = CIAuth::id();
        $user = new User();
        $user_info = $user->asObject()->where('id', $user_id)->first();

        if(!Hash::check($password, $user_info->password)){
            return false;
        }
        
        return true;
    }

    public function check_admin_current_password($password , $data, $allData): bool {
        $password = trim($password);
        $admin_user = new AdminUser();
        $user_info = $admin_user->asObject()->where('id', $allData['category_id'])->first();
        if(!Hash::check($password, $user_info->password)){
            return false;
        }
        
        return true;
    }
}
