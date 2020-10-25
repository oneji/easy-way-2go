@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.createDriver.label'),
        'items' => [
            [ 'name' => __('pages.drivers.label'), 'link' => route('admin.drivers.index') ],
            [ 'name' => __('pages.createDriver.label'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
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

    <form action="{{ route('admin.drivers.store') }}" class="form-horizontal custom-validation" novalidate method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.drivers.driverInfoLabel') }}</h4>
                        <p class="card-title-desc"></p>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="radio-btn-group">
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderFemale" name="gender" value="1" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="genderFemale">{{ __('pages.drivers.addForm.labels.mr') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderMale" name="gender" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="genderMale">{{ __('pages.drivers.addForm.labels.ms') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="genderOther" name="gender" value="2" class="custom-control-input">
                                        <label class="custom-control-label" for="genderOther">{{ __('pages.drivers.addForm.labels.notSure') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.firstName') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="translations[{{ $lang->code }}][first_name]" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.firstName') }}" required>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.lastName') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="translations[{{ $lang->code }}][last_name]" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.lastName') }}" required>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.email') }}: {{ $lang->name }}</label>
                            <div class="col-md-10">
                                <input name="email" type="email" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.email') }}" parsley-type="email" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.photo') }}</label>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo">
                                    <label class="custom-file-label" for="photo">{{ __('pages.drivers.addForm.placeholders.photo') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.password') }}</label>
                            <div class="col-md-10">
                                <input data-parsley-minlength="8" id="password" name="password" type="password" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.password') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.confirmPassword') }}</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" required name="password_confirmation" data-parsley-equalto="#password" placeholder="{{ __('pages.drivers.addForm.placeholders.confirmPassword') }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.birthday') }}</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" name="birthday" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.birthday') }}" data-provide="datepicker" data-date-autoclose="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.nationality') }}</label>
                            <div class="col-md-10">
                                <select name="nationality" class="form-control" required>
                                    <option value="" selected>{{ __('pages.drivers.addForm.placeholders.nationality') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.phone') }}</label>
                            <div class="col-md-10">
                                <input name="phone_number" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.phone') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.country') }}</label>
                            <div class="col-md-10">
                                <select name="country_id" class="form-control" required>
                                    <option value="" selected>{{ __('pages.drivers.addForm.placeholders.country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @foreach ($langs as $lang)
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.city') }}: {{ $lang->name }}</label>
                                <div class="col-md-10">
                                    <input name="translations[{{ $lang->code }}][city]" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.city') }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.drivers.documentsLabel') }}</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">{{ __('pages.drivers.addForm.labels.drivingExperience') }}</label>
                                    <select name="driving_experience_id" class="form-control">
                                        @foreach ($deList as $idx => $de)
                                            <option value="{{ $de->id }}" {{ $idx === 0 ? 'selected' : null }}>{{ $de->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{ __('pages.drivers.addForm.labels.dlIssuePlace') }}</label>
                                    <select name="dl_issue_place" class="form-control">
                                        <option value="" selected>{{ __('pages.drivers.addForm.placeholders.dlIssuePlace') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('pages.drivers.addForm.labels.dlIssuedAt') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="dl_issued_at" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.dlIssuedAt') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('pages.drivers.addForm.labels.dlExpiresAt') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="dl_expires_at" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.dlExpiresAt') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach ($langs as $lang)
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">{{ __('pages.drivers.addForm.labels.comment') }}: {{ $lang->name }}</label>
                                        <textarea name="translations[{{ $lang->code }}][comment]" class="form-control" cols="30" maxlength="255" rows="3" placeholder="{{ __('pages.drivers.addForm.placeholders.comment') }}"></textarea>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-sm-12">
                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="convictionSwitch" name="conviction">
                                    <label class="custom-control-label" for="convictionSwitch">{{ __('pages.drivers.addForm.labels.conviction') }}</label>
                                </div>

                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="drunkSwitch" name="was_kept_drunk">
                                    <label class="custom-control-label" for="drunkSwitch">{{ __('pages.drivers.addForm.labels.keptDrunk') }}</label>
                                </div>

                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="dtpSwitch" name="dtp">
                                    <label class="custom-control-label" for="dtpSwitch">{{ __('pages.drivers.addForm.labels.dtp') }}</label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">{{ __('pages.drivers.addForm.labels.grades') }}</label>
                                    <input type="number" class="form-control" name="grades" value="0" placeholder="Не указано" min="0">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('pages.drivers.addForm.labels.gradesExpireAt') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="grade_expire_at" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.gradesExpireAt') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('pages.drivers.addForm.labels.dlPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="d_license[]" multiple>
                                        <label class="custom-file-label" for="d_license[]">{{ __('pages.drivers.addForm.placeholders.dlPhoto') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('pages.drivers.addForm.labels.passportPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="passport[]" multiple>
                                        <label class="custom-file-label" for="passport[]">{{ __('pages.drivers.addForm.placeholders.passportPhoto') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
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