<div class="modal fade" id="firmOwnerInfoModal" tabindex="-1" role="dialog" aria-labelledby="firmOwnerInfoModalLabel aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('pages.bas.datatable.request') }} №<span id="firmOwnerInfoModalTitle">--</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body border-bottom pt-0">
                    <div class="mb-2 mr-3">
                        <i class="mdi mdi-account-circle text-primary h1"></i>
                    </div>

                    <div>
                        <h5 id="firmOwnerCompanyName">--</h5>
                        <p class="text-muted mb-1"><strong>{{ __('pages.bas.firmOwner.name') }}:</strong> <span id="firmOwnerName"></span></p>
                        <p class="text-muted mb-1"><strong>{{ __('pages.bas.firmOwner.email') }}:</strong> <span id="firmOwnerEmail"></span></p>
                        <p class="text-muted mb-1"><strong>{{ __('pages.bas.firmOwner.phoneNumber') }}:</strong> <span id="firmOwnerPhoneNumber"></span></p>
                        <p class="text-muted mb-1"><strong>{{ __('pages.bas.firmOwner.nationality') }}:</strong> <span id="firmOwnerNationality"></span></p>
                        <p class="text-muted mb-1"><strong>{{ __('pages.bas.firmOwner.country') }}:</strong> <span id="firmOwnerCountry"></span></p>
                        <p class="text-muted mb-1"><strong>{{ __('pages.bas.firmOwner.inn') }}:</strong> <span id="firmOwnerInn"></span></p>
                    </div>
                </div>
                <div class="card-body border-bottom p-1">
                    <div class="row">
                        <div class="col-sm-12" id="firmOwnerDocs"></div>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="#" method="POST" id="approveBaRequestForm" class="form-horizontal custom-validation" novalidate>
                                @csrf

                                <div class="form-group">
                                    <label for="password">Email</label>
                                    <input type="text" placeholder="Введите пароль" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Придумайте пароль</label>
                                    <input type="password" data-parsley-minlength="8" id="password" required placeholder="Введите пароль" name="password" class="form-control">
                                </div>
                                <div class="form-group mb-0">
                                    <label for="password_confirmation">Подтвердите пароль</label>
                                    <input type="password" data-parsley-equalto="#password" required placeholder="Подтвердите пароль" name="password_confirmation" class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-sm-center mt-4 mt-sm-0">
                                <a 
                                    href="#"
                                    class="btn btn-danger btn-block waves-effect waves-light"
                                    onclick="event.preventDefault(); document.getElementById('declineBaRequestForm').submit();"
                                >
                                    <i class="bx bx-x font-size-16 align-middle mr-2"></i> Отклонить
                                </a>

                                <form action="#" method="POST" id="declineBaRequestForm">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-center mt-4 mt-sm-0">
                                <a
                                    href="#"
                                    class="btn btn-success btn-block waves-effect waves-light"
                                    onclick="event.preventDefault(); document.getElementById('approveBaRequestForm').submit();"
                                >
                                    <i class="bx bx-check-double font-size-16 align-middle mr-2"></i> Принять
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>