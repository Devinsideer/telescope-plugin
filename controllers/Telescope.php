<?php namespace Devinside\Telescope\Controllers;

use Backend\Classes\Controller;
use Backend\Classes\NavigationManager;

class Telescope extends Controller
{
    public $requiredPermissions = ['devinside.telescope.access'];

    public function __construct()
    {
        parent::__construct();

        NavigationManager::instance()->setContext('Devinside.Telescope', 'telescope', 'telescope');
    }

    public function index()
    {
        $this->pageTitle = 'Telescope dashboard';
    }
}
