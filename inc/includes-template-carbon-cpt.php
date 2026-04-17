<?php
/**
 * Custom post type: Carbon Templates (reusable layouts; Header/Footer Template posts drive site chrome via the editor).
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Slug for the global Header Template Carbon Template post.
 *
 * @return string
 */
function custom_theme_header_template_slug(): string {
  return 'header-template';
}

/**
 * Slug for the global Footer Template Carbon Template post.
 *
 * @return string
 */
function custom_theme_footer_template_slug(): string {
  return 'footer-template';
}

/**
 * Register the Carbon Templates post type.
 *
 * @return void
 */
function custom_theme_register_carbon_template_post_type(): void {
  $labels = array(
	  'name'               => __( 'Carbon Templates', CUSTOM_THEME_TEXT_DOMAIN ),
	  'singular_name'      => __( 'Carbon Template', CUSTOM_THEME_TEXT_DOMAIN ),
	  'add_new'            => __( 'Add New', CUSTOM_THEME_TEXT_DOMAIN ),
	  'add_new_item'       => __( 'Add New Carbon Template', CUSTOM_THEME_TEXT_DOMAIN ),
	  'edit_item'          => __( 'Edit Carbon Template', CUSTOM_THEME_TEXT_DOMAIN ),
	  'new_item'           => __( 'New Carbon Template', CUSTOM_THEME_TEXT_DOMAIN ),
	  'view_item'          => __( 'View Carbon Template', CUSTOM_THEME_TEXT_DOMAIN ),
	  'search_items'       => __( 'Search Carbon Templates', CUSTOM_THEME_TEXT_DOMAIN ),
	  'not_found'          => __( 'No carbon templates found.', CUSTOM_THEME_TEXT_DOMAIN ),
	  'not_found_in_trash' => __( 'No carbon templates found in Trash.', CUSTOM_THEME_TEXT_DOMAIN ),
	  'all_items'          => __( 'Carbon Templates', CUSTOM_THEME_TEXT_DOMAIN ),
  );

  register_post_type(
    'carbon_template',
    array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'carbon-template' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-layout',
		'supports'           => array( 'title', 'editor', 'revisions' ),
    )
  );
}
add_action( 'init', 'custom_theme_register_carbon_template_post_type', 5 );

/**
 * Resolve a Carbon Template post ID by slug.
 *
 * @param string $slug Post name slug.
 * @return int Post ID or 0.
 */
function custom_theme_get_carbon_template_id_by_slug( string $slug ): int {
  if ( '' === $slug ) {
    return 0;
  }

  $post = get_page_by_path( $slug, OBJECT, 'carbon_template' );
  if ( $post instanceof \WP_Post ) {
    return (int) $post->ID;
  }

  return 0;
}

/**
 * Resolve a Carbon Template post ID by slug (any status, including draft and trash).
 *
 * Used to avoid duplicate auto-created templates when a matching post already exists.
 *
 * @param string $slug Post name slug.
 * @return int Post ID or 0.
 */
function custom_theme_get_carbon_template_id_by_slug_any_status( string $slug ): int {
  $slug = sanitize_title( $slug );
  if ( '' === $slug ) {
    return 0;
  }

  $posts = get_posts(
    array(
		'post_type'              => 'carbon_template',
		'name'                   => $slug,
		'post_status'            => 'any',
		'posts_per_page'         => 1,
		'fields'                 => 'ids',
		'suppress_filters'       => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'no_found_rows'          => true,
    )
  );

  if ( empty( $posts ) ) {
    return 0;
  }

  return (int) $posts[0];
}

/**
 * Post IDs to omit from the Template block association picker (global chrome + page template layouts).
 *
 * @return array<int, int>
 */
function custom_theme_get_carbon_template_post_ids_excluded_from_template_block(): array {
  $slugs = array(
	  custom_theme_header_template_slug(),
	  custom_theme_footer_template_slug(),
  );

  if ( function_exists( 'custom_theme_get_layout_template_file_slugs' ) ) {
    $slugs = array_merge( $slugs, custom_theme_get_layout_template_file_slugs() );
  }

  $slugs[] = 'blank';
  $slugs[] = 'sidebar';
  $slugs[] = 'blank-template';
  $slugs[] = 'sidebar-template';

  $slugs = array_unique( array_filter( array_map( 'sanitize_title', $slugs ) ) );
  $ids   = array();

  foreach ( $slugs as $slug ) {
    $id = custom_theme_get_carbon_template_id_by_slug_any_status( $slug );
    if ( $id > 0 ) {
      $ids[] = $id;
    }
  }

  return array_values( array_unique( $ids ) );
}

