@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.orders.label'),
        'items' => [
            [ 'name' => __('pages.orders.label'), 'link' => null ],
        ]
    ]
])

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">{{ __('pages.orders.infoLabel') }}</div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('pages.orders.from') }}</th>
                                <th>{{ __('pages.orders.to') }}</th>
                                <th>{{ __('pages.orders.date') }}</th>
                                <th>{{ __('pages.orders.client') }}</th>
                                <th>{{ __('pages.orders.passengers') }} &middot; {{ __('pages.orders.packages') }}</th>
                                <th>{{ __('pages.orders.type') }}</th>
                                <th>{{ __('pages.orders.totalPrice') }}</th>
                                <th>{{ __('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->country_from->name .', '. $order->from_address }}</td>
                                    <td>{{ $order->country_to->name .', '. $order->to_address }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->date)->translatedFormat('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.clients.show', [$order->client->id]) }}">{{ $order->client->getFullName() }}</a>
                                    </td>
                                    <td>
                                        <span class="badge badge-success font-size-14">{{ $order->passengers->count() }}</span>
                                        &middot;
                                        <span class="badge badge-success font-size-14">{{ $order->packages->count() }}</span>
                                    </td>
                                    <td>
                                        @if ($order->order_type === 'passengers')
                                            <span class="badge badge-success font-size-14">{{ __('pages.orders.passengers') }}</span>
                                        @elseif($order->order_type === 'packages')
                                            <span class="badge badge-info font-size-14">{{ __('pages.orders.packages') }}</span>
                                        @else
                                            <span class="badge badge-warning font-size-14">{{ __('pages.orders.moving') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->total_price }} &euro;</td>
                                    <td>
                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                            <li class="list-inline-item px-2">
                                                <a href="{{ route('admin.orders.show', [$order->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-info-circle"></i></a>
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