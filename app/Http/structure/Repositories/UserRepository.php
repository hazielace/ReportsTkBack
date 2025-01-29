<?php

namespace App\Http\structure\Repositories;

use App\Models\User;

class UserRepository {
    public static function getAllUsers(){
        return User::all();
    }

    public static function getUsersByBirthDate($startDate, $endDate){
        return User::whereBetween('birth_date', [$startDate, $endDate])->get(['id', 'name', 'birth_date']);
    }

    public static function getUserById($id){
        $data = User::where('id','=', $id)->first();
        return $data;
    }
}