<?php

namespace Wbe\Loginland\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Auth;
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
        $user->save();

        $email = $data['email'];
        $name = $data['name'];

        if(view()->exists('emails.registration')){
            $view_email  = 'emails.registration';
        }else{
            $view_email = 'loginland::emails.registration';
        }
        if (\Auth::loginUsingId($user->id, true)) {

            /////need testing this sheet :)
            Mail::send($view_email, ['user' => $user], function ($message) use ($name, $email) {
                $message->from('test@email.com', 'Test name');
                $message->to($email, $name)->subject('Wellcome!');
            });
            return '';
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

    public function postRegistration(Request $request)
    {
        $validation = $this->validator($request->all());
        if ($validation->fails()) {
            return response()->json($validation->errors()->toArray());
        } else {
            $this->create($request->all());
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
