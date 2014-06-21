<?php


// Register Custom Post Type for Projects
function custom_post_type() {
    $labels = array(
        'name'                => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Projects', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Projects:', 'text_domain' ),
        'all_items'           => __( 'All Projects', 'text_domain' ),
        'view_item'           => __( 'View Project', 'text_domain' ),
        'add_new_item'        => __( 'Add New Project', 'text_domain' ),
        'add_new'             => __( 'New Project', 'text_domain' ),
        'edit_item'           => __( 'Edit Project', 'text_domain' ),
        'update_item'         => __( 'Update Project', 'text_domain' ),
        'search_items'        => __( 'Search projects', 'text_domain' ),
        'not_found'           => __( 'No projects found', 'text_domain' ),
        'not_found_in_trash'  => __( 'No projects found in Trash', 'text_domain' ),
    );

    $rewrite = array(
        'slug'                => 'projects',
        'with_front'          => true,
        'pages'               => true,
        'feeds'               => true,
    );

    $args = array(
        'label'               => __( 'project', 'text_domain' ),
        'description'         => __( 'Project information pages', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
        'taxonomies'          => array( 'category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'query_var'           => 'project',
        'rewrite'             => $rewrite,
        //'rewrite' => array( 'slug' => '/who-we-are/team' ),
        'capability_type'     => 'page',
    );

    register_post_type( 'project', $args );
}

// Add filter to ensure the text Project, or project, is displayed when a user updates a project
add_filter('post_updated_messages', 'project_updated_messages');

function project_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['project'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Project updated. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Project updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Project published. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Project saved.'),
    8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// Initialize New Taxonomy Labels
$labels = array(
    'name' => _x( 'Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Types' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => __( 'Parent Tag' ),
    'parent_item_colon' => __( 'Parent Tag:' ),
    'edit_item' => __( 'Edit Tags' ),
    'update_item' => __( 'Update Tag' ),
    'add_new_item' => __( 'Add New Tag' ),
    'new_item_name' => __( 'New Tag Name' ),
);

// Custom taxonomy for Project Tags
register_taxonomy('tag',array('project'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tag' ),
));


// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );
