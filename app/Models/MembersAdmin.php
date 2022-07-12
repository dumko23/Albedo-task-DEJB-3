<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MembersAdmin extends Model
{
    use HasFactory;

    public static function editMember($data)
    {
        DB::table('members')
            ->where('email', $data['oldEmail'])
            ->update(
                [
                    'about' => $data['about'],
                    'position' => $data['position'],
                    'company' => $data['company'],
                    'photo' => $data['photo'],
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'birthDate' => $data['birthDate'],
                    'country' => $data['country'],
                    'subject' => $data['subject'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                ]
            );
    }

    public static function deleteMember($data)
    {

        DB::table('members')
            ->where('email', $data['email'])
            ->delete();
    }

    public static function getFullInfo($data): Collection
    {
        return DB::table('members')
            ->where('memberId', $data)
            ->get();
    }

    public static function toggleVisibility(array $data)
    {
        DB::table('members')
            ->where('email', $data['email'])
            ->update(
                [
                    'visibility' => $data['show']
                ]
            );
    }
}
