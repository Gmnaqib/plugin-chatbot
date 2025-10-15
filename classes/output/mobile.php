<?php
// blocks/chatbot/classes/output/mobile.php

namespace block_chatbot\output;

defined('MOODLE_INTERNAL') || die();

use core_external\external_function_parameters;
// Hapus use external_value; dan external_api; untuk menghindari konflik

class mobile extends \core_external\external_api // Menggunakan Full Namespace untuk kelas induk
{
    /**
     * Mendefinisikan parameter input Web Service (wajib ada courseid).
     */
    public static function mobile_view_parameters()
    {
        return new \external_function_parameters([
            // Menggunakan backslash (\) untuk mengakses kelas dan konstanta global
            new \external_value(\external_value::TYPE_INT, 'The course id for the context.', \VALUE_DEFAULT, 0)
        ]);
    }

    /**
     * Mendefinisikan struktur output Web Service.
     */
    public static function mobile_view_returns()
    {
        // Menggunakan backslash (\) untuk mengakses kelas dan konstanta global
        return new \external_single_structure([
            'templates' => new \external_multiple_structure(
                new \external_single_structure([
                    'id' => new \external_value(\PARAM_TEXT, 'Template id'),
                    'html' => new \external_value(\PARAM_RAW, 'Template HTML')
                ]),
                'Block templates'
            ),
            'javascript' => new \external_value(\PARAM_RAW, 'Javascript to run', \VALUE_OPTIONAL, ''),
            'otherdata' => new \external_value(\PARAM_RAW, 'Other data', \VALUE_OPTIONAL, '{}')
        ]);
    }

    /**
     * Mengembalikan konten blok untuk Moodle Mobile App
     */
    public static function mobile_view($courseid = 0)
    {
        global $OUTPUT, $CFG;

        // Validasi parameter
        $params = self::validate_parameters(self::mobile_view_parameters(), ['courseid' => $courseid]);
        $courseid = $params['courseid'];

        // Tentukan konteks: kursus atau sistem
        if ($courseid > 0) {
            $context = \context_course::instance($courseid, \MUST_EXIST);
        } else {
            // Untuk My home/Dasbor (Sistem)
            $context = \context_system::instance();
        }

        // Pemeriksaan izin
        require_capability('moodle/block:view', $context);

        // --- 2. MUAT FUNGSI CHAT (JavaScript) ---
        // Menggunakan $CFG->dirroot untuk mendapatkan path absolut
        $jsfile = $CFG->dirroot . '/blocks/chatbot/script.js';
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
            'javascript' => $jscontent,
            'otherdata' => json_encode($data)
        ];
    }
}
