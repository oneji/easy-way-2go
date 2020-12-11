@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.prices.label'),
        'items' => [
            [ 'name' => __('pages.prices.label'), 'link' => null ],
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
                                <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target=".prices-modal">
                                    <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($prices->count() === 0)
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <i class="mdi mdi-information mr-2"></i>
                            {{ __('pages.prices.emptySet') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 70px;">#</th>
                                        <th scope="col">{{ __('pages.prices.label') }}</th>
                                        <th scope="col">{{ __('pages.prices.unitLabel') }}</th>
                                        <th scope="col">{{ __('pages.prices.priceLabel') }}, &euro;</th>
                                        <th scope="col">{{ __('pages.prices.codeLabel') }}</th>
                                        <th scope="col">{{ __('pages.prices.actionsLabel') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prices as $idx => $price)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $price->name }}</td>
                                            <td>
                                                <span class="badge badge-success font-size-14">{{ $price->unit }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success font-size-14">{{ $price->price }}</span>
                                            </td>
                                            <td>{{ $price->code }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="#" data-id="{{ $price->id }}" class="edit-btn" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
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
                            {{ $prices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('prices.modals.create')
    @include('prices.modals.edit')
@endsection


@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                const editBtn = $(this);
                const editPriceModal = $('.edit-price-modal');
                const priceId = editBtn.data('id');

                const loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
                const pencilIcon = '<i class="bx bx-pencil"></i>';
                
                editBtn.html(loadingIcon);

                // Make the AJAX request
                $.ajax({
                    url: '/prices/getById/' + priceId,
                    type: 'GET',
                    success: function(price) {
                        for (const langCode in price.name) {
                            editPriceModal.find('form').find(`input[data-lang=${langCode}]`).val(price.name[langCode]);
                        }

                        editPriceModal.find('form').find('input[name=code]').val(price.code);
                        editPriceModal.find('form').find('input[name=unit]').val(price.unit);
                        editPriceModal.find('form').find('input[name=price]').val(price.price);

                        editPriceModal.find('form').attr('action', `prices/${priceId}`);

                        // Show the modal
                        editPriceModal.modal('show');
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