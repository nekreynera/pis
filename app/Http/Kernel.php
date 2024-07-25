<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\LogLastUserActivity::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'register' => \App\Http\Middleware\RegisterAuth::class,
        'admin' => \App\Http\Middleware\AdminAuth::class,
        'triage' => \App\Http\Middleware\TriageAuth::class,
        'mss' => \App\Http\Middleware\MssAuth::class,
        'pharmacist' => \App\Http\Middleware\PharmacyAuth::class,
        'receptions' => \App\Http\Middleware\ReceptionsAuth::class,
        'patients' => \App\Http\Middleware\PatientsAuth::class,
        'cashier' => \App\Http\Middleware\CashierAuth::class,
        'doctors' => \App\Http\Middleware\DoctorsAuth::class,
        'clerk' => \App\Http\Middleware\ClerkAuth::class,
        'radiology' => \App\Http\Middleware\RadiologyAuth::class,
        'referral' => \App\Http\Middleware\ReferralAuth::class,
        'medicalrecord' => \App\Http\Middleware\MedicalrecordAuth::class,
        'malasakit' => \App\Http\Middleware\MalasakitAuth::class,
        'laboratory' => \App\Http\Middleware\LaboratoryAuth::class,
    ];
}
