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
                            <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target=".car-model-modal">
                                <i class="mdi mdi-plus mr-1"></i> Добавить модель
                            </a>
                        </div>
                    </div>
                </div>

                @if ($carModels->count() === 0)
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        На данный момент записей о моделях траспорта не найдено.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">Модель</th>
                                    <th scope="col">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carModels as $idx => $model)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td>{{ $model->name }}</td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="#" data-id="{{ $model->id }}" class="edit-btn" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="bx bx-pencil"></i></a>
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
                        {{ $carModels->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('car-models.partials._car-model-modal', [ 'carBrands' => $carBrands ])
@include('car-models.partials._edit-car-model-modal', [ 'carBrands' => $carBrands ])
@endsection


@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            var editModelModal = $('.edit-car-model-modal');
            var editLoading = $('.loading-block');
            var modelId = null;

            $('.edit-btn').click(function(e) {
                e.preventDefault();
                modelId = $(this).data('id');
                // Show the modal
                editModelModal.modal('show');
            });

            editModelModal.on('shown.bs.modal', function() {
                editLoading.css('display', 'flex');

                // Make the AJAX request
                $.ajax({
                    url: '/car-models/getById/' + modelId,
                    type: 'GET',
                    success: function(data) {
                        editModelModal.find('form').attr('action', `/car-models/${modelId}`);
                        editModelModal.find('form').find('input[name=name]').val(data.carModel.name)
                    },
                    error: function(err) {
                        console.log('err', err);
                    }
                }); 
            });
        });
    </script>
@endsection