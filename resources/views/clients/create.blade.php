@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.createClient.label'),
        'items' => [
            [ 'name' => __('pages.clients.label'), 'link' => route('admin.clients.index') ],
            [ 'name' => __('pages.createClient.label'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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

    <form action="{{ route('admin.clients.store') }}" class="form-horizontal custom-validation" novalidate method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.clients.clientInfoLabel') }}</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-12">
                                <div class="radio-btn-group">
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderFemale" name="gender" value="1" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="genderFemale">{{ __('pages.clients.addForm.labels.mr') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderMale" name="gender" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="genderMale">{{ __('pages.clients.addForm.labels.ms') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="genderOther" name="gender" value="2" class="custom-control-input">
                                        <label class="custom-control-label" for="genderOther">{{ __('pages.clients.addForm.labels.notSure') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="first_name">{{ __('pages.clients.addForm.labels.firstName') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="first_name[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.firstName') }}" required>
                                </div>
                            </div>
                        @endforeach
                        
                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="last_name">{{ __('pages.clients.addForm.labels.lastName') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="last_name[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.lastName') }}" required>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="email">{{ __('pages.clients.addForm.labels.email') }}</label>
                            <div class="col-md-10">
                                <input name="email" type="email" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.email') }}" parsley-type="email" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="photo">{{ __('pages.clients.addForm.labels.photo') }}</label>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo">
                                    <label class="custom-file-label" for="photo">{{ __('pages.clients.addForm.placeholders.photo') }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="password">{{ __('pages.clients.addForm.labels.password') }}</label>
                            <div class="col-md-10">
                                <input data-parsley-minlength="8" id="password" name="password" type="password" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.password') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="password_confirmation">{{ __('pages.clients.addForm.labels.confirmPassword') }}</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" required name="password_confirmation" data-parsley-equalto="#password" placeholder="{{ __('pages.clients.addForm.placeholders.confirmPassword') }}"/>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="birthday">{{ __('pages.clients.addForm.labels.birthday') }}</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" name="birthday" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.birthday') }}" data-provide="datepicker" data-date-autoclose="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="last_name" class="control-label">{{ __('pages.clients.addForm.labels.nationality') }}</label>
                            <div class="col-md-10">
                                <select name="nationality" class="form-control" required>
                                    <option value="" selected>{{ __('pages.clients.addForm.placeholders.nationality') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="phone_number">{{ __('pages.clients.addForm.labels.phone') }}</label>
                            <div class="col-md-10">
                                <input name="phone_number" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.phone') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="id_card">{{ __('pages.clients.addForm.labels.idCard') }}</label>
                            <div class="col-md-10">
                                <input name="id_card" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.idCard') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="id_card_expires_at">{{ __('pages.clients.addForm.labels.idCardExpiresAt') }}</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" name="id_card_expires_at" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.idCardExpiresAt') }}" data-provide="datepicker" data-date-autoclose="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" for="passport_number">{{ __('pages.clients.addForm.labels.passport') }}</label>
                            <div class="col-md-10">
                                <input id="passport_number" name="passport_number" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.passport') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{ __('pages.clients.addForm.labels.passportExpiresAt') }}</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" name="passport_expires_at" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.passportExpiresAt') }}" data-provide="datepicker" data-date-autoclose="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-8">
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

    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/ru.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection