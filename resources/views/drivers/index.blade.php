@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Водители',
        'items' => [
            [ 'name' => 'Водители', 'link' => null ],
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
                                <i class="mdi mdi-plus mr-1"></i> Добавить водителя
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
                                <th scope="col">Страна проживания</th>
                                <th scope="col">Город</th>
                                <th scope="col">Опыт вождения</th>
                                <th scope="col">Действия</th>
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
                                            <img class="rounded-circle avatar-sm" src="{{ asset('assets/images/users/no-photo.png') }}" alt="{{ $driver->first_name .' '. $driver->last_name }}">
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="{{ route('admin.drivers.show', [ $driver->id ]) }}" class="text-dark">{{ $driver->first_name . ' ' . $driver->last_name }}</a></h5>
                                        <p class="text-muted mb-0">{{ $driver->email }}</p>
                                    </td>
                                    <td>{{ $driver->phone_number }}</td>
                                    <td>{{ $driver->driver_data->country_name }}</td>
                                    <td>{{ $driver->driver_data->city }}</td>
                                    <td>
                                        <span class="badge badge-success font-size-12"><i class="mdi mdi-star mr-1"></i> {{ $driver->driver_data->driving_experience_name }}</span>
                                    </td>
                                    <td>
                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                            <li class="list-inline-item px-2">
                                                <a href="{{ route('admin.drivers.edit', [ $driver->id ]) }}" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="bx bx-pencil"></i></a>
                                            </li>
                                            <li class="list-inline-item px-2">
                                                <a href="{{ route('admin.drivers.show', [ $driver->id ]) }}" data-toggle="tooltip" data-placement="top" title="Просмотреть"><i class="bx bx-user-circle"></i></a>
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
                        {{ $drivers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection