<script src="/packages/wbe/login/assets/js/auth.js"></script>
{{--{!! \Auth::user(); !!}--}}
<link rel="stylesheet" href="/packages/wbe/login/assets/css/auth.css">
<div id="head_auth" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 1000px;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"</h4>
            </div>
            <div class="container-auth" id="auth_form">
                <h4 style="text-align: center">Sign In</h4>
                <form class="form-horizontal" role="form" id="auth_form_post" name="auth_form_post" method="POST" action="#"
                      data-passwordormail="{{trans('login::modalauth.email')}}" data-errpass="{{trans('login::modalauth.err_pass')}}">
                    {{ csrf_field() }}
                    <div id="err_auth" style="text-align: center; color: red;"></div>
                    <div class="form-group{{ isset($errors)&&$errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">{{trans('login::modalauth.emailAdress')}}</label>

                        <div class="col-md-6">
                            <input id="email_auth" type="email" class="form-control" name="email"
                                   value="{{ old('email') }}">

                        </div>
                    </div>
                    <div id="err_auth_pass" style="text-align: center; color: red;"></div>
                    <div class="form-group{{ isset($errors)&&$errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">{{trans('login::modalauth.password')}}</label>

                        <div class="col-md-6">
                            <input id="password_auth" type="password" class="form-control" name="password">


                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> {{trans('login::modalauth.rememberme')}}

                                    <a class="btn btn-link forgot_pass" href="#"> {{trans('login::modalauth.forgotpass')}}?</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> {{trans('login::modalauth.login')}}
                            </button>


                        </div>
                    </div>
                </form>
                <div style="text-align: center"><h4>{{trans('login::modalauth.orsocialbutton')}}</h4>


                    <a onClick='login();' href="#" class="share-btn google-plus">
                        <i class="fa fa-google-plus"></i>
                    </a>

                    <a id="btn_facebook" href="#" class="share-btn facebook">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a href="/auth/vk" class="share-btn vk">
                        <i class="fa fa-vk"></i>
                    </a>


                </div>

            </div>


<script type="text/javascript">
    FB.init({appId: "{{ env('fb_client_id') }}", status: true, cookie: true, xfbml: true});
</script>





            <script>
                var OAUTHURL    =   'https://accounts.google.com/o/oauth2/auth?';
                var VALIDURL    =   'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=';
                var SCOPE       =   'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';
                var CLIENTID    =   '{!! env('google_client_id') !!}';
                var REDIRECT    =   '{!! env('google_redirect_uri') !!}'
                var LOGOUT      =   'http://accounts.google.com/Logout';
                var TYPE        =   'code';
                var _url        =   OAUTHURL + 'scope=' + SCOPE + '&client_id=' + CLIENTID + '&redirect_uri=' + REDIRECT + '&response_type=' + TYPE;
