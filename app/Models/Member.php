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
            ->insert($data);
    }

    public static function updateMember($data, $whereField, $whereValue)
    {
        DB::table('members')
            ->where($whereField, $whereValue)
            ->update($data);
    }

    public static function getMembers($select, $whereField, $whereValue): Collection
    {
        return DB::table('members')
            ->where($whereField, $whereValue)
            ->get($select);
    }

    public static function getVisibleMembersCount($select, $whereField, $whereValue): int
    {
        return DB::table('members')
            ->where($whereField, $whereValue)
            ->count($select);
    }
}
