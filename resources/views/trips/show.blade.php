@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.trips.label'),
        'items' => [
            [ 'name' => __('pages.trips.label'), 'link' => route('admin.trips.index') ],
            [ 'name' => 'Trip №' . $trip->id, 'link' => null ],
        ]
    ]
])

@section('head')
    @parent

    <link href="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 d-flex align-items-center">
                        <p class="mb-0 font-size-18">
                            {{ $trip->car_number }} &middot; 
                            {{ \Carbon\Carbon::parse($trip->data->date)->format('d.m.y') }} &middot; 
                            <span class="badge badge-success">{{ $trip->status->name }}</span>
                        </p>
                    </div>

                    <div class="col-sm-8">
                        <ul class="list-inline user-chat-nav text-right mb-0">
                            <li class="list-inline-item">
                                <div class="dropdown">
                                    <button class="btn nav-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#forward" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Forward</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#back" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Back</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#drivers" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Drivers</span> 
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="forward" role="tabpanel">
                        @include('trips.partials.__addresses', [
                            'departure_time' => $routes->forward['starting']->departure_time,
                            'departure_date' => $routes->forward['starting']->departure_date,
                            'departure_from' => $routes->forward['starting']->country->name .', '. $routes->forward['starting']->address,
                            'arrival_time'   => $routes->forward['ending']->arrival_time,
                            'arrival_date'   => $routes->forward['ending']->arrival_date,
                            'arrival_to'     => $routes->forward['ending']->country->name .', '. $routes->forward['ending']->address,
                        ])

                        {{-- Stats cards --}}
                        @include('trips.partials.__stats', [
                            'passengers' => $routes['forward']['stats']['passengers'],
                            'packages' => $routes['forward']['stats']['packages'],
                            'factPrice' => $routes['forward']['stats']['fact_price'],
                            'totalPrice' => $routes['forward']['stats']['total_price'],
                        ])
                        {{-- Stats cards end --}}
                        
                        {{-- Orders --}}
                        @include('trips.partials.__orders', [
                            'orders' => $routes['forward']['orders']
                        ])
                    </div>
                    <div class="tab-pane" id="back" role="tabpanel">
                        @include('trips.partials.__addresses', [
                            'departure_time' => $routes->back['starting']->departure_time,
                            'departure_date' => $routes->back['starting']->departure_date,
                            'departure_from' => $routes->back['starting']->country->name .', '. $routes->back['starting']->address,
                            'arrival_time'   => $routes->back['ending']->arrival_time,
                            'arrival_date'   => $routes->back['ending']->arrival_date,
                            'arrival_to'     => $routes->back['ending']->country->name .', '. $routes->back['ending']->address,
                        ])

                        {{-- Stats cards --}}
                        @include('trips.partials.__stats', [
                            'passengers' => $routes['back']['stats']['passengers'],
                            'packages' => $routes['back']['stats']['packages'],
                            'factPrice' => $routes['back']['stats']['fact_price'],
                            'totalPrice' => $routes['back']['stats']['total_price'],
                        ])
                        {{-- Stats cards end --}}
                        
                        {{-- Orders --}}
                        @include('trips.partials.__orders', [
                            'orders' => $routes['back']['orders']
                        ])
                    </div>
                    <div class="tab-pane" id="drivers" role="tabpanel">
                        @include('trips.partials.__drivers', [
                            'drivers' => $drivers
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <!-- Responsive Table js -->
    <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
    <!-- Init js -->
    <script src="{{ asset('assets/js/pages/table-responsive.init.js') }}"></script>
@endsection