<div class="modal fade bind-driver-modal" tabindex="-1" role="dialog" aria-labelledby="bindDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Привязать водителя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.transport.bindDriver') }}" method="POST" class="form-horizontal custom-validation" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="transport_id">Транспортное средство</label>
                                @if ($transport->count() === 0)
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-check-all mr-2"></i>
                                    Сначала добавьте транспортное средство.
                                    </div>
                                @else
                                    <select name="transport_id" class="form-control" required>
                                        <option value="" selected disabled>Выберите авто</option>
                                        @foreach ($transport as $car)
                                            <option value="{{ $car->id }}">
                                                {{ $car->car_brand_name .' '. $car->car_model_name }} &middot; {{ $car->car_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="driver_id">Водители</label>
                                @if ($drivers->count() === 0)
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-check-all mr-2"></i>
                                        Сначала добавьте водителя.
                                    </div>
                                @else
                                    <select name="driver_id" class="form-control" required>
                                        <option value="" selected disabled>Выберите водителя</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->first_name .' '. $driver->last_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        @if ($drivers->count() > 0 && $transport->count() > 0)
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block waves-effect waves-light">Привязать</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>