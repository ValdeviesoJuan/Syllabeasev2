<?php

namespace App\Imports;
use App\Models\User;
use App\Models\UserRole;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Create a new User instance
        $user = new User([
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'])
        ]);
    
        $user->save();
    
        $role = new UserRole([
            'user_id' => $user->id,
            'role_id' => 5 
        ]);
    
        $role->save();
    
        return $user;
    }
}
