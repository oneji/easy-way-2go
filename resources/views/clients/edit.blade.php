@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.editClient.label'),
        'items' => [
            [ 'name' => __('pages.clients.label'), 'link' => route('admin.clients.index') ],
            [ 'name' => __('pages.editClient.label'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
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

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all mr-2"></i>
            {{ Session::get('success') }}
        </div>
    @endif

    <form action="{{ route('admin.clients.update', [ $client->id ]) }}" method="POST" class="form-horizontal custom-validation" novalidate method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('pages.clients.clientInfoLabel') }}</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-12">
                                @if ($client->photo !== null)
                                    <img class="rounded-circle avatar-xl mb-3" style="display:block; margin: 0 auto" src="{{ asset('storage/'.$client->photo) }}" alt="{{ $client->first_name .' '. $client->last_name }}">
                                @else
                                    <img class="rounded-circle avatar-xl mb-3" style="display:block; margin: 0 auto" src="{{ asset('assets/images/users/no-photo.png') }}" alt="{{ $client->first_name .' '. $client->last_name }}">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="radio-btn-group">
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderFemale" name="gender" value="1" class="custom-control-input" {{ $client->gender === 1 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderFemale">{{ __('pages.clients.addForm.labels.mr') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderMale" name="gender" value="0" class="custom-control-input" {{ $client->gender === 0 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderMale">{{ __('pages.clients.addForm.labels.ms') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="genderOther" name="gender" value="2" class="custom-control-input" {{ $client->gender === 2 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderOther">{{ __('pages.clients.addForm.labels.notSure') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            @foreach ($langs as $lang)
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="first_name">{{ __('pages.clients.addForm.labels.firstName') }}: {{ $lang->name }}</label>
                                        <input name="translations[{{ $lang->code }}][first_name]" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.firstName') }}" value="{{ $client->getTranslation('first_name', $lang->code) }}" required>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($langs as $lang)
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="last_name">{{ __('pages.clients.addForm.labels.lastName') }}: {{ $lang->name }}</label>
                                        <input name="translations[{{ $lang->code }}][last_name]" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.lastName') }}" value="{{ $client->getTranslation('last_name', $lang->code) }}" required>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">{{ __('pages.clients.addForm.labels.email') }}</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.email') }}" parsley-type="email" value="{{ $client->email }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="photo">{{ __('pages.clients.addForm.labels.photo') }}</label></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo" name="photo">
                                        <label class="custom-file-label" for="photo">{{ __('pages.clients.addForm.placeholders.photo') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('pages.clients.addForm.labels.birthday') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="birthday" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.birthday') }}" data-provide="datepicker" value="{{ \Carbon\Carbon::parse($client->birthday)->format('m/d/Y') }}" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">{{ __('pages.clients.addForm.labels.nationality') }}</label>
                                    <select name="nationality" class="form-control" required>
                                        <option value="" selected>{{ __('pages.clients.addForm.placeholders.nationality') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $client->nationality === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="phone_number">{{ __('pages.clients.addForm.labels.phone') }}</label>
                                    <input id="phone_number" name="phone_number" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.phone') }}" value="{{ $client->phone_number }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id_card">{{ __('pages.clients.addForm.labels.idCard') }}</label>
                                    <input id="id_card" name="id_card" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.idCard') }}" value="{{ $client->client_data->id_card }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{ __('pages.clients.addForm.labels.idCardExpiresAt') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="id_card_expires_at" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.idCardExpiresAt') }}" data-provide="datepicker" value="{{ \Carbon\Carbon::parse($client->client_data->id_card_expires_at)->format('m/d/Y') }}" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="passport_number">{{ __('pages.clients.addForm.labels.passport') }}</label>
                                    <input id="passport_number" name="passport_number" type="text" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.passport') }}" value="{{ $client->client_data->passport_number }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{ __('pages.clients.addForm.labels.passportExpiresAt') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="passport_expires_at" class="form-control" placeholder="{{ __('pages.clients.addForm.placeholders.passportExpiresAt') }}" value="{{ \Carbon\Carbon::parse($client->client_data->passport_expires_at)->format('m/d/Y') }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
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
                        <button type="submit" class="btn btn-success waves-effect waves-light" style="float: right">{{ __('form.buttons.save') }}</button>
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
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/ru.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('[data-toggle=touchspin]').TouchSpin();
        });
    </script>
@endsection