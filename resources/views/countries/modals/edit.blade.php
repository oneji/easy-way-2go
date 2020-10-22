<div class="modal fade edit-country-modal" tabindex="-1" role="dialog" aria-labelledby="editCountryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('pages.countries.editModalLabel') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" class="form-horizontal custom-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">{{ __('form.labels.name') }}</label>
                                <input name="translations[ru][name]" id="nameRu" type="text" class="form-control" placeholder="{{ __('form.placeholders.name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('form.labels.name') }}</label>
                                <input name="translations[en][name]" id="nameEn" type="text" class="form-control" placeholder="{{ __('form.placeholders.name') }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block waves-effect waves-light">{{ __('form.buttons.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>