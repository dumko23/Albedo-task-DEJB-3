<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //

    public function getMembersCount(): int
    {
        return count(Member::all(['email']));
    }

    public function getMembers(): Collection
    {
        return Member::all(['firstName', 'lastName', 'subject', 'photo', 'email']);

    }

    public function send(Request $request)
    {
//        return $request->all();
        Member::storeMember($request->all());
    }

    public function update(Request $request)
    {
        return $request->all();
    }

}
