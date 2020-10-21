@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.carModels.label'),
        'items' => [
            [ 'name' => __('pages.carModels.label'), 'link' => null ],
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
                                <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target=".car-model-modal">
                                    <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($carModels->count() === 0)
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <i class="mdi mdi-information mr-2"></i>
                            {{ __('pages.carModels.emptySet') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 70px;">#</th>
                                        <th scope="col">{{ __('pages.carModels.modelsLabel') }}</th>
                                        <th scope="col">{{ __('pages.carModels.actionsLabel') }}</th>
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
                                                        <a href="#" data-id="{{ $model->id }}" class="edit-btn" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
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

    @include('car-models.modals.create', [ 'carBrands' => $carBrands ])
    @include('car-models.modals.edit', [ 'carBrands' => $carBrands ])
@endsection


@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                
                const editBtn = $(this);
                const editModelModal = $('.edit-car-model-modal');
                const modelId = editBtn.data('id');

                const loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
                const pencilIcon = '<i class="bx bx-pencil"></i>';

                editBtn.html(loadingIcon);

                // Make the AJAX request
                $.ajax({
                    url: '/car-models/getById/' + modelId,
                    type: 'GET',
                    success: function(model) {
                        for (const langCode in model.name) {
                            editModelModal.find('form').find(`input[data-lang=${langCode}]`).val(model.name[langCode]);
                        }

                        editModelModal.find('form').attr('action', `car-models/${modelId}`);

                        // Show the modal
                        editModelModal.modal('show');
                        editBtn.html(pencilIcon);
                    },
                    error: function(err) {
                        console.log('err', err);
                    }
                });
            });
        });
    </script>
@endsection