<?php
/*
Plugin Name: External Media without Import
 */
namespace WP_ExternalMedia_WithoutImport;

$style = 'WP_ExternalMedia_WithoutImport_css';
$css_file = plugins_url( '/external-media-without-import.css', __FILE__ );
wp_register_style( $style, $css_file );
wp_enqueue_style( $style );

$script = 'WP_ExternalMedia_WithoutImport_js';
$js_file = plugins_url( '/external-media-without-import.js', __FILE__ );
wp_register_script( $script, $js_file, array( 'jquery' ) );
wp_enqueue_script( $script );

add_action( 'admin_menu', 'WP_ExternalMedia_WithoutImport\add_submenu' );
add_action( 'post-plupload-upload-ui', 'WP_ExternalMedia_WithoutImport\post_plupload_upload_ui' );

function add_submenu() {
    add_submenu_page(
        'upload.php',
        __( 'Add External Media without Import' ),
        __( 'Add External Media without Import' ),
        'manage_options',
        'add-external-media-without-import',
        'WP_ExternalMedia_WithoutImport\print_submenu_page'
    );
}

function post_plupload_upload_ui() {
    $media_library_mode = get_user_option( 'media_library_mode', get_current_user_id() );
?>
    <div class="emwi-in-upload-ui">
      <div class="row1">
        <?php echo __('or'); ?>
      </div>
      <div class="row2">
        <?php if ( 'grid' === $media_library_mode ) : ?>
          <button class="button button-large">
            <?php echo __('Add External Media without Import'); ?>
          </button>
          <?php print_media_new_panel( false ); ?>
        <?php else : ?>
          <a class="button button-large" href="<?php echo admin_url( '/upload.php?page=add-external-media-without-import', __FILE__ ); ?>">
            <?php echo __('Add External Media without Import'); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
<?php
}

function print_submenu_page() {
    print_media_new_panel( true );
}

function print_media_new_panel( $is_in_submenu_page ) {
?>
    <div id="emwi-media-new-panel" <?php if ( !$is_in_submenu_page  ) : ?>style="display: none"<?php endif;?>>
      <div class="url-row">
        <label><?php echo __('Add a media from URL'); ?></label>
        <span id="emwi-url-input-wrapper">
          <input type="url" placeholder="<?php echo __('Image URL');?>">
        </span>
      </div>
      <div class="buttons-row">
        <input type="button" id="emwi-add" class="button button-primary" value="<?php echo __('Add') ?>">
        <input type="button" id="emwi-cancel" class="button" value="<?php echo __('Cancel') ?>">
      </div>
    </div>
<?php
}
