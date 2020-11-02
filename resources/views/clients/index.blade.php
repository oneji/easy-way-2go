@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.clients.label'),
        'items' => [
            [ 'name' => __('pages.clients.label'), 'link' => null ],
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
                            <a href="{{ route('admin.clients.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">
                                <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                            </a>
                        </div>
                    </div><!-- end col-->
                </div>

                @if ($clients->count() === 0)
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        {{ __('pages.clients.emptySet') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">{{ __('pages.clients.datatable.fullName') }}</th>
                                    <th scope="col">{{ __('pages.clients.datatable.phoneNumber') }}</th>
                                    <th scope="col">{{ __('pages.clients.datatable.idCard') }}</th>
                                    <th scope="col">{{ __('pages.clients.datatable.passport') }}</th>
                                    <th scope="col">{{ __('pages.clients.datatable.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>
                                            @if ($client->photo !== null)
                                                <div>
                                                    <img class="rounded-circle avatar-sm" src="{{ asset('storage/'.$client->photo) }}" alt="Driver avatar">
                                                </div>
                                            @else
                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/no-photo.png') }}" alt="{{ $client->first_name .' '. $client->last_name }}">
                                            @endif
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1"><a href="{{ route('admin.clients.show', [ $client->id ]) }}" class="text-dark">{{ $client->first_name . ' ' . $client->last_name }}</a></h5>
                                            <p class="text-muted mb-0">{{ $client->email }}</p>
                                        </td>
                                        <td>{{ $client->phone_number }}</td>
                                        <td>{{ $client->id_card }}</td>
                                        <td>
                                            <span class="badge badge-success font-size-12"><i class="mdi mdi-passport mr-1"></i> {{ $client->passport_number }}</span>
                                        </td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ route('admin.clients.edit', [ $client->id ]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
                                                </li>
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ route('admin.clients.show', [ $client->id ]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-user-circle"></i></a>
                                                </li>
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
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection