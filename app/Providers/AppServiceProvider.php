<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Cabang;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share data cabang ke semua view
        View::composer('layouts.sidebar', function ($view) {
            $user = Auth::user();

            $cabangs = match (true) {
                $user && $user->role === 'cabang' && $user->cabang_id
                    => Cabang::where('id', $user->cabang_id)->get(),
                default => Cabang::orderBy('nama_cabang')->get(),
            };

            $view->with('cabangs', $cabangs);
        });
    }
}
