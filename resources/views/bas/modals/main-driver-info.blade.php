<div class="modal fade" id="mainDriverInfoModal" tabindex="-1" role="dialog" aria-labelledby="mainDriverInfoModalLabel aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('pages.bas.datatable.request') }} №<span id="mainDriverInfoModalTitle">--</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card-body border-bottom pt-0">
                            <div class="mb-2 mr-3">
                                <i class="mdi mdi-account-circle text-primary h1"></i>
                            </div>
        
                            <div>
                                <h5 id="mainDriverName">--</h5>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.birthday') }}:</strong> <span id="mainDriverBirthday"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.nationality') }}:</strong> <span id="mainDriverNationality"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.phoneNumber') }}:</strong> <span id="mainDriverPhoneNumber"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.email') }}:</strong> <span id="mainDriverEmail"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.country') }}:</strong> <span id="mainDriverCountry"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.dlIssuePlace') }}:</strong> <span id="mainDriverDlIssuePlace"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.dlExpiresAt') }}:</strong> <span id="mainDriverDlExpiresAt"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.drivingExperience') }}:</strong> <span id="mainDriverDrivingExperience"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.conviction') }}:</strong> <span id="mainDriverConviction"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.comment') }}:</strong> <span id="mainDriverComment"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.wasKeptDrunk') }}:</strong> <span id="mainDriverWasKeptDrunk"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.grades') }}:</strong> <span id="mainDriverGrads"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.gradesExpireAt') }}:</strong> <span id="mainDriverGradesExpireAt"></span></p>
                                <p class="text-muted mb-1"><strong>{{ __('pages.bas.mainDriver.dtp') }}:</strong> <span id="mainDriverDtp"></span></p>
                            </div>
                        </div>
        
                        <div class="card-body p-1">
                            <div class="row">
                                <div class="col-sm-12" id="mainDriverDocs"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="#" method="POST" id="mainDriverApproveBaRequestForm" class="form-horizontal custom-validation" novalidate>
                                        @csrf
        
                                        <div class="form-group">
                                            <label for="password">Email</label>
                                            <input type="text" placeholder="Введите пароль" name="email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Придумайте пароль</label>
                                            <input type="password" data-parsley-minlength="8" id="mainDriverPassword" required placeholder="Введите пароль" name="password" class="form-control">
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="password_confirmation">Подтвердите пароль</label>
                                            <input type="password" data-parsley-equalto="#mainDriverPassword" required placeholder="Подтвердите пароль" name="password_confirmation" class="form-control">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-sm-center mt-4 mt-sm-0">
                    <a 
                        href="#"
                        class="btn btn-danger btn-block waves-effect waves-light"
                        onclick="event.preventDefault(); document.getElementById('mainDriverDeclineBaRequestForm').submit();"
                    >
                        <i class="bx bx-x font-size-16 align-middle mr-2"></i> Отклонить
                    </a>

                    <form action="#" method="POST" id="mainDriverDeclineBaRequestForm">
                        @csrf
                    </form>
                </div>
                <div class="text-sm-center mt-4 mt-sm-0">
                    <a
                        href="#"
                        class="btn btn-success btn-block waves-effect waves-light"
                        onclick="event.preventDefault(); document.getElementById('mainDriverApproveBaRequestForm').submit();"
                    >
                        <i class="bx bx-check-double font-size-16 align-middle mr-2"></i> Принять
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>