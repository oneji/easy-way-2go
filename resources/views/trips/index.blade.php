@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.trips.label'),
        'items' => [
            [ 'name' => __('pages.trips.label'), 'link' => null ],
        ]
    ]
])

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">{{ __('pages.trips.infoLabel') }}</div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('pages.trips.bus') }}</th>
                                <th>{{ __('pages.trips.date') }}</th>
                                <th>{{ __('pages.trips.from') }}</th>
                                <th>{{ __('pages.trips.to') }}</th>
                                <th>{{ __('pages.trips.passengers') }}</th>
                                <th>{{ __('pages.trips.packages') }}</th>
                                <th>{{ __('pages.trips.moving') }}</th>
                                <th>{{ __('pages.trips.status') }}</th>
                                <th>{{ __('pages.trips.totalPrice') }}</th>
                                <th>{{ __('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trips as $trip)
                                <tr>
                                    <td>{{ $trip->car_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($trip->date)->format('d.m.y') }} {{ $trip->time }}</td>
                                    <td>{{ $trip->from_country->name .', '. $trip->from_address }}</td>
                                    <td>{{ $trip->to_country->name .', '. $trip->to_address }}</td>
                                    <td>{{ $trip->passengers }}</td>
                                    <td>{{ $trip->packages }}</td>
                                    <td>--</td>
                                    <td>
                                        <span class="badge badge-success font-size-14">{{ $trip->status->name }}</span>
                                    </td>
                                    <td>{{ $trip->total_price }} &euro;</td>
                                    <td>
                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                            <li class="list-inline-item px-2">
                                                <a href="{{ route('admin.trips.show', [$trip->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-info-circle"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        $(function() {
            $('#datatable').DataTable()
        })
    </script>
@endsection