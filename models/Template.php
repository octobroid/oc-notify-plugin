<?php namespace Octobro\Notify\Models;

use Ini;
use Twig;
use Model;
use Cms\Classes\Page;

/**
 * Template Model
 */
class Template extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'octobro_notify_templates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'notifications' => [
            'Octobro\Notify\Models\Notification',
            'key' => 'code',
            'otherKey' => 'template_code',
        ],
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function parseTitle($data)
    {
        if (! $this->content) return null;

        $data = $this->parseData($data);

        return Twig::parse($this->title, $data);
    }

    public function parseContent($data)
    {
        if (! $this->content) return null;

        $data = $this->parseData($data);

        return Twig::parse($this->content, $data);
    }

    public function parseLinkUrl($data)
    {
        if (! $this->link_page) return null;

        $data = $this->parseData($data);

        $data = Ini::parse(Twig::parse($this->link_data, $data));

        return Page::url($this->link_page, $data);
    }

    public function parseData($data)
    {
        $properties = Ini::parse($this->properties);

        if (! is_array($properties)) return $data;

        foreach ($data as $key => $value) {
            if (! isset($properties[$key])) continue;

            $property = $properties[$key];

            $data[$key] = isset($property['class']) ? $property['class']::find($value) : $value;
        }

        return $data;
    }
}
