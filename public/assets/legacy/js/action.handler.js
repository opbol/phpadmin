(function() {

    var laravel = {
        initialize: function() {
            this.registerEvents();
        },

        registerEvents: function() {
            $('body').on('click', 'a[data-method]', this.handleMethod);
        },

        handleMethod: function(e) {
            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();
            var form;

            // If the data-method attribute is not POST or PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ( $.inArray(httpMethod, ['POST', 'PUT', 'DELETE']) === - 1 ) {
                return;
            }

            // Allow user to optionally provide data-confirm="Are you sure?"
            if ( link.data('confirm-text') ) {
                laravel.verifyConfirm(link, function (t) {
                    if (! t) return false;

                    form = laravel.createForm(link);
                    form.submit();
                })
            }

            e.preventDefault();
        },

        verifyConfirm: function(link, callback) {
            if (typeof swal == 'function') {
                swal({
                    title: link.data('confirm-title'),
                    text: link.data('confirm-text'),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: link.data('confirm-action') ? link.data('confirm-action') : "Yes",
                }, function (t) {
                    callback(t)
                })
            } else {
                if (confirm(link.data('confirm-text'))) {
                    callback(true)
                }
            }

        },

        getCsrfToken: function () {
            return $('meta[name="csrf-token"]').attr('content');
        },

        createForm: function(link) {
            var form =
                $('<form>', {
                    'method': 'POST',
                    'action': link.attr('href')
                });

            var token =
                $('<input>', {
                    'name': '_token',
                    'type': 'hidden',
                    'value': laravel.getCsrfToken()
                });

            var hiddenInput =
                $('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': link.data('method')
                });

            return form.append(token, hiddenInput)
                .appendTo('body');
        }
    };

    laravel.initialize();

})();