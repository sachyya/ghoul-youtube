<?php
/*
Plugin Name: Ghoul YouTube
*/

function gh_yt_settings_init()
{
    // register a new setting for "reading" page
    register_setting( 'gh_yt_fields', 'gh_yt_client_id', 'sanitize_text_field' );
    register_setting( 'gh_yt_fields', 'gh_yt_secret_key', 'sanitize_text_field' );
 
    // register a new section in the "reading" page
    add_settings_section(
        'gh_yt_section_id',
        'GH YouTube Settings',
        'gh_yt_settings_section_cb',
        'gh_yt_sections'
    );
 
    // register a new field in the "wporg_settings_section" section, inside the "reading" page
    add_settings_field(
        'gh_yt_api_key_field',
        'API Key',
        'gh_yt_api_key_cb',
        'gh_yt_sections',
        'gh_yt_section_id'
    );
}
 
/**
 * register gh_yt_settings_init to the admin_init action hook
 */
add_action('admin_init', 'gh_yt_settings_init');
 
/**
 * callback functions
 */
 
// section content cb
function gh_yt_settings_section_cb()
{
    echo '<p>Input your Google API key here:</p>';
}
 
// field content cb
function gh_yt_api_key_cb()
{
    // get the value of the setting we've registered with register_setting()
    $client_id = get_option('gh_yt_client_id');
    $secret_key = get_option('gh_yt_secret_key');
    // output the field
    ?>
    <label>
    	Client ID:
    	<input type="text" name="gh_yt_client_id" value="<?php echo isset( $client_id ) ? esc_attr( $client_id ) : ''; ?>">
    </label>
    <label>
    	Secret Key:
    	<input type="text" name="gh_yt_secret_key" value="<?php echo isset( $secret_key ) ? esc_attr( $secret_key ) : ''; ?>">
    </label>
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
        <h1><? echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields( 'gh_yt_fields' );
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

// Adding sub menu page.

function gh_yt_sub_menu_page_cb()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <?php
        $client_id = get_option('gh_yt_client_id');
        // echo $client_id;

        $secret_key = get_option('gh_yt_secret_key');
        // echo $secret_key;

        require_once plugin_dir_path(__FILE__) . 'admin/api.php';
        ?>
    </div>
    <?php
}

function gh_yt_sub_menu_page()
{
    add_submenu_page(
        'gh-yt',
        'YouTube Videos',
        'YouTube Videos',
        'manage_options',
        'gh-yt-sub-page',
        'gh_yt_sub_menu_page_cb'
    );
}
add_action('admin_menu', 'gh_yt_sub_menu_page');