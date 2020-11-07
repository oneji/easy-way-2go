<div class="modal fade" id="mainDriverInfoModal" tabindex="-1" role="dialog" aria-labelledby="mainDriverInfoModalLabel aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">{{ __('pages.bas.datatable.request') }} №<span id="mainDriverInfoModalTitle">--</span></h5>
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
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col-sm-12" id="mainDriverDocs"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <p class="text-muted mb-2">Available Balance</p>
                                <h5>$ 9148.00</h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right mt-4 mt-sm-0">
                                <p class="text-muted mb-2">Since last month</p>
                                <h5>+ $ 215.53   <span class="badge badge-success ml-1 align-bottom">+ 1.3 %</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>