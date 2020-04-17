@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Treatment</div>

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

                    <form method="POST" action="{{ route('doctor.treatments.store') }}">
                        @csrf
                           <div class="form-group row">
                            <label for="patient_id_selector" class="col-md-4 col-form-label text-md-right">{{ __('Select Patient') }}</label>

                            <div class="col-md-6 pt-2">
                                <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id') }}"/>
                                <select class="custom-select @error('patient_id') is-invalid @enderror" id="patient_id_selector" >
                                </select>

                                @error('patient_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="disease" class="col-md-4 col-form-label text-md-right">{{ __('Disease Name') }}</label>

                            <div class="col-md-6">
                                <input id="disease" type="text" class="form-control @error('disease') is-invalid @enderror"
                                    name="disease" value="{{ old('disease') }}" autocomplete="disease" autofocus>

                                @error('disease')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="treatment" class="col-md-4 col-form-label text-md-right">{{ __('Treatment') }}</label>

                            <div class="col-md-6">
                                <textarea id="treatment" type="text" class="form-control @error('treatment') is-invalid @enderror"
                                    name="treatment" autocomplete="treatment" autofocus>{{ old('treatment') }}</textarea>

                                @error('treatment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="note" class="col-md-4 col-form-label text-md-right">{{ __('Doctor\'s Note') }}</label>

                            <div class="col-md-6">
                                <textarea id="note" type="text" class="form-control @error('note') is-invalid @enderror"
                                    name="note" autocomplete="disease" autofocus>{{ old('note') }}</textarea>

                                @error('note')
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
            @if(!old('disease'))
            $('#disease').prop("disabled", true)
            @endif

            @if(!old('treatment'))
            $('#treatment').prop("disabled", true)
            @endif

            @if(!old('note'))
            $('#note').prop("disabled", true)
            @endif

           const patientSelector = $('#patient_id_selector');

           patientSelector.select2({
            theme: 'bootstrap4',
            ajax: {
                delay: 250,
                url: "{{ route('doctor.appointments') }}",
                dataType: 'json',
                processResults: function (patients) {
                    return {
                        results: patients
                    };
                },
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

           patientSelector.on('select2:select', function (e) {
                var data = e.params.data;
                $('#patient_id').val(data.patient_id)

                $('#disease, #treatment, #note').prop("disabled", false)
            });
        })
    </script>
@endpush
