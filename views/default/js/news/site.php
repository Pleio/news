//<script>

elgg.provide("elgg.news");

elgg.news.init = function() {
    $('.news-icon-remove').click(function(e) {
        e.preventDefault();

        var parent = $(this).parent();
        var fieldName = $(this).data('fieldname');

        if (fieldName) {
            parent.children().remove();
            parent.append('<input type="hidden" name="' + fieldName + '" value="remove">');
        }
    });
}

elgg.register_hook_handler("init", "system", elgg.news.init);
