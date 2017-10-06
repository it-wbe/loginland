<h1>Hi! {{ $user->name }}</h1>
<p>Please click the link below to set your account password and get access to your account :</p>
<p><a href="{{ URL::to('auth/passwordset/' .  $token) }}">{{ URL::to('auth/passwordset/' .  $token) }}</a></p>