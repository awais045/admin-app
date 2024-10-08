<?php

namespace BalajiDharma\LaravelAdminCore\Actions\Menu;

use BalajiDharma\LaravelAdminCore\Data\Menu\MenuCreateData;
use BalajiDharma\LaravelMenu\Models\Menu;

class MenuCreateAction
{
    public function handle(MenuCreateData $data): Menu
    {
        return Menu::create([
            'name' => $data->getName(),
            'machine_name' => $data->getMachineName(),
            'description' => $data->getDescription(),
        ]);
    }
}
