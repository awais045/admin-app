<?php

namespace BalajiDharma\LaravelAdminCore\Actions\MenuItem;

use BalajiDharma\LaravelAdminCore\Data\MenuItem\MenuItemCreateData;
use BalajiDharma\LaravelMenu\Models\Menu;

class MenuItemCreateAction
{
    public function handle(MenuItemCreateData $data, Menu $menu)
    {
        $item = $menu->menuItems()->create([
            'name' => $data->getName(),
            'uri' => $data->getUri(),
            'description' => $data->getDescription(),
            'enabled' => $data->getIsEnabled(),
            'parent_id' => $data->getParentId(),
            'weight' => $data->getWeight(),
            'icon' => $data->getIcon(),
        ]);

        $item->assignRole(array_map('intval', $data->getRoles()));

        return $item;
    }
}
