@extends('layouts.app')

@section('content')
    <div class="row">
        @if ($baRequest->type === 'firm_owner')
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Общая информация</h4>
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
        @else
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Водители и транспорт</h4>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="accordion" class="mb-4">
                                    @foreach ($baRequest->drivers as $idx => $driver)
                                        <div class="card mb-1 shadow-none">
                                            <div class="card-header" id="headingTwo">
                                                <h6 class="m-0">
                                                    <a 
                                                        href="#driversCollapse-{{ $driver->id }}"
                                                        class="text-dark {{ $idx !== 'collapsed' }}"
                                                        data-toggle="collapse"
                                                        aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                                        aria-controls="driversCollapse-{{ $driver->id }}">
                                                        {{ $driver->getFullName() }}
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="driversCollapse-{{ $driver->id }}" class="collapse {{ $idx === 0 ? 'show' : null }}" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-nowrap mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">{{ __('pages.bas.mainDriver.birthday') }}:</th>
                                                                    <td>{{ $driver->birthday }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">{{ __('pages.bas.mainDriver.nationality') }}:</th>
                                                                    <td>{{ $driver->nationality }}</td>
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
                                                                    <td>{{ $driver->dl_issue_place }}</td>
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
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="card mb-0 shadow-none">
                                        <div class="card-header" id="headingThree">
                                            <h6 class="m-0">
                                                <a
                                                    href="#collapseThree" class="text-dark collapsed" data-toggle="collapse"
                                                    aria-expanded="false"
                                                    aria-controls="collapseThree">
                                                    Транспорт
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life
                                                accusamus terry richardson ad squid. 3 wolf moon officia
                                                aute, non cupidatat skateboard dolor brunch. Food truck
                                                quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                                sunt aliqua put a bird on it squid single-origin coffee
                                                nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                helvetica, craft beer labore wes anderson cred nesciunt
                                                sapiente ea proident. Ad vegan excepteur butcher vice lomo.
                                                Leggings occaecat craft beer farm-to-table, raw denim
                                                aesthetic synth nesciunt you probably haven't heard of them
                                                accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
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

                            <div class="col-sm-6">
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
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/ru.js') }}"></script>
    <script>
        $(function() {
            $('#generateRandomPassBtn').on('click', function() {
                let randomPassword = Math.random().toString(36).slice(-8);
                
                $('#approveBaRequestForm').find('input[name=password]').val(randomPassword)
                $('#approveBaRequestForm').find('input[name=password_confirmation]').val(randomPassword)
            });
        })
    </script>
@endsection