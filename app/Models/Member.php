<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    public static function storeMember($data)
    {
        print_r($data);
        DB::insert('insert into members (firstName, lastName, birthDate,country, subject, phone, email) values (?,?,?,? ,?,?,?)', $data);
    }
}
