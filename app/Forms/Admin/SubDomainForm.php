<?php

namespace App\Forms\Admin;

use App\Models\Role;
use BalajiDharma\LaravelFormBuilder\Form;

class SubDomainForm extends Form
{
    protected $showFieldErrors = true;

    public function buildForm()
    {

        $this->add('name', 'text', [
            'label' => __('Client Name *'),
            'value' => '',
        ]);
        $this->add('subdomain', 'text', [
            'label' => __('Domain Name *'),
            'value' => '',
            'pattern' => '^[a-zA-Z0-9]+$',
            'title' => "Domain name must be a single word without spaces or special characters.",
        ]);
        $this->add('domain_name', 'text', [
            'label' => __('Domain URL *'),
            'value' => '',
        ]);
        $this->add('subdomain_type', 'select', [
            'label' => __('Domain Type *'),
            'choices' => [
                'local' => 'Internal',
                'remote' => 'External',
            ],
            'value' => '',
        ]);

        // $this->add('domain_dns1', 'text', [
        //     'label' => __('Domain DNS1'),
        //     'value' => '',
        //     'attributes' => ['id' => 'domain_dns1'], // For JS handling
        // ]);

        // $this->add('domain_dns2', 'text', [
        //     'label' => __('Domain DNS2'),
        //     'value' => '',
        //     'attributes' => ['id' => 'domain_dns2'], // For JS handling
        // ]);

        $this->add('db_name', 'text', [
            'label' => __('Database Name *'),
            'value' => '',
        ]);

        $this->add('db_type', 'select', [
            'label' => __('Database Type *'),
            'choices' => [
                'local' => 'Local',
                'remote' => 'Remote',
            ],
            'value' => 'local',
        ]);

        $this->add('hostname', 'text', [
            'label' => __('Host Name'),
            // 'value' => 'hostname',
            'attributes' => ['id' => 'hostname'], // For JS handling
        ]);

        $this->add('db_user', 'text', [
            'label' => __('Database User'),
            // 'value' => 'db_user',
            'attributes' => ['id' => 'db_user'], // For JS handling
        ]);

        $this->add('db_password', 'text', [
            'label' => __('Database Password'),
            // 'value' => 'db_password',
            'attributes' => ['id' => 'db_password'], // For JS handling
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
