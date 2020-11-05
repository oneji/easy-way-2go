$(document).ready(function() {
    $('.info-btn').click(function(e) {
        e.preventDefault();
        
        let infoBtn = $(this);
        let infoModal = $('#infoModal');
        let id = infoBtn.data('id');

        $.ajax({
            url: '/api/routes/getById/' + id,
            success: function(data) {
                console.log(data)
            },
            error: function(err) {
                console.log(err)
            }
        });
    });
});