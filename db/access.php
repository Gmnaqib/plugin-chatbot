<?php
$capabilities = array(
  'block/chatbot:addinstance' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_BLOCK,
    'archetypes' => array(
      'editingteacher' => CAP_ALLOW,
      'manager' => CAP_ALLOW
    ),
  ),
);
