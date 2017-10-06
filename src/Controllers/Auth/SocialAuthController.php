<?php

namespace Wbe\Login\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Wbe\Login\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
    public function index()
    {
        return view('login::auth.');
    }
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->asPopup()->redirect();
    }

    public function callbackFacebook(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user() , 'facebook');
        auth()->login($user , true);

        return redirect()->to('/home');
    }

    public function redirectVk()
    {
        $client_id = env('vk_client_id'); // ID приложения
        $redirect_uri =  env('vk_redirect_uri'); // Адрес сайта
        $url_go = 'http://oauth.vk.com/authorize?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=email';

        return redirect($url_go);
    }

    public function callbackVk(SocialAccountService $service)
    {
        $client_id = env('vk_client_id'); // ID приложения
        $client_secret =  env('vk_client_secret'); // Защищённый ключ
        $redirect_uri =  env('vk_redirect_uri'); // Адрес сайта

        if (isset($_GET['code'])) {
            $result = false;
            $params = array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $_GET['code'],
                'redirect_uri' => $redirect_uri
            );

            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

            if (isset($token['access_token'])) {
                $params = array(
                    'uids'         => $token['user_id'],
                    'fields'       => 'uid,first_name,email,last_name,screen_name,sex,bdate,photo_big',
                    'access_token' => $token['access_token']
                );

                $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
                if (isset($userInfo['response'][0]['uid'])) {
                    $userInfo = $userInfo['response'][0];
                    $result = true;
                }
            }
        }
        if ($result)
        {
            //if(!$token['email'])
            $userInfo['email'] = $token['email'];
            $user = $service->createOrGetUserVk($userInfo);

            auth()->login($user , true);

            return redirect()->to('/home');

        }
    }

    public function redirectGoogle()
    {
//        'https://accounts.google.com/signin/oauth/oauthchooseaccount?client_id=573113671446-u63717rs7uui474asmpm70m6pud3jhdt.apps.googleusercontent.com&as=-7bcc5ece5e104070&destination=http%3A%2F%2Flogin.com&approval_state=!ChRHTm1ZV05kVHBSbVpaS1NtZFgxRRIfRXdsSjdXT1VwbklVd0Q4c01wTnQ0WWJuTjNUQzdoVQ%E2%88%99AHw7d_cAAAAAWddfpT-t7CaKWJ_AUdkmqvTzwg684piy&passive=1209600&oauth=1&sarp=1&scc=1&xsrfsig=AHgIfE_nv2JuwapRIvXo5BVH9QA5reuNkg&flowName=GeneralOAuthFlow'

        return Socialite::driver('google')->stateless()->redirect();

    }

    public function callbackGoogle(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('google')->stateless()->user()  , 'google');
        auth()->login($user , true);
        return redirect()->to('/home');
    }
}
