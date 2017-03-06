<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.admin', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('adminauth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $activeGuards = 0;

        $this->guard()->logout();

        foreach (config('auth.guards') as $guard => $guardConfig) {

            if ($guardConfig['driver'] === 'session') {

                if ($this->isActiveGuard($request, $guard)) {
                    $activeGuards++;
                }
            }
        }
        if ( ! $activeGuards) {
            
            $request->session()->flush();
            $request->session()->regenerate();
        }
        return redirect()->to($this->logoutToPath());
    }
    /**
     * Get the path that we should redirect once logged out.
     * Adaptable to user needs.
     *
     * @return string
     */
    public function logoutToPath() {
        return '/admin/login';
    }
    /**
     * Check if a particular guard is active.
     *
     * @param $request
     * @param $guard
     * @return bool
     */
    public function isActiveGuard($request, $guard)
    {
        $name = Auth::guard($guard) ->getName();

        return ($this->sessionHas($request, $name) && $this->sessionGet($request, $name) === $this->getAuthIdentifier($guard));
    }
    /**
     * Get the Auth identifier for the specified guard.
     *
     * @param $guard
     * @return mixed
     */
    public function getAuthIdentifier($guard)
    {
        return Auth::guard($guard)->user()->getAuthIdentifier();
    }
    /**
     * Get the specified key from the session.
     *
     * @param $request
     * @param $name
     * @return mixed
     */
    public function sessionGet($request, $name)
    {
        return $request->session()->get($name);
    }
    /**
     * Check if the session has a particular key.
     *
     * @param $request
     * @param $name
     * @return mixed
     */
    public function sessionHas($request, $name)
    {
        return $request->session()->has($name);
    }

}
