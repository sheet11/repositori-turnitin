<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokumen;

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
        if(config('app.env') === 'production') {
            URL::forceScheme('https');
        }
            
        View::composer('layouts.operator', function ($view) {
            $pendingCount = Dokumen::where('status', 'Pending')
                ->whereNull('assigned_operator_id')
                ->count();
            $view->with('pendingCount', $pendingCount);
        });

        View::composer('layouts.mahasiswa', function ($view) {
            if (Auth::check()) {
                $notifDokumens = Dokumen::where('user_id', Auth::id())
                    ->whereIn('status', ['Sudah Dicek', 'Ditolak'])
                    ->orderBy('updated_at', 'desc')
                    ->get();
                $notifCount = $notifDokumens->count();
                
                $view->with(compact('notifDokumens', 'notifCount'));
            } else {
                $view->with('notifCount', 0)->with('notifDokumens', collect());
            }
        });
    }
}
