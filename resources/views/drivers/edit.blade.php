@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.editDriver.label'),
        'items' => [
            [ 'name' => __('pages.drivers.label'), 'link' => route('admin.drivers.index') ],
            [ 'name' => __('pages.editDriver.label'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- Lightbox css -->
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

        .custom-file-input:lang(en)~.custom-file-label::after {
            content: "Выбрать";
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

    <form action="{{ route('admin.drivers.update', [ $driver->id ]) }}" class="form-horizontal custom-validation" novalidate method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.drivers.driverInfoLabel') }}</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-12">
                                @if ($driver->photo !== null)
                                    <img class="rounded-circle avatar-xl mb-3" style="display:block; margin: 0 auto" src="{{ asset('storage/'.$driver->photo) }}" alt="{{ $driver->first_name .' '. $driver->last_name }}">
                                @else
                                    <img class="rounded-circle avatar-xl mb-3" style="display:block; margin: 0 auto" src="{{ asset('assets/images/users/no-photo.png') }}" alt="{{ $driver->first_name .' '. $driver->last_name }}">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="radio-btn-group">
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderFemale" name="gender" value="1" class="custom-control-input" {{ $driver->gender === 1 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderFemale">{{ __('pages.drivers.addForm.labels.mr') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderMale" name="gender" value="0" class="custom-control-input" {{ $driver->gender === 0 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderMale">{{ __('pages.drivers.addForm.labels.ms') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="genderOther" name="gender" value="2" class="custom-control-input" {{ $driver->gender === 2 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderOther">{{ __('pages.drivers.addForm.labels.notSure') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.firstName') }}</label>
                            <div class="col-md-10">
                                <input value="{{ $driver->first_name }}" name="first_name" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.firstName') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.lastName') }}</label>
                            <div class="col-md-10">
                                <input value="{{ $driver->last_name }}" name="last_name" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.lastName') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.email') }}</label>
                            <div class="col-md-10">
                                <input value="{{ $driver->email }}" name="email" type="email" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.email') }}" parsley-type="email" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.photo') }}</label>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo">
                                    <label class="custom-file-label" for="photo">{{ __('pages.drivers.addForm.placeholders.photo') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.birthday') }}</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input value="{{ \Carbon\Carbon::parse($driver->birthday)->format('m/d/Y') }}" type="text" name="birthday" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.birthday') }}" data-provide="datepicker" data-date-autoclose="true">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.nationality') }}</label>
                            <div class="col-md-10">
                                <select name="nationality" class="form-control select2" required>
                                    <option value="" selected>{{ __('pages.drivers.addForm.placeholders.nationality') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ $driver->nationality === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.phone') }}</label>
                            <div class="col-md-10">
                                <input value="{{ $driver->phone_number }}" name="phone_number" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.phone') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.country') }}</label>
                            <div class="col-md-10">
                                <select name="country_id" class="form-control select2" required>
                                    <option value="" selected>{{ __('pages.drivers.addForm.placeholders.country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ $driver->country_id === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-2 col-form-label">{{ __('pages.drivers.addForm.labels.city') }}</label>
                            <div class="col-md-10">
                                <input value="{{ $driver->city }}" name="city" type="text" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.city') }}">
                            </div>
                        </div>
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
                                    <select name="driving_experience_id" class="form-control select2">
                                        @foreach ($deList as $idx => $de)
                                            <option value="{{ $de->id }}" {{ $driver->driving_experience_id === $de->id ? 'selected' : null }}>{{ $de->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{ __('pages.drivers.addForm.labels.dlIssuePlace') }}</label>
                                    <select name="dl_issue_place" class="form-control select2">
                                        <option value="">{{ __('pages.drivers.addForm.placeholders.dlIssuePlace') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $driver->dl_issue_place === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('pages.drivers.addForm.labels.dlIssuedAt') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="dl_issued_at" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.dlIssuedAt') }}" value="{{ \Carbon\Carbon::parse($driver->dl_issued_at)->format('m/d/Y') }}" data-provide="datepicker" data-date-autoclose="true">
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
                                        <input type="text" name="dl_expires_at" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.dlExpiresAt') }}" value="{{ \Carbon\Carbon::parse($driver->dl_expires_at)->format('m/d/Y') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">{{ __('pages.drivers.addForm.labels.comment') }}</label>
                                    <textarea name="comment" class="form-control" id="" cols="30" maxlength="255" rows="3" placeholder="{{ __('pages.drivers.addForm.placeholders.comment') }}">{{ $driver->comment }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="convictionSwitch" name="conviction" {{ $driver->conviction ? 'checked' : null }}>
                                    <label class="custom-control-label" for="convictionSwitch">{{ __('pages.drivers.addForm.labels.conviction') }}</label>
                                </div>

                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="dtpSwitch" name="dtp" {{ $driver->dtp ? 'checked' : null }}>
                                    <label class="custom-control-label" for="dtpSwitch">{{ __('pages.drivers.addForm.labels.keptDrunk') }}</label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="drunkSwitch" name="was_kept_drunk" {{ $driver->was_kept_drunk ? 'checked' : null }}>
                                    <label class="custom-control-label" for="drunkSwitch">{{ __('pages.drivers.addForm.labels.dtp') }}</label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">{{ __('pages.drivers.addForm.labels.grades') }}</label>
                                    <input type="number" class="form-control" name="grades" value="{{ $driver->grades }}" placeholder="Не указано" min="0">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('pages.drivers.addForm.labels.gradesExpireAt') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="grade_expire_at" class="form-control" placeholder="{{ __('pages.drivers.addForm.placeholders.gradesExpireAt') }}" value="{{ \Carbon\Carbon::parse($driver->grade_expire_at)->format('m/d/Y') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">{{ __('pages.drivers.addForm.labels.dlPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="driving_license_photos[]" multiple id="d_licenseDoc" aria-describedby="d_licenseDocAddon">
                                        <label class="custom-file-label">{{ __('pages.drivers.addForm.placeholders.dlPhoto') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">{{ __('pages.drivers.addForm.labels.passportPhoto') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="passport_photos[]" multiple>
                                        <label class="custom-file-label">{{ __('pages.drivers.addForm.placeholders.passportPhoto') }}</label>
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
                        <h4 class="card-title">{{ __('pages.drivers.uploadedDocumentsLabel') }}</h4>
                        <p class="card-title-desc"></p>
                        @if ($driver->driving_license_photos || $driver->passport_photos)
                            @if ($driver->driving_license_photos)
                                @foreach ($driver->driving_license_photos as $item)
                                    <div class="car-image-wrapper">
                                        <a class="image-popup-no-margins" href="{{ asset('storage/'.$item->file) }}" title="Фото водительского удостоверения">
                                            <img class="img-fluid car-image" alt="" src="{{ asset('storage/'.$item->file) }}">
                                        </a>
                                        <a href="{{ route('admin.drivers.destroyDoc', [ 'driverId' => $driver->id, 'docId' => $item->id ]) }}" class="car-image-delete-btn">
                                            <i class="bx bx-trash-alt"></i>
                                        </a>
                                    </div>
                                @endforeach
                            @endif

                            @if ($driver->passport_photos)
                                @foreach ($driver->passport_photos as $item)
                                    <div class="car-image-wrapper">
                                        <a class="image-popup-no-margins" href="{{ asset('storage/'.$item->file) }}" title="Фото паспорта">
                                            <img class="img-fluid car-image" alt="" src="{{ asset('storage/'.$item->file) }}">
                                        </a>
                                        <a href="{{ route('admin.drivers.destroyDoc', [ 'driverId' => $driver->id, 'docId' => $item->id ]) }}" class="car-image-delete-btn">
                                            <i class="bx bx-trash-alt"></i>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <div class="alert alert-info">
                                <i class="mdi mdi-information mr-2"></i>
                                {{ __('pages.drivers.noDocumentsLabel') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

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
    <script>
        $(document).ready(function() {
            
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