<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use App\Models\SiteInformation;
use App\Models\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

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
        // Load SMTP settings from database
        $this->loadSmtpSettings();

        // Share data with views based on view type (admin vs frontend)
        $this->shareViewData();
    }

    /**
     * Load SMTP settings from database and configure mail settings.
     */
    private function loadSmtpSettings(): void
    {
        try {
            $smtpSetting = SmtpSetting::getActive();

            if ($smtpSetting) {
                // Configure mail settings
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp', $smtpSetting->mail_config);
                Config::set('mail.from', $smtpSetting->from_config);
            }
        } catch (\Exception $e) {
            // Log error but don't break the application
            Log::error('SMTP settings could not be loaded: ' . $e->getMessage());
        }
    }

    /**
     * Share data with views based on view type (admin vs frontend).
     */
    private function shareViewData(): void
    {
        try {
            View::composer('*', function ($view) {
                $siteInformation = Cache::remember('frontend_site_information_global', 3600, function () {
                    return SiteInformation::first();
                });

                $globalServices = Cache::remember('frontend_services_global', 1800, function () {
                    return Service::active()->orderBy('name')->get();
                });

                // Check if this is an admin view
                $isAdminView = str_starts_with($view->getName(), 'admin.');

                if ($isAdminView) {
                    // For admin views, share site information and global services only
                    // Don't share 'services' to avoid conflicts with admin controller variables
                    $view->with([
                        'siteInformation' => $siteInformation,
                        'globalServices' => $globalServices
                    ]);
                } else {
                    // For frontend views, share everything including services
                    $view->with([
                        'siteInformation' => $siteInformation,
                        'services' => $globalServices,
                        'globalServices' => $globalServices
                    ]);
                }
            });
        } catch (\Exception $e) {
            // Log error but don't break the application
            Log::error('View data could not be loaded: ' . $e->getMessage());
        }
    }
}
