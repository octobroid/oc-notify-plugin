<?php namespace Octobro\Notify\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Notifications Back-end Controller
 */
class Notifications extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Octobro.Notify', 'notifications', 'notifications');
    }
}
