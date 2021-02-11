@extends('layouts.app')

@section('content')
    @if ($baRequest->status !== 'pending')
        <div class="alert alert-{{ $baRequest->status === 'approved' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all mr-2"></i>
            Business account request has been {{ $baRequest->status }}.
        </div>
    @endif

    <div class="row">
        @if ($baRequest->type === 'firm_owner')
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">{{ __('common.generalInfo') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ __('pages.bas.firmOwner.companyName') }}:</th>
                                        <td>{{ $baRequest->data->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('pages.bas.firmOwner.name') }}:</th>
                                        <td>{{ $baRequest->data->first_name }} {{ $baRequest->data->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('pages.bas.firmOwner.email') }}:</th>
                                        <td>{{ $baRequest->data->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('pages.bas.firmOwner.phoneNumber') }}:</th>
                                        <td>{{ $baRequest->data->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('pages.bas.firmOwner.nationality') }}:</th>
                                        <td>{{ $baRequest->data->nationality }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('pages.bas.firmOwner.country') }}:</th>
                                        <td>{{ $baRequest->data->country->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('pages.bas.firmOwner.inn') }}:</th>
                                        <td>{{ $baRequest->data->inn }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if ($baRequest->status === 'pending')
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{ __('pages.bas.userInfo') }}</h4>
                            <form action="{{ route('admin.bas.approve', [$baRequest->id]) }}" method="POST" class="form-horizontal custom-validation" novalidate id="approveForm">
                                @csrf
            
                                <div class="form-group">
                                    <label for="email">{{ __('pages.bas.firmOwner.email') }}</label>
                                    <input type="email" name="email" placeholder="{{ __('pages.bas.firmOwner.email') }}" value="{{ $baRequest->data->email }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('pages.bas.firmOwner.password') }}</label>
                                    <input type="text" name="password" placeholder="{{ __('pages.bas.firmOwner.password') }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('pages.bas.firmOwner.passwordConfirmation') }}</label>
                                    <input type="text" name="password" placeholder="{{ __('pages.bas.firmOwner.passwordConfirmation') }}" class="form-control" required>
                                </div>
                            </form>
                            
                            <div class="form-group">
                                <button type="button" class="btn btn-info waves-effect waves-light" id="generateRandomPassBtn">
                                    <i class="bx bxs-keyboard font-size-16 align-middle mr-2"></i> {{ __('pages.bas.generateRandomPassBtn') }}
                                </button>
                                <a href="#"
                                    class="btn btn-success waves-effect waves-light" 
                                    id="approveBtn"
                                    {{-- onclick="event.preventDefault(); document.getElementById('approveForm').submit();" --}}
                                >
                                    <i class="bx bx-check-double font-size-16 align-middle mr-2"></i> {{ __('pages.bas.approveBtn') }}
                                </a>

                                <a 
                                    href="#"
                                    class="btn btn-danger waves-effect waves-light" 
                                    onclick="event.preventDefault(); document.getElementById('declineForm').submit();"
                                >
                                    <i class="bx bx-check-double font-size-16 align-middle mr-2"></i> {{ __('pages.bas.declineBtn') }}
                                </a>

                                <form action="{{ route('admin.bas.decline', [$baRequest->id]) }}" method="POST" id="declineForm">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">{{ __('pages.bas.driversAndTransport') }}</h4>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($baRequest->drivers as $idx => $driver) 
                                        <a
                                            class="nav-link mb-2 {{ $idx === 0 ? 'active' : null }}"
                                            id="driver-{{ $driver->id }}-tab"
                                            data-toggle="pill"
                                            href="#driver-{{ $driver->id }}"
                                            role="tab"
                                            aria-controls="driver-{{ $driver->id }}"
                                            aria-selected="{{ $idx === 0 ? 'true' : 'false' }}">
                                            {{ $driver->first_name .' '. $driver->last_name }}
                                        </a>
                                    @endforeach
                                    @if ($baRequest->transport)
                                        <a
                                            class="nav-link mb-2"
                                            id="transport-tab"
                                            data-toggle="pill"
                                            href="#transport-pill"
                                            role="tab"
                                            aria-controls="transport-pill"
                                            aria-selected="false">
                                            {{ __('pages.transport.label') }}
                                        </a>
                                    @endif

                                    @if ($baRequest->status === 'pending')
                                        <div class="form-group">
                                            <a
                                                href="#"
                                                class="btn btn-success btn-block waves-effect waves-light"
                                                onclick="event.preventDefault(); document.getElementById('approveForm').submit();"
                                            >
                                                <i class="bx bx-check-double font-size-16 align-middle mr-2"></i> {{ __('pages.bas.approveBtn') }}
                                            </a>
                                            
                                            <form action="{{ route('admin.bas.approve', [$baRequest->id]) }}" method="POST" id="approveForm">
                                                @csrf
                                            </form>
                                        </div>

                                        <div class="form-group">
                                            <a 
                                                href="#"
                                                class="btn btn-danger btn-block waves-effect waves-light"
                                                onclick="event.preventDefault(); document.getElementById('declineForm').submit();"
                                            >
                                                <i class="bx bx-x font-size-16 align-middle mr-2"></i> {{ __('pages.bas.declineBtn') }}
                                            </a>

                                            <form action="{{ route('admin.bas.decline', [$baRequest->id]) }}" method="POST" id="declineForm">
                                                @csrf
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                    @foreach ($baRequest->drivers as $idx => $driver)
                                        <div class="tab-pane fade {{ $idx === 0 ? 'show active' : null }}" id="driver-{{ $driver->id }}" role="tabpanel" aria-labelledby="driver-{{ $driver->id }}-tab">
                                            <div class="table-responsive">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.birthday') }}:</th>
                                                            <td>{{ $driver->birthday }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.nationality') }}:</th>
                                                            <td>{{ $driver->nationality_country->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.phoneNumber') }}:</th>
                                                            <td>{{ $driver->phone_number }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.email') }}:</th>
                                                            <td>{{ $driver->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.country') }}:</th>
                                                            <td>{{ $driver->country->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.dlIssuePlace') }}:</th>
                                                            <td>{{ $driver->driver_license_issue_place->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.dlIssuedAt') }}:</th>
                                                            <td>{{ $driver->dl_issued_at }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.dlExpiresAt') }}:</th>
                                                            <td>{{ $driver->dl_expires_at }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.drivingExperience') }}:</th>
                                                            <td>{{ $driver->driving_experience->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.conviction') }}:</th>
                                                            <td>{{ $driver->conviction ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.comment') }}:</th>
                                                            <td>{{ $driver->comment ?? __('pages.transport.form.labels.yes') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.wasKeptDrunk') }}:</th>
                                                            <td>{{ $driver->was_kept_drunk ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.grades') }}:</th>
                                                            <td>{{ $driver->grades }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.gradesExpireAt') }}:</th>
                                                            <td>{{ $driver->grades_expire_at }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.bas.mainDriver.dtp') }}:</th>
                                                            <td>{{ $driver->dtp ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($baRequest->transport)
                                        <div class="tab-pane fade" id="transport-pill" role="tabpanel" aria-labelledby="transport-tab">
                                            <div class="table-responsive">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.transportRegistered') }}:</th>
                                                            <td>{{ $baRequest->transport->registered_on ? __('pages.transport.form.labels.individual') : __('pages.transport.form.labels.company') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.country') }}:</th>
                                                            <td>{{ $baRequest->transport->register->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.city') }}:</th>
                                                            <td>{{ $baRequest->transport->register_city }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.carNumber') }}:</th>
                                                            <td>{{ $baRequest->transport->car_number }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.brand') }}:</th>
                                                            <td>{{ $baRequest->transport->brand->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.model') }}:</th>
                                                            <td>{{ $baRequest->transport->model->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.year') }}:</th>
                                                            <td>{{ $baRequest->transport->year }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.inspectionFrom') }}:</th>
                                                            <td>{{ $baRequest->transport->teh_osmotr_date_from }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.inspectionTo') }}:</th>
                                                            <td>{{ $baRequest->transport->teh_osmotr_date_to }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.insuranceFrom') }}:</th>
                                                            <td>{{ $baRequest->transport->insurance_date_from }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.insuranceTo') }}:</th>
                                                            <td>{{ $baRequest->transport->insurance_date_to }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.hasCmr') }}:</th>
                                                            <td>{{ $baRequest->transport->has_cmr ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.passengerSeats') }}:</th>
                                                            <td>{{ $baRequest->transport->passengers_seats }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.cuboMetres') }}:</th>
                                                            <td>{{ $baRequest->transport->cubo_metres_available }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.kilos') }}:</th>
                                                            <td>{{ $baRequest->transport->kilos_available }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.okForMove') }}:</th>
                                                            <td>{{ $baRequest->transport->ok_for_move ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.canPullTrailer') }}:</th>
                                                            <td>{{ $baRequest->transport->can_pull_trailer ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.hasTrailer') }}:</th>
                                                            <td>{{ $baRequest->transport->has_trailer ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.palletTransportation') }}:</th>
                                                            <td>{{ $baRequest->transport->pallet_transportation ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.conditioner') }}:</th>
                                                            <td>{{ $baRequest->transport->conditioner ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.wifi') }}:</th>
                                                            <td>{{ $baRequest->transport->wifi ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.tvVideo') }}:</th>
                                                            <td>{{ $baRequest->transport->tv_video ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('pages.transport.form.labels.disabledPeopleSeats') }}:</th>
                                                            <td>{{ $baRequest->transport->disabled_people_seats ? __('pages.transport.form.labels.yes') : __('pages.transport.form.labels.no') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        $(function() {
            $('#generateRandomPassBtn').on('click', function() {
                let randomPassword = Math.random().toString(36).slice(-8);
                
                $('#approveForm').find('input[name=password]').val(randomPassword)
                $('#approveForm').find('input[name=password_confirmation]').val(randomPassword)
            });

            $('#approveBtn').on('click', function() {
                console.log('...')
                let approveBtn = $(this);
                let approveForm = $('#approveForm');
                
                if(approveForm.parsley().validate()) {
                    approveForm.submit();
                }
            });
        })
    </script>
@endsection