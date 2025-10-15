<?php
$functions = [
    'block_chatbot_mobile_view' => [ // Nama fungsi Web Service
        'classname' => 'block_chatbot\output\mobile', // Ganti dengan namespace dan class yang benar jika menggunakan classes/external/
        'methodname' => 'mobile_view',
        'classpath' => 'block/chatbot/classes/output/mobile.php', // Path ke file implementasi
        'description' => 'Returns the content of the chatbot block for mobile.',
        'type' => 'read',
        'ajax' => true,
    ],
];