/**
 * Create default Header Template and Footer Template posts once.
 *
 * @return void
 */
function custom_theme_maybe_seed_default_carbon_templates(): void {
  if ( '1' === get_option( 'custom_theme_carbon_defaults_seeded', '' ) ) {
    return;
  }

  if ( ! post_type_exists( 'carbon_template' ) ) {
    return;
  }

  if ( 0 === custom_theme_get_carbon_template_id_by_slug( custom_theme_header_template_slug() ) ) {
    $created_header = wp_insert_post(
      array(
		  'post_type'    => 'carbon_template',
		  'post_title'   => __( 'Header Template', CUSTOM_THEME_TEXT_DOMAIN ),
		  'post_name'    => custom_theme_header_template_slug(),
		  'post_status'  => 'publish',
		  'post_content' => '',
      ),
      true
    );
    if ( is_wp_error( $created_header ) ) {
      return;
    }
  }

  if ( 0 === custom_theme_get_carbon_template_id_by_slug( custom_theme_footer_template_slug() ) ) {
    $created_footer = wp_insert_post(
      array(
		  'post_type'    => 'carbon_template',
		  'post_title'   => __( 'Footer Template', CUSTOM_THEME_TEXT_DOMAIN ),
		  'post_name'    => custom_theme_footer_template_slug(),
		  'post_status'  => 'publish',
		  'post_content' => '',
      ),
      true
    );
    if ( is_wp_error( $created_footer ) ) {
      return;
    }
  }

  update_option( 'custom_theme_carbon_defaults_seeded', '1' );
}
add_action( 'init', 'custom_theme_maybe_seed_default_carbon_templates', 20 );

/**
 * Global site header HTML from the Header Template Carbon Template post (block editor content).
 *
 * @return string HTML fragment for inside theme header (run through the_content filters).
 */
function custom_theme_get_global_header_template_output_html(): string {
  $post_id = custom_theme_get_carbon_template_id_by_slug( custom_theme_header_template_slug() );
  if ( $post_id <= 0 ) {
    return '';
  }

  $post = get_post( $post_id );
  if ( ! $post instanceof \WP_Post || 'publish' !== $post->post_status ) {
    return '';
  }

  $content = (string) $post->post_content;
  if ( '' === trim( $content ) ) {
    return '';
  }

  setup_postdata( $post );
  $html = apply_filters( 'the_content', $content );
  wp_reset_postdata();

  return is_string( $html ) ? $html : '';
}

/**
 * Global site footer HTML from the Footer Template Carbon Template post (block editor content).
 *
 * @return string HTML fragment for inside theme footer (run through the_content filters).
 */
function custom_theme_get_global_footer_template_output_html(): string {
  $post_id = custom_theme_get_carbon_template_id_by_slug( custom_theme_footer_template_slug() );
  if ( $post_id <= 0 ) {
    return '';
  }

  $post = get_post( $post_id );
  if ( ! $post instanceof \WP_Post || 'publish' !== $post->post_status ) {
    return '';
  }

  $content = (string) $post->post_content;
  if ( '' === trim( $content ) ) {
    return '';
  }

  setup_postdata( $post );
  $html = apply_filters( 'the_content', $content );
  wp_reset_postdata();

  return is_string( $html ) ? $html : '';
}

/**
 * Admin list table: add Badges column for Carbon Templates.
 *
 * @param array<string, string> $columns Columns.
 * @return array<string, string>
 */
function custom_theme_carbon_template_posts_columns( array $columns ): array {
  $out = array();
  foreach ( $columns as $id => $label ) {
    $out[ $id ] = $label;
    if ( 'title' === $id ) {
      $out['custom_theme_badges'] = __( 'Badges', CUSTOM_THEME_TEXT_DOMAIN );
    }
  }

  return $out;
}

/**
 * Admin list table: output badge markup for Carbon Templates.
 *
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 * @return void
 */
