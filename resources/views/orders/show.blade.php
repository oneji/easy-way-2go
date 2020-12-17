@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Заказы',
        'items' => [
            [ 'name' => 'Заказы', 'link' => route('admin.orders.index') ],
            [ 'name' => 'Заказ #' . $order->id, 'link' => null ],
        ]
    ]
])

@section('content')
    {{-- <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{ __('common.generalInfo') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">{{ __('pages.orders.type') }}:</th>
                                    <td>
                                        @if ($order->order_type === 'passengers')
                                            <span class="badge badge-success">{{ __('pages.orders.passengers') }}</span>
                                        @elseif($order->order_type === 'packages')
                                            <span class="badge badge-info">{{ __('pages.orders.packages') }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ __('pages.orders.moving') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Клиент:</th>
                                    <td>
                                        <a href="{{ route('admin.clients.show', [$order->client->id]) }}">{{ $order->client->getFullName() }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="mb-0">
                            <img src="{{ asset('assets/images/logo-black.svg') }}" alt="logo" height="30"/>
                        </div>
                        <h4 class="font-size-16 mb-0">Заказ #{{ $order->id }}</h4>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>{{ __('pages.orders.from') }}:</strong><br>
                                {{ $order->country_from->name .', '. $order->from_address }}
                            </address>
                            <address>
                                <strong>{{ __('pages.orders.to') }}:</strong><br>
                                {{ $order->country_to->name .', '. $order->to_address }}
                            </address>
                            <address>
                                <strong>{{ __('pages.orders.date') }}:</strong><br>
                                {{ \Carbon\Carbon::parse($order->date)->translatedFormat('M d, Y') }}
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <address>
                                <strong>{{ __('pages.orders.buyerPhoneNumber') }}:</strong> {{ $order->buyer_phone_number }}<br>
                                <strong>{{ __('pages.orders.buyerEmail') }}:</strong> {{ $order->buyer_email }}
                            </address>
                        </div>
                    </div>
                    @if ($order->passengers->count() > 0)
                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 font-weight-bold">{{ __('pages.orders.passengers') }}</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>ФИО</th>
                                        <th>Пол</th>
                                        <th>День рождения</th>
                                        <th>Национальность</th>
                                        <th>ID карта</th>
                                        <th>Номер паспорта</th>
                                        <th>Срок истечения паспорта</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->passengers as $idx => $passenger)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $passenger->first_name .' '. $passenger->last_name }}</td>
                                            <td>
                                                @if ($passenger->gender === 0)
                                                    Мистер
                                                @elseif($passenger->gender === 1)
                                                    Миссис
                                                @else
                                                    Не определился
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($passenger->birthday)->translatedFormat('M d, Y') }}</td>
                                            <td>{{ $passenger->nationality_country->name }}</td>
                                            <td>{{ $passenger->id_card }}</td>
                                            <td>{{ $passenger->passport_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($passenger->passport_expires_at)->translatedFormat('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($order->packages->count() > 0)
                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 font-weight-bold">{{ __('pages.orders.packages') }}</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th style="width: 70px;">Вес</th>
                                        <th style="width: 70px;">Длина</th>
                                        <th style="width: 70px;">Ширина</th>
                                        <th style="width: 70px;">Высота</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->packages as $idx => $package)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $package->weight }}</td>
                                            <td>{{ $package->length }}</td>
                                            <td>{{ $package->width }}</td>
                                            <td>{{ $package->height }}</td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan="4" class="border-0 text-right">
                                                <strong>{{ __('pages.orders.totalPrice') }}</strong></td>
                                            <td class="border-0 text-right"><h4 class="m-0">{{ $order->total_price }}&euro;</h4></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
                    <div class="d-print-none">
                        <div class="float-right">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection