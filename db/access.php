<?php
// blocks/chatbot/db/access.php

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
      'user' => CAP_ALLOW // Izinkan pengguna untuk menambahkan ke Dashboard/My Home
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
