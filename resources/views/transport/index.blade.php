@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Транспорт',
        'items' => [
            [ 'name' => 'Транспорт', 'link' => null ]
        ]
    ]
])

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('admin.transport.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-3 ml-3" style="float: right">
                <i class="bx bx-plus mr-1"></i> Добавить машину
            </a>
            <a href="#" class="btn btn-primary btn-rounded waves-effect waves-light mb-3" style="float: right">
                <i class="bx bx-user-plus mr-1"></i> Привязать водителя
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all mr-2"></i>
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>

        @if ($transport->count() === 0)
            <div class="col-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-information mr-2"></i>
                    На данный момент транспортных средств в базе не найдено.
                </div>
            </div>
        @else
            @foreach ($transport as $car)
                <div class="col-xs-12 col-sm-6 col-md-4 col-xl-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="avatar-sm mx-auto mb-4">
                                <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                    D
                                </span>
                            </div>
                            <h5 class="font-size-15"><a href="#" class="text-dark">{{ $car->car_brand_name .' '. $car->car_model_name }}</a></h5>
                            <p class="text-muted">{{ $car->car_number }}</p>

                            <div>
                                <a href="#" class="badge badge-primary font-size-11 m-1">Photoshop</a>
                                <a href="#" class="badge badge-primary font-size-11 m-1">illustrator</a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top">
                            <div class="contact-links d-flex font-size-20">
                                <div class="flex-fill">
                                    <a href="{{ route('admin.transport.edit', [ $car->id ]) }}" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="bx bx-pencil"></i></a>
                                </div>
                                <div class="flex-fill">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Projects"><i class="bx bx-pie-chart-alt"></i></a>
                                </div>
                                <div class="flex-fill">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Просмотреть"><i class="bx bx-car"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        
    </div>

    <div class="row">
        <div class="col-12">
            {{ $transport->links() }}
        </div>
    </div>
@endsection