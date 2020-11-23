@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.transport.form.editFormLabel'),
        'items' => [
            [ 'name' => __('pages.transport.label'), 'link' => route('admin.transport.index') ],
            [ 'name' => __('pages.transport.form.editFormLabel'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .radio-btn-group {
            display: flex;
            align-items: center;
        }

        .car-image-wrapper {
            display: inline-block;
            position: relative;
        }

        .car-image-wrapper > .car-image-delete-btn {
            font-size: 18px;
            color: #ddd;
            transition: .3s all ease;
            position: absolute;
            top: 0;
            right: 5px;
            opacity: 0;
        }

        .car-image-wrapper > .car-image-delete-btn:hover {
            color: #f46a6a;
        }

        .car-image {
            width: 100px;
            border: 1px solid #ddd;
            padding: 5px;
            margin-right: 10px;
            border-radius: 100%;
            height: 100px;
            margin-bottom: 10px;
            transition: .3s all ease;
        }

        .car-image:hover {
            border: 1px solid #34c38f;
        }

        .car-image-wrapper:hover .car-image-delete-btn {
            opacity: 1;
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

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all mr-2"></i>
            {{ Session::get('success') }}
        </div>
    @endif

    <form action="{{ route('admin.transport.update', [ $transport->id ]) }}" method="POST" enctype="multipart/form-data" class="form-horizontal custom-validation" novalidate>
        @csrf
        @method('PUT')

        {{-- Main info --}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.transport.form.editFormLabel') }}</h4>
                        <p class="card-title-desc"></p>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.transportRegistered') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="companyRadio" name="registered_on" value="0" class="custom-control-input" {{ $transport->registered_on === 0 ? 'checked' : null }}>
                                            <label class="custom-control-label" for="companyRadio">{{ __('pages.transport.form.labels.company') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="individualRadio" name="registered_on" value="1" class="custom-control-input" {{ $transport->registered_on === 1 ? 'checked' : null }}>
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
                                    <select name="register_country" class="form-control select2" required>
                                        <option value="" disabled>{{ __('pages.transport.form.placeholders.country') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $transport->register_country === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @foreach ($langs as $lang)
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="register_city">{{ __('pages.transport.form.labels.city') }}: {{ $lang->name }}</label>
                                        <input name="register_city[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.city') }}" value="{{ $transport->getTranslation('register_city', $lang->code) }}" required>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="car_number">{{ __('pages.transport.form.labels.carNumber') }}</label>
                                    <input id="car_number" name="car_number" type="text" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.carNumber') }}" value="{{ $transport->car_number }}" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="car_brand_id">{{ __('pages.transport.form.labels.brand') }}</label>
                                    <select name="car_brand_id" class="form-control select2" required>
                                        @foreach ($carBrands as $brand)
                                            <option value="{{ $brand->id }}" {{ $transport->car_brand_id === $brand->id ? 'selected' : null }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="car_model_id">{{ __('pages.transport.form.labels.model') }}</label>
                                    <select name="car_model_id" class="form-control select2" required>
                                        @foreach ($carModels as $model)
                                            <option value="{{ $model->id }}" {{ $transport->car_model_id === $model->id ? 'selected' : null }}>{{ $model->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="car_number">{{ __('pages.transport.form.labels.year') }}</label>
                                    <select name="year" class="form-control select2" id="yearpicker" required>
                                        <option value="{{ $transport->year }}" selected>{{ $transport->year }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('pages.transport.form.labels.inspectionFrom') }}</label>
                                    <div class="input-group">
                                        <input value="{{ Carbon\Carbon::parse($transport->teh_osmotr_date_from)->format('m/d/Y') }}" required type="text" name="teh_osmotr_date_from" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.inspectionFrom') }}" data-provide="datepicker" data-date-autoclose="true">
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
                                        <input value="{{ Carbon\Carbon::parse($transport->teh_osmotr_date_to)->format('m/d/Y') }}" required type="text" name="teh_osmotr_date_to" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.inspectionTo') }}" data-provide="datepicker" data-date-autoclose="true">
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
                                        <input value="{{ Carbon\Carbon::parse($transport->insurance_date_from)->format('m/d/Y') }}" required type="text" name="insurance_date_from" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.insuranceFrom') }}" data-provide="datepicker" data-date-autoclose="true">
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
                                        <input value="{{ Carbon\Carbon::parse($transport->insurance_date_to)->format('m/d/Y') }}" required type="text" name="insurance_date_to" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.insuranceTo') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.hasCmr') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="cmrYesRadio" name="has_cmr" value="1" class="custom-control-input" {{ $transport->has_cmr ? 'checked' : null }}>
                                            <label class="custom-control-label" for="cmrYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="cmrNoRadio" name="has_cmr" value="0" class="custom-control-input" {{ !$transport->has_cmr ? 'checked' : null }}>
                                            <label class="custom-control-label" for="cmrNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="passengers_seats">{{ __('pages.transport.form.labels.passengerSeats') }}</label>
                                    <input required id="passengers_seats" name="passengers_seats" type="number" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.passengerSeats') }}" value="{{ $transport->passengers_seats }}" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="cubo_metres_available">{{ __('pages.transport.form.labels.cuboMetres') }}</label>
                                    <input required id="cubo_metres_available" name="cubo_metres_available" type="number" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.cuboMetres') }}" value="{{ $transport->cubo_metres_available }}" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="kilos_available">{{ __('pages.transport.form.labels.kilos') }}</label>
                                    <input required id="kilos_available" name="kilos_available" type="number" class="form-control" placeholder="{{ __('pages.transport.form.placeholders.kilos') }}" value="{{ $transport->kilos_available }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.okForMove') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="okForMoveYesRadio" name="ok_for_move" value="1" class="custom-control-input" {{ $transport->ok_for_move ? 'checked' : null }}>
                                            <label class="custom-control-label" for="okForMoveYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="okForMoveNoRadio" name="ok_for_move" value="0" class="custom-control-input" {{ !$transport->ok_for_move ? 'checked' : null }}>
                                            <label class="custom-control-label" for="okForMoveNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.canPullTrailer') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="canPullTrailerYesRadio" name="can_pull_trailer" value="1" class="custom-control-input" {{ $transport->can_pull_trailer ? 'checked' : null }}>
                                            <label class="custom-control-label" for="canPullTrailerYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="canPullTrailerNoRadio" name="can_pull_trailer" value="0" class="custom-control-input" {{ !$transport->can_pull_trailer ? 'checked' : null }}>
                                            <label class="custom-control-label" for="canPullTrailerNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.hasTrailer') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="hasTrailerYesRadio" name="has_trailer" value="1" class="custom-control-input" {{ $transport->has_trailer ? 'checked' : null }}>
                                            <label class="custom-control-label" for="hasTrailerYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="hasTrailerNoRadio" name="has_trailer" value="0" class="custom-control-input" {{ !$transport->has_trailer ? 'checked' : null }}>
                                            <label class="custom-control-label" for="hasTrailerNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.palletTransportation') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="palletsTrasportationYesRadio" name="pallet_transportation" value="1" class="custom-control-input" {{ $transport->pallet_transportation ? 'checked' : null }}>
                                            <label class="custom-control-label" for="palletsTrasportationYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="palletsTrasportationNoRadio" name="pallet_transportation" value="0" class="custom-control-input" {{ !$transport->pallet_transportation ? 'checked' : null }}>
                                            <label class="custom-control-label" for="palletsTrasportationNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.conditioner') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="airConditionerYesRadio" name="air_conditioner" value="1" class="custom-control-input" {{ $transport->air_conditioner ? 'checked' : null }}>
                                            <label class="custom-control-label" for="airConditionerYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="airConditionerNoRadio" name="air_conditioner" value="0" class="custom-control-input" {{ !$transport->air_conditioner ? 'checked' : null }}>
                                            <label class="custom-control-label" for="airConditionerNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.wifi') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="wifiYesRadio" name="wifi" value="1" class="custom-control-input" {{ $transport->wifi ? 'checked' : null }}>
                                            <label class="custom-control-label" for="wifiYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="wifiNoRadio" name="wifi" value="0" class="custom-control-input" {{ !$transport->wifi ? 'checked' : null }}>
                                            <label class="custom-control-label" for="wifiNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.tvVideo') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="tvVideoYesRadio" name="tv_video" value="1" class="custom-control-input" {{ $transport->tv_video ? 'checked' : null }}>
                                            <label class="custom-control-label" for="tvVideoYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="tvVideoNoRadio" name="tv_video" value="0" class="custom-control-input" {{ !$transport->tv_video ? 'checked' : null }}>
                                            <label class="custom-control-label" for="tvVideoNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <label for="car_passport">{{ __('pages.transport.form.labels.disabledPeopleSeats') }}</label>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="disabledPeopleSeatsYesRadio" name="disabled_people_seats" value="1" class="custom-control-input" {{ $transport->disabled_people_seats ? 'checked' : null }}>
                                            <label class="custom-control-label" for="disabledPeopleSeatsYesRadio">{{ __('pages.transport.form.labels.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="disabledPeopleSeatsNoRadio" name="disabled_people_seats" value="0" class="custom-control-input" {{ !$transport->disabled_people_seats ? 'checked' : null }}>
                                            <label class="custom-control-label" for="disabledPeopleSeatsNoRadio">{{ __('pages.transport.form.labels.no') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                        <h4 class="card-title">{{ __('pages.transport.form.uploadedDocumentsLabel') }}</h4>
                        <p class="card-title-desc"></p>

                        @if ($transport->car_docs->count() > 0)
                            @foreach ($transport->car_docs as $doc)
                                <div class="car-image-wrapper">
                                    <a class="image-popup-no-margins" href="{{ asset('storage/'.$doc->file_path) }}" title="{{ $doc->doc_type }}">
                                        <img class="img-fluid car-image" alt="" src="{{ asset('storage/'.$doc->file_path) }}">
                                    </a>
                                    <a href="{{ route('admin.transport.destroyDoc', [ 'id' => $doc->id ]) }}" class="car-image-delete-btn">
                                        <i class="bx bx-trash-alt"></i>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <i class="mdi mdi-information mr-2"></i>
                                {{ __('pages.transport.form.noDocumentsLabel') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit form btn --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success waves-effect waves-light" style="float: right">{{ __('form.buttons.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            for (i = new Date().getFullYear(); i > 1900; i--){
                $('#yearpicker').append($('<option />').val(i).html(i));
            }

            $('.image-popup-no-margins').magnificPopup({
                type: "image",
                closeOnContentClick: !0,
                closeBtnInside: !1,
                fixedContentPos: !0,
                mainClass: "mfp-no-margins mfp-with-zoom",
                image: {
                    verticalFit: !0
                },
                zoom: {
                    enabled: !0,
                    duration: 300
                }
            })
        });
    </script>
@endsection