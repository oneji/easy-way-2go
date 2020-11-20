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
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Общая информация</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Откуда:</th>
                                    <td>{{ $order->country_from->name .', '. $order->from_address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Куда:</th>
                                    <td>{{ $order->country_to->name .', '. $order->to_address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Дата:</th>
                                    <td>{{ \Carbon\Carbon::parse($order->date)->translatedFormat('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Номер телефона покупателя:</th>
                                    <td>{{ $order->buyer_phone_number ?? __('pages.transport.form.labels.no') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email адрес покупателя:</th>
                                    <td>{{ $order->email ?? __('pages.transport.form.labels.no') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Тип заказа:</th>
                                    <td>
                                        @if ($order->order_type === 'passengers')
                                            <span class="badge badge-success">Пассажиры</span>
                                        @elseif($order->order_type === 'packages')
                                            <span class="badge badge-info">Посылки</span>
                                        @else
                                            <span class="badge badge-warning">Переезд</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Клиент:</th>
                                    <td>
                                        <a href="{{ route('admin.clients.show', [$order->client->id]) }}">{{ $order->client->getFullName() }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">К оплате:</th>
                                    <td>{{ $order->total_price }} &euro;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($order->passengers->count() > 0)
            <div class="col-sm-12 col-md-5 col-lg-5">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Пассажиры</h4>
                        <p class="card-title-desc">Пассажиры участвующие в заказе</p>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            @foreach ($order->passengers as $idx => $passenger)
                                <li class="nav-item">
                                    <a class="nav-link {{ $idx === 0 ? 'active' : null }}" data-toggle="tab" href="#passenger-{{ $passenger->id }}" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                                        <span class="d-none d-sm-block">{{ $passenger->first_name .' '. $passenger->last_name }}</span> 
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            @foreach ($order->passengers as $idx => $passenger)
                                <div class="tab-pane {{ $idx === 0 ? 'active' : null }}" id="passenger-{{ $passenger->id }}" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ФИО:</th>
                                                    <td>{{ $passenger->first_name .' '. $passenger->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Пол:</th>
                                                    <td>
                                                        @if ($passenger->gender === 0)
                                                            Мистер
                                                        @elseif($passenger->gender === 1)
                                                            Миссис
                                                        @else
                                                            Не определился
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">День рождения:</th>
                                                    <td>{{ \Carbon\Carbon::parse($passenger->birthday)->translatedFormat('M d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Национальность:</th>
                                                    <td>{{ $passenger->nationality_country->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ID карта:</th>
                                                    <td>{{ $passenger->id_card }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Номер паспорта:</th>
                                                    <td>{{ $passenger->passport_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Срок истечения паспорта:</th>
                                                    <td>{{ \Carbon\Carbon::parse($passenger->passport_expires_at)->translatedFormat('M d, Y') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($order->packages->count() > 0)
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Посылки</h4>
                    <p class="card-title-desc">Посылки включенные в заказ</p>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        @foreach ($order->packages as $idx => $package)
                            <li class="nav-item">
                                <a class="nav-link {{ $idx === 0 ? 'active' : null }}" data-toggle="tab" href="#package-{{ $package->id }}" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-box"></i></span>
                                    <span class="d-none d-sm-block">Посылка {{ $idx + 1 }}</span> 
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        @foreach ($order->packages as $idx => $package)
                            <div class="tab-pane {{ $idx === 0 ? 'active' : null }}" id="package-{{ $package->id }}" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-nowrap mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Вес:</th>
                                                <td>{{ $package->weight }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Длина:</th>
                                                <td>{{ $package->length }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Ширина:</th>
                                                <td>{{ $package->width }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Высота:</th>
                                                <td>{{ $package->height }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection