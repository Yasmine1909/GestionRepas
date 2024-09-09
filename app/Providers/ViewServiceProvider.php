<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('FrontOffice.layouts.app', function ($view) {
            $unreadCount = 0;

            if (Auth::check()) {
                $userId = Auth::id();
                $unreadCount = Notification::where('user_id', $userId)
                                           ->where('is_read', false)
                                           ->count();
            }

            $view->with('unreadCount', $unreadCount);
        });
    }

    public function register()
    {
        //
    }
}
