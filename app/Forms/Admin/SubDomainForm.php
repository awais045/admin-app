<?php

namespace App\Forms\Admin;

use App\Models\Role;
use BalajiDharma\LaravelFormBuilder\Form;

class SubDomainForm extends Form
{
    protected $showFieldErrors = false;

    public function buildForm()
    {
        $roles = Role::all();
        $userHasRoles = [];

        if ($this->model) {
            $userHasRoles = array_column(json_decode($this->model->roles, true), 'name');
        }

        $this->add('name', 'text', [
            'label' => __('Client Name'),
        ]);

        $this->add('domain_name', 'text', [
            'label' => __('Domain Name'),
        ]);

        $this->add('subdomain', 'text', [
            'label' => __('Domain URL'),
            'value' => '',
        ]);
        $this->add('db_name', 'text', [
            'label' => __('Database Name'),
            'value' => '',
        ]);

        $this->add('is_active', 'checkbox', [
            'label' => __('Enabled'),
            'value' => 1,
            'default_value' => 1,
        ]);

        $submitLabel = __('Create');

        if ($this->model) {
            $submitLabel = __('Update');
        }

        $this->add('submit', 'submit', [
            'label' => $submitLabel,
        ]);
    }
}
