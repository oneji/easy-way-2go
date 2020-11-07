$(function() {
    let appLocale = $('html').attr('lang');

    $(document).on('click', '.firm-owner-info-btn' ,function(e) {
        e.preventDefault();

        let infoBtn = $(this);
        let infoModal = $('#firmOwnerInfoModal');
        let id = infoBtn.data('id');
        let loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
        let infoIcon = '<i class="bx bx-info-circle"></i>';

        infoBtn.html(loadingIcon);

        $.ajax({
            url: '/api/baRequests/getById/' + id,
            success: function(data) {
                let { baRequest } = data;
                let firmOwnerinfoModalTitle = $('#firmOwnerInfoModalTitle');

                firmOwnerinfoModalTitle.text(baRequest.id);
                $('#firmOwnerCompanyName').text(baRequest.data.company_name[appLocale]);
                $('#firmOwnerName').text(baRequest.data.first_name[appLocale] + ' ' + baRequest.data.last_name[appLocale]);
                $('#firmOwnerEmail').text(baRequest.data.email);
                $('#firmOwnerPhoneNumber').text(baRequest.data.phone_number);
                $('#firmOwnerNationality').text(baRequest.data.nationality.name[appLocale]);
                $('#firmOwnerCountry').text(baRequest.data.country.name[appLocale] + ', ' + baRequest.data.city[appLocale]);
                $('#firmOwnerInn').text(baRequest.data.inn);

                $('#firmOwnerDocs').html('');
                baRequest.data.passport_photo.map(photo => {
                    $('#firmOwnerDocs').append(`
                        <div class="car-image-wrapper">
                            <a class="image-popup-no-margins" href="/storage/${photo.file}">
                                <img class="img-fluid car-image" alt="" src="/storage/${photo.file}">
                            </a>
                        </div>
                    `);
                });

                $('.image-popup-no-margins').magnificPopup({
                    type: "image",
                    closeOnContentClick: !0,
                    closeBtnInside: !1,
                    fixedContentPos: !0,
                    mainClass: "mfp-no-margins mfp-with-zoom",
                    image: {
                        verticalFit: !0
                    },
                    zoom: {
                        enabled: !0,
                        duration: 300
                    }
                })

                $('#declineBaRequestForm').attr('action', `bas/${baRequest.id}/decline`);
                $('#approveBaRequestForm').attr('action', `bas/${baRequest.id}/approve`);
                $('#approveBaRequestForm').find('input[name=email]').val(baRequest.data.email);

                infoBtn.html(infoIcon);
                infoModal.modal(true);
            },
            error: function(err) {
                console.log(err)
            }
        });
    });
    
    $(document).on('click', '.main-driver-info-btn' ,function(e) {
        e.preventDefault();

        let infoBtn = $(this);
        let infoModal = $('#mainDriverInfoModal');
        let id = infoBtn.data('id');
        let loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
        let infoIcon = '<i class="bx bx-info-circle"></i>';

        infoBtn.html(loadingIcon);

        $.ajax({
            url: '/api/baRequests/getById/' + id,
            success: function(data) {
                console.log(data)
                let { baRequest } = data;
                let mainDriverInfoModalTitle = $('#mainDriverInfoModalTitle');

                mainDriverInfoModalTitle.text(baRequest.id);

                $('#mainDriverName').text(baRequest.data.first_name[appLocale] + ' ' + baRequest.data.last_name[appLocale]);
                $('#mainDriverBirthday').text(baRequest.data.birthday);
                $('#mainDriverNationality').text(baRequest.data.nationality.name[appLocale]);
                $('#mainDriverPhoneNumber').text(baRequest.data.phone_number);
                $('#mainDriverEmail').text(baRequest.data.email);
                $('#mainDriverCountry').text(baRequest.data.country.name[appLocale] + ', ' + baRequest.data.city[appLocale]);
                $('#mainDriverDlIssuePlace').text(baRequest.data.dl_issue_place);
                $('#mainDriverDlExpiresAt').text(baRequest.data.dl_expires_at);
                $('#mainDriverDrivingExperience').text(baRequest.data.driving_experience.name[appLocale]);
                $('#mainDriverConviction').text(baRequest.data.conviction);
                $('#mainDriverComment').text(baRequest.data.comment[appLocale]);
                $('#mainDriverWasKeptDrunk').text(baRequest.data.was_kept_drunk);
                $('#mainDriverGrades').text(baRequest.data.grades);
                $('#mainDriverGradesExpireAt').text(baRequest.data.grades_expire_at);
                $('#mainDriverDtp').text(baRequest.data.dtp);

                $('#mainDriverDocs').html('');
                baRequest.data.passport_photos.map(photo => {
                    $('#mainDriverDocs').append(`
                        <div class="car-image-wrapper">
                            <a class="image-popup-no-margins" href="/storage/${photo.file}">
                                <img class="img-fluid car-image" alt="" src="/storage/${photo.file}">
                            </a>
                        </div>
                    `);
                });

                $('.image-popup-no-margins').magnificPopup({
                    type: "image",
                    closeOnContentClick: !0,
                    closeBtnInside: !1,
                    fixedContentPos: !0,
                    mainClass: "mfp-no-margins mfp-with-zoom",
                    image: {
                        verticalFit: !0
                    },
                    zoom: {
                        enabled: !0,
                        duration: 300
                    }
                })

                infoBtn.html(infoIcon);
                infoModal.modal(true);
            },
            error: function(err) {
                console.log(err)
            }
        });
    });
});