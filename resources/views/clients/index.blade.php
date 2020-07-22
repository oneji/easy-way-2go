@extends('layouts.app')

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
                                <i class="mdi mdi-plus mr-1"></i> Добавить клиента
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
                                <th scope="col">Номер ID карты</th>
                                <th scope="col">Номер паспорта</th>
                                <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>
                                        @if ($client->photo !== null)
                                            <div>
                                                <img class="rounded-circle avatar-xs" src="{{ asset('storage/'.$client->photo) }}" alt="Driver avatar">
                                            </div>
                                        @else
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle">
                                                    D
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{ $client->first_name . ' ' . $client->last_name }}</a></h5>
                                        <p class="text-muted mb-0">{{ $client->email }}</p>
                                    </td>
                                    <td>{{ $client->phone_number }}</td>
                                    <td>{{ $client->client_data->id_card }}</td>
                                    <td>
                                        <span class="badge badge-success font-size-12"><i class="mdi mdi-passport mr-1"></i> {{ $client->client_data->passport_number }}</span>
                                    </td>
                                    <td>
                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                            <li class="list-inline-item px-2">
                                                <a href="{{ route('admin.clients.edit', [ $client->id ]) }}" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="bx bx-pencil"></i></a>
                                            </li>
                                            <li class="list-inline-item px-2">
                                                <a href="#" data-toggle="tooltip" data-placement="top" title="Просмотреть" class="view-user-btn"><i class="bx bx-user-circle"></i></a>
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
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.view-user-btn').click(function(e) {
                e.preventDefault();

                console.log('...')
            });
        });
    </script>
@endsection