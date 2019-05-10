<?php

namespace App\Http\Middleware;

use App\Models\Users;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Repositories\AuthRepository;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $username = $request->header('username');
        $password = $request->header('password');
        if(isset($username) && isset($password)) {
            $user = Users::where('username', '=',$username)->first();
        }
//        $result = $this->auth->verifyAuth($username,$password);
        if($user === null) {
            return ([Response::HTTP_NO_CONTENT, 'Invalid username or Password']);
        }
        else {
            return $next($request);

        }
    }
}
