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

        // Mendefinisikan path ke script.js
        // Lokasi relatif: classes/output/mobile.php adalah di blocks/chatbot/classes/output/
        // script.js berada di blocks/chatbot/
        $jsfile = __DIR__ . '/../../script.js';
        $jscontent = '';

        if (file_exists($jsfile)) {
            // Membaca konten script.js untuk diinjeksikan ke Moodle App
            $jscontent = file_get_contents($jsfile);
        }

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
            // Masukkan konten JavaScript yang telah dibaca di sini
            'javascript' => $jscontent,
            'otherdata' => $data
        ];
    }
}
