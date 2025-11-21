<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ContentSection;
use App\Models\SiteSetting;
use App\Models\Mua;
use App\Models\MuaService;

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
        // Share published content sections with all front views so templates can
        // render CMS-managed sections without needing controller changes.
        View::composer('front.*', function ($view) {
            $contents = ContentSection::with('details')
                ->where('status', 'publish')
                ->orderBy('order', 'asc')
                ->get();

            // site settings (first row) - used for site name, logo, contact, etc.
            $siteSetting = SiteSetting::first();

            // top MUAs (by rating) with services and portfolios to render on front pages
            $topMuas = Mua::with(['services' => function ($q) {
                // mua_services table uses 'price' column
                $q->orderBy('price');
            }, 'portfolios'])
                ->orderByDesc('rating')
                ->take(6)
                ->get();

            // featured services list (for front cards) based on MuaService data
            $featuredServices = MuaService::with(['mua.rel_city', 'portfolios'])
                ->whereHas('mua')
                ->orderBy('price')
                ->take(12)
                ->get();

            $view->with(compact('contents', 'siteSetting', 'topMuas', 'featuredServices'));
        });
    }
}
