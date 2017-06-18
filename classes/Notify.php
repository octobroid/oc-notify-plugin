<?php namespace Octobro\Notify\Classes;

use Event;
use SystemException;
use RainLab\User\Models\User;
use Octobro\Notify\Models\Template;
use Octobro\Notify\Models\Notification;

class Notify
{
    use \October\Rain\Support\Traits\Emitter;

    public function sendTo(User $recipient, $options)
    {
        if (
            ($this->fireEvent('notify.beforeSend', [$recipient, $options], true) === false) ||
            (Event::fire('notify.beforeSend', [$this, $recipient, $options], true) === false)
        ) {
            return;
        }

        if (is_array($options)) {

            if (! isset($options['content']) && ! isset($options['template'])) {
                throw new SystemException('Template not set');
            }

            $template = Template::whereCode($options['template'])->first();

            if (! $template) {
                throw new SystemException('Template \'%s\' not found', $options['template']);
            }

            $options['template'] = $template;
        } else {
            $options = [];
            $options['content'] = (string) $options;
        }

        /*
        * Extensibility
        */
        if (
            ($this->fireEvent('notify.beforeSend', [$recipient, $options], true) === false) ||
            (Event::fire('notify.beforeSend', [$this, $recipient, $options], true) === false)
        ) {
            return;
        }

        /*
         * Send notification
         */
        $notification = Notification::make([
            'recipient' => $recipient,
        ]);
        $notification->fill($options);
        $notification->save();

        /*
         * Extensibility
         */
        $this->fireEvent('notify.send', [$recipient, $options, $notification]);
        Event::fire('notify.send', [$this, $recipient, $options, $notification]);

        return $notification;
    }
}
