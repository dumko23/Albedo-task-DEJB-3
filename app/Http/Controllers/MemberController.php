<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //

    public function membersCount(): int
    {
        return count(Member::all(['email']));
    }

    public function index()
    {
        return view('members.index', [
            'members' => Member::all(['firstName', 'lastName', 'subject', 'photo', 'email'])
        ]);
    }

    public static function send(Request $request)
    {
//        return $request->all();
        Member::storeMember($request->all());
    }

    public function update(Request $request)
    {
        return $request->all();
    }


}
