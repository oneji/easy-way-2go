@extends('layouts.app')

@section('head')
    @parent 
    
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAPS_API_KEY') }}&libraries=&v=weekly" defer></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('pages.routes.routeAddresses') }}</h4>
                    @if ($transports->count() > 0)
                        <div class="form-group">
                            <label for="transport_id">{{ __('pages.routes.transport') }}</label>
                            <select name="transport_id" id="transportId" class="form-control">
                                @foreach ($transports as $transport)
                                    <option value="{{ $transport->id }}">
                                        {{ $transport->car_number }} &middot; {{ $transport->car_brand->name . ' ' . $transport->car_model->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-block waves-effect waves-light" id="saveRouteBtn">{{ __('form.buttons.save') }}</button>
                        </div>
                    @else
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-information mr-2"></i>
                            {{ __('pages.transport.bindDriverModal.firstAddTransportLabel') }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#forward" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">{{ __('pages.routes.from') }}</span>    
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#back" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">{{ __('pages.routes.to') }}</span>    
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#calendar" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">{{ __('pages.routes.calendar') }}</span>    
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="forward" role="tabpanel">
                            <ul class="verti-timeline list-unstyled" id="addresses-forward"></ul>
                        </div>
                        <div class="tab-pane" id="back" role="tabpanel">
                            <ul class="verti-timeline list-unstyled" id="addresses-back"></ul>
                        </div>
                        <div class="tab-pane" id="calendar" role="tabpanel"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
            <div id="map"></div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <form id="addAddressForm" class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label">{{ __('common.country') }}</label>
                                    <select class="form-control select2" name="country" required>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="form-group">
                                    <label for="address">{{ __('pages.routes.address') }}</label>
                                    {{-- <input type="text" class="form-control" required name="address" placeholder="{{ __('pages.routes.address') }}"> --}}
                                    <select class="form-control select2-ajax" name="address" required></select>
                                    <div class="invalid-feedback">
                                        * Обязательное поле.
                                    </div>
                                </div>
            
                                <div class="form-group">
                                    <label for="departure_date">{{ __('pages.routes.departureDate') }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" required name="departure_date" placeholder="{{ __('common.chooseDate') }}" data-position="bottom" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="departure_time">{{ __('pages.routes.departureTime') }}</label>
                                    <input type="time" class="form-control" name="departure_time" placeholder="Введите время" value="00:00" required>
                                </div>

                                <div class="form-group">
                                    <label for="arrival_date">{{ __('pages.routes.arrivalDate') }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" required name="arrival_date" placeholder="{{ __('common.chooseDate') }}" data-position="bottom" data-provide="datepicker" data-date-autoclose="true">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="arrival_time">{{ __('pages.routes.arrivalTime') }}</label>
                                    <input type="time" class="form-control" required name="arrival_time" value="00:00" placeholder="Введите время">
                                </div>

                                <div class="form-group">
                                    <label for="type">{{ __('pages.routes.type') }}</label>
                                    <select class="form-control" name="type" required>
                                        <option value="forward">{{ __('pages.routes.from') }}</option>
                                        <option value="back">{{ __('pages.routes.to') }}</option>
                                    </select>
                                </div>
                                
                                @if ($transports->count() > 0)
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-success btn-block waves-effect waves-light" id="addAddressBtn">{{ __('form.buttons.add') }}</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2();
            let appLocale = $('html').attr('lang');
            let addresses = [];
            let idx = 0;

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: { lat: 56.879635, lng: 24.603189 },
            });
            directionsRenderer.setMap(map);

            $('#addAddressForm').on('submit', function(e) {
                e.preventDefault();

                let addAddressForm = $(this);
                let lastAddress = null;
                let order = 0;
                
                if(addresses.length !== 0) {
                    for (let i = addresses.length - 1; i >= 0; i--) {
                        const address = addresses[i];
                        
                        if(address.type === addAddressForm.find('select[name=type]').val()) {
                            lastAddress = address;
                            break;
                        }
                    }

                    console.log('lastAddress', lastAddress);

                    if(lastAddress !== null && lastAddress !== undefined) {
                        order = lastAddress.order + 1;
                    }
                }

                let data = {
                    idx,
                    country_id: addAddressForm.find('select[name=country]').val(),
                    country: addAddressForm.find('select[name=country]').find('option:selected').text(),
                    address: addAddressForm.find('select[name=address]').val(),
                    departure_date: addAddressForm.find('input[name=departure_date]').val(), 
                    departure_time: addAddressForm.find('input[name=departure_time]').val(),
                    arrival_date: addAddressForm.find('input[name=arrival_date]').val(),
                    arrival_time: addAddressForm.find('input[name=arrival_time]').val(),
                    type: addAddressForm.find('select[name=type]').val(),
                    order: order
                }

                console.log('order', data.order);
                
                if(addresses.length === 0) {
                    $(`#addresses-${data.type}`).html('');
                }

                $(`#addresses-${data.type}`).append(`
                    <li class="event-list pb-2" data-id="${idx}" data-type="${data.type}">
                        <div class="event-timeline-dot">
                            <i class="bx bx-right-arrow-circle"></i>
                        </div>
                        <div class="media">
                            <div class="mr-3">
                                <i class="bx bx-map-alt h2 text-primary"></i>
                            </div>
                            <div class="media-body">
                                <div>
                                    <h5 class="font-size-14">${data.country}, ${data.address}</h5>
                                    <p class="text-muted mb-0">Отправление: ${data.departure_date} - ${data.departure_time}</p>
                                    <p class="text-muted">Прибытие: ${data.arrival_date} - ${data.arrival_time}</p>
                                    <a href="#" data-id="${idx}" data-type="${data.type}" class="delete-address-btn">Удалить</a>
                                </div>
                            </div>
                        </div>
                    </li>
                `);

                $('.nav-tabs a[href="#' + data.type + '"]').tab('show');

                addresses.push(data);
                idx++;

                calculateAndDisplayRoute(directionsService, directionsRenderer);
            });

            $(document).on('click', '.delete-address-btn', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let type = $(this).data('type');

                $(`div#${type}`).find(`li[data-id=${id}]`).remove();

                addresses = addresses.filter(address => address.idx !== id);
                idx--;

                calculateAndDisplayRoute(directionsService, directionsRenderer);
            })

            function calculateAndDisplayRoute(directionsService, directionsRenderer) {
                const waypts = [];

                if(addresses.length > 0) {
                    addresses.map(address => {
                        waypts.push({
                            location: address.address,
                            stopover: true,
                        });
                    });
        
                    directionsService.route(
                        {
                            origin: addresses[0].address,
                            destination: addresses[addresses.length - 1].address,
                            waypoints: waypts,
                            optimizeWaypoints: false,
                            travelMode: google.maps.TravelMode.DRIVING,
                        },
                        (response, status) => {
                            if (status === "OK") {
                                directionsRenderer.setDirections(response);
                                const route = response.routes[0];
                            } else {
                                window.alert("Directions request failed due to " + status);
                            }
                        }
                    );
                }
            }

            $('#saveRouteBtn').on('click', function() {
                let saveBtn = $(this);
                let loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';

                
                if(addresses.length > 0) {
                    saveBtn.html(loadingIcon);
                    $.ajax({
                        method: 'POST',
                        url: '/api/routes',
                        data: {
                            'addresses': addresses,
                            'transport_id': $('#transportId').val(),
                            'repeats': [
                                {
                                    'from': '01/01/2021',
                                    'to': '02/01/2021'
                                }
                            ]
                        },
                        success: function(data) {
                            saveBtn.html('Сохранить')
                            Swal.fire({
                                title: 'Успешно!',
                                text: 'Маршрут успешно добавлен!',
                                type: 'success',
                                showCancelButton: 0,
                                confirmButtonColor: '#556ee6',
                            });

                            $('#addresses-forward').html('');
                            $('#addresses-back').html('');
                            $('#addAddressForm').trigger('reset');
                            addresses = [];
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Внимание!',
                        text: 'Перед сохранением добавьте хотя бы один адрес!',
                        type: 'info',
                        showCancelButton: 0,
                        confirmButtonColor: '#556ee6',
                    });
                }

            });
        });
    </script>

    <script>
        $(function() {
            $('.select2-ajax').select2({
                ajax: {
                    url: 'https://maps.googleapis.com/maps/api/place/autocomplete/json',
                    dataType: 'json',
                    delay: 1000,
                    data: function (params) {
                        return {
                            // ?input=%D1%84%D0%B5%D0%B4%D0%B8%D0%BD%D0%B0%2011/9&key=AIzaSyCHPS6mXbStkOthoiF6lAzAYTuHwBLSs7M&sessiontoken=1234567890
                            input: params.term,
                            key: 'AIzaSyCHPS6mXbStkOthoiF6lAzAYTuHwBLSs7M',
                            sessiontoken: '1234567890'
                        }
                    },
                    processResults: function (data) {
                        console.log(data);
                        var select2Data = $.map(data.predictions, function (obj) {
                            obj.id = obj.place_id;
                            obj.text = obj.description;

                            return obj;
                        });
                        
                        return {
                            results: select2Data
                        };
                    },
                    cache: false
                },
                placeholder: "Введите адрес для поиска",
                minimumInputLength: 3,
                templateResult: function (e) {
                    if (e.loading) return e.description;
                    return e.description;
                }
            })
        })
    </script>
@endsection