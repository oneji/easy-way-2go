@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2 float-right" data-toggle="modal" data-target=".payment-method-modal">
                <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
            </a>
        </div>
    </div>

    <div class="row">
        @if ($data->count() > 0)
            @foreach ($data as $item)
                <div class="col-xs-12 col-sm-6 col-md-4 col-xl-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="avatar-sm mx-auto mb-2">
                                <span class="avatar-title rounded-circle bg-white text-primary font-size-16">
                                    <img src="{{ asset('storage/'.$item->icon) }}" alt="">
                                </span>
                            </div>
                            <h5 class="font-size-15 mb-0">{{ $item->name }}</h5>
                        </div>
                        <div class="card-footer bg-transparent border-top">
                            <div class="contact-links d-flex font-size-20">
                                <div class="flex-fill">
                                    <a href="#" class="edit-btn" data-id="{{ $item->id }}"><i class="bx bx-pencil"></i></a>
                                </div>
                                <div class="flex-fill">
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('deleteMethodForm{{ $item->id }}').submit();"><i class="bx bx-trash" style="color: red"></i></a>
                                </div>

                                <form action="{{ route('admin.paymentMethods.delete', [$item->id]) }}" method="POST" id="deleteMethodForm{{ $item->id }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-information mr-2"></i>
                    {{ __('pages.paymentMethods.emptySet') }}
                </div>
            </div>
        @endif
    </div>

    @include('payment-methods.modals.create')
    @include('payment-methods.modals.edit')
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                const editBtn = $(this);
                const editMethodModal = $('.edit-payment-method-modal');
                const methodId = editBtn.data('id');

                const loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
                const pencilIcon = '<i class="bx bx-pencil"></i>';
                
                editBtn.html(loadingIcon);

                // Make the AJAX request
                $.ajax({
                    url: '/payment-methods/getById/' + methodId,
                    type: 'GET',
                    success: function(method) {
                        for (const langCode in method.name) {
                            editMethodModal.find('form').find(`input[data-lang=${langCode}]`).val(method.name[langCode]);
                        }

                        editMethodModal.find('form').find('input[name=code]').val(method.code);

                        editMethodModal.find('form').attr('action', `payment-methods/${methodId}`);

                        // Show the modal
                        editMethodModal.modal('show');
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