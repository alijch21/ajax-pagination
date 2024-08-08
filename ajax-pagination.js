jQuery(document).ready(function($) {
    var page = 1;
    $('#load-more').on('click', function() {
        page++;
        $.ajax({
            url: ajaxpagination.ajax_url,
            type: 'post',
            data: {
                action: 'ajax_pagination',
                page: page,
            },
            success: function(response) {
                $('#posts-container').append(response);
            }
        });
    });
});
