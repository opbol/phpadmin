var as = {};


as.init = function () {

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

  

    $("a[data-toggle=loader], button[data-toggle=loader]").click(function () {
        if ($(this).parents('form').valid()) {
            as.btn.loading($(this), $(this).data('loading-text'));
            $(this).parents('form').submit();
        }
    });

    $.fn.viewer.setDefaults({"navbar": false, "title": false})

    $("img.image-viewer").viewer();
    $("ul.viewer-image-sm-list").viewer({"navbar": true});

    $("a[data-toggle=image-viewer], button[data-toggle=image-viewer]").click(function () {
        var $target = $($(this).data('target'));
        $target.viewer({"navbar": true});
        $target.find('img:eq(0)').trigger('click');
    });
};

$(document).ready(as.init);