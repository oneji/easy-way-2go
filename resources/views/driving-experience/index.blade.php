@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Водительский опыт',
        'items' => [
            [ 'name' => 'Водительский опыт', 'link' => null ],
        ]
    ]
]);

@section('content')
    <div class="row">
        <div class="col-12">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all mr-2"></i>
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">    
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">ФИО</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deList as $idx => $item)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Добавить водительский опыт</h4>
                    <p class="card-title-desc"></p>

                    <form action="{{ route('admin.de.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float: right">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

@endsection