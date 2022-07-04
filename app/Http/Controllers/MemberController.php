<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;
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
        Member::storeMember($request->all());
    }

    public function update(Request $request)
    {
        Member::updateMember($request->all());
        return $request->all();
    }

}
