@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Профиль пользователя',
        'items' => [
            [ 'name' => 'Клиенты', 'link' => route('admin.clients.index') ],
            [ 'name' => $client->getFullName(), 'link' => null ]
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
                                    <td>{{ $client->birthday }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Номер телефона:</th>
                                    <td>{{ $client->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail:</th>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Номер ID карты:</th>
                                    <td>{{ $client->id_card }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">ID карта действительна до:</th>
                                    <td>{{ $client->id_card_expires_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Номер паспорта:</th>
                                    <td>
                                        <span class="badge badge-success font-size-12"><i class="mdi mdi-passport mr-1"></i> {{ $client->passport_number }}</span>    
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Номер паспорта действителен до:</th>
                                    <td>{{ $client->passport_expires_at }}</td>
                                </tr>
                            </tbody>
                        </table>
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

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">My Projects</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Projects</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Skote admin UI</td>
                                    <td>2 Sep, 2019</td>
                                    <td>20 Oct, 2019</td>
                                    <td>$506</td>
                                </tr>

                                <tr>
                                    <th scope="row">2</th>
                                    <td>Skote admin Logo</td>
                                    <td>1 Sep, 2019</td>
                                    <td>2 Sep, 2019</td>
                                    <td>$94</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Redesign - Landing page</td>
                                    <td>21 Sep, 2019</td>
                                    <td>29 Sep, 2019</td>
                                    <td>$156</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>App Landing UI</td>
                                    <td>29 Sep, 2019</td>
                                    <td>04 Oct, 2019</td>
                                    <td>$122</td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Blog Template</td>
                                    <td>05 Oct, 2019</td>
                                    <td>16 Oct, 2019</td>
                                    <td>$164</td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>Redesign - Multipurpose Landing</td>
                                    <td>17 Oct, 2019</td>
                                    <td>05 Nov, 2019</td>
                                    <td>$192</td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>Logo Branding</td>
                                    <td>04 Nov, 2019</td>
                                    <td>05 Nov, 2019</td>
                                    <td>$94</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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