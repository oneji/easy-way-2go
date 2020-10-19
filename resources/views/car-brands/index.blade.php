@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.carBrands.label'),
        'items' => [
            [ 'name' => __('pages.carBrands.label'), 'link' => null ],
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
                                <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target=".car-brand-modal">
                                    <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($carBrands->count() === 0)
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <i class="mdi mdi-information mr-2"></i>
                            {{ __('pages.carBrands.emptySet') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 70px;">#</th>
                                        <th scope="col">{{ trans_choice('pages.carBrands.brandsLabel', 2) }}</th>
                                        <th scope="col">{{ __('pages.carBrands.actionsLabel') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carBrands as $idx => $brand)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="#" data-id="{{ $brand->id }}" class="edit-btn" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
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
                            {{ $carBrands->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('car-brands.partials._car-brand-modal')
    @include('car-brands.partials._edit-car-brand-modal')
@endsection


@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            var editBrandModal = $('.edit-car-brand-modal');
            var editLoading = $('.loading-block');
            var brandId = null;

            $('.edit-btn').click(function(e) {
                e.preventDefault();
                brandId = $(this).data('id');
                // Show the modal
                editBrandModal.modal('show');
            });

            editBrandModal.on('shown.bs.modal', function() {
                editLoading.css('display', 'flex');

                // Make the AJAX request
                $.ajax({
                    url: '/car-brands/getById/' + brandId,
                    type: 'GET',
                    success: function(data) {
                        editBrandModal.find('form').attr('action', `/car-brands/${brandId}`);
                        editBrandModal.find('form').find('input[name=name]').val(data.carBrand.name)
                    },
                    error: function(err) {
                        console.log('err', err);
                    }
                }); 
            });
        });
    </script>
@endsection