<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MemberController extends Controller
{
    //

    public function getMembersCount(): int
    {
        return Member::where("visibility", true)->count('email');
    }

    public function getMembers(): Collection
    {
        return Member::where("visibility", true)->get(['firstName', 'lastName', 'subject', 'photo', 'email']);
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

        Member::create($request->all())->save();
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
            $newImageName = time() . '-' . $request->get('newName') . '.' . $request->file('photo')->extension();
            $request->file('photo')->move(storage_path('app/images'), $newImageName);

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
            'photo' => $newImageName,
            'position' => $request->get('position'),
            'company' => $request->get('company'),
            'about' => $request->get('about'),
        ];

        Member::where('email', $request->get('email'))->update($data);
    }


}
