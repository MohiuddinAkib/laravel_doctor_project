<?php

namespace App\Http\Controllers\Doctor;

use App\DoctorCategory;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $categories = DoctorCategory::all();
        return view('doctor.profile.edit', compact('profile', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $data = $request->validate(
            [
                'name' => ['string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
                'mobile' => ['string', 'between:11, 14'],
                'address' => ['array', 'size:3'],
                'address.street' => ['string'],
                'address.city' => ['string'],
                'address.zip' => ['numeric'],
                'gender' => ['numeric'],
                'category_id' => 'required|exists:App\DoctorCategory,id'
            ],
            [
                'address.zip.numeric' => 'The zip field must be a number',
            ]
        );

        $profileData = Arr::except($data, ['name', 'email', 'password']);
        $userData = Arr::only($data, ['name', 'email', 'password']);

        if ($profile->update($profileData)) {
            $profile->user()->update($userData);
            toast('Succesfully updated your profile', 'success', 'top-right')->showCloseButton()->timerProgressBar();
            // return  back()->withSuccess('Succesfully updated your profile');
            return  back();
        } else {
            toast('Failed to update profile', 'error', 'top-right')->showCloseButton()->timerProgressBar();
            // return back()->with('error', 'Failed to update profile');
            return back();
        }
    }
}