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
        DB::insert('insert into members (firstName, lastName, birthDate, country, subject, phone, email) values (?,?,?,?,?,?,?)', array_values($data));
    }

    public static function updateMember($data)
    {
        DB::table('members')
            ->where('email', $data['email'])
            ->update([
                    'about' => $data['about'],
                    'position' => $data['position'],
                    'company' => $data['company']
                ]
            );
    }

    public static function updatePhoto($data)
    {
        DB::table('members')
            ->where('email', $data['email'])
            ->update([
                    'photo' => $data['path']
                ]
            );
    }
}
