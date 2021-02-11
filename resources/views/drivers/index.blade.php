@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.drivers.label'),
        'items' => [
            [ 'name' => __('pages.drivers.label'), 'link' => null ],
        ]
    ]
])

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
                <div class="row mb-2">
                    <div class="col-sm-8 offset-sm-4">
                        <div class="text-sm-right">
                            <a href="{{ route('admin.drivers.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">
                                <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                            </a>
                        </div>
                    </div><!-- end col-->
                </div>

                @if ($drivers->count() === 0)
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        {{ __('pages.drivers.emptySet') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">{{ __('pages.drivers.datatable.fullName') }}</th>
                                    <th scope="col">{{ __('pages.drivers.datatable.phoneNumber') }}</th>
                                    <th scope="col">{{ __('pages.drivers.datatable.country') }}</th>
                                    <th scope="col">{{ __('pages.drivers.datatable.city') }}</th>
                                    <th scope="col">{{ __('pages.drivers.datatable.drivingExperience') }}</th>
                                    <th scope="col">{{ __('pages.drivers.datatable.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $driver)
                                    <tr>
                                        <td>
                                            @if ($driver->photo !== null)
                                                <div>
                                                    <img class="rounded-circle avatar-sm" src="{{ asset('storage/'.$driver->photo) }}" alt="Driver avatar">
                                                </div>
                                            @else
                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/no-photo.png') }}" alt="{{ $driver->getFullName() }}">
                                            @endif
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1"><a href="{{ route('admin.drivers.show', [ $driver->id ]) }}" class="text-dark">{{ $driver->getFullName() }}</a></h5>
                                            <p class="text-muted mb-0">{{ $driver->email }}</p>
                                        </td>
                                        <td>{{ $driver->phone_number }}</td>
                                        <td>{{ $driver->country ? $driver->country->name : null }}</td>
                                        <td>{{ $driver->city ?? '--' }}</td>
                                        <td>
                                            <span class="badge badge-success font-size-12"><i class="mdi mdi-star mr-1"></i> {{ $driver->driving_experience->name ?? '--' }}</span>
                                        </td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ route('admin.drivers.edit', [ $driver->id ]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
                                                </li>
                                                {{-- <li class="list-inline-item px-2">
                                                    <a href="{{ route('admin.drivers.show', [ $driver->id ]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-user-circle"></i></a>
                                                </li> --}}
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
                        {{ $drivers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection