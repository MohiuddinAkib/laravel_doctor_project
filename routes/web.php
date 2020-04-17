<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Patient')->name('patient.')->middleware(['role:patient'])->prefix('patient')->group(function () {
    // Profile routes
    Route::resource('profile', 'ProfileController')->only(['edit', 'update']);

    // Appointment routes
    Route::resource('appointments', 'AppointmentController');

    Route::resource('treatments', 'TreatmentController');

    // Search Doctor
    Route::resource('doctors', 'DoctorController');

    // Feedback
    Route::get('feedback', function () {
        return 'patient feedback';
    })->name('feedback');
});


Route::middleware(['role:doctor'])->get('api/doctor/appointments', 'Doctor\Api\DoctorController@appointments')->name('doctor.appointments');
Route::middleware(['role:doctor'])->apiResource('api/doctors', 'Doctor\Api\DoctorController');
Route::middleware(['role:patient'])->apiResource('api/patients', 'Patient\Api\PatientController');


Route::namespace('Doctor')->name('doctor.')->middleware(['role:doctor'])->prefix('doctor')->group(function () {
    // My appointments
    Route::resource('appointments', 'AppointmentController');

    // View customer
    Route::get('patient/show', 'DoctorController@showPatient')->name('patient.show');

    // Add description
    Route::resource('treatments', 'TreatmentController');

    // Profile routes
    Route::resource('profile', 'ProfileController')->only(['edit', 'update']);
});