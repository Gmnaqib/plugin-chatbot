<?php
// blocks/chatbot/classes/output/mobile.php

namespace block_chatbot\output;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/externallib.php');

// Ensure we have the required context classes
require_once($CFG->libdir . '/accesslib.php');

/**
 * Mobile API functions for the chatbot block
 */
class mobile extends \external_api
{
    /**
     * Describes the parameters for mobile_view.
     *
     * @return \external_function_parameters
     */
    public static function mobile_view_parameters()
    {
        return new \external_function_parameters([
            'courseid' => new \external_value(PARAM_INT, 'Course ID', VALUE_DEFAULT, 0)
        ]);
    }

    /**
     * Describes the return value for mobile_view.
     *
     * @return \external_single_structure
     */
    public static function mobile_view_returns()
    {
        return new \external_single_structure([
            'templates' => new \external_multiple_structure(
                new \external_single_structure([
                    'id' => new \external_value(PARAM_TEXT, 'Template ID'),
                    'html' => new \external_value(PARAM_RAW, 'Template HTML content')
                ]),
                'List of templates'
            ),
            'javascript' => new \external_value(PARAM_RAW, 'JavaScript code', VALUE_OPTIONAL, ''),
            'otherdata' => new \external_value(PARAM_RAW, 'Additional data', VALUE_OPTIONAL, '{}')
        ]);
    }

    /**
     * Returns the chatbot block content for mobile app.
     *
     * @param int $courseid Course ID
     * @return array Block content
     */
    public static function mobile_view($courseid = 0)
    {
        global $OUTPUT, $CFG, $USER;

        // Validate parameters
        $params = self::validate_parameters(self::mobile_view_parameters(), ['courseid' => $courseid]);
        $courseid = $params['courseid'];

        // Basic security check
        if (!$USER || !$USER->id) {
            return [
                'templates' => [
                    [
                        'id' => 'main',
                        'html' => '<div class="alert alert-warning">Please log in to access the chatbot.</div>',
                    ],
                ],
                'javascript' => '',
                'otherdata' => '{}'
            ];
        }

        // Determine context
        if ($courseid > 0) {
            try {
                $context = \context_course::instance($courseid, MUST_EXIST);
                \require_capability('moodle/course:view', $context);
            } catch (\Exception $e) {
                // If course access fails, use system context
                $context = \context_system::instance();
            }
        } else {
            $context = \context_system::instance();
        }

        // Load JavaScript content
        $jsfile = $CFG->dirroot . '/blocks/chatbot/script.js';
        $jscontent = '';
        if (file_exists($jsfile)) {
            $jscontent = file_get_contents($jsfile);
        }

        // Prepare template data
        $data = [
            'title' => 'Chatbot',
            'welcomemessage' => 'Welcome to the Moodle Chatbot!',
            'courseid' => $courseid
        ];

        // Try to render template, with fallback
        try {
            $html = $OUTPUT->render_from_template('block_chatbot/block_chatbot', $data);
        } catch (\Exception $e) {
            // Fallback HTML with inline styles
            $html = '<div class="block-chatbot-mobile" style="padding: 15px; border: 1px solid #ddd; border-radius: 8px;">';
            $html .= '<h3 style="color: #0A62A9; margin-bottom: 10px;">' . htmlspecialchars($data['title']) . '</h3>';
            $html .= '<p style="margin-bottom: 15px;">' . htmlspecialchars($data['welcomemessage']) . '</p>';
            $html .= '<div id="chatbot-container" style="background: white; padding: 10px; border-radius: 5px;">';
            $html .= '<div class="chatbot-messages" style="min-height: 200px; border: 1px solid #eee; padding: 10px; margin-bottom: 10px;"></div>';
            $html .= '<div style="display: flex; gap: 5px;">';
            $html .= '<input type="text" id="chatbot-input" placeholder="Type your message..." style="flex: 1; padding: 8px; border: 1px solid #ddd;">';
            $html .= '<button id="chatbot-send" style="padding: 8px 15px; background: #0A62A9; color: white; border: none; cursor: pointer;">Send</button>';
            $html .= '</div></div></div>';
        }

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
