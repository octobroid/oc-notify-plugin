<?php namespace Octobro\Notify\Components;

use Auth;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;

class Notifications extends ComponentBase
{
    public $count;
    public $notifications;

    public function componentDetails()
    {
        return [
            'name'        => 'Notifications Component',
            'description' => 'Display user notifications'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $user = Auth::getUser();

        if (! $user) return;

        if ($notifId = get('notif_id')) {
            $user->notifications()->whereId($notifId)->whereNull('viewed_at')->update(['viewed_at' => Carbon::now()]);
        }

        $this->count = $user->notifications()->unread()->count();
        $this->notifications = $user->notifications()->with('template')->orderBy('created_at', 'desc')->paginate(15);
    }

    public function onLoad()
    {
        //
    }

    public function onRead()
    {
        //
    }

    public function onReadAll()
    {
        $user = Auth::getUser();

        if (! $user) return;

        $user->notifications()->unread()->update(['read_at' => Carbon::now()]);
    }

    public function onUnread()
    {
        //
    }

}
