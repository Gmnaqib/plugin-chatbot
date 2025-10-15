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

  // *** TAMBAHAN PENTING UNTUK DUKUNGAN MOBILE/DASHBOARD ***
  'block/chatbot:myaddinstance' => array(
    'captype' => 'write',
    'contextlevel' => CONTEXT_SYSTEM,
    'archetypes' => array(
      'user' => CAP_ALLOW // Izinkan pengguna untuk menambahkan ke Dashboard/My Home
    ),
    'clonepermissionsfrom' => 'moodle/my:manageblocks'
  ),
);
