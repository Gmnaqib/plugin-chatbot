<?php

namespace block_chatbot\output;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/externallib.php');

/**
 * Class mobile untuk mendukung Moodle Mobile App
 */
class mobile extends \external_api
{
    /**
     * Parameters definition for mobile_view function
     *
     * @return \external_function_parameters
     */
    public static function mobile_view_parameters()
    {
        return new \external_function_parameters([
            'courseid' => new \external_value(PARAM_INT, 'The course id for the context.', VALUE_DEFAULT, 0)
        ]);
    }

    /**
     * Returns definition for mobile_view function
     *
     * @return \external_single_structure
     */
    public static function mobile_view_returns()
    {
        return new \external_single_structure([
            'templates' => new \external_multiple_structure(
                new \external_single_structure([
                    'id' => new \external_value(PARAM_TEXT, 'Template id'),
                    'html' => new \external_value(PARAM_RAW, 'Template HTML')
                ]),
                'Block templates'
            ),
            'javascript' => new \external_value(PARAM_RAW, 'Javascript to run', VALUE_OPTIONAL, ''),
            'otherdata' => new \external_value(PARAM_RAW, 'Other data', VALUE_OPTIONAL, '{}')
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
        global $OUTPUT, $CFG, $USER;

        // Validate parameters
        $params = self::validate_parameters(self::mobile_view_parameters(), ['courseid' => $courseid]);
        $courseid = $params['courseid'];

        // Basic security - user must be logged in
        if (!$USER || !$USER->id) {
            return [
                'templates' => [
                    [
                        'id' => 'main',
                        'html' => '<div class="alert alert-warning">Please log in to use the chatbot.</div>',
                    ],
                ],
                'javascript' => '',
                'otherdata' => '{}'
            ];
        }

        // --- 2. MUAT FUNGSI CHAT (JavaScript) ---
        $jsfile = $CFG->dirroot . '/blocks/chatbot/script.js';
        $jscontent = '';

        if (file_exists($jsfile)) {
            $jscontent = file_get_contents($jsfile);
        }

        // --- 3. RENDER KONTEN ---
        // Use simple title fallback
        $title = 'Chatbot';

        $data = [
            'title' => $title,
            'welcomemessage' => 'Welcome to the Moodle Chatbot (Mobile)!',
            'courseid' => $courseid
        ];

        // Coba render template, jika gagal gunakan HTML sederhana
        try {
            $html = $OUTPUT->render_from_template('block_chatbot/block_chatbot', $data);
        } catch (\Exception $e) {
            // Fallback jika template tidak ditemukan - dengan styling yang lebih baik
            $html = '<div class="block-chatbot-mobile" style="padding: 15px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">';
            $html .= '<h3 style="color: #0A62A9; margin-bottom: 10px;">' . htmlspecialchars($data['title']) . '</h3>';
            $html .= '<p style="margin-bottom: 15px;">' . htmlspecialchars($data['welcomemessage']) . '</p>';
            $html .= '<div id="chatbot-container" style="background: white; padding: 10px; border-radius: 5px;">';
            $html .= '<div class="chatbot-messages" style="min-height: 200px; border: 1px solid #eee; padding: 10px; margin-bottom: 10px; border-radius: 5px;"></div>';
            $html .= '<div style="display: flex; gap: 5px;">';
            $html .= '<input type="text" id="chatbot-input" placeholder="Type your message..." style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 3px;">';
            $html .= '<button id="chatbot-send" style="padding: 8px 15px; background: #0A62A9; color: white; border: none; border-radius: 3px; cursor: pointer;">Send</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return [
            'templates' => [
                [
                    'id' => 'main',
                    'html' => $html,
                ],
            ],
            // Masukkan JavaScript yang telah dimuat
            'javascript' => $jscontent,
            'otherdata' => json_encode($data)
        ];
    }
}