function custom_theme_carbon_template_posts_custom_column( string $column, int $post_id ): void {
  if ( 'custom_theme_badges' !== $column ) {
    return;
  }

  $post = get_post( $post_id );
  if ( ! $post instanceof \WP_Post || 'carbon_template' !== $post->post_type ) {
    return;
  }

  $slug = (string) $post->post_name;

  if ( custom_theme_header_template_slug() === $slug ) {
    echo '<span class="carbon-template-badge carbon-template-badge--global">' . esc_html__( 'Global', CUSTOM_THEME_TEXT_DOMAIN ) . '</span> ';
    echo '<span class="carbon-template-badge carbon-template-badge--chrome">' . esc_html__( 'Header', CUSTOM_THEME_TEXT_DOMAIN ) . '</span>';
    return;
  }

  if ( custom_theme_footer_template_slug() === $slug ) {
    echo '<span class="carbon-template-badge carbon-template-badge--global">' . esc_html__( 'Global', CUSTOM_THEME_TEXT_DOMAIN ) . '</span> ';
    echo '<span class="carbon-template-badge carbon-template-badge--chrome">' . esc_html__( 'Footer', CUSTOM_THEME_TEXT_DOMAIN ) . '</span>';
    return;
  }

  if ( custom_theme_carbon_slug_is_page_template_layout( $slug ) ) {
    echo '<span class="carbon-template-badge carbon-template-badge--page">' . esc_html__( 'Page Templates', CUSTOM_THEME_TEXT_DOMAIN ) . '</span>';
    return;
  }

  echo '&mdash;';
}

/**
 * Admin: styles for Carbon Template list badges.
 *
 * @return void
 */
function custom_theme_carbon_template_admin_list_styles(): void {
  $screen = get_current_screen();
  if ( ! $screen || 'edit-carbon_template' !== $screen->id ) {
    return;
  }

  echo '<style>
    .column-custom_theme_badges { width: 14em; }
    .carbon-template-badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 3px;
      font-size: 11px;
      font-weight: 600;
      line-height: 1.6;
      vertical-align: middle;
    }
    .carbon-template-badge--global {
      background: #dcdcde;
      color: #1d2327;
    }
    .carbon-template-badge--chrome {
      background: #f0f0f1;
      color: #50575e;
    }
    .carbon-template-badge--page {
      background: #d6f0e8;
      color: #0a4a3a;
    }
  </style>';
}

add_filter( 'manage_carbon_template_posts_columns', 'custom_theme_carbon_template_posts_columns' );
add_action( 'manage_carbon_template_posts_custom_column', 'custom_theme_carbon_template_posts_custom_column', 10, 2 );
add_action( 'admin_head', 'custom_theme_carbon_template_admin_list_styles' );

/**
 * Whether this Carbon Template is global chrome or a theme page layout (must not be moved to Trash from published state).
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function custom_theme_carbon_template_post_is_protected_from_trash( int $post_id ): bool {
  $post = get_post( $post_id );
  if ( ! $post instanceof \WP_Post || 'carbon_template' !== $post->post_type ) {
    return false;
  }

  $slug = (string) $post->post_name;

  if ( custom_theme_header_template_slug() === $slug ) {
    return true;
  }

  if ( custom_theme_footer_template_slug() === $slug ) {
    return true;
  }

  if ( function_exists( 'custom_theme_carbon_slug_is_page_template_layout' ) && custom_theme_carbon_slug_is_page_template_layout( $slug ) ) {
    return true;
  }

  return false;
}

/**
 * Block trashing protected Carbon Templates; allow permanent delete only when already in trash.
 *
 * @param array<int, string> $caps    Primitive caps for the user.
 * @param string             $cap     Capability name.
 * @param int                $user_id User ID.
 * @param array<int, mixed>  $args    Arguments (post ID for delete_post).
 * @return array<int, string>
 */
function custom_theme_carbon_template_map_meta_cap_protect_trash( array $caps, string $cap, int $user_id, array $args ): array {
  if ( 'delete_post' !== $cap || empty( $args[0] ) ) {
    return $caps;
  }

  $post_id = (int) $args[0];
  if ( ! custom_theme_carbon_template_post_is_protected_from_trash( $post_id ) ) {
    return $caps;
  }

  $post = get_post( $post_id );
  if ( ! $post instanceof \WP_Post ) {
    return $caps;
  }

  if ( 'trash' === $post->post_status ) {
    return $caps;
  }

  return array( 'do_not_allow' );
}

/**
 * Remove Trash row action for protected Carbon Templates (not already in trash).
 *
 * @param array<string, string> $actions Row actions.
 * @param \WP_Post              $post   Post object.
 * @return array<string, string>
 */
function custom_theme_carbon_template_row_actions_remove_trash( array $actions, \WP_Post $post ): array {
  if ( 'carbon_template' !== $post->post_type ) {
    return $actions;
  }

  if ( 'trash' === $post->post_status ) {
    return $actions;
  }

  if ( ! custom_theme_carbon_template_post_is_protected_from_trash( $post->ID ) ) {
    return $actions;
  }

  unset( $actions['trash'] );

  return $actions;
}

add_filter( 'map_meta_cap', 'custom_theme_carbon_template_map_meta_cap_protect_trash', 10, 4 );
add_filter( 'post_row_actions', 'custom_theme_carbon_template_row_actions_remove_trash', 10, 2 );
