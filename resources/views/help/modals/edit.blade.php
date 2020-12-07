<div class="modal fade edit-help-modal" tabindex="-1" role="dialog" aria-labelledby="editHelpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('pages.help.editModalLabel') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" class="form-horizontal custom-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12">
                            @foreach ($langs as $lang)
                                <div class="form-group">
                                    <label for="name">{{ __('form.labels.name') }}: {{ $lang->name }}</label>
                                    <input name="name[{{ $lang->code }}]" data-lang="{{ $lang->code }}" type="text" class="form-control" placeholder="{{ __('form.placeholders.name') }}" required>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>{{ __('form.labels.icon') }}</label> <br>
                                <input type="file" name="icon" placeholder="{{ __('form.placeholders.icon') }}">
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