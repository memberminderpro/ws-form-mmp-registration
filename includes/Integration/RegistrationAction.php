<?php

namespace Mmpro\WSFormRegistration\Integration;

defined('ABSPATH') || exit;

class RegistrationAction {

    public $id    = 'mmp_registration';
    public $label = 'MMP Registration';

    public function __construct() {
        add_filter('wsf_action_list', [ $this, 'register_action' ]);
        add_filter('wsf_action_config_options', [ $this, 'config_options' ], 10, 2);
    }

    public function register_action($actions) {
        $actions[$this->id] = [
            'label' => $this->label,
            'class' => get_class($this)
        ];
        return $actions;
    }

    public function config_options($options, $form_id) {
        $options['action_' . $this->id] = [
            'label' => $this->label,
            'fields' => [
                'action_' . $this->id . '_version' => [
                    'label' => 'Addon Version',
                    'type'  => 'static',
                    'default' => '0.0.1'
                ],
                'action_' . $this->id . '_dacdb_status' => [
                    'label' => 'DACdbPlus Status',
                    'type'  => 'static',
                    'default' => class_exists('Mmpro\\DACdbPlus\\Core') ? '✅ Detected' : '❌ Not detected'
                ],
                'action_' . $this->id . '_account_id_override' => [
                    'label' => 'Manual AccountID Override',
                    'type'  => 'text',
                    'default' => '',
                    'help' => 'Optional: use this AccountID instead of detecting it from DACdbPlus.'
                ]
            ]
        ];
        return $options;
    }
}
