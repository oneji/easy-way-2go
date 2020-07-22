@extends('layouts.app')

@section('head')
    @parent
    
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
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
            <div class="col-6">
                <div class="card border border-success">
                    <div class="card-body">
                        <h4 class="card-title">Данные водителя</h4>
                        <p class="card-title-desc"></p>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="first_name">Имя</label>
                                    <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Введите имя" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name">Фамилия</label>
                                    <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Введите фамилию" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Введите email" parsley-type="email" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Фото</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo" name="photo">
                                        <label class="custom-file-label" for="photo">Выберите фото</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input data-parsley-minlength="8" id="password" name="password" type="password" class="form-control" placeholder="Введите пароль" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Подтвердите пароль</label>
                                    <input type="password" class="form-control" required name="password_confirmation" data-parsley-equalto="#password" placeholder="Подтвердите пароль"/>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>День рождения</label>
                                    <div class="input-group">
                                        <input type="text" name="birthday" class="form-control" placeholder="dd.mm.yyyy" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone_number">Номер телефона</label>
                                    <input id="phone_number" name="phone_number" type="text" class="form-control" placeholder="Введите номер телефона" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Место проживания</label>
                                    <select name="country_id" class="form-control" required>
                                        <option value="" selected>Выберите страну</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="city">Город, адрес, индекс</label>
                                    <input id="city" name="city" type="text" class="form-control" placeholder="Город, адрес, индекс">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card border border-success">
                    <div class="card-body">
                        <h4 class="card-title">Документы</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Где выданы вод. права?</label>
                                    <select name="dl_issue_place" class="form-control">
                                        <option value="" selected>Выберите страну</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Действует с</label>
                                    <div class="input-group">
                                        <input type="text" name="dl_issued_at" class="form-control" placeholder="dd.mm.yyyy" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Действует до</label>
                                    <div class="input-group">
                                        <input type="text" name="dl_expires_at" class="form-control" placeholder="dd.mm.yyyy" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Водительский опыт</label>
                                    <input data-toggle="touchspin" value="0" min="0" max="100" name="driving_experience" type="number" data-step="1" data-bts-postfix="лет">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="custom-control custom-switch mt-4 mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="convictionSwitch" name="conviction">
                                    <label class="custom-control-label" for="convictionSwitch">Судимость</label>
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label class="control-label">Комментарий</label>
                                    <textarea name="comment" class="form-control" id="" cols="30" maxlength="255" rows="3" placeholder="Не указано"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="custom-control custom-switch mt-4 mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="drunkSwitch" name="was_kept_drunk">
                                    <label class="custom-control-label" for="drunkSwitch">Были ли задержаны пьяными?</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Баллы</label>
                                    <input type="number" class="form-control" name="grades" value="0" placeholder="Не указано" min="0">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Срок действия баллов</label>
                                    <div class="input-group">
                                        <input type="text" name="grade_expire_at" class="form-control" placeholder="dd.mm.yyyy" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="custom-control custom-switch mt-4 mb-2" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="dtpSwitch" name="dtp">
                                    <label class="custom-control-label" for="dtpSwitch">Были ли в ДТП в течение 5 лет?</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Фото водительского удостоверения (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo" name="d_license[]" multiple>
                                        <label class="custom-file-label" for="photo">Выберите файл</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Паспорт или ИД (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo" name="passport[]" multiple>
                                        <label class="custom-file-label" for="photo">Выберите файл</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border border-success">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success waves-effect waves-light" style="float: right">Добавить водителя</button>
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