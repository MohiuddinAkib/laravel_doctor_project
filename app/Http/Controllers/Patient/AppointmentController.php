<?php

namespace App\Http\Controllers\Patient;

use App\Appointment;
use App\DoctorCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Patient\AppointmentsDataTable;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AppointmentsDataTable $datatable)
    {
        return $datatable->render('patient.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DoctorCategory::all();
        return view('patient.appointments.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string',
                'age' => 'required|numeric',
                'sex' => 'required|numeric',
                'doctor_id' => 'required|exists:App\User,id'
            ],
            [
                'doctor_id.required' => 'The doctor field is requierd',
                'doctor_id.exists' => 'The selected doctor is invalid'
            ]
        );

        $created = auth()->user()->appointmentsAsPatient()->create($validatedData);

        if ($created) {
            toast('Appointment created successfully', 'success', 'top-right')
                ->hideCloseButton()
                ->timerProgressBar();
        } else {
            toast('Something went wrong. Appointment was not created', 'error', 'top-right')
                ->hideCloseButton()
                ->timerProgressBar();
        };



        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}