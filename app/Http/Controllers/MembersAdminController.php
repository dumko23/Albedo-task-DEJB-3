<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MembersAdminController extends Controller
{
    public function getMemberFullData($memberId): Collection
    {
        return Member::all()->where('memberId', '=', $memberId);

    }

    public function getMembersInfo(): Collection
    {
        return Member::all(['firstName', 'lastName', 'country', 'photo', 'email', 'memberId']);

    }
}
