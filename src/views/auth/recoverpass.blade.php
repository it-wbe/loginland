@extends('layouts.app')
@section('content')
        <div class="modal-dialog" style="max-width: 800px; z-index:99999;"">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                    <h4 style="text-align: center">Password recovery</h4>
                    <form class="form-horizontal" role="form" name="auth_form_post_recover_pass" id="auth_form_post_recover_pass" method="POST" action="#" data-token = "{{$token}}"  data-errpass = "{{trans('loginland::modalauth.err_pass')}}" data-errorepassmatch ="{{trans('loginland::modalauth.match')}}">
                        {{ csrf_field() }}
                        <div id="err_first_pass" style="text-align: center; color: red;"></div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password_auth_recover" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div id="err_secound_pass" style="text-align: center; color: red;"></div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password_recover" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Save
                                </button>
                            </div>
                        </div>

                    </form>
                <div class="modal-footer">

                </div>
            </div>

        </div>
        <div class="modal-backdrop fade in"></div>
@endsection

@section('scritps')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="/packages/wbe/loginland/assets/js/jquery.validate.js"></script>
<script src="/packages/wbe/loginland/assets/js/auth.js"></script>
@endsection