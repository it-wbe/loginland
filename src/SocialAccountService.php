<?php

namespace Wbe\Login;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser , $type)
    {

        $account = SocialAccount::whereProvider($type)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $type
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => bcrypt(time()),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
    public function createOrGetUserVk($userInfo)
    {
        $account = SocialAccount::whereProvider('vk')
            ->whereProviderUserId($userInfo['uid'])
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $userInfo['uid'],
                'provider' => 'vk'
            ]);

            $user = User::whereEmail($userInfo['email'])->first();

            if (!$user) {

                $user = User::create([
                    'email' => $userInfo['email'],
                    'name' => $userInfo['first_name'].' '.$userInfo['last_name'],
                    'password' => bcrypt(time()),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}