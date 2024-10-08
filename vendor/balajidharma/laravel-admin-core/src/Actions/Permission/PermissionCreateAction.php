<?php

namespace BalajiDharma\LaravelAdminCore\Actions\Permission;

use App\Models\Permission;
use BalajiDharma\LaravelAdminCore\Data\Permission\PermissionCreateData;

class PermissionCreateAction
{
    public function handle(PermissionCreateData $data): Permission
    {
        return Permission::create([
            'name' => $data->getName(),
        ]);
    }
}
