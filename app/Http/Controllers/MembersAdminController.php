<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembersAdmin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MembersAdminController extends Controller
{
    public function getMemberFullData($memberId): \Illuminate\Support\Collection
    {
        return MembersAdmin::getFullInfo('memberId', $memberId);

    }

    public function getMembersInfo(): Collection
    {
        return Member::all(['firstName', 'lastName', 'subject', 'photo', 'email', 'memberId', 'visibility']);

    }

    public function editMember(Request $request)
    {
        $emailRule = '';
        if ($request->get('email') !== $request->get('oldEmail')) {
            $emailRule = 'required|unique:members|';
        }
        $photoRule = '';
        if ($request->hasFile('photo')) {
            $photoRule = 'mimes:jpg,png,jpeg|file|';
        }

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
                'email' => $emailRule . 'max:256|email:rfc,dns',
                'position' => 'max:255',
                'company' => 'max:255',
                'photo' => $photoRule . 'max:10485760'
            ],
            [
                'required' => 'This field should be filled!',
                'max' => 'This filed should be less than :max symbols!',
                'before_or_equal' => 'Incorrect value!',
                'regex' => 'Field is invalid!',
                'photo.max' => 'File size is greater than :max bytes!',
                'email.unique' => 'This email is already registered!',
                'email' => 'Email address should have a valid format!',
            ]);

        if ($request->hasFile('photo')) {
            $newImageName = 'images/' . time() . '-' . $request->get('newName') . '.'
                . $request->file('photo')
                    ->extension();
            $request->file('photo')->move(public_path('images'), $newImageName);
            $data['photo'] = $newImageName;
        } else {
            $data['photo'] = $request->get('photo');
        }


        foreach ($request->except('newName', 'photo', "oldEmail") as $key => $value) {
            $data[$key] = $value;
        }

        MembersAdmin::editMember($data, 'email', $request->get('oldEmail'));
    }

    public function deleteMember(Request $request)
    {
        MembersAdmin::deleteMember('email', $request->get('email'));
    }

    public function toggleVisibility(Request $request)
    {
        MembersAdmin::toggleVisibility($request->all());
    }
}
