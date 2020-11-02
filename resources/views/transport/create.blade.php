@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.transport.form.addFormLabel'),
        'items' => [
            [ 'name' => __('pages.transport.label'), 'link' => route('admin.transport.index') ],
            [ 'name' => __('pages.transport.form.addFormLabel'), 'link' => null ],
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

    <form action="{{ route('admin.transport.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal custom-validation" novalidate>
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.transport.form.addFormLabel') }}</h4>
                        <p class="card-title-desc"></p>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.transportRegistered') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="companyRadio" name="registered_on" value="0" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="companyRadio">{{ __('pages.transport.form.labels.company') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="individualRadio" name="registered_on" value="1" class="custom-control-input">
                                            <label class="custom-control-label" for="individualRadio">{{ __('pages.transport.form.labels.individual') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="register_country">{{ __('pages.transport.form.labels.country') }}</label>
                                    <select name="register_country" class="form-control" required>
                                        <option value="" selected disabled>{{ __('pages.transport.form.placeholders.country') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @foreach ($langs as $lang)
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="register_city">{{ __('pages.transport.form.labels.city') }}: {{ $lang->name }}</label>
                                        <input name="register_city[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.city') }}" required>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="car_number">{{ __('pages.transport.form.labels.carNumber') }}</label>
                                    <input id="car_number" name="car_number" type="text" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.carNumber') }}" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="car_brand_id">{{ __('pages.transport.form.labels.brand') }}</label>
                                    <select name="car_brand_id" class="form-control" required>
                                        @foreach ($carBrands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="car_model_id">{{ __('pages.transport.form.labels.model') }}</label>
                                    <select name="car_model_id" class="form-control" required>
                                        @foreach ($carModels as $model)
                                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="year">{{ __('pages.transport.form.labels.year') }}</label>
                                    <select name="year" class="form-control" id="yearpicker" required></select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('pages.transport.form.labels.inspectionFrom') }}</label>
                                    <div class="input-group">
                                        <input required type="text" name="teh_osmotr_date_from" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.inspectionFrom') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('pages.transport.form.labels.inspectionTo') }}</label>
                                    <div class="input-group">
                                        <input required type="text" name="teh_osmotr_date_to" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.inspectionTo') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('pages.transport.form.labels.insuranceFrom') }}</label>
                                    <div class="input-group">
                                        <input required type="text" name="insurance_date_from" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.insuranceFrom') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('pages.transport.form.labels.insuranceTo') }}</label>
                                    <div class="input-group">
                                        <input required type="text" name="insurance_date_to" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.insuranceTo') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.hasCmr') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="cmrYesRadio" name="has_cmr" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="cmrYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="cmrNoRadio" name="has_cmr" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="cmrNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="passengers_seats">{{ __('pages.transport.form.labels.passengerSeats') }}</label>
                                    <input required id="passengers_seats" name="passengers_seats" type="number" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.passengerSeats') }}" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="cubo_metres_available">{{ __('pages.transport.form.labels.cuboMetres') }}</label>
                                    <input required id="cubo_metres_available" name="cubo_metres_available" type="number" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.cuboMetres') }}" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="kilos_available">{{ __('pages.transport.form.labels.kilos') }}</label>
                                    <input required id="kilos_available" name="kilos_available" type="number" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.kilos') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.okForMove') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="okForMoveYesRadio" name="ok_for_move" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="okForMoveYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="okForMoveNoRadio" name="ok_for_move" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="okForMoveNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.canPullTrailer') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="canPullTrailerYesRadio" name="can_pull_trailer" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="canPullTrailerYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="canPullTrailerNoRadio" name="can_pull_trailer" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="canPullTrailerNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.hasTrailer') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="hasTrailerYesRadio" name="has_trailer" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="hasTrailerYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="hasTrailerNoRadio" name="has_trailer" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="hasTrailerNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.palletTransportation') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="palletsTrasportationYesRadio" name="pallet_transportation" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="palletsTrasportationYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="palletsTrasportationNoRadio" name="pallet_transportation" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="palletsTrasportationNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.conditioner') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="airConditionerYesRadio" name="air_conditioner" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="airConditionerYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="airConditionerNoRadio" name="air_conditioner" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="airConditionerNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.wifi') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="wifiYesRadio" name="wifi" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="wifiYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="wifiNoRadio" name="wifi" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="wifiNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.tvVideo') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="tvVideoYesRadio" name="tv_video" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="tvVideoYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="tvVideoNoRadio" name="tv_video" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="tvVideoNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">{{ __('pages.transport.form.labels.disabledPeopleSeats') }}</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="disabledPeopleSeatsYesRadio" name="disabled_people_seats" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="disabledPeopleSeatsYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="disabledPeopleSeatsNoRadio" name="disabled_people_seats" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="disabledPeopleSeatsNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.transport.form.documentsLabel') }}</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.passportPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="car_passport[]" id="car_passport_docs" multiple>
                                        <label class="custom-file-label" for="car_passport_docs">{{ __('pages.transport.form.placeholders.passportPhoto') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="teh_osmotr">{{ __('pages.transport.form.labels.tehOsmotrPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="teh_osmotr[]" multiple>
                                        <label class="custom-file-label" for="teh_osmotr[]">{{ __('pages.transport.form.placeholders.tehOsmotrPhoto') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="insurance">{{ __('pages.transport.form.labels.insurancePhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="insurance[]" multiple>
                                        <label class="custom-file-label" for="insurance[]">{{ __('pages.transport.form.placeholders.insurancePhoto') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="people_license">{{ __('pages.transport.form.labels.peopleLicensePhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="people_license[]" multiple>
                                        <label class="custom-file-label" for="people_license[]">{{ __('pages.transport.form.placeholders.peopleLicensePhoto') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="car_photos">{{ __('pages.transport.form.labels.carPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="car_photos[]" multiple>
                                        <label class="custom-file-label" for="car_photos[]">{{ __('pages.transport.form.placeholders.carPhoto') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="trailer_photos">{{ __('pages.transport.form.labels.trailerPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="trailer_photos[]" multiple>
                                        <label class="custom-file-label" for="trailer_photos[]">{{ __('pages.transport.form.placeholders.trailerPhoto') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
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
            
            for (i = new Date().getFullYear(); i > 1900; i--){
                $('#yearpicker').append($('<option />').val(i).html(i));
            }
        });
    </script>
@endsection