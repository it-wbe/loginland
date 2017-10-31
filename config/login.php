<?php

return [
    'fb_client_id'=>'',
    'fb_client_secret'=>'',
    'fb_redirect_uri'=>'',

    'google_client_id'=>'',
    'google_client_secret'=>'',
    'google_redirect_uri'=>'',



    'confirm_registration_email' => env('confirm_registration_email',1),
    /// blade for letter to activate user
    'email_registration_activate'=>'',
    /// blade for letter hello
    'email_registration_hello'=>'',

    /// user edit password blade
    'user_edit_pass'=>'',

    // user edit profile blade
    'user_edit_prof'=>'',


    'redirect_after_activated'=>'/',


    /// email
    'email_from'=>'company@gmail.com',
    'email_name'=>'COMPANY',
];
