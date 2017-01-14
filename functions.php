<?php

//enable feature images
add_theme_support( 'post-thumbnails' ); 

//Remove top level admin menus

add_action( 'admin_menu', 'remove_admin_menus' );
add_action( 'admin_menu', 'remove_admin_submenus' );

function remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'link-manager.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'plugins.php' );
    remove_menu_page( 'users.php' );
    remove_menu_page( 'upload.php' );
    remove_menu_page( 'themes.php' );
}


//Remove sub level admin menus
function remove_admin_submenus() {
    remove_submenu_page( 'themes.php', 'theme-editor.php' );
    remove_submenu_page( 'themes.php', 'themes.php' );
    remove_submenu_page( 'themes.php', 'nav-menus.php' );
    remove_submenu_page( 'themes.php', 'widgets.php' );
    remove_submenu_page( 'themes.php', 'theme-editor.php' );
    remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
    remove_submenu_page( 'plugins.php', 'plugin-install.php' );
    remove_submenu_page( 'users.php', 'users.php' );
    remove_submenu_page( 'users.php', 'user-new.php' );
    remove_submenu_page( 'upload.php', 'media-new.php' );
    remove_submenu_page( 'options-general.php', 'options-writing.php' );
    remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    remove_submenu_page( 'options-general.php', 'options-reading.php' );
    remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    remove_submenu_page( 'options-general.php', 'options-media.php' );
    remove_submenu_page( 'options-general.php', 'options-privacy.php' );
    remove_submenu_page( 'options-general.php', 'options-permalinks.php' );
    remove_submenu_page( 'index.php', 'update-core.php' );
}

//remove everything from Dashboard

function remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );   // Right Now
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  // Incoming Links
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   // Plugins
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  // Recent Drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
	// use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );


function remove_welcome_panel()
{
    remove_action('welcome_panel', 'wp_welcome_panel');
    $user_id = get_current_user_id();
    if (0 !== get_user_meta( $user_id, 'show_welcome_panel', true ) ) {
        update_user_meta( $user_id, 'show_welcome_panel', 0 );
    }
}

function customize_post_admin_menu_labels() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Images';
	$submenu['edit.php'][5][0] = 'All Images';
    $submenu['edit.php'][10][0] = 'Add Image';
    $submenu['edit.php'][15][0] = 'Albums'; // Change name for categories
    //$submenu['edit.php'][16][0] = 'Labels'; // Change name for tags
    echo '';
}

function customize_admin_labels(){
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Images';
        $labels->singular_name = 'Image';
        $labels->add_new = 'Add Image';
        $labels->add_new_item = 'Add Image';
        $labels->edit_item = 'Edit Images';
        $labels->new_item = 'Image';
        $labels->view_item = 'View Image';
        $labels->search_items = 'Search Images';
        $labels->not_found = 'No Images found';
        $labels->not_found_in_trash = 'No Images found in Trash';
    }
    add_action( 'init', 'customize_admin_labels' );
    add_action( 'admin_menu', 'customize_post_admin_menu_labels' );
	
// rename categories to albums

function customize_tax_object_label() {
  global $wp_taxonomies;
  $labels = &$wp_taxonomies['category']->labels;
  $labels->name = __('Albums', 'theme_namespace');
  $labels->singular_name = __('Album', 'theme_namespace');
  $labels->search_items = __('Search Albums', 'theme_namespace');
  $labels->all_items = __('All Albums', 'theme_namespace');
  $labels->parent_item = __('Your Parent Taxonomy Name', 'theme_namespace');
  $labels->parent_item_colon = __('Your Parent Taxonomy Name:', 'theme_namespace');
  $labels->edit_item = __('Edit Album', 'theme_namespace');
  $labels->view_item = __('View Album', 'theme_namespace');
  $labels->update_item = __('Update Album', 'theme_namespace');
  $labels->add_new_item = __('Add Album', 'theme_namespace');
  $labels->new_item_name = __('Your New Album', 'theme_namespace');
}
add_action( 'init', 'customize_tax_object_label' );
	
//move and rename interface boxes - metaboxes
	
add_action('do_meta_boxes', 'simplegallery_change_meta_boxes');

function simplegallery_change_meta_boxes(){
    remove_meta_box( 'postimagediv', 'post', 'side' );
    add_meta_box('postimagediv', __('Upload or choose an image'), 'post_thumbnail_meta_box', 'post', 'advanced', 'high');
    remove_meta_box( 'categorydiv', 'post', 'side' );
    add_meta_box( 'categorydiv', __('Albums'), 'post_categories_meta_box', 'post', 'side', 'high' );

	
}

// Move all "advanced" metaboxes above the default editor
add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});


//remove page editor from pages with a certain template

add_action( 'admin_head', 'hide_editor' );

function hide_editor() {
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
  if( !isset( $post_id ) ) return;

  // Hide the editor on a page with a specific page template.
  
  $template_file = get_post_meta($post_id, '_wp_page_template', true);
  if($template_file != 'about-template.php' ){ // the filename of the page template
    remove_post_type_support('page', 'editor');
	remove_meta_box( 'postimagediv', 'page', 'side' );
	echo '<div class="error"><p>Content of this page can not be edited directly. All images are automatically added to the Gallery. To add an image to the home page, please add it to "Home" album.</p></div>';
  }
}


?>

