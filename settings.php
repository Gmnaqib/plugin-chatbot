<?php
defined('MOODLE_INTERNAL') || die();

$ADMIN->add(
    'blocksettings',
    new admin_externalpage(
        'blockchatbot',
        get_string('pluginname', 'block_chatbot'),
        new moodle_url('/admin/settings.php', ['section' => 'block_chatbot_settings'])
    )
);

if ($hassiteconfig) {
    $settings = new admin_settingpage('block_chatbot_settings', get_string('settings'));

    $settings->add(new admin_setting_heading(
        'block_chatbot/openai_header',
        get_string('openaisettings', 'block_chatbot'),
        get_string('openaisettings_desc', 'block_chatbot')
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'block_chatbot/apikey',
        get_string('apikey', 'block_chatbot'),
        get_string('apikey_desc', 'block_chatbot'),
        ''
    ));

    $ADMIN->add('block_chatbot_settings', $settings);
}
