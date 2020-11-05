$(function() {
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
                console.log(data)
                let { baRequest } = data;
                let firmOwnerinfoModalTitle = $('#firmOwnerInfoModalTitle');

                firmOwnerinfoModalTitle.text(baRequest.id);

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
                let firmOwnerinfoModalTitle = $('#mainDriverInfoModalTitle');

                firmOwnerinfoModalTitle.text(baRequest.id);

                infoBtn.html(infoIcon);
                infoModal.modal(true);
            },
            error: function(err) {
                console.log(err)
            }
        });
    });
});