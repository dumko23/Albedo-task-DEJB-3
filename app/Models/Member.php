<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    public static function storeMember($data)
    {
        DB::table('members')
            ->insert(
                [
                    'firstname' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'birthDate' => $data['birthDate'],
                    'country' => $data['country'],
                    'subject' => $data['subject'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                ]
            );
    }

    public static function updateMember($data)
    {
        DB::table('members')
            ->where('email', $data['email'])
            ->update([
                    'about' => $data['about'],
                    'position' => $data['position'],
                    'company' => $data['company'],
                    'photo' => $data['path']
                ]
            );
    }

    public static function getMembers(): Collection
    {
        return DB::table('members')
            ->where('visibility', true)
            ->get(['firstName', 'lastName', 'subject', 'photo', 'email']);
    }
}
