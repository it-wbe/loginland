<?php

namespace Wbe\Loginland\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
//use App\User;

use Wbe\Loginland\Auth;
use Wbe\Loginland\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;
use URL;
use Illuminate\Support\Facades\View;


class AuthAjaxController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function postLogin(Request $request)
    {
        if (\Auth::check()) return collect(['false']);
        $auth = false;
        $credentials = $request->only('email', 'password');

        if (\Auth::attempt($credentials, $request->has('remember'))) {
            $auth = true; // Success
        }

        if ($request->ajax() && $auth == true) {
            $arrayRequest = collect(['true']);
        } else {
            $arrayRequest = collect(['false', 'Wrong password or email']);
        }
        return $arrayRequest;

    }

    protected function create(array $data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);

        ///// confirm registration
        if(config('login.confirm_registration_email')==1) {
            $user->active = 0;
            $user->active_tocken = str_random(255);
                /////need testing this sheet :)
                 $this->sendEmail($user,'confirm');
            $user->save();
        }else{
            $user->active = 1;
            // send hello email
            if (\Auth::loginUsingId($user->id, true)) {
                $this->sendEmail($user ,'hello');
            }
            $user->save();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function sendEmail($user,$type){
        switch ($type){
            case 'hello':
                if (view()->exists(config('login.email_hello'))) {
                    $view_email = config('login.email_hello');
                } else {
                    $view_email = 'loginland::emails.registration';
                }
                $subject = __('login.welcome');
                if($subject == 'login.welcome'){
                    $subject = __('loginland::login.welcome');
                }

                break;
            case 'confirm':
                if (view()->exists(config('login.email_registration_activate'))) {
                    $view_email = config('login.email_registration_activate');
                } else {
                    $view_email = 'loginland::emails.registration_activate';
                }
                $subject = __('login.activate_account');
                if($subject == 'login.activate_account'){
                    $subject = __('loginland::login.activate_account');
                }
                break;
        }

        Mail::send($view_email, ['user' => $user], function ($message) use ($user,$subject) {
            $message->from(config('login.email_from'), config('login.email_name'));
            $message->to($user->email, $user->name)->subject($subject);
        });
    }

    public function postRegistration()
    {
        $validation = $this->validator(request()->all());
        if ($validation->fails()) {
            return response()->json($validation->errors()->toArray());
        } else {
            if(config('login.confirm_registration_email')==1){
                $this->create(request()->all());

                $message =  __('login.activate_email_message');
                if($message == 'login.activate_email_message'){
                    $message = __('loginland::login.activate_email_message');
                }
                return response()->json(["message"=>$message,'confirm'=>'1']);
            }else{
                $this->create(request()->all());
                return response()->json(['confirm'=>'0']);
            }

        }
    }

    public function RecoverPassword(Request $request)
    {  
       
        $validator = Validator::make($request->all(), [
            'email' => 'min:1|max:255|',
        ]);
        if (!$validator->fails()) {
   
            $user = User::where('email', $request->email)->first();
            if ($user) {
                //
                $searchToken = \DB::table('password_resets')->where('email', $request->email)->first();
                
                if (!$searchToken) {
                   
                    $contactfirstname = $user->name;
                    $contactemail = $user->email;

                    $token = hash_hmac('sha256', str_random(40), config('app.key'));
                    // $token = 'test';


                    \DB::table('password_resets')->insert(['email' => $user->email, 'token' => $token, 'created_at' => \Carbon\Carbon::now()->toDateTimeString()]);

                    if(view()->exists('emails.resetpassword')){
                        $view_reset_pass = 'emails.resetpassword';
                    }else{
                        $view_reset_pass = 'loginland::emails.resetpassword';
                    }


                    Mail::send($view_reset_pass, ['user' => $user, 'token' => $token], function ($message) use ($contactfirstname, $contactemail) {
                        $message->from('name@email.com', 'Reset password');
                        $message->to($contactemail, $contactfirstname)->subject('Reset Password!');
                    });
                    
                    return collect(['success', __('loginland::modalauth.sentEmail')]);

                } else {
                   
                    return collect(['success', __('loginland::modalauth.sentEmail')]);
                }

            } else {
                return collect(['err', __('loginland::modalauth.user')]);
            }
        } else {
            return collect(['err', __('loginland::modalauth.sentEmail')]);
        }

    }

    public function getTocken($tocken){
       $user =  User::where('active_tocken','=',$tocken)->first();
//       dd($user);
        if($user){
            $user->active = 1;
            $user->active_tocken = "";
            $user->save();
            if (\Auth::loginUsingId($user->id, true)){
                $this->sendEmail($user,'hello');
                return    redirect(config('login.redirect_after_activated'));
            }
        }
        else{
            return redirect(404);
        }
    }




    public function resetpass($token)
    {
        if(\Auth::check())return redirect('/');

        $searchToken = \DB::table('password_resets')->where('token', $token)->first();
        if(view()->exists('auth.recoverpass')){
            $recover_pass_blade = 'auth.recoverpass';
        }else{
            $recover_pass_blade = 'loginland::auth.recoverpass';
        }

        if ($searchToken) {

            return view($recover_pass_blade)->with(['token' => $token]);

        } else {
            return redirect(404);
        }

    }

    public function newPassword(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'min:6|max:255|',
            'password_confirmation' => 'min:6|max:255|',
        ]);
        if ($validator->fails()) {
            return collect(['err'], __('loginland::modalauth.err_pass'));
        }

        if(\Auth::check())return redirect('/');

        $password = $request->password;
        $conf_password = $request->password_confirmation;

        if ($password != $conf_password) {
            return collect(['err', __('loginland::modalauth.match')]);
        }
        $searchToken = \DB::table('password_resets')->where('token', $token)->first();
        if(is_null($searchToken)){
            return collect(['err',__('loginland::modalauth.already_recovered')]);
        }
        $user = User::where('email', $searchToken->email)->first();
        $user->password = bcrypt($password);
        $user->save();

        \Auth::login($user, true);

        \DB::table('password_resets')->where('token', $token)->delete();

        return collect(['success']);

    }


}
