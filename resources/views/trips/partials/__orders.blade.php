<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="form-group mt-3">
            <input 
                type="text"
                class="form-control"
                placeholder="Поиск по № заказа">
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="form-group mt-3">
            <select class="form-control">
                <option value="" selected>Все заказы</option>
                <option value="passengers">Пассажиры</option>
                <option value="packages">Посылки</option>
                <option value="moving">Переезд</option>
            </select>
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="form-group mt-3">
            <select class="form-control">
                <option value="" selected>Любой вид оплаты</option>
                @foreach ($paymentMethods as $method)
                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="table-rep-plugin">
            <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table id="tech-companies-1" class="table table-striped">
                    <thead>
                        <tr>
                            <th data-priority="1">№ Заказа</th>
                            <th data-priority="3">Дата</th>
                            <th data-priority="1">Откуда</th>
                            <th data-priority="3">Куда</th>
                            <th data-priority="3">Пассажиры</th>
                            <th data-priority="6">Посылки</th>
                            <th data-priority="6">Оплата</th>
                            <th data-priority="6">Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="text-center">{{ $order->id }}</td>
                                <td>{{ $order->date }}</td>
                                <td>{{ $order->country_from->name .', '. $order->from_address }}</td>
                                <td>{{ $order->country_to->name .', '. $order->to_address }}</td>
                                <td class="text-center">{{ $order->passengers_count }}</td>
                                <td class="text-center">{{ $order->packages_count }}</td>
                                <td>{{ $order->payment_method->name ?? 'Нет' }}</td>
                                <td>{{ $order->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>