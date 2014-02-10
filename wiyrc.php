<?php

//Disallow direct Initialization for extra security.

    if(!defined("IN_MYBB"))
    {
        die("You Cannot Access This File Directly. Please Make Sure IN_MYBB Is Defined.");
    }

    $plugins->add_hook('reputation_do_add_start', 'wiyrc_global_start');

    function wiyrc_info()
    {
    return array(
            "name"  => "Where is your reputation comment?",
            "description"=> "Plugin force users to write a comment for reputation.",
            "website"        => "http://fluidsea.com",
            "author"        => "Jovan J.",
            "authorsite"    => "http://fluidsea.com",
            "version"        => "1.0",
            "guid"             => "",
            "compatibility" => "16*"
        );
    }

    function wiyrc_activate() {
    global $db;

    $wiyrc_group = array(
            'gid'    => 'NULL',
            'name'  => 'wiyrc',
            'title'      => 'Where is your reputation comment?',
            'description'    => 'Settings For Where is your reputation comment plugin.',
            'disporder'    => "1",
            'isdefault'  => "0",
        );
    $db->insert_query('settinggroups', $wiyrc_group);
     $gid = $db->insert_id();

    $wiyrc_setting = array(
            'sid'            => 'NULL',
            'name'        => 'wiyrc_enable',
            'title'            => 'Do you want to enable "Where is your reputation comment" plugin?',
            'description'    => 'If you set this option to yes, this plugin be active on your board.',
            'optionscode'    => 'yesno',
            'value'        => '1',
            'disporder'        => 1,
            'gid'            => intval($gid),
        );
    $db->insert_query('settings', $wiyrc_setting);
      rebuild_settings();
    }

    function wiyrc_deactivate()
      {
        global $db;
        $db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name IN ('wiyrc_enable')");
            $db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name='wiyrc'");
        rebuild_settings();
     }

    function wiyrc_global_start(){
    global $mybb;

        if(empty($mybb->input['comments'])) {

             error("Reputation comment is required.");
        }
    } 
?>
