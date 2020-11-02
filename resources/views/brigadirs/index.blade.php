@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.brigadirs.label'),
        'items' => [
            [ 'name' => __('pages.brigadirs.label'), 'link' => null ],
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
                            <a href="{{ route('admin.brigadirs.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">
                                <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                            </a>
                        </div>
                    </div><!-- end col-->
                </div>

                @if ($brigadirs->count() === 0)
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        {{ __('pages.brigadirs.emptySet') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">{{ __('pages.brigadirs.datatable.fullName') }}</th>
                                    <th scope="col">{{ __('pages.brigadirs.datatable.phoneNumber') }}</th>
                                    <th scope="col">{{ __('pages.brigadirs.datatable.company') }}</th>
                                    <th scope="col">{{ __('pages.brigadirs.datatable.inn') }}</th>
                                    <th scope="col">{{ __('pages.brigadirs.datatable.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brigadirs as $brigadir)
                                    <tr>
                                        <td>
                                            @if ($brigadir->photo !== null)
                                                <div>
                                                    <img class="rounded-circle avatar-sm" src="{{ asset('storage/'.$brigadir->photo) }}" alt="Driver avatar">
                                                </div>
                                            @else
                                                <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/no-photo.png') }}" alt="{{ $brigadir->first_name .' '. $brigadir->last_name }}">
                                            @endif
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1"><a href="{{ route('admin.brigadirs.show', [ $brigadir->id ]) }}" class="text-dark">{{ $brigadir->first_name . ' ' . $brigadir->last_name }}</a></h5>
                                            <p class="text-muted mb-0">{{ $brigadir->email }}</p>
                                        </td>
                                        <td>{{ $brigadir->phone_number }}</td>
                                        <td>{{ $brigadir->company_name }}</td>
                                        <td>
                                            <span class="badge badge-success font-size-12"><i class="mdi mdi-passport mr-1"></i> {{ $brigadir->inn }}</span>
                                        </td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ route('admin.brigadirs.edit', [ $brigadir->id ]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
                                                </li>
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ route('admin.brigadirs.show', [ $brigadir->id ]) }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-user-circle"></i></a>
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
                        {{ $brigadirs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection