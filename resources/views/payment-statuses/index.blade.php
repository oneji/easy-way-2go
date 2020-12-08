@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.paymentStatuses.label'),
        'items' => [
            [ 'name' => __('pages.paymentStatuses.label'), 'link' => null ],
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
                                <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target=".payment-status-modal">
                                    <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($paymentStatuses->count() === 0)
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <i class="mdi mdi-information mr-2"></i>
                            {{ __('pages.paymentStatuses.emptySet') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 70px;">#</th>
                                        <th scope="col">{{ trans_choice('pages.paymentStatuses.statusesLabel', 2) }}</th>
                                        <th scope="col">{{ __('pages.paymentStatuses.actionsLabel') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentStatuses as $idx => $status)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $status->name }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="#" data-id="{{ $status->id }}" class="edit-btn" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
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
                            {{ $paymentStatuses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('payment-statuses.modals.create')
    @include('payment-statuses.modals.edit')
@endsection


@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                const editBtn = $(this);
                const editStatusModal = $('.edit-payment-status-modal');
                const statusId = editBtn.data('id');

                const loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
                const pencilIcon = '<i class="bx bx-pencil"></i>';
                
                editBtn.html(loadingIcon);

                // Make the AJAX request
                $.ajax({
                    url: '/payment-statuses/getById/' + statusId,
                    type: 'GET',
                    success: function(status) {
                        for (const langCode in status.name) {
                            editStatusModal.find('form').find(`input[data-lang=${langCode}]`).val(status.name[langCode]);
                        }

                        editStatusModal.find('form').attr('action', `payment-statuses/${statusId}`);

                        // Show the modal
                        editStatusModal.modal('show');
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