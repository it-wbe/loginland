<div id="profile_edit" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Profile</h4>
            </div>
            <div class="modal-body" id="body_edit_prof">
                <form class="form-horizontal" class="form-horizontal" role="form" name="edit_prof" id="edit_profile_popup">
                    {{ csrf_field() }}
                    <div class="form-group{{ isset($errors)&&$errors->has('name') ? ' has-error' : '' }}">
                        <div id="err_req_name" style="text-align: center; color: red;"></div>
                        <label for="name" class="col-md-4 control-label">name</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                        </div>
                    </div>
                    <div class="form-group{{ isset($errors)&&$errors->has('email') ? ' has-error' : '' }}">
                        <div id="err_req_email" style="text-align: center; color: red;"></div>
                        <label for="email" class="col-md-4 control-label">email</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email}}">
                        </div>
                    </div>
                    <button type="submit"  class="btn btn-primary">Ok</button>
                </form>
                <div class="success" style="display: none;">
                    дані були успішно змінені
                </div>
            </div>
        </div>

    </div>
</div>

<div id="password_edit" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Password</h4>
            </div>
            <div class="modal-body" id="body_edit_pass">
                <form class="form-horizontal" class="form-horizontal" role="form" name="edit_password" id="edit_pass_popup">
                    {{ csrf_field() }}
                    <div class="form-group{{ isset($errors)&&$errors->has('password') ? ' has-error' : '' }}">
                        <div id="err_req_password" style="text-align: center; color: red;"></div>
                        <label for="password" class="col-md-4 control-label">password</label>
                        <div class="col-md-6">
                            <input id="password_" type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group{{ isset($errors)&&$errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm"
                               class="col-md-4 control-label">password confirm</label>
                        <div class="col-md-6">
                            <input id="password-confirm_" type="password" class="form-control"
                                   name="password_confirmation">
                        </div>
                    </div>
                        <button type="submit"  class="btn btn-primary">Ok</button>
                </form>
                <div class="success" style="display: none;">
                    дані були успішно змінені
                </div>
            </div>
        </div>

    </div>
</div>


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="/packages/wbe/loginland/assets/js/jquery.validate.js"></script>


<script type="text/javascript">
    $("form[name='edit_password']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo : "#password_"
            }
        },
        // Specify validation error messages
        messages: {
            password_confirmation: {
                equalTo : "Both of password must be same"
            },

            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            var submit_btn = $(this).find('button[type=submit]');
            $.ajax({
                type: "POST",
                url: '/auth/profile/edit_password',
                data: $(form).serialize(),
                error: function (err) {
                    console.log(err.responseText);
                },
                success: function (data) {
                    console.log(data);
                    for (arrayIn in data) {
                        $('#err_req_' + arrayIn).html(data[arrayIn][0]);
                    }

                    if(data['ok']==1){
                        $("form[name='edit_password']").hide();
                        $("#body_edit_pass .success").show();
                        var interval = setInterval(function() {
                                // Display a login box
                                $("form[name='edit_password']").show();
                                $("#body_edit_pass .success").hide();
                                clearInterval(interval);
                        }, 3000);
                    }
                }
            })
        }
    });

    $("form[name='edit_prof']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            name: {
                required: true,
                minlength: 1,
                maxlength: 255
            },
            email: {
                required: true,
                minlength: 4,
                email: true
            },
        },
        // Specify validation error messages
        messages: {
            name: "Please enter your name",
            email: "Please enter a valid email address"
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            var submit_btn = $(this).find('button[type=submit]');
            $.ajax({
                type: "POST",
                url: '/auth/profile/edit_profile',
                data: $(form).serialize(),
                error: function (err) {
                    console.log(err.responseText);
                },
                success: function (data) {
                    console.log(data);
                    for (arrayIn in data) {
                        $('#err_req_' + arrayIn).html(data[arrayIn][0]);
                    }
                    if(data['ok']==1){
                        $("form[name='edit_prof']").hide();
                        $("#body_edit_prof .success").show();
                        var interval = setInterval(function() {
                            // Display 'counter' wherever you want to display it.
                                    // Display a login box
                                    $("form[name='edit_prof']").show();
                                    $("#body_edit_prof .success").hide();
                                    clearInterval(interval);
                            }, 3000);
                    }
                }
            })
        }
    });

</script>

