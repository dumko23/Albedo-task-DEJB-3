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

    public function getMembers(): \Illuminate\Support\Collection
    {
        return Member::getMembers();
    }

    public function send(Request $request)
    {
        $request->validate([
            'firstName' => 'required|max:30|regex:/^[.\D]{1,}$/U',
            'lastName' => 'required|max:30|regex:/^[.\D]{1,}$/U',
            'birthDate' => [
                'required',
                'before_or_equal:' . date('Y-m-d', 1104537600),
                'date'
            ],
            'country' => 'required|max:255',
            'subject' => 'required|max:255',
            'phone' => 'required|max:17|regex:/\+\d \(\d{3}\) \d{3}-\d{4}/i',
            'email' => 'required|unique:members|max:256|email:rfc,dns',
        ],
            [
                'required' => 'This field should be filled!',
                'email.unique' => 'This email is already registered!',
                'max' => 'This filed should be less than :max symbols!',
                'before_or_equal' => 'Incorrect value!',
                'email' => 'Email address should have a valid format!',
                'regex' => 'Field is invalid!'

            ]);

        Member::storeMember($request->all());
    }

    public function update(Request $request)
    {
        $newImageName = 'default-image.png';

        if ($request->hasFile('photo')) {
            $request->validate(
                [
                    'position' => 'max:255',
                    'company' => 'max:255',
                    'photo' => 'mimes:jpg,png,jpeg|file|max:10485760'
                ],
                [
                    'max' => 'This filed should be less than :max symbols!',
                    'photo.max' => 'File size is greater than :max bytes!'
                ]);
            $newImageName = 'public/images/' . time() . '-' . $request->get('newName') . '.' . $request->file('photo')->extension();
            $request->file('photo')->move(public_path('/public/images'), $newImageName);

        } else {
            $request->validate(
                [
                    'position' => 'max:255',
                    'company' => 'max:255',
                ],
                [
                    'max' => 'This filed should be less than :max symbols!',
                ]);
        }

        $data = [
            'email' => $request->get('email'),
            'path' => $newImageName,
            'position' => $request->get('position'),
            'company' => $request->get('company'),
            'about' => $request->get('about'),
        ];
        Member::updateMember($data);
    }


}
