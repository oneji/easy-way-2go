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

    <form action="{{ route('admin.clients.update', [ $client->id ]) }}" method="POST" class="form-horizontal custom-validation" novalidate method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card border border-success">
                    <div class="card-body">
                        <h4 class="card-title">Данные клиента</h4>
                        <p class="card-title-desc"></p>

                        <div class="row">
                            <div class="col-12">
                                @if ($client->photo !== null)
                                    <img class="rounded-circle avatar-xl mb-3" style="display:block; margin: 0 auto" src="{{ asset('storage/'.$client->photo) }}" alt="{{ $client->first_name .' '. $client->last_name }}">
                                @else
                                    <div class="avatar-xl mb-3" style="display:block; margin: 0 auto">
                                        <span class="avatar-title rounded-circle">
                                            D
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="first_name">Имя</label>
                                    <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Введите имя" value="{{ $client->first_name }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name">Фамилия</label>
                                    <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Введите фамилию" value="{{ $client->last_name }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Введите email" parsley-type="email" value="{{ $client->email }}" required>
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
                                    <label>День рождения</label>
                                    <div class="input-group">
                                        <input type="text" name="birthday" class="form-control" placeholder="dd.mm.yyyy" data-provide="datepicker" value="{{ $client->birthday }}" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone_number">Номер телефона</label>
                                    <input id="phone_number" name="phone_number" type="text" class="form-control" placeholder="Введите номер телефона" value="{{ $client->phone_number }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id_card">Номер ID карты</label>
                                    <input id="id_card" name="id_card" type="text" class="form-control" placeholder="Введите номер ID карты" value="{{ $client->client_data->id_card }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Действителен до</label>
                                    <div class="input-group">
                                        <input type="text" name="id_card_expires_at" class="form-control" placeholder="dd.mm.yyyy" data-provide="datepicker" value="{{ $client->client_data->id_card_expires_at }}" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="passport_number">Номер паспорта</label>
                                    <input id="passport_number" name="passport_number" type="text" class="form-control" placeholder="Введите номер паспорта" value="{{ $client->client_data->passport_number }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Действителен до</label>
                                    <div class="input-group">
                                        <input type="text" name="passport_expires_at" class="form-control" placeholder="dd.mm.yyyy" value="{{ $client->client_data->passport_expires_at }}" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div><!-- input-group -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border border-success">
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