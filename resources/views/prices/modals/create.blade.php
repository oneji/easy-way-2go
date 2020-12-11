<div class="modal fade prices-modal" tabindex="-1" role="dialog" aria-labelledby="priceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('pages.prices.addModalLabel') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.prices.store') }}" method="POST" class="form-horizontal custom-validation" novalidate>
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
                        
                        <div class="col-6">
                            <div class="form-group">
                                <label for="unit">{{ __('form.labels.unit') }}</label>
                                <input name="unit" type="text" class="form-control" placeholder="{{ __('form.placeholders.unit') }}" required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">{{ __('form.labels.price') }}, &euro;</label>
                                <input name="price" type="text" class="form-control" placeholder="{{ __('form.placeholders.price') }}" required>
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