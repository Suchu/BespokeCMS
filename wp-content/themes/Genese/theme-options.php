<?php
function theme_get_default_options() {
    $options = array(
        'logo' => ''
    );
    return $options;
}

function theme_options_init() {
    $theme_options = get_option( 'theme_theme_options' );
 
    // Are our options saved in the DB?
    if ( false === $theme_options ) {
        // If not, we'll save our default options
        $theme_options = theme_get_default_options();
        add_option( 'theme_theme_options', $theme_options );
    }
 
    // In other case we don't need to update the DB
}
 
// Initialize theme options
add_action( 'after_setup_theme', 'theme_options_init' );


function theme_admin_options_page() {
    ?>
        <!-- 'wrap','submit','icon32','button-primary' and 'button-secondary' are classes
        for a good WP Admin Panel viewing and are predefined by WP CSS -->
 
        <div class="wrap">
 
            <div id="icon-themes" class="icon32"><br /></div>
 
            <h2><?php _e( 'theme Options', 'theme' ); ?></h2>
 
            <!-- If we have any error by submiting the form, they will appear here -->
            <?php settings_errors( 'theme-settings-errors' ); ?>
 
            <form id="form-theme-options" action="options.php" method="post" enctype="multipart/form-data">
 
                <?php
                    settings_fields('theme_theme_options');
                    do_settings_sections('theme');
                ?>
 
                <p class="submit">
                    <input name="theme_theme_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'theme'); ?>" />
                    <input name="theme_theme_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'theme'); ?>" />
                </p>
 
            </form>
 
        </div>
    <?php
}
function theme_options_settings_init() {
    register_setting( 'theme_theme_options', 'theme_theme_options', 'theme_options_validate' );
 
    // Add a form section for the Logo
    add_settings_section('theme_settings_header', __( 'Logo Options', 'theme' ), 'theme_settings_header_text', 'theme');
 
    // Add Logo uploader
    add_settings_field('theme_setting_logo',  __( 'Logo', 'theme' ), 'theme_setting_logo', 'theme', 'theme_settings_header');
    // Add Current Image Preview
	add_settings_field('theme_setting_logo_preview',  __( 'Logo Preview', 'theme' ), 'theme_setting_logo_preview', 'theme', 'theme_settings_header');

}
add_action( 'admin_init', 'theme_options_settings_init' );

	function theme_setting_logo_preview() {
    $theme_options = get_option( 'theme_theme_options' );  ?>
    <div id="upload_logo_preview" style="min-height: 100px;">
        <img style="max-width:100%;" src="<?php echo esc_url( $theme_options['logo'] ); ?>" />
    </div>
    <?php
}
 
function theme_settings_header_text() {
    ?>
        <p><?php _e( 'Manage Logo Options for theme theme.', 'theme' ); ?></p>
    <?php
}
 
function theme_setting_logo() {
    $theme_options = get_option( 'theme_theme_options' );
    ?>
        <input type="text" id="logo_url" name="theme_theme_options[logo]" value="<?php echo esc_url( $theme_options['logo'] ); ?>" />
        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'theme' ); ?>" />
        <span class="description"><?php _e('Upload an image for the banner.', 'theme' ); ?></span>
    <?php
}

function theme_options_setup() {
    global $pagenow;
 
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
    }
}
add_action( 'admin_init', 'theme_options_setup' );
 
function replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'theme-settings' );
        if ( $referer != '' ) {
            return __('I want this to be my logo!', 'theme' );
        }
    }
    return $translated_text;
}
?> 
<script type="text/javascript">
    jQuery(document).ready(function($) { 
$('#upload_logo_button').click(function() { 
tb_show('Upload a logo', 'media-upload.php?referer=theme-settings&type=image&TB_iframe=true&post_id=0', false); 
window.send_to_editor = function(html) { 
var image_url = $('img',html).attr('src'); 
$('#logo_url').val(image_url); 
tb_remove(); 
$('#upload_logo_preview img').attr('src',image_url); 
$('#submit_options_form').trigger('click');
};
return false;
}); 
}); 

</script>