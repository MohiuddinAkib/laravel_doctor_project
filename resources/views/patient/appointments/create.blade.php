@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Appointment</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('patient.appointments.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Patient Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Patient Age') }}</label>

                            <div class="col-md-6">
                                <input id="age" type="text" class="form-control @error('age') is-invalid @enderror"
                                    name="age" value="{{ old('age') }}" autocomplete="age" autofocus>

                                @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('Patient Sex') }}</label>

                            <div class="col-md-6">
                               <input id="male" class="@error('sex') is-invalid @enderror" type="radio"
                                    name="sex" value="0">
                                <label for="male">Male</label>

                                <input id="female" class="@error('sex') is-invalid @enderror" type="radio"
                                    name="sex" value="1">
                                <label for="female">Female</label>

                                @error('sex')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Doctor Category') }}</label>

                            <div class="col-md-6 pt-2">
                                <select class="custom-select" id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="doctor-row">
                            <label for="doctor_id" class="col-md-4 col-form-label text-md-right">{{ __('Select Doctor') }}</label>

                            <div class="col-md-6 pt-2">
                                <select class="custom-select @error('doctor_id') is-invalid @enderror" name="doctor_id" id="doctor_id" disabled>
                                </select>

                                @error('doctor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function() {
           const categorySelector = $('#category_id'),
             doctorSelector = $('#doctor_id');


            categorySelector.on('change', function(event) {
                const category = categorySelector.val()
                $.getJSON("{{ route('doctors.index') }}", {type: category}, function(doctors) {
                    /*const lis = $.map(doctors, function(doctor) {
                        return `<option value="${doctor.id}">${doctor.name}</option>`
                    })*/

                    // doctorSelector.html(lis.join(''))

                    doctorSelector.select2({
                        theme: 'bootstrap4',
                        data: doctors,
                        ajax: {
                            delay: 250,
                            url: "{{ route('doctors.index') }}",
                            dataType: 'json',
                            processResults: function (doctors) {
                                return {
                                    results: doctors
                                };
                            },
                            data: function (params) {
                                var query = {
                                    q: params.term,
                                    type: category
                                }

                                return query;
                            }
                        },
                        templateResult: function(repo) {
                            if (repo.loading) {
                                return repo.text;
                            }
                            
                            var $container = $(
                                "<div class='select2-result-repository clearfix'>" +
                                "<div class='select2-result-repository__meta'>" +
                                    "<div class='select2-result-repository__title'></div>" +
                                    "<div class='select2-result-repository__description'></div>" +
                                    "<div class='select2-result-repository__statistics'>" +
                                    "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
                                    "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
                                    "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
                                    "</div>" +
                                "</div>" +
                                "</div>"
                            );

                            $container.find(".select2-result-repository__title").text(repo.name);

                            return $container;
                        },
                        templateSelection: function(repo) {
                            return repo.name;
                        }
                    })

                    doctorSelector.prop("disabled", false);
                })
            })

            doctorSelector.on('select2:select', function (e) {
                var data = e.params.data;
            });
        })
    </script>
@endpush
