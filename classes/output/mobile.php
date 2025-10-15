<?php

namespace block_chatbot\output;

defined('MOODLE_INTERNAL') || die();

// Hapus baris use external_api; untuk menghindari konflik.
use core_external\external_function_parameters;
// Hapus baris use external_value; untuk menghindari konflik.
use context_block;
use context_course;
use context_system;
use block_chatbot\block_chatbot;

// MENGGUNAKAN FULL NAMESPACE UNTUK MENGHINDARI KONFLIK
class mobile extends \core_external\external_api
{
    /**
     * Mengembalikan parameter eksternal untuk mobile_view.
     * Menggunakan \external_value dan konstanta global.
     *
     * @return external_function_parameters
     */
    public static function mobile_view_parameters()
    {
        return new external_function_parameters([
            // Menggunakan backslash (\) untuk mengakses konstanta global
            new \external_value(\external_value::TYPE_INT, 'The course id for the context.', \VALUE_DEFAULT, 0)
        ]);
    }

    /**
     * Mengembalikan struktur output untuk mobile_view
     * Menggunakan \external_value dan konstanta global.
     *
     * @return \external_value
     */
    public static function mobile_view_returns()
    {
        // Menggunakan backslash (\) untuk mengakses konstanta global
        return new \external_value(\external_value::TYPE_OBJECT, 'Block content for mobile', [
            'templates' => new \external_value(\external_value::TYPE_ARRAY, 'Block templates', false, null, new \external_value(\external_value::TYPE_OBJECT)),
            'javascript' => new \external_value(\external_value::TYPE_STRING, 'Javascript to run', false, ''),
            'otherdata' => new \external_value(\external_value::TYPE_OBJECT, 'Other data', false, null)
        ]);
    }

    /**
     * Mengembalikan konten blok untuk Moodle Mobile App
     *
     * @param int $courseid ID kursus (0 untuk konteks sistem/My home).
     * @return array
     */
    public static function mobile_view($courseid = 0)
    {
        global $OUTPUT;

        // Validasi dan pemeriksaan kapabilitas dengan konteks yang benar.
        self::validate_parameters(self::mobile_view_parameters(), ['courseid' => $courseid]);

        // Tentukan konteks: kursus atau sistem
        if ($courseid > 0) {
            $context = \context_course::instance($courseid, \MUST_EXIST);
        } else {
            // Untuk My home/Dasbor (Sistem)
            $context = \context_system::instance();
        }

        // Pemeriksaan izin: pengguna harus bisa melihat blok di konteks ini.
        require_capability('moodle/block:view', $context);

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
