<div class="panel panel-default">
    <div class="panel-heading">@lang('app.user_details')</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="realname">@lang('app.realname')</label>
                    <input type="text" class="form-control" id="realname"
                           name="realname" placeholder="@lang('app.realname')" value="{{ $edit ? $user->realname : '' }}">
                </div>
                <div class="form-group">
                    <label for="role">@lang('app.role')</label>
                    {!! Form::select('role', $roles, $edit ? $user->roles->first()->id : '',
                        ['class' => 'form-control', 'id' => 'role', $profile ? 'disabled' : '']) !!}
                </div>
                <div class="form-group">
                    <label for="status">@lang('app.status')</label>
                    {!! Form::select('status', $statuses, $edit ? $user->status : '',
                        ['class' => 'form-control', 'id' => 'status', $profile ? 'disabled' : '']) !!}
                </div>
            </div>

            <div class="col-md-6">
                @permission('users.manage')
                <div class="form-group">
                    <label for="department_id">@lang('app.department')</label>
                    {!! Form::select('department_id', $departments, $edit ? $user->department_id : '', [ 'class' => 'form-control' ]) !!}
                </div>
                @endpermission
                <div class="form-group">
                    <label for="birthday">@lang('app.date_of_birth')</label>
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type='text' name="birthday" id='birthday' value="{{ $edit ? $user->birthday : '' }}" class="form-control" />
                            <span class="input-group-addon" style="cursor: default;">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">@lang('app.address')</label>
                    <input type="text" class="form-control" id="address"
                           name="address" placeholder="@lang('app.address')" value="{{ $edit ? $user->address : '' }}">
                </div>
                <input type="hidden" name="country_id" value="156" />
            </div>

            @if ($edit)
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" id="update-details-btn">
                        <i class="fa fa-refresh"></i>
                        @lang('app.update_details')
                    </button>
                </div>
            @endif
        </div>
    </div>

</div>