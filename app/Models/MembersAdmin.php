<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MembersAdmin extends Model
{
    use HasFactory;

    protected $table = 'members';
    protected $primaryKey = 'member_id';
}
