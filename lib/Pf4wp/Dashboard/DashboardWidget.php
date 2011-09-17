<?php

/*
 * Copyright (c) 2011 Mike Green <myatus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pf4wp\Dashboard;

use Pf4wp\WordpressPlugin;

/**
 * DashboardWidget is a base class for adding Dashboard Widgets
 *
 * @author Mike Green <myatus@gmail.com>
 * @package Pf4wp
 * @subpackage Dashboard
 */
class DashboardWidget
{
    protected $name = '';
    protected $registered = false;
    protected $owner;

    /**
     * The title to display on the Dashboard Widget
     */
    protected $title = '';
       
    /**
     * Constructor
     *
     * @param WordpressPlugin $owner Owner of this dashboard widget
     * @param bool $auto_register Set to true if the widget can be registered immidiately during construct
     */
    public function __construct(WordpressPlugin $owner, $auto_register = true)
    {
        if (!is_admin())
            return;

        $this->owner = &$owner;
        $this->name = strtolower(preg_replace('/\W/', '-', get_class($this)));

        if ($auto_register === true)
            $this->register();
    }
    
    /**
     * Returns working name for the dashboard widget
     * 
     * @return string Working name of dashboard widget
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Registers the dashboard widget
     */
    public function register()
    {
        if (!is_admin() || $this->registered)
            return;
            
        wp_add_dashboard_widget($this->name, $this->title, array($this, 'onCallback'));
        
        $this->registered = true;
    }

    /**
     * Event called when the plugin contents need to be rendered
     */
    public function onCallback() {}
}