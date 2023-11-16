<?php

namespace Acme\FlowEditor;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class FlowEditor extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('flow-editor', __DIR__.'/../dist/js/flow.js');
        Nova::style('flow-editor', __DIR__.'/../dist/css/flow.css');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::make('Flow Editor')
            ->path('/flow-editor')
            ->icon('server');
    }
}
