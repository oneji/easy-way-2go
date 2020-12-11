<div class="modal fade order-status-modal" tabindex="-1" role="dialog" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('pages.orderStatuses.addModalLabel') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.orderStatuses.store') }}" method="POST" class="form-horizontal custom-validation" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            @foreach ($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('form.labels.name') }}: {{ $lang->name }}</label>
                                    <input name="name[{{ $lang->code }}]" type="text" class="form-control" placeholder="{{ __('form.placeholders.name') }}" required>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="code">{{ __('form.labels.code') }}</label>
                                <input name="code" type="text" class="form-control" placeholder="{{ __('form.placeholders.code') }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block waves-effect waves-light">{{ __('form.buttons.add') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>