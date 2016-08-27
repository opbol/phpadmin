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

    $.fn.viewer.setDefaults({
        "navbar": false,
        "title": false,
        "toolbar": false,
        "movable": false,
        "zoomable": false,
        "rotatable": false,
        "scalable": false,
        "transition": false
    });

    $("img.image-viewer").viewer();
    $("ul.viewer-image-sm-list").viewer({"navbar": true});

    $("a[data-toggle=image-viewer], button[data-toggle=image-viewer]").click(function () {
        var $target = $($(this).data('target'));
        $target.viewer({"navbar": true});
        $target.find('img:eq(0)').trigger('click');
    });

    $("input[data-toggle=enter-button]").keydown(function (e) {
        var e = e || event;
        var $this = $(this);
        var action = function($target) {
            if ($target[0].tagName == 'button') {
                $target.trigger('click');
            } else {
                $target.focus();
            }
        };
        if (e && e.keyCode == 13) {
            var target = $(this).data('target');
            if (target) {
                action($(target))
            } else {
                var $next = $this.next();
                if ($next.length == 0) {
                    var $next = $this.parent().next().find($this[0].tagName + ':eq(0)');
                }
                if ($next.length > 0 && $next[0].tagName == $(this)[0].tagName) action($next);
            }
        }
    });

    $('select').filter('.select2').select2({minimumResultsForSearch: 10});
};

$(document).ready(as.init);