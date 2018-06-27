<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields('wporg_options');
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections('wporg');
        // output save settings button
        submit_button('Save Settings');
        ?>
    </form>
</div>

<?php
function wporg_settings_init()
{
    // register a new setting for "reading" page
    register_setting('reading', 'wporg_setting_name');
 
    // register a new section in the "reading" page
    add_settings_section(
        'wporg_settings_section',
        'WPOrg Settings Section',
        'wporg_settings_section_cb',
        'reading'
    );
 
    // register a new field in the "wporg_settings_section" section, inside the "reading" page
    add_settings_field(
        'wporg_settings_field',
        'WPOrg Setting',
        'wporg_settings_field_cb',
        'reading',
        'wporg_settings_section'
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
function wporg_settings_section_cb()
{
    echo '<p>WPOrg Section Introduction.</p>';
}
 
// field content cb
function wporg_settings_field_cb()
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('wporg_setting_name');
    // output the field
    ?>
    <input type="text" name="wporg_setting_name" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}