<?php
class block_chatbot extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_chatbot');
    }
  public function get_content()
  {
    global $PAGE, $OUTPUT;

    if ($this->content !== null) {
      return $this->content;
    }

    // echo "<script>console.log('Hello from the chatbot block');</script>";
    // Include the custom CSS file
    $PAGE->requires->css('/blocks/chatbot/styles.css');
    $PAGE->requires->js('/blocks/chatbot/script.js');
    $PAGE->requires->js('/blocks/chatbot/chat.js');


    $this->content = new stdClass;
    $course_id= $this->page->course->id;
    $data = ['title' => 'Welcome to the Moodle Chatbot!', 'course_id' => $course_id];
    $this->content->text = $OUTPUT->render_from_template('block_chatbot/block_chatbot', $data);
    return $this->content;
  }


}
