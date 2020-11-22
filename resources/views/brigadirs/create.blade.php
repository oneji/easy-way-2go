@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.createBrigadir.label'),
        'items' => [
            [ 'name' => trans_choice('pages.createBrigadir.label', 2), 'link' => route('admin.brigadirs.index') ],
            [ 'name' => __('pages.createBrigadir.label'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <style>
        .radio-btn-group {
            display: flex;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.brigadirs.store') }}" class="form-horizontal custom-validation" novalidate method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.createBrigadir.addForm.label') }}</h4>
                        <p class="card-title-desc"></p>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="radio-btn-group">
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderFemale" name="gender" value="1" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="genderFemale">{{ __('pages.createBrigadir.addForm.labels.mr') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderMale" name="gender" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="genderMale">{{ __('pages.createBrigadir.addForm.labels.ms') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="genderOther" name="gender" value="2" class="custom-control-input">
                                        <label class="custom-control-label" for="genderOther">{{ __('pages.createBrigadir.addForm.labels.notSure') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label for="first_name" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.firstName') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="first_name[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.firstName') }}" required>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label for="last_name" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.lastName') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="last_name[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.lastName') }}" required>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.email') }}</label>
                            <div class="col-md-10">
                                <input name="email" type="email" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.email') }}" parsley-type="email" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.photo') }}</label>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo">
                                    <label class="custom-file-label" for="photo">{{ __('pages.createBrigadir.addForm.placeholders.photo') }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.password') }}</label>
                            <div class="col-md-10">
                                <input data-parsley-minlength="8" id="password" name="password" type="password" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.password') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.confirmPassword') }}</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" required name="password_confirmation" data-parsley-equalto="#password" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.confirmPassword') }}"/>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="birthday" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.birthday') }}</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" name="birthday" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.birthday') }}" data-provide="datepicker" data-date-autoclose="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="nationality" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.nationality') }}</label>
                            <div class="col-md-10">
                                <select name="nationality" class="form-control select2" required>
                                    <option value="" selected>{{ __('pages.createBrigadir.addForm.placeholders.nationality') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.phone') }}</label>
                            <div class="col-md-10">
                                <input id="phone_number" name="phone_number" type="text" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.phone') }}" required>
                            </div>
                        </div>
                        
                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label for="company_name" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.company') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="company_name[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.company') }}" required>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="form-group row">
                            <label for="inn" class="col-md-2 col-form-label">{{ __('pages.createBrigadir.addForm.labels.inn') }}</label>
                            <div class="col-md-10">
                                <input id="inn" name="inn" type="text" class="form-control" placeholder="{{ __('pages.createBrigadir.addForm.placeholders.inn') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success waves-effect waves-light" style="float: right">{{ __('form.buttons.add') }}</button>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
@endsection

@section('scripts')
    @parent
    
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/ru.js') }}"></script>
@endsection