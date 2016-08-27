var del = require('del');
var elixir = require('laravel-elixir');

elixir.extend('remove', function(path) {
    new elixir.Task('remove', function() {
        del(path);
    });
});

elixir(function(mix) {

    // Copy fonts 
    mix.copy('bower_components/AdminLTE/bootstrap/fonts', 'public/build/fonts');
    mix.copy('bower_components/font-awesome/fonts', 'public/build/fonts');
    // Copy iCheck plugin image 
    mix.copy('bower_components/AdminLTE/plugins/iCheck/square/blue.png', 'public/build/css/blue.png');
    mix.copy('bower_components/AdminLTE/plugins/iCheck/flat/flat.png', 'public/build/css/flat.png');

    // Copy jstree plugin image
    mix.copy('bower_components/jstree/dist/themes/default/throbber.gif', 'public/build/css/throbber.gif');
    mix.copy('bower_components/jstree/dist/themes/default/40px.png', 'public/build/css/40px.png');
    mix.copy('bower_components/jstree/dist/themes/default/32px.png', 'public/build/css/32px.png');

    // Merge all dashboard CSS files in one file.
    mix.styles([
        './bower_components/AdminLTE/bootstrap/css/bootstrap.css',
        './bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css',
        './bower_components/AdminLTE/dist/css/AdminLTE.css',
        './bower_components/AdminLTE/dist/css/skins/_all-skins.css',
        './bower_components/font-awesome/css/font-awesome.css',
        './bower_components/AdminLTE/plugins/iCheck/square/blue.css',
        './bower_components/AdminLTE/plugins/iCheck/flat/flat.css',
        './bower_components/jstree/dist/themes/default/style.min.css',
        './bower_components/jquery-loading/dist/jquery.loading.min.css',
        './bower_components/croppie/croppie.css',
        './bower_components/imageviewer/dist/viewer.css',
        './resources/assets/less/custom.less',
        './resources/assets/css/bootstrap-datetimepicker.min.css',
        './bower_components/sweetalert/dist/sweetalert.css',
        './bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        './bower_components/AdminLTE/plugins/select2/select2.min.css'
    ], './public/css/dashboard.css', './public/css');


    // Merge all dashboard JS  files in one file.
    mix.scripts([
        './resources/assets/js/jquery.min.js',
        './resources/assets/js/bootstrap.min.js',
        './bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js',
        './bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js',
        './bower_components/AdminLTE/dist/js/app.js',
        './bower_components/AdminLTE/plugins/iCheck/icheck.js',
        './bower_components/AdminLTE/plugins/chartjs/Chart.min.js',
        './bower_components/jstree/dist/jstree.min.js',
        './bower_components/jquery-loading/dist/jquery.loading.min.js',
        './bower_components/croppie/croppie.js',
        './bower_components/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
        './bower_components/jQuery-File-Upload/js/jquery.iframe-transport.js',
        './bower_components/jQuery-File-Upload/js/jquery.fileupload.js',
        './bower_components/imageviewer/dist/viewer.js',
        './resources/assets/js/app.js',
        './resources/assets/js/moment-with-locales.min.js',
        './resources/assets/js/action.handler.js',
        './resources/assets/js/bootstrap-datetimepicker.min.js',
        './bower_components/sweetalert/dist/sweetalert.min.js',
        './bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js',
        './bower_components/AdminLTE/plugins/select2/select2.full.min.js'
    ], './public/js/dashboard.js', './public/js');

    mix.copy('resources/assets/flags', 'public/build/flags');
    
    // Merge all frontend CSS files in one file.
    mix.styles([
        './bower_components/AdminLTE/bootstrap/css/bootstrap.css',
        './bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css',
        './bower_components/AdminLTE/dist/css/AdminLTE.css',
        './bower_components/AdminLTE/dist/css/skins/_all-skins.css',
        './bower_components/font-awesome/css/font-awesome.css',
        './bower_components/AdminLTE/plugins/iCheck/square/blue.css',
        './bower_components/AdminLTE/plugins/iCheck/flat/flat.css',
        './bower_components/jstree/dist/themes/default/style.min.css',
        './bower_components/jquery-loading/dist/jquery.loading.min.css',
        './bower_components/croppie/croppie.css',
        './bower_components/imageviewer/dist/viewer.css',
        './resources/assets/less/custom.less',
        './resources/assets/css/bootstrap-datetimepicker.min.css',
        './bower_components/sweetalert/dist/sweetalert.css',
        './bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        './bower_components/AdminLTE/plugins/select2/select2.min.css'
    ], './public/css/frontend.css', './public/css');

    // Merge all frontend JS  files in one file.
    mix.scripts([
        './resources/assets/js/jquery.min.js',
        './resources/assets/js/bootstrap.min.js',
        './bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js',
        './bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js',
        './bower_components/AdminLTE/dist/js/app.js',
        './bower_components/AdminLTE/plugins/iCheck/icheck.js',
        './bower_components/AdminLTE/plugins/chartjs/Chart.min.js',
        './bower_components/jstree/dist/jstree.min.js',
        './bower_components/jquery-loading/dist/jquery.loading.min.js',
        './bower_components/croppie/croppie.js',
        './bower_components/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
        './bower_components/jQuery-File-Upload/js/jquery.iframe-transport.js',
        './bower_components/jQuery-File-Upload/js/jquery.fileupload.js',
        './bower_components/imageviewer/dist/viewer.js',
        './resources/assets/js/app.js',
        './resources/assets/js/moment-with-locales.min.js',
        './resources/assets/js/action.handler.js',
        './resources/assets/js/bootstrap-datetimepicker.min.js',
        './bower_components/sweetalert/dist/sweetalert.min.js',
        './bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js',
        './bower_components/AdminLTE/plugins/select2/select2.full.min.js'
    ], './public/js/frontend.js', './public/js');

    mix.version([
        "public/css/dashboard.css",
        "public/css/frontend.css",
        "public/js/dashboard.js",
        "public/js/frontend.js"
    ]);

    elixir(function(mix) {
        mix.remove([ 'public/css', 'public/js', 'public/fonts' ]);
    });
});
