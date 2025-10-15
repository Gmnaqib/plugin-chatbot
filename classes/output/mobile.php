<?php

namespace block_chatbot\output;

defined('MOODLE_INTERNAL') || die();

use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;

class mobile extends external_api
{

    public static function mobile_view_parameters()
    {
        return new external_function_parameters([]);
    }

    public static function mobile_view()
    {
        global $OUTPUT;

        $data = [
            'title' => 'Welcome to the Moodle Chatbot (Mobile)!',
        ];

        // Render Mustache template yang sama
        $html = $OUTPUT->render_from_template('block_chatbot/block_chatbot', $data);

        return [
            'templates' => [
                [
                    'id' => 'main',
                    'html' => $html,
                ],
            ],
            'javascript' => '',
            'otherdata' => $data
        ];
    }
}
