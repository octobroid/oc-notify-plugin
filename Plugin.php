<?php namespace Octobro\Notify;

use RainLab\User\Models\User;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Octobro\Notify\Components\Notifications' => 'notifications',
        ];
    }

    public function registerSettings()
    {
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('Notify', 'Octobro\Notify\Facades\Notify');
    }

    public function boot()
    {
        User::extend(function($model) {
            $model->hasMany['notifications'] = [
                'Octobro\Notify\Models\Notification',
                'key' => 'recipient_id',
            ];
        });
    }
}
