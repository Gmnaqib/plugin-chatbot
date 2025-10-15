<?php

namespace block_chatbot\output;

defined('MOODLE_INTERNAL') || die();

use external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use context_block; // Wajib diimpor untuk mendapatkan konteks blok
use block_chatbot\block_chatbot; // Impor kelas utama blok

class mobile extends external_api
{
    /**
     * Mengembalikan parameter eksternal untuk mobile_view
     *
     * @return external_function_parameters
     */
    public static function mobile_view_parameters()
    {
        return new external_function_parameters([]);
    }

    /**
     * Mengembalikan struktur output untuk mobile_view
     *
     * @return external_value
     */
    public static function mobile_view_returns()
    {
        return new external_value(external_value::TYPE_OBJECT, 'Block content for mobile', [
            'templates' => new external_value(external_value::TYPE_ARRAY, 'Block templates', false, null, new external_value(external_value::TYPE_OBJECT)),
            'javascript' => new external_value(external_value::TYPE_STRING, 'Javascript to run', false, ''),
            'otherdata' => new external_value(external_value::TYPE_OBJECT, 'Other data', false, null)
        ]);
    }

    /**
     * Mengembalikan konten blok untuk Moodle Mobile App
     *
     * @return array
     */
    public static function mobile_view()
    {
        global $OUTPUT;

        // --- 1. PEMERIKSAAN KAPABILITAS (Wajib) ---
        // Mendapatkan konteks sistem (karena blok dapat berada di mana saja).
        $context = context_block::instance(0);

        // Pemeriksaan izin untuk melihat blok. 
        // Anda harus menggunakan kapabilitas yang benar dari db/access.php.
        // Jika db/access.php Anda mendefinisikan 'block/chatbot:view', gunakan itu.
        require_capability('moodle/block:view', $context);
        // Jika blok Anda memiliki kapabilitas khusus, ganti 'moodle/block:view' dengan 'block/chatbot:view'

        // --- 2. MUAT FUNGSI CHAT (JavaScript) ---
        $jsfile = __DIR__ . '/../../script.js';
        $jscontent = '';

        if (file_exists($jsfile)) {
            $jscontent = file_get_contents($jsfile);
        }

        // --- 3. RENDER KONTEN ---
        $data = [
            'title' => 'Welcome to the Moodle Chatbot (Mobile)!',
        ];

        $html = $OUTPUT->render_from_template('block_chatbot/block_chatbot', $data);

        return [
            'templates' => [
                [
                    'id' => 'main',
                    'html' => $html,
                ],
            ],
            // Masukkan JavaScript yang telah dimuat
            'javascript' => $jscontent,
            'otherdata' => $data
        ];
    }
}
