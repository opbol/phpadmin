<div class="modal fade" style="display: none;" id="pic-modal" tabindex="-1" role="dialog" aria-labelledby="pic-model-label">
    <div class="modal-dialog" style="width:670px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pic-model-label">@lang('tax.preview')</h4>
            </div>
            <div class="modal-body">
                <div id="preview-image-container" class="preview-image-container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="pic-download-picture" class="btn btn-primary">@lang('tax.download_picture')</button>
                <button type="button" data-dismiss="modal" class="btn btn-default">@lang('app.close')</button>
            </div>
        </div>
    </div>
</div>
@section('after-scripts-end')
    @parent
    <script>
        function view_picture(img) {
            $('#preview-image-container').html('<img src="' + $(img).attr('src') + '" />');
            $('#pic-modal').modal('show');
        }
        jQuery(document).ready(function($) {
            $('#pic-download-picture').click(function() {
                window.open($('#preview-image-container').find('img').attr('src'));
            });
        });
    </script>
@stop