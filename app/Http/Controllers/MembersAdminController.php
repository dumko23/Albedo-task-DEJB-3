<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MembersAdminController extends Controller
{
    public function getAllMembersData(): Collection
    {
        return Member::all();

    }

    public function getMembers(): Collection
    {
        return Member::all(['firstName', 'lastName', 'subject', 'photo', 'email']);

    }
}
