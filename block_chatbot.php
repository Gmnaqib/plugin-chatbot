<?php
defined('MOODLE_INTERNAL') || die();
$string['pluginname'] = 'Chatbot';
$string['settings'] = 'Chatbot Settings';
$string['openaisettings'] = 'OpenAI Integration';
$string['openaisettings_desc'] = 'Configuration for OpenAI API integration';
$string['apikey'] = 'API Key';
$string['apikey_desc'] = 'Enter your OpenAI API key (starts with sk-...)';

$string['chatbot:addinstance'] = 'Add a new Chatbot block';
$string['chatbot:myaddinstance'] = 'Add a new Chatbot block to the Dashboard';

class block_chatbot extends block_base
{

  public function init()
  {
    $this->title = get_string('pluginname', 'block_chatbot');
  }

  public function get_content()
  {
    global $PAGE, $OUTPUT;

    if ($this->content !== null) {
      return $this->content;
    }

    // Load CSS dan JS (untuk tampilan web)
    $PAGE->requires->css('/blocks/chatbot/styles.css');
    $PAGE->requires->js('/blocks/chatbot/script.js');

    // Data untuk template
    $course_id = $this->page->course->id ?? 0;
    $data = [
      'title' => 'Welcome to the Moodle Chatbot!',
      'course_id' => $course_id
    ];

    // Render template mustache
    $this->content = new stdClass();
    $this->content->text = $OUTPUT->render_from_template('block_chatbot/block_chatbot', $data);
    $this->content->footer = '';

    return $this->content;
  }

  /**
   * Mendeklarasikan dukungan untuk Moodle Mobile App.
   */
  public function supports_mobile()
  {
    return [
      'handler' => [
        'name' => 'chatbot',
        'method' => 'mobile_view',
        'offlinefunctions' => [],
      ],
      'displaydata' => [
        'title' => get_string('pluginname', 'block_chatbot'),
        'icon' => 'i/chat',
      ],
    ];
  }
}