//                var _url        =   '/auth/google';
                var acToken;
                var tokenType;
                var expiresIn;
                var user;
                var loggedIn    =   false;

                function login() {
                    var win         =   window.open(_url, "windowname1", 'width=800, height=600');
                    var a = 0;
                    var pollTimer   =   window.setInterval(function() {
                        try {
                            console.log(win.document.URL.indexOf(window.location.hostname));

                            if(win.document.URL.indexOf(window.location.hostname)==7){
                                window.clearInterval(pollTimer);
                                var url =   win.document.URL;
                                acToken =   gup(url, 'access_token');
                                tokenType = gup(url, 'token_type');
                                expiresIn = gup(url, 'expires_in');
                                win.close();
                                validateToken(acToken);
                                location.reload();

                            }

                            a++;
                        } catch(e) {
                            console.log(win.document.URL.indexOf(window.location.hostname));
                        }
                    }, 500);
                }

                function validateToken(token) {
                    $.ajax({
                        url: VALIDURL + token,
                        data: null,
                        success: function(responseText){
                            getUserInfo();
                            loggedIn = true;
                            $('#loginText').hide();
                            $('#logoutText').show();
                        },
                        dataType: "jsonp"
                    });
                }

                function getUserInfo() {
                    $.ajax({
                        url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
                        data: null,
                        success: function(resp) {
                            user    =   resp;
                            console.log(user);
                            $('#uName').text('Welcome ' + user.name);
                            $('#imgHolder').attr('src', user.picture);
                        },
                        dataType: "jsonp"
                    });
                }

                function gup(url, name) {
                    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
                    var regexS = "[\\#&]"+name+"=([^&#]*)";
                    var regex = new RegExp( regexS );
                    var results = regex.exec( url );
                    if( results == null )
                        return "";
                    else
                        return results[1];
                }

                function startLogoutPolling() {
                    $('#loginText').show();
                    $('#logoutText').hide();
                    loggedIn = false;
                    $('#uName').text('Welcome ');
                    $('#imgHolder').attr('src', 'none.jpg');
                }

            </script>

            <a href='#' onClick='login();' id="loginText"'> Click here to login </a>
            <a href="#" style="display:none" id="logoutText" target='myIFrame' onclick="myIFrame.location='https://www.google.com/accounts/Logout'; startLogoutPolling();return false;"> Click here to logout </a>
            <iframe name='myIFrame' id="myIFrame" style='display:none'></iframe>
            <div id='uName'></div>
            <img src='' id='imgHolder'/>
            {{--/////////////////////////////////////////////registration/////////////////////////////////////////--}}

            <div class="container-auth" id="auth_form_reg">
                <h4 style="text-align: center">{{trans('login::modalauth.donthaveaccount')}}</h4>

                <form class="form-horizontal" role="form" id="reg_form"  name="form_reg" method="POST" action="{{ url('/register') }}"
                      data-errorname="{{trans('login::modalauth.name')}}"
                      data-erroremail="{{trans('login::modalauth.email')}}"
                      data-errorepass="{{trans('login::modalauth.match')}}"
                      data-errpass="{{trans('login::modalauth.err_pass')}}">
                    {{ csrf_field() }}

                    <div class="form-group{{ isset($errors)&&$errors->has('name') ? ' has-error' : '' }}">
                        <div id="err_req_name" style="text-align: center; color: red;"></div>
                        <label for="name" class="col-md-4 control-label">{{trans('login::modalauth.name')}}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">


                        </div>
                    </div>

                    <div class="form-group{{ isset($errors)&&$errors->has('email') ? ' has-error' : '' }}">
                        <div id="err_req_email" style="text-align: center; color: red;"></div>
                        <label for="email" class="col-md-4 control-label">{{trans('login::modalauth.emailAdress')}}</label>

                        <div class="col-md-6">
                            <input id="email_" type="email" class="form-control" name="email"
                                   value="{{ old('email') }}">


                        </div>
                    </div>

                    <div id="err_req_password" style="text-align: center; color: red;"></div>
                    <div class="form-group{{ isset($errors)&&$errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">{{trans('login::modalauth.password')}}</label>
                        <div class="col-md-6">
                            <input id="password_" type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group{{ isset($errors)&&$errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm"
                               class="col-md-4 control-label">{{trans('login::modalauth.conf_password')}}</label>
                        <div class="col-md-6">
                            <input id="password-confirm_" type="password" class="form-control"
                                   name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> {{trans('login::modalauth.register')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

    {{--/////////////////////////////////////////////recover password/////////////////////////////////////////--}}


            <div class="panel-default" id="forget_pass_form" style="display: none;">

                <div class="panel-heading">{{trans('login::modalauth.resetpassword')}}</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <center>
                        <div id="err_recover_email" style="color: red;"></div>
                        <div id="recover_email_success" style="color: green;"></div>
                    </center>
                    <form class="form-horizontal" role="form" id="post_form_recover_pass" name="post_form_recover_pass" method="POST"
                          action="{{ route('password.email') }}" data-errmail="{{trans('login::modalauth.email')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ isset($errors)&&$errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{trans('login::modalauth.emailAdress')}}</label>

                            <div class="col-md-6">

                                <input id="email_recover" type="email" class="form-control" name="email"
                                       value="{{ old('email') }}" required>


                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('login::modalauth.send_res_pass')}}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


            <div class="modal-footer">
                <button class="btn btn-primary" id="back_to_auth"
                        style="display: none;"> {{trans('login::modalauth.return_back')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('login::modalauth.close')}}</button>
            </div>
        </div>

    </div>
</div>