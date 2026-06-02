<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Event;
use OwenIt\Auditing\Events\AuditCustom;

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
    protected $redirectTo = '/me';

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['logout']),
        ];
    }

    protected function authenticated(Request $request, \App\Models\User $user)
    {
        $user->auditEvent = 'login';
        $user->isCustomEvent = true;
        $user->auditCustomOld = [];
        $user->auditCustomNew = ['ip' => $request->ip()];
        Event::dispatch(new AuditCustom($user));
    }

    public function logout(Request $request)
    {
        $user = $this->guard()->user();

        if ($user instanceof User) {
            $user->auditEvent = 'logout';
            $user->isCustomEvent = true;
            $user->auditCustomOld = [];
            $user->auditCustomNew = ['ip' => $request->ip()];
            Event::dispatch(new AuditCustom($user));
        }

        User::withoutAuditing(function () use ($request) {
            $this->guard()->logout();
            $request->session()->invalidate();
        });

        return redirect('/');
    }

    public function username()
    {
        return 'id';
    }

    public function credentials(\Illuminate\Http\Request $request)
    {
        $id = $request->get('id');
        $field = filter_var($id, FILTER_VALIDATE_EMAIL) ? 'email' : 'id';

        $credentials = array(
            $field => $request->get('id'),
            'password' => $request->get('password')
        );

        return $credentials;
    }
}
