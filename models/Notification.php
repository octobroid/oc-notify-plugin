<?php namespace Octobro\Notify\Models;

use Model;
use Carbon\Carbon;

/**
 * Notification Model
 */
class Notification extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'octobro_notify_notifications';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Protected Dates
     */
    protected $dates = ['created_at','read_at','viewed_at'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    protected $jsonable = ['data'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'recipient' => 'RainLab\User\Models\User',
        'template' => [
            'Octobro\Notify\Models\Template',
            'key' => 'template_code',
            'otherKey' => 'code',
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [
        'from' => [],
        'related' => [],
    ];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'images' => 'System\Models\File',
    ];

    public function scopeUnread($query)
    {
        return $query->whereReadAt(null);
    }

    public function isRead()
    {
        return $this->read_at ? true : false;
    }

    public function isViewed()
    {
        return $this->viewed_at ? true : false;
    }

    public function read()
    {
        $this->update(['read_at' => Carbon::now()]);
    }

    public function unread()
    {
        $this->update(['read_at' => null]);
    }

    public function view()
    {
        $this->update(['viewed_at' => Carbon::now()]);
    }

    public function unview()
    {
        $this->update(['viewed_at' => null]);
    }

    public function getTitleAttribute($value)
    {
        if ($this->template) {
            $data = $this->prepareData($this->data);
            return $this->template->parseTitle($data);
        }

        return $value;
    }

    public function getContentAttribute($value)
    {
        if ($this->template) {
            $data = $this->prepareData($this->data);
            return $this->template->parseContent($data);
        }

        return $value;
    }

    public function getLinkUrlAttribute($value)
    {
        $append = '?rel=notif&notif_id=' . $this->id;

        if ($this->template) {
            $data = $this->prepareData($this->data);
            return $this->template->parseLinkUrl($data) . $append;
        }

        return $value . $append;
    }

    public function prepareData($data)
    {
        $data['from'] = $this->from;
        $data['related'] = $this->related;

        return $data;
    }
}
