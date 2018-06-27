<?php
/*
Plugin Name: Ghoul YouTube
*/

function wporg_settings_init()
{
    // register a new setting for "reading" page
    register_setting('gh_yt_fields', 'gh_yt_setting_name');
 
    // register a new section in the "reading" page
    add_settings_section(
        'wporg_section_id',
        'GH YT Settings Section',
        'gh_yt_settings_section_cb',
        'gh_yt_sections'
    );
 
    // register a new field in the "wporg_settings_section" section, inside the "reading" page
    add_settings_field(
        'setting_id',
        'WPOrg Setting',
        'gh_yt_settings_field_cb',
        'gh_yt_sections',
        'wporg_section_id'
    );
}
 
/**
 * register wporg_settings_init to the admin_init action hook
 */
add_action('admin_init', 'wporg_settings_init');
 
/**
 * callback functions
 */
 
// section content cb
function gh_yt_settings_section_cb()
{
    echo '<p>WPOrg Section Introduction.</p>';
}
 
// field content cb
function gh_yt_settings_field_cb()
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('gh_yt_setting_name');
    // output the field
    ?>
    <input type="text" name="gh_yt_setting_name" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}

function gh_yt_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields('gh_yt_fields');
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections('gh_yt_sections');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

function gh_yt_options_page()
{
    add_menu_page(
        'GH YouTube',
        'GH YT Options',
        'manage_options',
        'gh-yt',
        'gh_yt_options_page_html',
       	'dashicons-video-alt3',
        20
    );
}
add_action('admin_menu', 'gh_yt_options_page');