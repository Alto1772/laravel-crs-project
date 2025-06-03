<?php

namespace App\View\Composers;

use Illuminate\View\View;

class SidebarMenuComposer
{
    protected $sidebarMenuPaths = [
        'userMenuData' => 'resources/menus/userMenus.json',
        'adminMenuData' => 'resources/menus/adminMenus.json',
    ];

    public function compose(View $view): void
    {
        foreach ($this->sidebarMenuPaths as $key => $path) {
            $view->with($key, json_decode(file_get_contents(base_path($path))));
        }
    }
}
