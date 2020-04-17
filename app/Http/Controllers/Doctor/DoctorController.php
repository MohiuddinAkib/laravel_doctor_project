<?php

namespace App\Http\Controllers\Doctor;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { }

    /**
     * Display details of a patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPatient()
    {
        return view('doctor.patient.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(User $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(User $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
        //
    }
}