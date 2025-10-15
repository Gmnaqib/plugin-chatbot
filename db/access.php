<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(
  'block/chatbot:addinstance' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_BLOCK,
    'archetypes' => array(
      'editingteacher' => CAP_ALLOW,
      'manager' => CAP_ALLOW
    ),
  ),

  'block/chatbot:myaddinstance' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_SYSTEM,
    'archetypes' => array(
      'user' => CAP_ALLOW
    ),
    'clonepermissionsfrom' => 'moodle/my:manageblocks'
  ),

  'block/chatbot:view' => array(
    'captype' => 'read',
    'contextlevel' => CONTEXT_BLOCK,
    'archetypes' => array(
      'guest' => CAP_ALLOW,
      'user' => CAP_ALLOW,
      'student' => CAP_ALLOW,
      'teacher' => CAP_ALLOW,
      'editingteacher' => CAP_ALLOW,
      'manager' => CAP_ALLOW
    ),
  ),
);
