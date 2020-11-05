@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.routes.label'),
        'items' => [
            [ 'name' => __('pages.routes.label'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent

    <!--Bootstrap Datepicker-->
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mdi mdi-check-all mr-2"></i>
                {{ Session::get('success') }}
            </div>
        @endif
        
        <div class="card">
            <div class="card-body">
                @if ($routes->count() === 0)
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        {{ __('pages.routes.emptySet') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">{{ __('pages.routes.datatable.to') }}</th>
                                    <th scope="col">{{ __('pages.routes.datatable.from') }}</th>
                                    <th scope="col">{{ __('pages.routes.datatable.driver') }}</th>
                                    <th scope="col">{{ __('pages.routes.datatable.status') }}</th>
                                    <th scope="col">{{ __('pages.routes.datatable.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routes as $idx => $route)
                                    <tr>
                                        <th>{{ $idx + 1 }}</th>
                                        <td>
                                            <h5 class="font-size-14 mb-1">{{ $route->getStartingPointWithTime()['country'] }}</h5>
                                            <p class="text-muted mb-0">{{ $route->getStartingPointWithTime()['time'] }}</p>
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1">{{ $route->getEndingPointWithTime()['country'] }}</h5>
                                            <p class="text-muted mb-0">{{ $route->getEndingPointWithTime()['time'] }}</p>
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1"><a href="{{ route('admin.drivers.show', [ $route->driver->id ]) }}" class="text-dark">{{ $route->driver->getFullName() }}</a></h5>
                                        </td>
                                        <td>
                                            @if ($route->status === 'active')
                                                <span class="badge badge-success font-size-12">Активный</span>
                                            @else
                                                <span class="badge badge-warning font-size-12">В архиве</span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="#" class="info-btn" data-id="{{ $route->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-info-circle"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        {{ $routes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('routes.modals.info')
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/routes.js') }}"></script>
@endsection