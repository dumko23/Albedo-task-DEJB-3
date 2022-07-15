<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MembersAdmin extends Model
{
    use HasFactory;

    public static function editMember($data, $whereField, $whereValue)
    {
        DB::table('members')
            ->where($whereField, $whereValue)
            ->update($data);
    }

    public static function deleteMember($whereField, $whereValue)
    {

        DB::table('members')
            ->where($whereField, $whereValue)
            ->delete();
    }

    public static function getFullInfo($whereField, $whereValue): Collection
    {
        return DB::table('members')
            ->where($whereField, $whereValue)
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
