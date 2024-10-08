<?php

return [
    'default' => 'default',
    'forms' => [
        'default' => [

        ],
    ],
    'defaults' => [
        'wrapper_show' => true,
        'wrapper_class' => 'form-group',
        'wrapper_error_class' => 'has-error',
        'label_class' => 'control-label',
        'label_error_class' => '',
        'field_class' => 'form-control',
        'field_error_class' => '',
        'help_block_class' => 'help-block',
        'error_class' => 'text-danger',
        'required_class' => 'required',
        'help_block_tag' => 'p',

        // Override a class from a field.
        //'text'                => [
        //    'wrapper_class'   => 'form-field-text',
        //    'label_class'     => 'form-field-text-label',
        //    'field_class'     => 'form-field-text-field',
        //]
        //'radio'               => [
        //    'choice_options'  => [
        //        'wrapper'     => ['class' => 'form-radio'],
        //        'label'       => ['class' => 'form-radio-label'],
        //        'field'       => ['class' => 'form-radio-field'],
        //    ]
        //],
        //
        // 'choice'             => [
        //    'choice_options'  => [
        //        'wrapper_class'  => 'choice-wrapper-class',
        //        'label_class'    => 'choice-label-class',
        //        'field_class'    => 'choice-field-class'
        //        'choices_wrapper' => ['class' => 'choices-wrapper-class'],
        //        # For choice type you may overwrite default choice options for each variant (checkbox, radio or select)
        //        'checkbox'       => [
        //            'wrapper_class' => 'choice-checkbox-wrapper-class',
        //            'label_class'   => 'choice-checkbox-label-class',
        //            'field_class'   => 'choice-checkbox-field-class',
        //        ]
        //    ]
        //]

        // Templates
        'templates' => [
            'form' => 'laravel-form-builder::form',
            'text' => 'laravel-form-builder::text',
            'textarea' => 'laravel-form-builder::textarea',
            'button' => 'laravel-form-builder::button',
            'buttongroup' => 'laravel-form-builder::buttongroup',
            'radio' => 'laravel-form-builder::radio',
            'checkbox' => 'laravel-form-builder::checkbox',
            'select' => 'laravel-form-builder::select',
            'choice' => 'laravel-form-builder::choice',
            'repeated' => 'laravel-form-builder::repeated',
            'child_form' => 'laravel-form-builder::child_form',
            'collection' => 'laravel-form-builder::collection',
            'static' => 'laravel-form-builder::static',
        ],

        // Remove the laravel-form-builder:: prefix above when using template_prefix
        'template_prefix' => '',

        'default_namespace' => '',

        'custom_fields' => [
            //        'datetime' => App\Forms\Fields\Datetime::class
        ],
    ],
    'plain_form_class' => \BalajiDharma\LaravelFormBuilder\Form::class,
    'form_builder_class' => \BalajiDharma\LaravelFormBuilder\FormBuilder::class,
    'form_helper_class' => \BalajiDharma\LaravelFormBuilder\FormHelper::class,
];
