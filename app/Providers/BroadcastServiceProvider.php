<?php
namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Load the default broadcasting configuration
        $this->mergeConfigFrom(config_path('broadcasting.php'), 'broadcasting');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Retrieve Pusher settings from the database
        $pusherSettings = Setting::where('type', 'pusher')->pluck('value', 'key')->toArray();

        // Check if Pusher is enabled
        $pusherEnabled = !empty($pusherSettings['is_enabled']) && $pusherSettings['is_enabled'] === 'true';

        // Set the default broadcaster based on the Pusher settings
        config(['broadcasting.default' => $pusherEnabled ? 'pusher' : 'null']);

        // Configure Pusher connection settings
        if ($pusherEnabled) {
            config([
                'broadcasting.connections.pusher' => [
                    'driver' => 'pusher',
                    'key' => $pusherSettings['app_key'] ?? '',
                    'secret' => $pusherSettings['app_secret'] ?? '',
                    'app_id' => $pusherSettings['app_id'] ?? '',
                    'options' => [
                        'cluster' => $pusherSettings['app_cluster'] ?? '',
                        'host' => $pusherSettings['host'] ?? 'api-' . ($pusherSettings['app_cluster'] ?? 'mt1') . '.pusher.com',
                        'port' => $pusherSettings['port'] ?? 443,
                        'scheme' => $pusherSettings['scheme'] ?? 'https',
                        'encrypted' => true,
                        'useTLS' => ($pusherSettings['scheme'] ?? 'https') === 'https',
                    ],
                ],
            ]);
        }
    }
}
