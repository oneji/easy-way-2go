@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Бригадиры',
        'items' => [
            [ 'name' => 'Бригадиры', 'link' => null ],
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
                                <i class="mdi mdi-plus mr-1"></i> Добавить бригадира
                            </a>
                        </div>
                    </div><!-- end col-->
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 70px;">#</th>
                                <th scope="col">ФИО</th>
                                <th scope="col">Номер телефона</th>
                                <th scope="col">Фирма</th>
                                <th scope="col">ИНН или ID</th>
                                <th scope="col">Действия</th>
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
                                    <td>{{ $brigadir->brigadir_data->company_name }}</td>
                                    <td>
                                        <span class="badge badge-success font-size-12"><i class="mdi mdi-passport mr-1"></i> {{ $brigadir->brigadir_data->inn }}</span>
                                    </td>
                                    <td>
                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                            <li class="list-inline-item px-2">
                                                <a href="{{ route('admin.brigadirs.edit', [ $brigadir->id ]) }}" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="bx bx-pencil"></i></a>
                                            </li>
                                            <li class="list-inline-item px-2">
                                                <a href="{{ route('admin.brigadirs.show', [ $brigadir->id ]) }}" data-toggle="tooltip" data-placement="top" title="Просмотреть"><i class="bx bx-user-circle"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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