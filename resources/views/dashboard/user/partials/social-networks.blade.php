<div class="panel panel-default">
    <div class="panel-heading">@lang('app.social_networks')</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <label for="facebook">Facebook</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    <input type="text" class="form-control" id="facebook" name="socials[facebook]" placeholder="Facebook" value="{{ $edit ? $socials->facebook : '' }}">
                </div>
                <br>
                <label for="twitter">Twitter</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                    <input type="text" class="form-control" id="twitter" name="socials[twitter]" placeholder="Twitter" value="{{ $edit ? $socials->twitter : '' }}">
                </div>
                <br>
                <label for="google_plus">Google+</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                    <input type="text" class="form-control" id="google_plus" name="socials[google_plus]" placeholder="Google+" value="{{ $edit ? $socials->google_plus : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="linkedin">LinkedIn</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                    <input type="text" class="form-control" id="linkedin" name="socials[linked_in]" placeholder="LinkedIn" value="{{ $edit ? $socials->linked_in : '' }}">
                </div>
                <br>
                <label for="dribbble">Dribbble</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dribbble"></i></span>
                    <input type="text" class="form-control" id="dribbble" name="socials[dribbble]" placeholder="Dribbble" value="{{ $edit ? $socials->dribbble : '' }}">
                </div>
                <br>
                <label for="skype">Skype</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-skype"></i></span>
                    <input type="text" class="form-control" id="skype" name="socials[skype]" placeholder="Skype ID" value="{{ $edit ? $socials->skype : '' }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-refresh"></i>
            @lang('app.update_social_networks')
        </button>
    </div>
</div>