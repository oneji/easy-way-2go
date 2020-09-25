@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Изменить водителя',
        'items' => [
            [ 'name' => 'Водители', 'link' => route('admin.drivers.index') ],
            [ 'name' => 'Изменить водителя', 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Данные водителя</h4>
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
                                        <label class="custom-control-label" for="genderFemale">Мистер</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3 mr-4">
                                        <input type="radio" id="genderMale" name="gender" value="0" class="custom-control-input" {{ $driver->gender === 0 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderMale">Миссис</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="genderOther" name="gender" value="2" class="custom-control-input" {{ $driver->gender === 2 ? 'checked' : null }}>
                                        <label class="custom-control-label" for="genderOther">Не определился</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="first_name">Имя</label>
                                    <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Введите имя" value="{{ $driver->first_name }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name">Фамилия</label>
                                    <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Введите фамилию" value="{{ $driver->last_name }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Введите email" value="{{ $driver->email }}" parsley-type="email" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Фото</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="photo">
                                        <label class="custom-file-label" for="photo">Выберите фото</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>День рождения</label>
                                    <div class="input-group">
                                        <input type="text" name="birthday" class="form-control" placeholder="Выберите дату" value="{{ $driver->birthday }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone_number">Номер телефона</label>
                                    <input id="phone_number" name="phone_number" type="text" class="form-control" placeholder="Введите номер телефона" value="{{ $driver->phone_number }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Национальность</label>
                                    <select name="nationality" class="form-control" required>
                                        <option value="" selected>Выберите национальность</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $driver->nationality === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Место проживания</label>
                                    <select name="country_id" class="form-control" required>
                                        <option value="">Выберите страну</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $driver->driver_data->country_id === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="city">Город, адрес, индекс</label>
                                    <input id="city" name="city" type="text" class="form-control" placeholder="Город, адрес, индекс" value="{{ $driver->driver_data->city }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Документы</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Водительский опыт </label>
                                    <select name="driving_experience" class="form-control">
                                        @foreach ($deList as $idx => $de)
                                            <option value="{{ $de->id }}" {{ $driver->driver_data->driving_experience === $de->id ? 'selected' : null }}>{{ $de->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Где выданы вод. права?</label>
                                    <select name="dl_issue_place" class="form-control">
                                        <option value="">Выберите страну</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $driver->driver_data->dl_issue_place === $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Действует с</label>
                                    <div class="input-group">
                                        <input type="text" name="dl_issued_at" class="form-control" placeholder="Выберите дату" value="{{ $driver->driver_data->dl_issued_at }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Действует до</label>
                                    <div class="input-group">
                                        <input type="text" name="dl_expires_at" class="form-control" placeholder="Выберите дату" value="{{ $driver->driver_data->dl_expires_at }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Комментарий</label>
                                    <textarea name="comment" class="form-control" id="" cols="30" maxlength="255" rows="3" placeholder="Не указано">{{ $driver->driver_data->comment }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="convictionSwitch" name="conviction" {{ $driver->driver_data->conviction ? 'checked' : null }}>
                                    <label class="custom-control-label" for="convictionSwitch">Судимость</label>
                                </div>

                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="dtpSwitch" name="dtp" {{ $driver->driver_data->dtp ? 'checked' : null }}>
                                    <label class="custom-control-label" for="dtpSwitch">Были ли в ДТП в течение 5 лет?</label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="drunkSwitch" name="was_kept_drunk" {{ $driver->driver_data->was_kept_drunk ? 'checked' : null }}>
                                    <label class="custom-control-label" for="drunkSwitch">Были ли задержаны пьяными?</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Баллы</label>
                                    <input type="number" class="form-control" name="grades" value="{{ $driver->driver_data->grades }}" placeholder="Не указано" min="0">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Срок действия баллов</label>
                                    <div class="input-group">
                                        <input type="text" name="grade_expire_at" class="form-control" placeholder="Выберите дату" value="{{ $driver->driver_data->grades_expire_at }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Фото водительского удостоверения (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="d_license[]" multiple id="d_licenseDoc" aria-describedby="d_licenseDocAddon">
                                        <label class="custom-file-label" for="d_licenseDoc">Выберите файл</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Паспорт или ИД (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="passport[]" multiple>
                                        <label class="custom-file-label" for="passport[]">Выберите файл</label>
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
                        <h4 class="card-title">Добавленные документы</h4>
                        <p class="card-title-desc"></p>
                        @if ($driver->driver_data->docs !== null)
                            @foreach ($driver->driver_data->docs as $item)
                                <div class="car-image-wrapper">
                                    <a class="image-popup-no-margins" href="{{ asset('storage/'.$item->file) }}" title="{{ $item->type === 'passport' ? 'Паспорт или ИД' : 'Фото водительского удостоверения' }}">
                                        <img class="img-fluid car-image" alt="" src="{{ asset('storage/'.$item->file) }}">
                                    </a>
                                    <a href="{{ route('admin.drivers.destroyDoc', [ 'driverId' => $driver->id, 'docId' => $item->id ]) }}" class="car-image-delete-btn">
                                        <i class="bx bx-trash-alt"></i>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <i class="mdi mdi-information mr-2"></i>
                                На данный момент документов не найдено.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success waves-effect waves-light" style="float: right">Сохранить</button>
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
    <!-- Magnific Popup-->
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            
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