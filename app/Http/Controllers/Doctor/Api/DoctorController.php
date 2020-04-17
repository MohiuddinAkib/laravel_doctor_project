<?php

namespace App\Http\Controllers\Doctor\Api;

use App\User;
use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = request()->query('q');
        $doctorCat = request()->query('type');
        $doctors = User::role('doctor')->whereHas('profile', function ($query) use ($doctorCat) {
            $query->where('category_id', $doctorCat);
        });
        $doctors = !!$q ? $doctors->where('name', 'LIKE', "%$q%") : $doctors;
        $doctors = $doctors->get(['id', 'name']);

        return response()->json($doctors);
    }

    /**
     * Display a listing of the appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function appointments()
    {
        $q = request()->query('q');
        $doctor_id = auth()->id();
        $patients = User::find($doctor_id)->appointmentsAsDoctor;
        $patients = !!$q ? $patients->filter(function (Appointment $appointment) use ($q) {
            return Str::contains($appointment->name, $q);
        })->values() : $patients;
        return response()->json($patients);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(User $doctor)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
        //
    }
}