<?php

namespace App\Http\Controllers\Doctor;

use App\Treatment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doctor.treatments.create');
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
                'disease' => 'required|string',
                'treatment' => 'required|string',
                'note' => 'required|string',
                'patient_id' => 'required|numeric|exists:App\User,id'
            ],
            [
                'patient_id.required' => 'The patient field is required',
                'ptient_id.exists' => 'The selected patient is invalid'
            ]
        );

        $created = auth()->user()->treatmentsAsDoctor()->create($validatedData);

        if ($created) {
            toast('Treatment created successfully', 'success', 'top-right')
                ->timerProgressBar()
                ->showCloseButton();
        } else {
            toast('Something went wrong. Treatment was not created', 'error', 'top-right')
                ->timerProgressBar()
                ->showCloseButton();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treatment $treatment)
    {
        //
    }
}