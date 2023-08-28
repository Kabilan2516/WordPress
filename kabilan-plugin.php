<?php

/*
 * Plugin Name:       My Basics Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

class WordCountPlugin
{
    function __construct()
    {
        add_action('admin_menu', array($this,'pluginSettings'));
        add_action('admin_init', array($this, 'settings'));
    }

    function settings()
    {
        add_settings_section('wcp_first_section',null,null,'settings-page');

        add_settings_field('Content_Location' ,'Display Location', array($this, 'locationHTML'),'settings-page','wcp_first_section');//build up html 
        register_setting('wordcountplugin', 'Content_Location',array('sanitize_callback'=> array($this, 'sanitizeLocation'), 'default' => '0'));

        add_settings_field('wcp_Headline' ,'Headline Text', array($this, 'headlineHTML'),'settings-page','wcp_first_section');//build up html 
        register_setting('wordcountplugin', 'wcp_Headline',array('sanitize_callback'=> 'sanitize_text_field', 'default' => 'Post Statistics'));

        add_settings_field('wcp_wordcount' ,' Word Count', array($this, 'checkboxHTML'),'settings-page','wcp_first_section',array('theName' => 'wcp_wordcount'));//build up html 
        register_setting('wordcountplugin', 'wcp_wordcount',array('sanitize_callback'=> 'sanitize_text_field', 'default' => '1'));

        add_settings_field('wcp_charactercount' ,' Character Count', array($this, 'checkboxHTML'),'settings-page','wcp_first_section', array('theName' => 'wcp_charactercount'));//build up html 
        register_setting('wordcountplugin', 'wcp_charactercount',array('sanitize_callback'=> 'sanitize_text_field', 'default' => '1'));

        add_settings_field('wcp_readtime' ,' Read Time', array($this, 'checkboxHTML'),'settings-page','wcp_first_section', array('theName' => 'wcp_readtime'));//build up html 
        register_setting('wordcountplugin', 'wcp_readtime',array('sanitize_callback'=> 'sanitize_text_field', 'default' => '1'));
    }

    function sanitizeLocation($input)
    {
        if($input != '0' && $input != '1')
        {
            add_settings_error('Content_Location', 'wcp_location_error', 'Display lcoation must be End or Begining');
            return get_option('Content_Location');
        }

        return $input;
        
    }

    function checkboxHTML($args)
    { ?>
        <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), '1')?>>
        <?php
    }

    function headlineHTML()
    {
        ?>
        <input type="text" name="wcp_Headline" value="<?php echo esc_attr(get_option('wcp_Headlinee')) ?>">
        <?php
    }

    function locationHTML()
    {
        ?>
        <select name="Content_Location" >
            <option value="0" <?php selected(get_option('Content_Location'), '0')?> >Begining post</option>
            <option value="1" <?php selected(get_option('Content_Location'), '1')?> >End Post</option>
        </select>
        <?php
    }

    function pluginSettings()
    {
        add_options_page('Word Settings', 'Word Count', 'manage_options', 'settings-page', array($this,'ChangeSomthing'));
    }

    function ChangeSomthing()
    { ?>
        <div class="wrap">
            <h1>hello i am hear can you see me me!</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('wordcountplugin');
                do_settings_sections('settings-page');
                submit_button();
                ?>

            </form>
        </div>
        
        <?php
    }
}

$wordCountPlugin = new WordCountPlugin();


?>