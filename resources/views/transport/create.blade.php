@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Добавить машину',
        'items' => [
            [ 'name' => 'Транспорт', 'link' => route('admin.transport.index') ],
            [ 'name' => 'Добавить машину', 'link' => null ],
        ]
    ]
])

@section('head')
    @parent
    
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Добавить транспортное средство</h4>
                        <p class="card-title-desc"></p>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Автомобиль зарегистрирован?</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="companyRadio" name="registered_on" value="0" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="companyRadio">Фирма</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="individualRadio" name="registered_on" value="1" class="custom-control-input">
                                            <label class="custom-control-label" for="individualRadio">Физ. лицо</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="register_country">Страна регистрации</label>
                                <select name="register_country" class="form-control" required>
                                    <option value="" selected disabled>Выберите страну</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="register_city">Город, адрес, индекс регистрации транспорта</label>
                                    <input id="register_city" name="register_city" type="text" class="form-control" placeholder="Город, адрес, индекс" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="car_number">Номер автомобиля</label>
                                    <input id="car_number" name="car_number" type="text" class="form-control" placeholder="Не указан" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="car_brand_id">Марка</label>
                                    <select name="car_brand_id" class="form-control" required>
                                        @foreach ($carBrands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="car_model_id">Модель</label>
                                    <select name="car_model_id" class="form-control" required>
                                        @foreach ($carModels as $model)
                                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="car_number">Год выпуска</label>
                                    <select name="year" class="form-control" id="yearpicker" required></select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Тех осмотр</label>
                                    <div class="input-group">
                                        <input required type="text" name="teh_osmotr_date_from" class="form-control" placeholder="Тех осмотр с:" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>...</label>
                                    <div class="input-group">
                                        <input required type="text" name="teh_osmotr_date_to" class="form-control" placeholder="Тех осмотр до:" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Страхование</label>
                                    <div class="input-group">
                                        <input required type="text" name="insurance_date_from" class="form-control" placeholder="Страхование с:" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>...</label>
                                    <div class="input-group">
                                        <input required type="text" name="insurance_date_to" class="form-control" placeholder="Страхование до:" data-provide="datepicker" data-date-autoclose="true">
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
                                    <h5 class="font-size-14">Есть CMR?</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="cmrYesRadio" name="has_cmr" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="cmrYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="cmrNoRadio" name="has_cmr" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="cmrNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="passengers_seats">Кол-во пассажирских мест</label>
                                    <input required id="passengers_seats" name="passengers_seats" type="number" class="form-control" placeholder="Не указан" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="cubo_metres_available">Сколько кубометров можете вести?</label>
                                    <input required id="cubo_metres_available" name="cubo_metres_available" type="number" class="form-control" placeholder="Не указан" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="kilos_available">Сколько киллограмм можете вести?</label>
                                    <input required id="kilos_available" name="kilos_available" type="number" class="form-control" placeholder="Не указан" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Транспорт подходит для переезда?</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="okForMoveYesRadio" name="ok_for_move" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="okForMoveYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="okForMoveNoRadio" name="ok_for_move" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="okForMoveNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Можете ли тянуть прицеп?</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="canPullTrailerYesRadio" name="can_pull_trailer" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="canPullTrailerYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="canPullTrailerNoRadio" name="can_pull_trailer" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="canPullTrailerNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Есть ли трейлер?</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="hasTrailerYesRadio" name="has_trailer" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="hasTrailerYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="hasTrailerNoRadio" name="has_trailer" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="hasTrailerNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Перевозка паллетов?</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="palletsTrasportationYesRadio" name="pallet_transportation" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="palletsTrasportationYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="palletsTrasportationNoRadio" name="pallet_transportation" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="palletsTrasportationNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Кондиционер?</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="airConditionerYesRadio" name="air_conditioner" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="airConditionerYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="airConditionerNoRadio" name="air_conditioner" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="airConditionerNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Wi-Fi</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="wifiYesRadio" name="wifi" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="wifiYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="wifiNoRadio" name="wifi" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="wifiNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Tv-Video</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="tvVideoYesRadio" name="tv_video" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="tvVideoYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="tvVideoNoRadio" name="tv_video" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="tvVideoNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14">Места для инвалидов</h5>
                                    <div class="radio-btn-group">
                                        <div class="custom-control custom-radio mb-3 mr-4">
                                            <input type="radio" id="disabledPeopleSeatsYesRadio" name="disabled_people_seats" value="1" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="disabledPeopleSeatsYesRadio">Да</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="disabledPeopleSeatsNoRadio" name="disabled_people_seats" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="disabledPeopleSeatsNoRadio">Нет</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Car doc files --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Документы</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="car_passport">Паспорт автомобиля (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="car_passport[]" id="car_passport_docs" multiple>
                                        <label class="custom-file-label" for="car_passport_docs">Выберите файл</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="teh_osmotr">Техобслуживание (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="teh_osmotr[]" multiple>
                                        <label class="custom-file-label" for="teh_osmotr[]">Выберите файл</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="insurance">Страховка (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="insurance[]" multiple>
                                        <label class="custom-file-label" for="insurance[]">Выберите файл</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="people_license">Лицензия на перевозку людей (2 стороны)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="people_license[]" multiple>
                                        <label class="custom-file-label" for="people_license[]">Выберите файл</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="car_photos">Фото автомобиля</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="car_photos[]" multiple>
                                        <label class="custom-file-label" for="car_photos[]">Выберите файл</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="trailer_photos">Фото трейлера</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="trailer_photos[]" multiple>
                                        <label class="custom-file-label" for="trailer_photos[]">Выберите файл</label>
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