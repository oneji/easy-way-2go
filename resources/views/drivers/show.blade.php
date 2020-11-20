@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Профиль пользователя',
        'items' => [
            [ 'name' => 'Водители', 'link' => route('admin.drivers.index') ],
            [ 'name' => $driver->first_name .' '. $driver->last_name, 'link' => null ]
        ]
    ]
])

@section('content')
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Личные данные</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">День рождения:</th>
                                    <td>{{ \Carbon\Carbon::parse($driver->birthday)->translatedFormat('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Номер телефона:</th>
                                    <td>{{ $driver->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail:</th>
                                    <td>{{ $driver->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Место проживания:</th>
                                    <td>{{ $driver->country->name .', '. $driver->city }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Где выданы вод. права?:</th>
                                    <td>{{ $driver->dl_issue_place }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Действуют с:</th>
                                    <td>{{ \Carbon\Carbon::parse($driver->dl_issued_at)->translatedFormat('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Действуют до:</th>
                                    <td>{{ \Carbon\Carbon::parse($driver->dl_expires_at)->translatedFormat('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Водительский опыт:</th>
                                    <td><span class="badge badge-success font-size-12"><i class="mdi mdi-star mr-1"></i> {{ $driver->driving_experience->name }}</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Судимость:</th>
                                    <td>
                                        @if ($driver->conviction)
                                            <span class="badge badge-danger font-size-12"> Да</span>
                                        @else
                                            <span class="badge badge-success font-size-12"> Нет</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Были ли задержаны пьяными?</th>
                                    <td>
                                        @if ($driver->was_kept_drunk)
                                            <span class="badge badge-danger font-size-12"> Да</span>
                                        @else
                                            <span class="badge badge-success font-size-12"> Нет</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Баллы:</th>
                                    <td>{{ $driver->grades }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Срок действия баллов:</th>
                                    <td>{{ \Carbon\Carbon::parse($driver->grades_expire_at)->translatedFormat('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Были ли в ДТП в течение 5 лет?</th>
                                    <td>
                                        @if ($driver->dpt)
                                            <span class="badge badge-danger font-size-12"> Да</span>
                                        @else
                                            <span class="badge badge-success font-size-12"> Нет</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar-sm mx-auto mb-4">
                        <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                            D
                        </span>
                    </div>
                    <h5 class="font-size-15"><a href="#" class="text-dark">{{ $driver->transport->first()->car_brand->name .' '. $driver->transport->first()->car_model->name }}</a></h5>
                    <p class="text-muted">{{ $driver->transport->first()->car_number }}</p>
                    <div>
                        <span class="badge badge-primary font-size-11 m-1">
                            <i class="bx bx-car mr-1"></i>
                            Транспортное средство
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="contact-links d-flex font-size-20">
                        <div class="flex-fill">
                            <a href="{{ route('admin.transport.edit', [ $driver->transport->first()->id ]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
                        </div>
                        <div class="flex-fill">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-car"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
        
        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Completed Projects</p>
                                    <h4 class="mb-0">125</h4>
                                </div>

                                <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-check-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Pending Projects</p>
                                    <h4 class="mb-0">12</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-hourglass font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Total Revenue</p>
                                    <h4 class="mb-0">$36,524</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-package font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Revenue</h4>
                    <div id="revenue-chart" class="apex-charts"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/profile.init.js') }}"></script>
@endsection