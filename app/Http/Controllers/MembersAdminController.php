<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembersAdmin;
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

    public function editMember(Request $request)
    {
        if ($request->get('email') !== $request->get('oldEmail')) {
            $request->validate(
                [
                    'email' => 'required|unique:members|max:256|email:rfc,dns',
                ],
                [
                    'required' => 'This field should be filled!',
                    'email.unique' => 'This email is already registered!',
                    'email' => 'Email address should have a valid format!',
                    'max' => 'This filed should be less than :max symbols!',
                ]);
        }


        if ($request->hasFile('photo')) {
            $request->validate(
                [
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
                    'position' => 'max:255',
                    'company' => 'max:255',
                    'photo' => 'mimes:jpg,png,jpeg|file|max:10485760'
                ],
                [
                    'required' => 'This field should be filled!',
                    'max' => 'This filed should be less than :max symbols!',
                    'before_or_equal' => 'Incorrect value!',
                    'regex' => 'Field is invalid!',
                    'photo.max' => 'File size is greater than :max bytes!'
                ]);
            $newImageName = 'images/' . time() . '-' . $request->get('newName') . '.'
                . $request->file('photo')
                    ->extension();
            $request->file('photo')->move(public_path('images'), $newImageName);

            $data['photo'] = $newImageName;


        } else {
            $request->validate(
                [
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
                    'position' => 'max:255',
                    'company' => 'max:255',
                ],
                [
                    'required' => 'This field should be filled!',
                    'max' => 'This filed should be less than :max symbols!',
                    'before_or_equal' => 'Incorrect value!',
                    'regex' => 'Field is invalid!'
                ]);

            if ($request->get('photo') === 'default-image.png') {
                $data['photo'] = $request->get('photo');
            }
        }

        foreach ($request->all() as $key => $value) {
            if (!array_search($key, ['newName', 'photo']))
                $data[$key] = $value;
        }

        MembersAdmin::editMember($data);

        return $data;

    }
}
