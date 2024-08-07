<?php

namespace App\Providers;

use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::loginView(function () {
            return view('Auth.login');
        });


        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('username', $request->email)->orWhere('telephone', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if ($request->has('jenis_meja') && $request->has('kode_meja')) {
                    $user->kode_meja = $request->kode_meja;
                    $user->jenis_meja = $request->jenis_meja;
                    $user->save();
                } 
                return $user;
            }
        });

        // Fortify::registerView(function () {
        //     return view('auth.register');
        // });

        // Fortify::resetPasswordView(function (Request $request) {
        //     return view('auth.reset-password', ['request' => $request]);
        // });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            if (Auth::user()) {
                $user = User::where('username', Auth::user()->email)->orWhere('telephone', Auth::user()->email)->first();
                if ($request->has('jenis_meja') && $request->has('kode_meja')) {
                    $user->kode_meja = $request->kode_meja;
                    $user->jenis_meja = $request->jenis_meja;
                    $user->save();
                } 
            }
            return Limit::perMinute(5)->by($email.$request->ip());
        });

        // Fortify::requestPasswordResetLinkView(function () {
        //     return view('auth.forgot-password');
        // });

        // RateLimiter::for('two-factor', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->session()->get('login.id'));
        // });
    }
}
