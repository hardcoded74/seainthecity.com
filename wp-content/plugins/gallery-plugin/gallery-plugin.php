<?php
/*
Plugin Name: Gallery by BestWebSoft
Plugin URI: https://bestwebsoft.com/products/wordpress/plugins/gallery/
Description: Add beautiful galleries, albums & images to your Wordpress website in few clicks.
Author: BestWebSoft
Text Domain: gallery-plugin
Domain Path: /languages
Version: 4.5.0
Author URI: https://bestwebsoft.com/
License: GPLv2 or later
*/

/*  © Copyright 2017  BestWebSoft  ( https://support.bestwebsoft.com )

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once( dirname( __FILE__ ) . '/inc/deprecated.php' );

if ( ! function_exists( 'add_gllr_admin_menu' ) ) {
	function add_gllr_admin_menu() {
		global $submenu, $gllr_options, $gllr_plugin_info, $wp_version;

		if ( empty( $gllr_options ) )
			gllr_settings();

		$settings = add_submenu_page( 'edit.php?post_type=' . $gllr_options['post_type_name'], __( 'Gallery Settings', 'gallery-plugin' ), __( 'Global Settings', 'gallery-plugin' ), 'manage_options', "gallery-plugin.php", 'gllr_settings_page' );

		add_submenu_page( 'edit.php?post_type=' . $gllr_options['post_type_name'], 'BWS Panel', 'BWS Panel', 'manage_options', 'gllr-bws-panel', 'bws_add_menu_render' );
		
		if ( isset( $submenu['edit.php?post_type=' . $gllr_options['post_type_name'] ] ) )
			$submenu['edit.php?post_type=' . $gllr_options['post_type_name'] ][] = array( 
				'<span style="color:#d86463"> ' . __( 'Upgrade to Pro', 'gallery-plugin' ) . '</span>',
				'manage_options',
				'https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=63a36f6bf5de0726ad6a43a165f38fe5&pn=79&v=' . $gllr_plugin_info["Version"] . '&wp_v=' . $wp_version );

		add_action( 'load-' . $settings, 'gllr_add_tabs' );
		add_action( 'load-post-new.php', 'gllr_add_tabs' );
		add_action( 'load-post.php', 'gllr_add_tabs' );
		add_action( 'load-edit.php', 'gllr_add_tabs' );
	}
}

if ( ! function_exists( 'gllr_plugins_loaded' ) ) {
	function gllr_plugins_loaded() {
		/* Internationalization, first(!)  */
		load_plugin_textdomain( 'gallery-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

if ( ! function_exists( 'gllr_init' ) ) {
	function gllr_init() {
		global $gllr_plugin_info, $pagenow, $gllr_options;

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );

		if ( ! $gllr_plugin_info ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$gllr_plugin_info = get_plugin_data( __FILE__ );
		}

		/* Function check if plugin is compatible with current WP version  */
		bws_wp_min_version_check( plugin_basename( __FILE__ ), $gllr_plugin_info, '4.0' );

		/* Call register settings function */
		gllr_settings();
		/* Register post type */
		gllr_post_type_images();

		if ( ! is_admin() ) {
			/* add template for gallery pages */
			add_action( 'template_include', 'gllr_template_include' );
		}

		/* Add media button to the gallery post type */
		if (
			( isset( $_GET['post'] ) && get_post_type( $_GET['post'] ) == $gllr_options['post_type_name'] ) ||
			( $pagenow == 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == $gllr_options['post_type_name'] )
		) {
			add_action( 'edit_form_after_title', 'gllr_media_custom_box' );
		}

		/* demo data */
		$demo_options = get_option( 'gllr_demo_options' );
		if ( ! empty( $demo_options ) || ( isset( $_GET['page'] ) && $_GET['page'] == 'gallery-plugin.php' ) ) {
			gllr_include_demo_data();
		}
	}
}

if ( ! function_exists( 'gllr_admin_init' ) ) {
	function gllr_admin_init() {
		global $bws_plugin_info, $gllr_plugin_info, $bws_shortcode_list, $gllr_options;
		/* Add variable for bws_menu */
		if ( empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '79', 'version' => $gllr_plugin_info["Version"] );

		/* add gallery to global $bws_shortcode_list */
		$bws_shortcode_list['gllr'] = array( 'name' => 'Gallery', 'js_function' => 'gllr_shortcode_init' );

		add_filter( 'manage_' . $gllr_options['post_type_name'] . '_posts_columns', 'gllr_change_columns' );
		add_action( 'manage_' . $gllr_options['post_type_name'] . '_posts_custom_column', 'gllr_custom_columns', 10, 2 );
	}
}

/**
 * Function for activation
 */
if ( ! function_exists( 'gllr_plugin_activate' ) ) {
	function gllr_plugin_activate() {
		/* registering uninstall hook */
		if ( is_multisite() ) {
			switch_to_blog( 1 );
			register_uninstall_hook( __FILE__, 'gllr_plugin_uninstall' );
			restore_current_blog();
		} else {
			register_uninstall_hook( __FILE__, 'gllr_plugin_uninstall' );
		}
	}
}

/* Register settings function */
if ( ! function_exists( 'gllr_settings' ) ) {
	function gllr_settings() {
		global $gllr_options, $gllr_plugin_info;

		/**
		 * @deprecated since 4.4.4
		 * @todo remove after 01.04.2017
		 */
		gllr_check_old_options();

		/* Install the option defaults */
		if ( ! get_option( 'gllr_options' ) ) {
			$option_defaults = gllr_get_options_default();
			add_option( 'gllr_options', $option_defaults );
		}

		/* Get options from the database */
		$gllr_options = get_option( 'gllr_options' );

		/* Array merge incase this version has added new options */
		if ( $gllr_options['plugin_option_version'] != $gllr_plugin_info["Version"] ) {
			/**
			 * @deprecated since 4.4.7
			 * @todo remove after 30.06.2017
			 */
			gllr_old_template_options();

			/**
			 * @deprecated since 4.4.9
			 * @todo remove after 01.08.2017
			 */
			gllr_update_options_after_redesign();

			/**
			 * using old post type name for updated plugin version
			 * @deprecated since 4.4.4
			 * @todo remove after 01.04.2017
			 */
			if ( ! isset( $gllr_options['post_type_name'] ) )
				$gllr_options['post_type_name'] = 'gallery';
			/* deprecated (end) */

			$option_defaults = gllr_get_options_default();

			$option_defaults['display_demo_notice'] = 0;
			$option_defaults['display_settings_notice'] = 0;

			$gllr_options = array_merge( $option_defaults, $gllr_options );
			$gllr_options['plugin_option_version'] = $gllr_plugin_info["Version"];

			/* show pro features */
			$gllr_options['hide_premium_options'] = array();

			update_option( 'gllr_options', $gllr_options );
		}

		if ( function_exists( 'add_image_size' ) ) {
			if ( 'album-thumb' == $gllr_options['image_size_album'] )
				add_image_size( 'album-thumb', $gllr_options['custom_size_px']['album-thumb'][0], $gllr_options['custom_size_px']['album-thumb'][1], true );
			if ( 'photo-thumb' == $gllr_options['image_size_photo'] )
				add_image_size( 'photo-thumb', $gllr_options['custom_size_px']['photo-thumb'][0], $gllr_options['custom_size_px']['photo-thumb'][1], true );
		}
	}
}

/**
 * Get Plugin default options
 */
if ( ! function_exists( 'gllr_get_options_default' ) ) {
	function gllr_get_options_default() {
		global $gllr_plugin_info;

		$option_defaults = array(
			/* internal general */
			'plugin_option_version' 					=> $gllr_plugin_info["Version"],
			'first_install'								=> strtotime( "now" ),
			'suggest_feature_banner'					=> 1,			
			'display_settings_notice'					=> 1,
			/* internal */
			'display_demo_notice'						=> 1,
			'flush_rewrite_rules'						=> 1,
			/* settings */
			'custom_size_px'							=> array( 
															'album-thumb' => array( 120, 80 ),
															'photo-thumb' => array( 160, 120 ) ),
			'custom_image_row_count'					=> 3,
			'image_size_photo'							=> 'thumbnail',			
			'image_text'								=> 0,			
			'border_images'								=> 1,
			'border_images_width'						=> 10,
			'border_images_color'						=> '#F1F1F1',			
			'order_by'									=> 'meta_value_num',
			'order'										=> 'ASC',
			'return_link'								=> 0,
			'return_link_url'							=> '',
			'return_link_text'							=> __( 'Return to all albums', 'gallery-plugin' ),
			'return_link_shortcode'						=> 0,
			/* cover */
			'page_id_gallery_template'					=> '',
			'image_size_album'							=> 'medium',
			'cover_border_images'						=> 1,
			'cover_border_images_width'					=> 10,
			'cover_border_images_color'					=> '#F1F1F1',
			'album_order_by'							=> 'date',
			'album_order'								=> 'DESC',
			'read_more_link_text'						=> __( 'See images &raquo;', 'gallery-plugin' ),	
			/* lightbox */
			'enable_lightbox'							=> 1,
			'start_slideshow'							=> 0,
			'slideshow_interval'						=> 2000,
			'lightbox_download_link'					=> 0,
			'lightbox_download_link_label'				=> __( 'Download high resolution image', 'gallery-plugin' ),
			'single_lightbox_for_multiple_galleries'	=> 0,			
			/* misc */
			'post_type_name'							=> 'bws-gallery'			
		);
		return $option_defaults;
	}
}

/**
 * Plugin include demo
 * @return void
 */
if ( ! function_exists( 'gllr_include_demo_data' ) ) {
	function gllr_include_demo_data() {
		global $gllr_BWS_demo_data;
		require_once( plugin_dir_path( __FILE__ ) . 'inc/demo-data/class-bws-demo-data.php' );
		$args = array(
			'plugin_basename' 	=> plugin_basename( __FILE__ ),
			'plugin_prefix'		=> 'gllr_',
			'plugin_name'		=> 'Gallery',
			'plugin_page'		=> 'gallery-plugin.php&bws_active_tab=import-export',
			'install_callback' 	=> 'gllr_plugin_upgrade',
			'demo_folder'		=> plugin_dir_path( __FILE__ ) . 'inc/demo-data/'
		);
		$gllr_BWS_demo_data = new Bws_Demo_Data( $args );

		/* filter for image url from demo data */
		add_filter( 'wp_get_attachment_url', array( $gllr_BWS_demo_data, 'bws_wp_get_attachment_url' ), 10, 2 );
		add_filter( 'wp_get_attachment_image_attributes', array( $gllr_BWS_demo_data, 'bws_wp_get_attachment_image_attributes' ), 10, 3 );
		add_filter( 'wp_update_attachment_metadata',array( $gllr_BWS_demo_data, 'bws_wp_update_attachment_metadata' ), 10, 2 );
	}
}

/**
 * Function for update all gallery images to new version ( Stable tag: 4.3.6 )
 */
if ( ! function_exists( 'gllr_plugin_upgrade' ) ) {
	function gllr_plugin_upgrade( $is_demo = true ) {
		global $wpdb, $gllr_options;

		$all_gallery_attachments = $wpdb->get_results( "SELECT p1.ID, p1.post_parent, p1.menu_order
			FROM {$wpdb->posts} p1, {$wpdb->posts} p2
			WHERE p1.post_parent = p2.ID
			AND p1.post_mime_type LIKE 'image%'
			AND p1.post_type = 'attachment'
			AND p1.post_status = 'inherit'
			AND p2.post_type = '{$gllr_options['post_type_name']}'",
			ARRAY_A
		);

		if ( ! empty( $all_gallery_attachments ) ) {
			$attachments_array = array();
			foreach ( $all_gallery_attachments as $key => $value ) {
				$post = $value['post_parent'];
				$attachment = $value['ID'];
				$order = $value['menu_order'];
				if ( ! isset( $attachments_array[ $post ] ) || ( isset( $attachments_array[ $post ] ) && ! in_array( $attachment, $attachments_array[ $post ] ) ) ) {
					$attachments_array[ $post ][] = $attachment;
					if ( false == $is_demo )
						update_post_meta( $attachment, '_gallery_order_' . $post, $order );
				}
			}
			foreach ( $attachments_array as $key => $value ) {
				update_post_meta( $key, '_gallery_images', implode( ',', $value ) );
			}
			/* set gallery category for demo data */
			if ( function_exists( 'gllrctgrs_add_default_term_all_gallery' ) )
				gllrctgrs_add_default_term_all_gallery();
		}
	}
}

/* Create post type for Gallery */
if ( ! function_exists( 'gllr_post_type_images' ) ) {
	function gllr_post_type_images() {
		global $gllr_options;

		register_post_type( $gllr_options['post_type_name'], array(
			'labels' => array(
				'name'				=>	__( 'Galleries', 'gallery-plugin' ),
				'singular_name'		=>	__( 'Gallery', 'gallery-plugin' ),
				'add_new_item' 		=>	__( 'Add New Gallery', 'gallery-plugin' ),
				'edit_item' 		=>	__( 'Edit Gallery', 'gallery-plugin' ),
				'new_item' 			=>	__( 'New Gallery', 'gallery-plugin' ),
				'view_item' 		=>	__( 'View Gallery', 'gallery-plugin' ),
				'search_items' 		=>	__( 'Search Galleries', 'gallery-plugin' ),
				'not_found' 		=>	__( 'No Gallery found', 'gallery-plugin' ),
				'parent_item_colon'	=>	'',
				'menu_name' 		=>	__( 'Galleries', 'gallery-plugin' )
			),
			'public' 				=>	true,
			'publicly_queryable'	=>	true,
			'exclude_from_search'	=>	true,
			'query_var'				=>	true,
			'rewrite' 				=>	true,
			'menu_icon'				=> 'dashicons-format-gallery',
			'capability_type' 		=>	'post',
			'has_archive' 			=>	false,
			'hierarchical' 			=>	true,
			'supports' 				=>	array( 'title', 'editor', 'thumbnail', 'author', 'page-attributes', 'comments' ),
			'register_meta_box_cb'	=>	'gllr_init_metaboxes',
			'taxonomy'				=>	array( 'gallery_categories' )
		) );

		if ( isset( $gllr_options["flush_rewrite_rules"] ) && $gllr_options["flush_rewrite_rules"] == 1 ) {
			flush_rewrite_rules();
			$gllr_options["flush_rewrite_rules"] = 0;
			update_option( 'gllr_options', $gllr_options );
		}
	}
}

if ( ! function_exists( 'gllr_init_metaboxes' ) ) {
	function gllr_init_metaboxes() {
		global $gllr_options;
		add_meta_box( 'Gallery-Shortcode', __( 'Gallery Shortcode', 'gallery-plugin' ), 'gllr_post_shortcode_box', $gllr_options['post_type_name'], 'side', 'high' );
		if ( ! is_plugin_active( 'gallery-categories/gallery-categories.php' ) ) {
			add_meta_box( 'Gallery-Categories', __( 'Gallery Categories', 'gallery-plugin' ), 'gllr_gallery_categories', $gllr_options['post_type_name'], 'side', 'core' );
		}
	}
}

/* Create shortcode meta box for gallery post type */
if ( ! function_exists( 'gllr_post_shortcode_box' ) ) {
	function gllr_post_shortcode_box( $obj = '', $box = '' ) {
		global $post; ?>
		<div>
			<?php _e( "Add a single gallery with images to your posts, pages, custom post types or widgets by using the following shortcode:", 'gallery-plugin' );
			bws_shortcode_output( '[print_gllr id=' . $post->ID . ']' ); ?>	
		</div>
		<div style="margin-top: 5px;">
			<?php _e( "Add a gallery cover including featured image, description, and a link to your single gallery using the following shortcode:", 'gallery-plugin' );
			bws_shortcode_output( '[print_gllr id=' . $post->ID . ' display=short]' ); ?>	
		</div>
	<?php }
}

/* Metabox-ad for plugin Gallery categories */
if ( ! function_exists( 'gllr_gallery_categories' ) ) {
	function gllr_gallery_categories() { 
		global $wp_version, $gllr_plugin_info; ?>
		<div id="gallery_categoriesdiv" class="postbox bws-addon-block">
			<div class="bws_table_bg"></div>
			<div class="inside">
				<div id="taxonomy-gallery_categories" class="categorydiv">
					<ul id="gallery_categories-tabs" class="category-tabs">
						<li class="tabs"><?php _e( 'Gallery Categories', 'gallery-plugin' ); ?></li>
						<li class="hide-if-no-js" style="color:#0074A2;"><?php _e( 'Most Used', 'gallery-plugin' ); ?></li>
					</ul>
					<div id="gallery_categories-all" class="tabs-panel">
						<ul id="gallery_categorieschecklist" data-wp-lists="list:gallery_categories" class="categorychecklist form-no-clear">
							<li id="gallery_categories-2" class="popular-category">
								<label class="selectit"><input value="2" type="checkbox" disabled="disabled" name="tax_input[gallery_categories][]" id="in-gallery_categories-2" checked="checked"><?php _e( 'Default', 'gallery-plugin' ); ?></label>
							</li>
						</ul>
					</div>
					<div id="gallery_categories-adder" class="wp-hidden-children">
						<h4><a id="gallery_categories-add-toggle" href="#" class="hide-if-no-js">+ <?php _e( 'Add New Gallery Category', 'gallery-plugin' ); ?></a></h4>
					</div>
				</div>
			</div>
			<div id="gllr_show_gallery_categories_notice"><a class="bws_button" href="https://bestwebsoft.com/products/wordpress/plugins/gallery-categories/?k=bb17b69bfb50827f3e2a9b3a75978760&pn=79&v=<?php echo $gllr_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank"><?php printf( __( 'Install %s', 'gallery-plugin' ), 'Gallery Categories' ); ?></a></div>
		</div>		
	<?php }
}

if ( ! function_exists ( 'gllr_save_postdata' ) ) {
	function gllr_save_postdata( $post_id, $post ) {
		global $post;
		
		if ( isset( $post ) ) {
			if ( isset( $_POST['_gallery_order_' . $post->ID ] ) ) {
				$i = 1;
				foreach ( $_POST['_gallery_order_' . $post->ID ] as $post_order_id => $order_id ) {
					update_post_meta( $post_order_id, '_gallery_order_' . $post->ID, $i );
					$i++;
				}
				update_post_meta( $post->ID, '_gallery_images', implode( ',', array_keys( $_POST['_gallery_order_' . $post->ID ] ) ) );
			}

			if ( ( isset( $_POST['action-top'] ) && $_POST['action-top'] == 'delete' ) ||
				( isset( $_POST['action-bottom'] ) && $_POST['action-bottom'] == 'delete' ) ) {
				$gallery_images = get_post_meta( $post_id, '_gallery_images', true );
				$gallery_images_array = explode( ',', $gallery_images );
				$gallery_images_array = array_flip( $gallery_images_array );
				foreach ( $_POST['media'] as $delete_id ) {
					delete_post_meta( $delete_id, '_gallery_order_' . $post->ID );
					unset( $gallery_images_array[ $delete_id ] );
				}
				$gallery_images_array = array_flip( $gallery_images_array );
				$gallery_images = implode( ',', $gallery_images_array );
				update_post_meta( $post->ID, '_gallery_images', $gallery_images );
			}
			if ( isset( $_REQUEST['gllr_image_text'] ) ) {
				foreach ( $_REQUEST['gllr_image_text'] as $gllr_image_text_key => $gllr_image_text ) {
					$value = htmlspecialchars( trim( $gllr_image_text ) );
					if ( get_post_meta( $gllr_image_text_key, 'gllr_image_text', false ) ) {
						/* Custom field has a value and this custom field exists in database */
						update_post_meta( $gllr_image_text_key, 'gllr_image_text', $value );
					} elseif ( $value ) {
						/* Custom field has a value, but this custom field does not exist in database */
						add_post_meta( $gllr_image_text_key, 'gllr_image_text', $value );
					}
				}
			}
			if ( isset( $_REQUEST['gllr_link_url'] ) ) {
				foreach ( $_REQUEST['gllr_link_url'] as $gllr_link_url_key => $gllr_link_url ) {
					$value = esc_url( trim( $gllr_link_url ) );
					if ( filter_var( $value, FILTER_VALIDATE_URL ) === FALSE ) {
						$value = '';
					}
					if ( get_post_meta( $gllr_link_url_key, 'gllr_link_url', FALSE ) ) {
						/* Custom field has a value and this custom field exists in database */
						update_post_meta( $gllr_link_url_key, 'gllr_link_url', $value );
					} elseif ( $value ) {
						/* Custom field has a value, but this custom field does not exist in database */
						add_post_meta( $gllr_link_url_key, 'gllr_link_url', $value );
					}
				}
			}
			if ( isset( $_REQUEST['gllr_image_alt_tag'] ) ) {
				foreach ( $_REQUEST['gllr_image_alt_tag'] as $gllr_image_alt_tag_key => $gllr_image_alt_tag ) {
					$value = htmlspecialchars( trim( $gllr_image_alt_tag ) );
					if ( get_post_meta( $gllr_image_alt_tag_key, 'gllr_image_alt_tag', FALSE ) ) {
						/* Custom field has a value and this custom field exists in database */
						update_post_meta( $gllr_image_alt_tag_key, 'gllr_image_alt_tag', $value );
					} elseif ( $value ) {
						/* Custom field has a value, but this custom field does not exist in database */
						add_post_meta( $gllr_image_alt_tag_key, 'gllr_image_alt_tag', $value );
					}
				}
			}
		}
	}
}

/**
 * Add custom permalinks for pages with 'gallery' template attribute
 */
if ( ! function_exists( 'gllr_custom_permalinks' ) ) {
	function gllr_custom_permalinks( $rules ) {
		global $gllr_options;
		$newrules = array();

		if ( ! empty( $gllr_options['page_id_gallery_template'] ) ) {
			$parent = get_post( $gllr_options['page_id_gallery_template'] );
			if ( ! empty( $parent ) ) {
				if ( ! isset( $rules['(.+)/' . $parent->post_name . '/([^/]+)/?$'] ) || ! isset( $rules[ $parent->post_name . '/([^/]+)/?$'] ) ) {
					$newrules['(.+)/' . $parent->post_name . '/([^/]+)/?$'] = 'index.php?post_type=' . $gllr_options['post_type_name'] . '&name=$matches[2]&posts_per_page=-1';
					$newrules[ $parent->post_name . '/([^/]+)/?$'] = 'index.php?post_type=' . $gllr_options['post_type_name'] . '&name=$matches[1]&posts_per_page=-1';
					$newrules[ $parent->post_name . '/page/([^/]+)/?$'] = 'index.php?pagename=' . $parent->post_name . '&paged=$matches[1]';
					$newrules[ $parent->post_name . '/page/([^/]+)?$'] = 'index.php?pagename=' . $parent->post_name . '&paged=$matches[1]';
				}
			}
		}

		if ( false === $rules )
			return $newrules;

		return $newrules + $rules;
	}
}

/**
* Load a template. Handles template usage so that plugin can use own templates instead of the themes.
*
* Templates are in the 'templates' folder.
* overrides in /{theme}/bws-templates/ by default.
* @param mixed $template
* @return string
*/
if ( ! function_exists( 'gllr_template_include' ) ) {
	function gllr_template_include( $template ) {
		global $gllr_options, $wp_query;

		if ( function_exists( 'is_embed' ) && is_embed() )
			return $template;

		$post_type = get_post_type();
		if ( is_single() && $gllr_options['post_type_name'] == $post_type ) {
			$file = 'gallery-single-template.php';
		} elseif ( $gllr_options['post_type_name'] == $post_type && isset( $wp_query->query_vars["gallery_categories"] ) ) {
			$file = 'gallery-template.php';
		} elseif ( ! empty( $gllr_options['page_id_gallery_template'] ) && is_page( $gllr_options['page_id_gallery_template'] ) ) {
			$file = 'gallery-template.php';
		}

		if ( isset( $file ) ) {
			$find = array( $file, 'bws-templates/' . $file );
			$template = locate_template( $find );

			if ( ! $template )
				$template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' . $file;
		}

		return $template;
	}
}

/* this function returns title for gallery post type template */
if ( ! function_exists( 'gllr_template_title' ) ) {
	function gllr_template_title() {
		global $wp_query;
		if ( isset( $wp_query->query_vars["gallery_categories"] ) ) {
			$term = get_term_by( 'slug', $wp_query->query_vars["gallery_categories"], 'gallery_categories' );
			return __( 'Gallery Category', 'gallery-plugin' ) . ':&nbsp;' . $term->name;
		} else {
			return get_the_title();
		}
	}
}

/* this function prints content for gallery post type template and returns array of pagination args and second query */
if ( ! function_exists( 'gllr_template_content' ) ) {
	function gllr_template_content() {
		global $post, $wp_query, $request, $gllr_options;

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		$permalink    = get_permalink();
		$count        = 0;
		$per_page = get_option( 'posts_per_page' );

		if ( substr( $permalink, strlen( $permalink ) -1 ) != "/" ) {
			if ( strpos( $permalink, "?" ) !== false ) {
				$permalink = substr( $permalink, 0, strpos( $permalink, "?" ) -1 ) . "/";
			} else {
				$permalink .= "/";
			}
		}

		if ( ! empty( $wp_query->query_vars["gallery_categories"] ) ) {
			$second_query = $wp_query;
		} else {
			$args = array(
				'post_type'			=> $gllr_options['post_type_name'],
				'post_status'		=> 'publish',
				'orderby'			=> $gllr_options['album_order_by'],
				'order'				=> $gllr_options['album_order'],
				'posts_per_page'	=> $per_page,
				'paged'				=> $paged
			);
			$second_query = new WP_Query( $args );
		}

		$request = $second_query->request; ?>
		<ul>
			<?php if ( $second_query->have_posts() ) {
				/* get width and height for image_size_album */
				if ( 'album-thumb' != $gllr_options['image_size_album'] ) {
					$width  = absint( get_option( $gllr_options['image_size_album'] . '_size_w' ) );
					$height = absint( get_option( $gllr_options['image_size_album'] . '_size_h' ) );
				} else {
					$width  = $gllr_options['custom_size_px']['album-thumb'][0];
					$height = $gllr_options['custom_size_px']['album-thumb'][1];
				}

				while ( $second_query->have_posts() ) {
					$second_query->the_post();
					$attachments	= get_post_thumbnail_id( $post->ID );
					$featured_image = false;
					
					if ( empty( $attachments ) ) {
						$images_id = get_post_meta( $post->ID, '_gallery_images', true );
						$attachments = get_posts( array(
							'showposts'			=> 1,
							'what_to_show'		=> 'posts',
							'post_status'		=> 'inherit',
							'post_type'			=> 'attachment',
							'orderby'			=> $gllr_options['order_by'],
							'order'				=> $gllr_options['order'],
							'post_mime_type'	=> 'image/jpeg,image/gif,image/jpg,image/png',
							'post__in'			=> explode( ',', $images_id ),
							'meta_key'			=> '_gallery_order_' . $post->ID
						) );
						if ( ! empty( $attachments[0] ) ) {
							$first_attachment = $attachments[0];
							$image_attributes = wp_get_attachment_image_src( $first_attachment->ID, $gllr_options['image_size_album'] );
						} else
							$image_attributes = array( '' );
					} else {
						$featured_image = wp_get_attachment_image_src( $attachments, $gllr_options['image_size_album'] );
					}
					if ( 1 == $gllr_options['cover_border_images'] ) {
						$border = 'border-width: ' . $gllr_options['cover_border_images_width'] . 'px; border-color:' . $gllr_options['cover_border_images_color'] . '; padding:0;';
						$border_images = $gllr_options['cover_border_images_width'] * 2;
					} else {
						$border = 'padding:0;';
						$border_images = 0;
					}
					$featured_image = ( false == $featured_image ) ? $image_attributes : $featured_image;
					$count++; ?>
					<li>
						<?php if ( ! empty( $featured_image[0] ) ) { ?>
							<a rel="bookmark" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
								<img <?php if ( $width ) echo 'width="' . $width . '"'; if ( $height ) echo 'height="' . $height . '"'; ?> style="<?php if ( $width ) echo 'width:' . $width . 'px;'; if ( $height ) echo 'height:' . $height . 'px;'; echo $border; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" src="<?php echo $featured_image[0]; ?>" />
							</a>
						<?php } ?>
						<div class="gallery_detail_box">
							<div><?php the_title(); ?></div>
							<div><?php gllr_the_excerpt_max_charlength( 100 ); ?></div>
							<a href="<?php echo get_permalink(); ?>"><?php echo $gllr_options["read_more_link_text"]; ?></a>
						</div><!-- .gallery_detail_box -->
						<div class="gllr_clear"></div>
					</li>
				<?php }
			} ?>
		</ul>

		<?php $count_all_albums = $second_query->found_posts;
		wp_reset_query();
		$request = $wp_query->request;
		$pages = intval( $count_all_albums / $per_page );
		if ( $count_all_albums % $per_page > 0 )
			$pages += 1;
		$range = 100;
		if ( ! $pages ) {
			$pages = 1;
		}
		return array(
			'second_query'	=> $second_query,
			'pages'			=> $pages,
			'paged'			=> $paged,
			'per_page'		=> $per_page,
			'range'			=> $range
		);
	}
}

/* this function prints pagination for gallery post type template */
if ( ! function_exists( 'gllr_template_pagination' ) ) {
	function gllr_template_pagination( $args ) {
		extract( $args );
		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && ( !( $i >= ( $paged + $range + 1 ) || $i <= ( $paged - $range - 1 ) ) || $pages <= $per_page ) ) {
				echo ( $paged == $i ) ? "<span class='page-numbers current'>". $i ."</span>" : "<a class='page-numbers inactive' href='". get_pagenum_link( $i ) ."'>" . $i . "</a>";
			}
		}
	}
}

/* this function prints content for single gallery template */
if ( ! function_exists( 'gllr_single_template_content' ) ) {
	function gllr_single_template_content() {
		global $post, $wp_query, $gllr_options, $gllr_vars_for_inline_script;
		wp_register_script( 'gllr_js', plugins_url( 'js/frontend_script.js', __FILE__ ), array( 'jquery' ) );
		
		$args = array(
			'post_type'				=> $gllr_options['post_type_name'],
			'post_status'			=> 'publish',
			'name'					=> $wp_query->query_vars['name'],
			'posts_per_page'		=> 1
		);
		$second_query = new WP_Query( $args );

		if ( $second_query->have_posts() ) {

			/* get width and height for image_size_photo */
			if ( 'photo-thumb' != $gllr_options['image_size_photo'] ) {
				$width  = absint( get_option( $gllr_options['image_size_photo'] . '_size_w' ) );
				$height = absint( get_option( $gllr_options['image_size_photo'] . '_size_h' ) );
			} else {
				$width  = $gllr_options['custom_size_px']['photo-thumb'][0];
				$height = $gllr_options['custom_size_px']['photo-thumb'][1];
			}

			while ( $second_query->have_posts() ) {
				$second_query->the_post(); ?>
				<h1 class="home_page_title entry-header"><?php the_title(); ?></h1>
				<div class="gallery_box_single entry-content">
					<?php if ( ! post_password_required() ) {
						the_content();

						$images_id = get_post_meta( $post->ID, '_gallery_images', true );

						$posts = get_posts( array(
							"showposts"			=>	-1,
							"what_to_show"		=>	"posts",
							"post_status"		=>	"inherit",
							"post_type"			=>	"attachment",
							"orderby"			=>	$gllr_options['order_by'],
							"order"				=>	$gllr_options['order'],
							"post_mime_type"	=>	"image/jpeg,image/gif,image/jpg,image/png",
							'post__in'			=> explode( ',', $images_id ),
							'meta_key'			=> '_gallery_order_' . $post->ID
						));
						if ( count( $posts ) > 0 ) {
							$count_image_block = 0; ?>
							<div class="gallery clearfix gllr_grid" data-columns="<?php echo $gllr_options["custom_image_row_count"]; ?>" data-border-width="<?php echo $gllr_options['border_images_width']; ?>">
								<?php foreach ( $posts as $attachment ) {
									$image_attributes = wp_get_attachment_image_src( $attachment->ID, $gllr_options['image_size_photo'] );
									$image_attributes_large = wp_get_attachment_image_src( $attachment->ID, 'large' );
									$image_attributes_full = wp_get_attachment_image_src( $attachment->ID, 'full' );
									if ( 1 == $gllr_options['border_images'] ) {
										$border = 'border-width: ' . $gllr_options['border_images_width'] . 'px; border-color:' . $gllr_options['border_images_color'] . ';border: ' . $gllr_options['border_images_width'] . 'px solid ' . $gllr_options['border_images_color'];
										$border_images = $gllr_options['border_images_width'] * 2;
									} else {
										$border = '';
										$border_images = 0;
									}
									$url_for_link = get_post_meta( $attachment->ID, 'gllr_link_url', true );
									$image_text = get_post_meta( $attachment->ID, 'gllr_image_text', true );
									$image_alt_tag = get_post_meta( $attachment->ID, 'gllr_image_alt_tag', true );

									if ( $count_image_block % $gllr_options['custom_image_row_count'] == 0 ) { ?>
										<div class="gllr_image_row">
									<?php } ?>
										<div class="gllr_image_block">
											<p style="<?php if ( $width ) echo 'width:' . ( $width + $border_images ) . 'px;'; if ( $height ) echo 'height:' . ( $height + $border_images ) . 'px;'; ?>">
												<?php if ( ! empty( $url_for_link ) ) { ?>
													<a href="<?php echo $url_for_link; ?>" title="<?php echo $image_text; ?>" target="_blank">
														<img <?php if ( $width ) echo 'width="' . $width . '"'; if ( $height ) echo 'height="' . $height . '"'; ?> style="<?php if ( $width ) echo 'width:' . $width . 'px;'; if ( $height ) echo 'height:' . $height . 'px;'; echo $border; ?>" alt="<?php echo $image_alt_tag; ?>" title="<?php echo $image_text; ?>" src="<?php echo $image_attributes[0]; ?>" />
													</a>
												<?php } else { ?>
													<a rel="gallery_fancybox<?php if ( 0 == $gllr_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $post->ID; ?>" href="<?php echo $image_attributes_large[0]; ?>" title="<?php echo $image_text; ?>" >
														<img <?php if ( $width ) echo 'width="' . $width . '"'; if ( $height ) echo 'height="' . $height . '"'; ?> style="<?php if ( $width ) echo 'width:' . $width . 'px;'; if ( $height ) echo 'height:' . $height . 'px;'; echo $border; ?>" alt="<?php echo $image_alt_tag; ?>" title="<?php echo $image_text; ?>" src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
													</a>
												<?php } ?>
											</p>
											<?php if ( 1 == $gllr_options["image_text"] ) { ?>
												<div <?php if ( $width ) echo 'style="width:' . ( $width + $border_images ) . 'px;"'; ?> class="gllr_single_image_text"><?php echo $image_text; ?>&nbsp;</div>
											<?php } ?>
										</div><!-- .gllr_image_block -->
									<?php if ( $count_image_block%$gllr_options['custom_image_row_count'] == $gllr_options['custom_image_row_count']-1 ) { ?>
										</div><!-- .gllr_image_row -->
									<?php }
									$count_image_block++;
								}
								if ( $count_image_block > 0 && $count_image_block%$gllr_options['custom_image_row_count'] != 0 ) { ?>
									</div><!-- .gllr_image_row -->
								<?php } ?>
							</div><!-- .gallery.clearfix -->
						<?php }
						if ( 1 == $gllr_options['return_link'] ) {
							if ( empty( $gllr_options['return_link_url'] ) ) {
								if ( ! empty( $gllr_options['page_id_gallery_template'] ) ) { ?>
									<div class="return_link gllr_return_link"><a href="<?php echo get_permalink( $gllr_options['page_id_gallery_template'] ); ?>"><?php echo $gllr_options['return_link_text']; ?></a></div>
								<?php }
							} else { ?>
								<div class="return_link gllr_return_link"><a href="<?php echo $gllr_options["return_link_url"]; ?>"><?php echo $gllr_options['return_link_text']; ?></a></div>
							<?php }
						}
						if ( $gllr_options['enable_lightbox'] ) {
							$gllr_vars_for_inline_script['single_script'][] = array(
								'post_id' => $post->ID
							);

							if ( defined( 'BWS_ENQUEUE_ALL_SCRIPTS' ) ) {
								gllr_echo_inline_script();
							}
						}
					} else { ?>
						<p><?php echo get_the_password_form(); ?></p>
					<?php } ?>
				</div><!-- .gallery_box_single -->
			<?php }			
		} else { ?>
			<div class="gallery_box_single">
				<p class="not_found"><?php _e( 'Sorry, nothing found.', 'gallery-plugin' ); ?></p>
			</div><!-- .gallery_box_single -->
		<?php }
	}
}

/* this function returns custom content with images for PDF&Print plugin in Gallery post */
if ( ! function_exists( 'gllr_add_pdf_print_content' ) ) {
	function gllr_add_pdf_print_content( $content, $params = '' ) {
		global $post, $wp_query, $gllr_options;
		$current_post_type = get_post_type();
		$custom_content = '';

		/* Displaying PDF&PRINT custom content for single gallery */
		if ( $gllr_options['post_type_name'] == $current_post_type && ! get_query_var( 'gallery_categories' ) ) {

			if ( 'photo-thumb' != $gllr_options['image_size_photo'] ) {
				$width  = absint( get_option( $gllr_options['image_size_photo'] . '_size_w' ) );
				$height = absint( get_option( $gllr_options['image_size_photo'] . '_size_h' ) );
			} else {
				$width  = $gllr_options['custom_size_px']['photo-thumb'][0];
				$height = $gllr_options['custom_size_px']['photo-thumb'][1];
			}

			$custom_content .= "
				<style type='text/css'>
					.gllr_grid,
					.gllr_grid td {
						border: none;
						vertical-align: top;
					}
					.gllr_grid {
						table-layout: fixed;
						margin: 0 auto;
					}
					.gllr_grid td img {
						width: {$width}px;
						height: {$height}px;
					}
				</style>\n";

			if ( 1 == $gllr_options['border_images'] )
				$image_style = "border: {$gllr_options['border_images_width']}px solid {$gllr_options['border_images_color']};";
			else
				$image_style = "border: none;";
			$image_style .= "margin: 0;";

			$args = array(
				'post_type'				=> $gllr_options['post_type_name'],
				'post_status'			=> 'publish',
				'name'					=> $wp_query->query_vars['name'],
				'posts_per_page'		=> 1
			);			
			$second_query = new WP_Query( $args );
			if ( $second_query->have_posts() ) {
				while ( $second_query->have_posts() ) {
					$second_query->the_post();
					$custom_content .= '<div class="gallery_box_single entry-content">';
						if ( ! post_password_required() ) {
							$images_id = get_post_meta( $post->ID, '_gallery_images', true );
							$posts = get_posts( array(
								"showposts"			=>	-1,
								"what_to_show"		=>	"posts",
								"post_status"		=>	"inherit",
								"post_type"			=>	"attachment",
								"orderby"			=>	$gllr_options['order_by'],
								"order"				=>	$gllr_options['order'],
								"post_mime_type"	=>	"image/jpeg,image/gif,image/jpg,image/png",
								"post__in"			=>	explode( ',', $images_id ),
								"meta_key"			=>	'_gallery_order_' . $post->ID
							) );

							if ( count( $posts ) > 0 ) {
								$count_image_block = 0;
								$custom_content .= '<table class="gallery clearfix gllr_grid">';
									foreach ( $posts as $attachment ) {
										$image_attributes = wp_get_attachment_image_src( $attachment->ID, $gllr_options['image_size_photo'] );
										if ( $count_image_block % $gllr_options['custom_image_row_count'] == 0 ) {
											$custom_content .= '<tr>';
										}
										$custom_content .= '<td class="gllr_image_block">
										<div>
											<img src="' . $image_attributes[0] . '" style="' . $image_style . '" />
										</div>';
										if ( 1 == $gllr_options["image_text"] ) {
											$custom_content .= '<div class="gllr_single_image_text">' . get_post_meta( $attachment->ID, 'gllr_image_text', true ) . '</div>';
										}
										$custom_content .= "</td><!-- .gllr_image_block -->\n";
										if ( $count_image_block % $gllr_options['custom_image_row_count'] == $gllr_options['custom_image_row_count']-1 ) {
											$custom_content .= "</tr>\n";
										}
										$count_image_block++;
									}
									if ( $count_image_block > 0 && $count_image_block % $gllr_options['custom_image_row_count'] != 0 ) {
										while ( $count_image_block % $gllr_options['custom_image_row_count'] != 0 ) {
											$custom_content .= '<td class="gllr_image_block"></td>';
											$count_image_block++;
										}
										$custom_content .= '</tr>';
									}
								$custom_content .= '</table><!-- .gallery.clearfix -->';
							}							
						}
					$custom_content .= '</div><!-- .gallery_box_single -->';
				}
			} else {
				$custom_content .= '<div class="gallery_box_single">
					<p class="not_found">' . __( 'Sorry, nothing found.', 'gallery-plugin' ) . '</p>
				</div><!-- .gallery_box_single -->';
			}
			$custom_content .= '<div class="gllr_clear"></div>';
		} elseif ( $post->ID == $gllr_options['page_id_gallery_template'] ) {
			if ( 'album-thumb' != $gllr_options['image_size_album'] ) {
				$width  = absint( get_option( $gllr_options['image_size_album'] . '_size_w' ) );
				$height = absint( get_option( $gllr_options['image_size_album'] . '_size_h' ) );
			} else {
				$width  = $gllr_options['custom_size_px']['album-thumb'][0];
				$height = $gllr_options['custom_size_px']['album-thumb'][1];
			}
			/* Displaying PDF&PRINT custom content for gallery pro template */
			$custom_content .= "<style type='text/css'>
				.gllr-list {
					list-style: none;
					margin-left: 0;
					padding: 0;
				}
				.gllr-list li > a > img {
					width: {$width}px;
					height: {$height}px;
					margin: 10px 0;
				}
				#gallery_pagination > span,
				#gallery_pagination > a {
					display: inline-block;
					padding: 5px;
				}
			</style>";
			$custom_content .= '<ul class="gllr-list">';
				global $request;
				if ( get_query_var( 'paged' ) ) {
					$paged = get_query_var( 'paged' );
				} elseif ( get_query_var( 'page' ) ) {
					$paged = get_query_var( 'page' );
				} else {
					$paged = 1;
				}
				$count = 0;
				$per_page = $showitems = get_option( 'posts_per_page' );

				$args = array(
					'post_type'			=> $gllr_options['post_type_name'],
					'post_status'		=> 'publish',
					'orderby'			=> $gllr_options['album_order_by'],
					'order'				=> $gllr_options['album_order'],
					'posts_per_page'	=> $per_page,
					'paged'				=> $paged
				);
				if ( isset( $wp_query->query_vars["gallery_categories"] ) && ( ! empty( $wp_query->query_vars["gallery_categories"] ) ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy'  => 'gallery_categories',
							'field'     => 'slug',
							'terms'     => $wp_query->query_vars["gallery_categories"]
						)
					);
				}
				$second_query = new WP_Query( $args );
				$request = $second_query->request;

				if ( $second_query->have_posts() ) {
					while ( $second_query->have_posts() ) {
						$second_query->the_post();
						$attachments	= get_post_thumbnail_id( $post->ID );
						if ( empty( $attachments ) ) {
							$images_id = get_post_meta( $post->ID, '_gallery_images', true );
							$attachments = get_posts( array(
								'showposts'			=>	1,
								'what_to_show'		=>	'posts',
								'post_status'		=>	'inherit',
								'post_type'			=>	'attachment',
								'orderby'			=>	$gllr_options['order_by'],
								'order'				=>	$gllr_options['order'],
								'post_mime_type'	=>	'image/jpeg,image/gif,image/jpg,image/png',
								'post__in'			=> explode( ',', $images_id ),
								'meta_key'			=> '_gallery_order_' . $post->ID
							));
							if ( ! empty( $attachments[0] ) ) {
								$first_attachment = $attachments[0];
								$image_attributes = wp_get_attachment_image_src( $first_attachment->ID, $gllr_options['image_size_album'] );
							} else
								$image_attributes = array( '' );
						} else {
							$image_attributes = wp_get_attachment_image_src( $attachments, $gllr_options['image_size_album'] );
						}
						if ( 1 == $gllr_options['cover_border_images'] ) {
							$border = 'border: ' . $gllr_options['cover_border_images_width'] . 'px solid ' . $gllr_options['cover_border_images_color'] . '; padding:0;';
						} else {
							$border = 'padding:0;';
						}
						$custom_content .= '<li>';
							$excerpt = wp_strip_all_tags( get_the_content() );
							if ( strlen( $excerpt ) > 100 )
								$excerpt = substr( $excerpt, 0, strripos( substr( $excerpt, 0, 100 ), ' ' ) ) . '...';
							$custom_content .= '<img width="' . $width . '" height="' . $height . '" style="width:' . $width . 'px; height:' . $height . 'px;' . $border . '" src="' . $image_attributes[0] . '" />
							<div class="gallery_detail_box">
								<div>' . get_the_title() . '</div>
								<div>' . $excerpt . '</div>';
								if ( $gllr_options["hide_single_gallery"] == 0 ) {
									$custom_content .= '<a href="' . get_permalink() . '">' . $gllr_options["read_more_link_text"] . '</a>';
								}
							$custom_content .= '</div><!-- .gallery_detail_box -->
							<div class="gllr_clear"></div>
						</li>';
					}
				}
			$custom_content .= '</ul>';
		}
		
		/* Displaying PDF&PRINT custom content for shortcode */
		if ( ! empty( $params ) && 'array' == gettype( $params ) ) { 
			extract( shortcode_atts( array(
					'id'		=> '',
					'display'	=> 'full',
					'cat_id'	=>	''
				), $params )
			);

			$old_wp_query = $wp_query;

			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( ! empty( $cat_id ) && is_plugin_active( 'gallery-categories/gallery-categories.php' ) ) {
				global $post, $wp_query;
				$term = get_term( $cat_id, 'gallery_categories' );
				if ( ! empty( $term ) ) {
					$args = array(
						'post_type'			=> $gllr_options['post_type_name'],
						'post_status'		=> 'publish',
						'posts_per_page'	=> -1,
						'gallery_categories'=> $term->slug,
						'orderby'			=> $gllr_options['album_order_by'],
						'order'				=> $gllr_options['album_order']
					);
					$second_query = new WP_Query( $args );
					$custom_content .= "<style type='text/css'>
						.gallery_box ul {
							list-style: none outside none !important;
							margin: 0;
							padding: 0;
						}
						.gallery_box ul li {
							margin: 0 0 20px;
						}
						.gallery_box li img {
							margin: 0 10px 10px 0;
							float: left;
							box-sizing: content-box;
							-moz-box-sizing: content-box;
							-webkit-box-sizing: content-box;
						}
						.rtl .gallery_box li img {
							margin: 0 0 10px 10px;
							float: right;
						}
						.gallery_detail_box {
							clear: both;
							float: left;
						}
						.rtl .gallery_detail_box {
							float: right;
						}
						.gllr_clear {
							clear: both;
							height: 0;
						}
					</style>";
					$custom_content .= '<div class="gallery_box">
						<ul>';
							if ( $second_query->have_posts() ) {
								if ( 'album-thumb' != $gllr_options['image_size_album'] ) {
									$width  = absint( get_option( $gllr_options['image_size_album'] . '_size_w' ) );
									$height = absint( get_option( $gllr_options['image_size_album'] . '_size_h' ) );
								} else {
									$width  = $gllr_options['custom_size_px']['album-thumb'][0];
									$height = $gllr_options['custom_size_px']['album-thumb'][1];
								}
								if ( 1 == $gllr_options['cover_border_images'] ) {
									$border = 'border-width: ' . $gllr_options['cover_border_images_width'] . 'px; border-color: ' . $gllr_options['cover_border_images_color'] . ';border: ' . $gllr_options['cover_border_images_width'] . 'px solid ' . $gllr_options['cover_border_images_color'];
								} else {
									$border = "";
								}

								while ( $second_query->have_posts() ) {
									$second_query->the_post();
									$attachments = get_post_thumbnail_id( $post->ID );
									if ( empty( $attachments ) ) {
										$images_id = get_post_meta( $post->ID, '_gallery_images', true );
										$attachments = get_posts( array(
											'showposts'			=>	1,
											'what_to_show'		=>	'posts',
											'post_status'		=>	'inherit',
											'post_type'			=>	'attachment',
											'orderby'			=>	$gllr_options['order_by'],
											'order'				=>	$gllr_options['order'],
											'post_mime_type'	=>	'image/jpeg,image/gif,image/jpg,image/png',
											'post__in'			=> explode( ',', $images_id ),
											'meta_key'			=> '_gallery_order_' . $post->ID
										) );
										if ( ! empty( $attachments[0] ) ) {
											$first_attachment = $attachments[0];
											$image_attributes = wp_get_attachment_image_src( $first_attachment->ID, $gllr_options['image_size_album'] );
										} else {
											$image_attributes = array( '' );
										}
									} else {
										$image_attributes = wp_get_attachment_image_src( $attachments, $gllr_options['image_size_album'] );
									}
									$excerpt = wp_strip_all_tags( get_the_content() );
									if ( strlen( $excerpt ) > 100 )
										$excerpt = substr( $excerpt, 0, strripos( substr( $excerpt, 0, 100 ), ' ' ) ) . '...';
									$custom_content .= '<li>
										<img width="' . $width . '" height="' . $height . '" style="width:' . $width . 'px; height:' . $height . 'px;' .$border . '" src="' . $image_attributes[0] . '" />
										<div class="gallery_detail_box">
											<div>' . get_the_title() . '</div>
											<div>' . $excerpt . '</div>
											<a href="' . get_permalink( $post->ID ) . '">' . $gllr_options["read_more_link_text"]. '</a>
										</div><!-- .gallery_detail_box -->
										<div class="gllr_clear"></div>
									</li>';
								}
							}
						$custom_content .= '</ul>
					</div><!-- .gallery_box -->';
				}
			} else {
				$args = array(
					'post_type'			=> $gllr_options['post_type_name'],
					'post_status'		=> 'publish',
					'p'					=> $id,
					'posts_per_page'	=> 1
				);
				$second_query = new WP_Query( $args );

				if ( $display == 'short' ) {
					if ( $second_query->have_posts() ) {
						$second_query->the_post();
						$attachments	= get_post_thumbnail_id( $post->ID );
						if ( empty( $attachments ) ) {
							$images_id = get_post_meta( $post->ID, '_gallery_images', true );
							$attachments = get_posts( array(
								'showposts'			=>	1,
								'what_to_show'		=>	'posts',
								'post_status'		=>	'inherit',
								'post_type'			=>	'attachment',
								'orderby'			=>	$gllr_options['order_by'],
								'order'				=>	$gllr_options['order'],
								'post_mime_type'	=>	'image/jpeg,image/gif,image/jpg,image/png',
								'post__in'			=> explode( ',', $images_id ),
								'meta_key'			=> '_gallery_order_' . $post->ID
							));
							if ( ! empty( $attachments[0] ) ) {
								$first_attachment = $attachments[0];
								$image_attributes_featured = wp_get_attachment_image_src( $first_attachment->ID, $gllr_options['image_size_album'] );
							} else
								$image_attributes_featured = array( '' );
						} else {
							$image_attributes_featured = wp_get_attachment_image_src( $attachments, $gllr_options['image_size_album'] );
						}

						if ( 1 == $gllr_options['cover_border_images'] ) {
							$border = 'border-width: ' . $gllr_options['cover_border_images_width'] . 'px; border-color: ' . $gllr_options['cover_border_images_color'] . ';border: ' . $gllr_options['cover_border_images_width'] . 'px solid ' . $gllr_options['cover_border_images_color'];
						} else {
							$border = "";
						}

						$excerpt = wp_strip_all_tags( get_the_content() );
						if ( strlen( $excerpt ) > 100 )
							$excerpt = substr( $excerpt, 0, strripos( substr( $excerpt, 0, 100 ), ' ' ) ) . '...';
						if ( 'album-thumb' != $gllr_options['image_size_album'] ) {
							$width  = absint( get_option( $gllr_options['image_size_album'] . '_size_w' ) );
							$height = absint( get_option( $gllr_options['image_size_album'] . '_size_h' ) );
						} else {
							$width  = $gllr_options['custom_size_px']['album-thumb'][0];
							$height = $gllr_options['custom_size_px']['album-thumb'][1];
						}
						$custom_content .= '<div class="gallery_box">';
						$custom_content .= "<img width=\"{$width}\" height=\"{$height}\" style=\"width:{$width}px; height:{$height}px; {$border}\" src=\"{$image_attributes_featured[0]}\" />";
						$custom_content .= '<div class="gallery_detail_box">
												<div>' . get_the_title() . '</div>
												<p>' . $excerpt . '</p>';
						if ( $gllr_options["hide_single_gallery"] == 0 ) {
							$custom_content .= '<a href="' . get_permalink() . '">' . $gllr_options["read_more_link_text"] . '</a>';
						}
						$custom_content .= '</div><!-- .gallery_detail_box -->
										<div class=\"gllr_clear\"></div>
									</div>';
					}
				} else {
					$custom_content .= '<div class="gallery_box_single">';
						if ( $second_query->have_posts() ) {
							if ( 'photo-thumb' != $gllr_options['image_size_photo'] ) {
								$width  = absint( get_option( $gllr_options['image_size_photo'] . '_size_w' ) );
								$height = absint( get_option( $gllr_options['image_size_photo'] . '_size_h' ) );
							} else {
								$width  = $gllr_options['custom_size_px']['photo-thumb'][0];
								$height = $gllr_options['custom_size_px']['photo-thumb'][1];
							}
							while ( $second_query->have_posts() ) {
								$second_query->the_post();
								$custom_content .= do_shortcode( get_the_content() );

								$images_id = get_post_meta( $post->ID, '_gallery_images', true );

								$posts = get_posts( array(
									"what_to_show"		=> "posts",
									"post_status"		=> "inherit",
									"post_type"			=> "attachment",
									"orderby"			=> $gllr_options['order_by'],
									"order"				=> $gllr_options['order'],
									"post_mime_type"	=> "image/jpeg,image/gif,image/jpg,image/png",
									'post__in'			=> explode( ',', $images_id ),
									'meta_key'			=> '_gallery_order_' . $post->ID,
									"posts_per_page"	=> -1
								) );

								if ( count( $posts ) > 0 ) {
									$count_image_block = 0;

									if ( 1 == $gllr_options['border_images'] ) {
										$border_images_width = $gllr_options['border_images_width'];
										$border = 'border-width: ' . $border_images_width . 'px; border-color: ' . $gllr_options['border_images_color'] . ';border: ' . $border_images_width . 'px solid ' . $gllr_options['border_images_color'];
										$border_images = $border_images_width * 2;
									} else {
										$border_images_width = 0;
										$border = '';
										$border_images = 0;
									}

									$custom_content .= "
										<style type='text/css'>
											.gllr_table,
											.gllr_table td {
												border: none;
												vertical-align: top;
											}
											.gllr_table {
												table-layout: fixed;
												margin: 0 auto;
											}
											.gllr_table td img {		
												width: {$width}px;
												height: {$height}px;
											}
										</style>\n";

									if ( 1 == $gllr_options['border_images'] ) {
										$image_style = "border: {$gllr_options['border_images_width']}px solid {$gllr_options['border_images_color']};";
									} else {
										$image_style = "border: none;";
									}
									$image_style .= "margin: 0;";

									$custom_content .= '<table class="gallery clearfix gllr_table" data-columns="' . $gllr_options["custom_image_row_count"] . '" data-border-width="' . $border_images_width . '"' . ( ( 1 == $gllr_options["image_text"] ) ? 'data-image-text-position="' . $gllr_options["image_text_position"] . '"' : '' ) . '>';

										foreach ( $posts as $attachment ) {
											$image_attributes = wp_get_attachment_image_src( $attachment->ID, $gllr_options['image_size_photo'] );
											$title = get_post_meta( $attachment->ID, 'gllr_image_text', true );
											if ( $count_image_block % $gllr_options['custom_image_row_count'] == 0 ) {
												$custom_content .= '<tr>';
											}
											$custom_content .= '<td class="gllr_image_block">';
											$custom_content .= '<div>';
												$custom_content .= '<img src="' . $image_attributes[0] . '" style="' . $image_style . '" />';
											$custom_content .= '</div>';
											if ( 1 == $gllr_options["image_text"] && $title != '' ) {
												$custom_content .= '<div style="width:' . ( $width + $border_images ) . 'px;" class="gllr_single_image_text">' . $title . '</div>';
											}
											$custom_content .= '</td>';
											if ( $count_image_block%$gllr_options['custom_image_row_count'] == $gllr_options['custom_image_row_count']-1 ) {
												$custom_content .= '</tr>';
											}
											$count_image_block++;
										}
										if ( $count_image_block > 0 && $count_image_block%$gllr_options['custom_image_row_count'] != 0 ) {
											$custom_content .= '</tr>';
										}
									$custom_content .= '</table>';
								}
							}
						}
					$custom_content .= '</div><!-- .gallery_box_single -->';
					$custom_content .= '<div class="gllr_clear"></div>';
				}
			}
			wp_reset_query();
			$wp_query = $old_wp_query;
		}
		return $content . $custom_content;
	}
}

/* Change the columns for the edit CPT screen */
if ( ! function_exists( 'gllr_change_columns' ) ) {
	function gllr_change_columns( $cols ) {
		$cols = array(
			'cb'				=>	'<input type="checkbox" />',
			'featured-image'	=>	__( 'Featured Image', 'gallery-plugin' ),
			'title'				=>	__( 'Title', 'gallery-plugin' ),
			'images'			=>	__( 'Images', 'gallery-plugin' ),
			'shortcode'			=>	__( 'Shortcode', 'gallery-plugin' ),
			'author'			=>	__( 'Author', 'gallery-plugin' ),			
			'date'				=>	__( 'Date', 'gallery-plugin' )
		);
		return $cols;
	}
}

if ( ! function_exists( 'gllr_custom_columns' ) ) {
	function gllr_custom_columns( $column, $post_id ) {
		global $wpdb;
		$post = get_post( $post_id );
		switch ( $column ) {
			case "shortcode":
				bws_shortcode_output( '[print_gllr id=' . $post->ID . ']' );
				echo '<br/>';
				bws_shortcode_output( '[print_gllr id=' . $post->ID . ' display=short]' );
				break;
			case "featured-image":
				echo get_the_post_thumbnail( $post->ID, array( 65, 65 ) );
				break;
			case "images":
				$images_id = get_post_meta( $post->ID, '_gallery_images', true );
				if ( empty( $images_id  ) )
					echo 0;
				else
					echo $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->posts . " WHERE ID IN( " . $images_id . " )" );
				break;
		}
	}
}

if ( ! function_exists( 'gllr_manage_pre_get_posts' ) ) {
	function gllr_manage_pre_get_posts( $query ) {
		global $gllr_options;

		if ( is_admin() && $query->is_main_query() && $query->get( 'post_type' ) == $gllr_options['post_type_name'] && ! isset( $_GET['order'] ) && ( $orderby = $query->get( 'orderby' ) ) ) {
			$query->set( 'orderby', $gllr_options['album_order_by'] );
			$query->set( 'order', $gllr_options['album_order'] );
		}
	}
}

if ( ! function_exists( 'gllr_the_excerpt_max_charlength' ) ) {
	function gllr_the_excerpt_max_charlength( $charlength ) {
		$excerpt = wp_strip_all_tags( get_the_content() );
		$charlength ++;
		if ( strlen( $excerpt ) > $charlength ) {
			$subex = substr( $excerpt, 0, $charlength-5 );
			$exwords = explode( " ", $subex );
			$excut = - ( strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo substr( $subex, 0, $excut );
			} else {
				echo $subex;
			}
			echo "...";
		} else {
			echo $excerpt;
		}
	}
}

if ( ! function_exists( 'gllr_settings_page' ) ) {
	function gllr_settings_page() {
		require_once( dirname( __FILE__ ) . '/inc/class-gllr-settings.php' );
		$page = new Gllr_Settings_Tabs( plugin_basename( __FILE__ ) ); ?>
		<div class="wrap">
			<h1><?php _e( 'Gallery Settings', 'gallery-plugin' ); ?></h1>
			<?php $page->display_content(); ?>
		</div>
	<?php }
}

/**
 * Remove shortcode from the content of the same gallery
 */
if ( ! function_exists ( 'gllr_content_save_pre' ) ) {
	function gllr_content_save_pre( $content ) {
		global $post, $gllr_options;

		if ( isset( $post ) && $gllr_options['post_type_name'] == $post->post_type && ! wp_is_post_revision( $post->ID ) && ! empty( $_POST ) ) {
			/* remove shortcode */
			$content = preg_replace( '/\[print_gllr id=' . $post->ID . '( display=short){0,1}\]/', '', $content );
		}
		return $content;
	}
}

if ( ! function_exists( 'gllr_register_plugin_links' ) ) {
	function gllr_register_plugin_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			if ( ! is_network_admin() && ! is_plugin_active( 'gallery-plugin-pro/gallery-plugin-pro.php' ) )
				$links[]	=	'<a href="edit.php?post_type=bws-gallery&page=gallery-plugin.php">' . __( 'Settings', 'gallery-plugin' ) . '</a>';
			$links[]	=	'<a href="https://support.bestwebsoft.com/hc/en-us/sections/200538899" target="_blank">' . __( 'FAQ', 'gallery-plugin' ) . '</a>';
			$links[]	=	'<a href="https://support.bestwebsoft.com">' . __( 'Support', 'gallery-plugin' ) . '</a>';
		}
		return $links;
	}
}

if ( ! function_exists( 'gllr_plugin_action_links' ) ) {
	function gllr_plugin_action_links( $links, $file ) {
		if ( ! is_network_admin() && ! is_plugin_active( 'gallery-plugin-pro/gallery-plugin-pro.php' ) ) {
			/* Static so we don't call plugin_basename on every plugin row. */
			static $this_plugin;
			if ( ! $this_plugin )
				$this_plugin = plugin_basename( __FILE__ );

			if ( $file == $this_plugin ) {
				$settings_link = '<a href="edit.php?post_type=bws-gallery&page=gallery-plugin.php">' . __( 'Settings', 'gallery-plugin' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}

if ( ! function_exists ( 'gllr_admin_head' ) ) {
	function gllr_admin_head() {
		global $wp_version, $gllr_plugin_info, $post_type, $pagenow, $gllr_options;

		wp_enqueue_style( 'gllr_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		wp_enqueue_script( 'jquery' );

		if ( isset( $_GET['page'] ) && "gallery-plugin.php" == $_GET['page'] ) {
			wp_enqueue_style( 'wp-color-picker' );
			bws_enqueue_settings_scripts();
			bws_plugins_include_codemirror();
			wp_enqueue_script( 'gllr_script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ) );
			wp_localize_script( 'gllr_script', 'gllr_vars',
				array(
					'gllr_nonce'			=> wp_create_nonce( plugin_basename( __FILE__ ), 'gllr_ajax_nonce_field' ),
					'update_img_message'	=> __( 'Updating images...', 'gallery-plugin' ) . '<img class="gllr_loader" src="' . plugins_url( 'images/ajax-loader.gif', __FILE__ ) . '" alt="" />',
					'not_found_img_info' 	=> __( 'No images found.', 'gallery-plugin' ),
					'img_success' 			=> __( 'All images were updated.', 'gallery-plugin' ),
					'img_error'				=> __( 'Error.', 'gallery-plugin' )
				) );
		} else if (
			( $pagenow == 'post.php' && isset( $_GET['action'] ) && $_GET['action'] == 'edit' && get_post_type( get_the_ID() ) == $gllr_options['post_type_name'] ) ||
			( $pagenow == 'post-new.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == $gllr_options['post_type_name'] ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
			bws_enqueue_settings_scripts();
			wp_enqueue_script( 'gllr_script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ) );
			wp_localize_script( 'gllr_script', 'gllr_vars',
				array(
					'gllr_nonce'				=> wp_create_nonce( plugin_basename( __FILE__ ), 'gllr_ajax_nonce_field' ),
					'gllr_add_nonce'			=> wp_create_nonce( plugin_basename( __FILE__ ), 'gllr_ajax_add_nonce' ),
					'warnBulkDelete'			=> __( "You are about to remove these items from this gallery.\n 'Cancel' to stop, 'OK' to delete.", 'gallery-plugin' ),
					'warnSingleDelete'			=> __( "You are about to remove this image from the gallery.\n 'Cancel' to stop, 'OK' to delete.", 'gallery-plugin' ),
					'confirm_update_gallery'	=> __( "Switching to another mode, all unsaved data will be lost. Save data before switching?", 'gallery-plugin' ),
					'wp_media_title'			=> __( 'Insert Media', 'gallery-plugin' ),
					'wp_media_button'			=> __( 'Insert', 'gallery-plugin' ),
				)
			);
		}
		/* Scripts for tooltips */
		if ( isset( $post_type ) && $gllr_options['post_type_name'] == $post_type ) {
			if ( ! function_exists( 'bws_add_tooltip_in_admin' ) )
				require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );

			if ( ! function_exists( 'get_plugins' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$all_plugins = get_plugins();
			$learn_more = str_replace( ' ', '&nbsp', __( 'Learn more', 'gallery-plugin' ) );
			/* tooltip for gallery categories */
			if ( isset( $all_plugins['gallery-categories/gallery-categories.php'] ) ) {
				/* if gallery categories is installed */
				$link = "plugins.php";
				$text = __( 'Activate', 'gallery-plugin' );
			} else {
				$link = self_admin_url( 'plugin-install.php?tab=search&type=term&s=Gallery+Categories+BestWebSoft&plugin-search-input=Search+Plugins' );
				$text = __( 'Install Now', 'gallery-plugin' );
			}

			$tooltip_args = array(
				'tooltip_id'	=> 'gllr_install_gallery_categories_tooltip',
				'css_selector' 	=> '#gallery_categories-add-toggle',
				'actions' 		=> array(
					'click' 	=> true,
					'onload' 	=> true,
				),
				'content' 		=> '<h3>' . __( 'Add multiple gallery categories', 'gallery-plugin' ) . '</h3><p>' . __( "Install Gallery Categories plugin to add unlimited number of categories.", 'gallery-plugin' ) . ' <a href="https://bestwebsoft.com/products/wordpress/plugins/gallery-categories/?k=bb17b69bfb50827f3e2a9b3a75978760&pn=79&v=' . $gllr_plugin_info["Version"] . '&wp_v=' . $wp_version . '" target="_blank">' . $learn_more . '</a></p>',
				'buttons'		=> array(
					array(
						'type' => 'link',
						'link' => $link,
						'text' => $text
					),
					'close' => array(
						'type' => 'dismiss',
						'text' => __( 'Close', 'gallery-plugin' ),
					),
				),
				'position' => array(
					'edge' => is_rtl() ? 'left' : 'right',
				),
			);
			bws_add_tooltip_in_admin( $tooltip_args );
		}
	}
}

if ( ! function_exists( 'gllr_wp_head' ) ) {
	function gllr_wp_head() {
		global $gllr_options;
		wp_enqueue_style( 'gllr_stylesheet', plugins_url( 'css/frontend_style.css', __FILE__ ) );

		if ( $gllr_options['enable_lightbox'] ) {
			wp_enqueue_style( 'gllr_fancybox_stylesheet', plugins_url( 'fancybox/jquery.fancybox-1.3.4.css', __FILE__ ) ); ?>
			<!-- Start ios -->
			<script type="text/javascript">
				( function( $ ){
					$( document ).ready( function() {
						$( '#fancybox-overlay' ).css( {
							'width' : $( document ).width()
						} );
					} );
				} )( jQuery );
			</script>
			<!-- End ios -->
		<?php }
		if ( 1 == $gllr_options["image_text"] ) { ?>
			<style type="text/css">
				.gllr_image_row {
					clear: both;
				}
			</style>
		<?php }
	}
}

/* Function for script enqueing */
if ( ! function_exists ( 'gllr_wp_footer' ) ) {
	function gllr_wp_footer() {
		global $gllr_options;

		if ( ! defined( 'BWS_ENQUEUE_ALL_SCRIPTS' ) && ! wp_script_is( 'gllr_js', 'registered' ) )
			return;

		wp_enqueue_script( 'jquery' );

		if ( ! wp_script_is( 'gllr_js', 'registered' ) )
			wp_enqueue_script( 'gllr_js', plugins_url( 'js/frontend_script.js', __FILE__ ) );
		else
			wp_enqueue_script( 'gllr_js' );

		if ( $gllr_options['enable_lightbox'] ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( ! ( is_plugin_active( 'portfolio-pro/portfolio-pro.php' ) && wp_script_is( 'prtfl_front_script', 'registered' ) ) ) {
				wp_enqueue_script( 'gllr_fancybox_mousewheel_js', plugins_url( 'fancybox/jquery.mousewheel-3.0.4.pack.js', __FILE__ ), array( 'jquery' ), true );
				wp_enqueue_script( 'gllr_fancybox_js', plugins_url( 'fancybox/jquery.fancybox-1.3.4.pack.js', __FILE__ ), array( 'jquery' ), true );
			}

			if ( ! defined( 'BWS_ENQUEUE_ALL_SCRIPTS' ) )
				wp_enqueue_script( 'gllr_inline_fancybox_script', gllr_echo_inline_script(), array( 'jquery' ), true );
		}
	}
}

if ( ! function_exists( 'gllr_pagination_callback' ) ) {
	function gllr_pagination_callback( $content ) {
		$content .= '$( ".gllr_grid:visible" ).trigger( "resize" ); if ( typeof gllr_fancy_init === "function" ) { gllr_fancy_init(); }';
		return $content;
	}
}

if ( ! function_exists ( 'gllr_shortcode' ) ) {
	function gllr_shortcode( $attr ) {
		global $gllr_options, $gllr_vars_for_inline_script;

		wp_register_script( 'gllr_js', plugins_url( 'js/frontend_script.js', __FILE__ ), array( 'jquery' ) );

		if ( isset( $_GET['print'] ) )
			return gllr_add_pdf_print_content( '', $attr );

		extract( shortcode_atts( array(
				'id'		=> '',
				'display'	=> 'full',
				'cat_id'	=>	''
			), $attr )
		);
		ob_start();
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if ( ! empty( $cat_id ) && is_plugin_active( 'gallery-categories/gallery-categories.php' ) ) {
			global $post, $wp_query;

			$term = get_term( $cat_id, 'gallery_categories' );
			if ( ! empty( $term ) ) {

				$old_wp_query = $wp_query;

				$args = array(
					'post_type'			=> $gllr_options['post_type_name'],
					'post_status'		=> 'publish',
					'posts_per_page'	=> -1,
					'gallery_categories'=> $term->slug,
					'orderby'			=> $gllr_options['album_order_by'],
					'order'				=> $gllr_options['album_order']
				);
				$second_query = new WP_Query( $args ); ?>
				<div class="gallery_box">
					<ul>
						<?php if ( $second_query->have_posts() ) {
							if ( 1 == $gllr_options['cover_border_images'] ) {
								$border = 'border-width: ' . $gllr_options['cover_border_images_width'] . 'px; border-color:' . $gllr_options['cover_border_images_color'] . ';border: ' . $gllr_options['cover_border_images_width'] . 'px solid ' . $gllr_options['cover_border_images_color'];
							} else {
								$border = "";
							}
							if ( 'album-thumb' != $gllr_options['image_size_album'] ) {
								$width  = absint( get_option( $gllr_options['image_size_album'] . '_size_w' ) );
								$height = absint( get_option( $gllr_options['image_size_album'] . '_size_h' ) );
							} else {
								$width  = $gllr_options['custom_size_px']['album-thumb'][0];
								$height = $gllr_options['custom_size_px']['album-thumb'][1];
							}

							while ( $second_query->have_posts() ) {
								$second_query->the_post();
								$attachments = get_post_thumbnail_id( $post->ID );
								if ( empty( $attachments ) ) {
									$images_id = get_post_meta( $post->ID, '_gallery_images', true );
									$attachments = get_posts( array(
										'showposts'			=>	1,
										'what_to_show'		=>	'posts',
										'post_status'		=>	'inherit',
										'post_type'			=>	'attachment',
										'orderby'			=>	$gllr_options['order_by'],
										'order'				=>	$gllr_options['order'],
										'post_mime_type'	=>	'image/jpeg,image/gif,image/jpg,image/png',
										'post__in'			=> explode( ',', $images_id ),
										'meta_key'			=> '_gallery_order_' . $post->ID
									));
									if ( ! empty( $attachments[0] ) ) {
										$first_attachment = $attachments[0];
										$image_attributes = wp_get_attachment_image_src( $first_attachment->ID, $gllr_options['image_size_album'] );
									} else
										$image_attributes = array( '' );
								} else {
									$image_attributes = wp_get_attachment_image_src( $attachments, $gllr_options['image_size_album'] );
								} ?>
								<li>
									<a rel="bookmark" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
										<img <?php if ( $width ) echo 'width="' . $width . '"'; if ( $height ) echo 'height="' . $height . '"'; ?> style="<?php if ( $width ) echo 'width:' . $width . 'px;'; if ( $height ) echo 'height:' . $height . 'px;'; echo $border; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" src="<?php echo $image_attributes[0]; ?>" />
									</a>
									<div class="gallery_detail_box">
										<div><?php the_title(); ?></div>
										<div><?php gllr_the_excerpt_max_charlength( 100 ); ?></div>
										<a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $gllr_options["read_more_link_text"]; ?></a>
									</div><!-- .gallery_detail_box -->
									<div class="gllr_clear"></div>
								</li>
							<?php }
						} ?>
					</ul>
				</div><!-- .gallery_box -->
				<?php wp_reset_query();
				$wp_query = $old_wp_query;
			}
		} else {
			global $post, $wp_query;
			$old_wp_query = $wp_query;

			$args = array(
				'post_type'			=> $gllr_options['post_type_name'],
				'post_status'		=> 'publish',
				'p'					=> $id,
				'posts_per_page'	=> 1
			);
			$second_query = new WP_Query( $args );
			if ( $display == 'short' ) { ?>
				<div class="gallery_box">
					<ul>
						<?php if ( $second_query->have_posts() ) {
							$second_query->the_post();
							$attachments = get_post_thumbnail_id( $post->ID );

							if ( 'album-thumb' != $gllr_options['image_size_album'] ) {
								$width  = absint( get_option( $gllr_options['image_size_album'] . '_size_w' ) );
								$height = absint( get_option( $gllr_options['image_size_album'] . '_size_h' ) );
							} else {
								$width  = $gllr_options['custom_size_px']['album-thumb'][0];
								$height = $gllr_options['custom_size_px']['album-thumb'][1];
							}

							if ( empty( $attachments ) ) {
								$images_id = get_post_meta( $post->ID, '_gallery_images', true );
								$attachments = get_posts( array(
									'showposts'			=>	1,
									'what_to_show'		=>	'posts',
									'post_status'		=>	'inherit',
									'post_type'			=>	'attachment',
									'orderby'			=>	$gllr_options['order_by'],
									'order'				=>	$gllr_options['order'],
									'post_mime_type'	=>	'image/jpeg,image/gif,image/jpg,image/png',
									'post__in'			=> explode( ',', $images_id ),
									'meta_key'			=> '_gallery_order_' . $post->ID
								));
								if ( ! empty( $attachments[0] ) ) {
									$first_attachment = $attachments[0];
									$image_attributes = wp_get_attachment_image_src( $first_attachment->ID, $gllr_options['image_size_album'] );
								} else
									$image_attributes = array( '' );
							} else {
								$image_attributes = wp_get_attachment_image_src( $attachments, $gllr_options['image_size_album'] );
							}

							if ( 1 == $gllr_options['cover_border_images'] ) {
								$border = 'border-width: ' . $gllr_options['cover_border_images_width'] . 'px; border-color:' . $gllr_options['cover_border_images_color'] . ';border: ' . $gllr_options['cover_border_images_width'] . 'px solid ' . $gllr_options['cover_border_images_color'];
							} else {
								$border = '';
							} ?>
							<li>
								<a rel="bookmark" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
									<img <?php if ( $width ) echo 'width="' . $width . '"'; if ( $height ) echo 'height="' . $height . '"'; ?> style="<?php if ( $width ) echo 'width:' . $width . 'px;'; if ( $height ) echo 'height:' . $height . 'px;'; echo $border; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" src="<?php echo $image_attributes[0]; ?>" />
								</a>
								<div class="gallery_detail_box">
									<div><?php the_title(); ?></div>
									<div><?php gllr_the_excerpt_max_charlength( 100 ); ?></div>
									<a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $gllr_options["read_more_link_text"]; ?></a>
								</div><!-- .gallery_detail_box -->
								<div class="gllr_clear"></div>
							</li>
						<?php } ?>
					</ul>
				</div><!-- .gallery_box -->
			<?php } else {
				if ( $second_query->have_posts() ) {
					if ( 1 == $gllr_options['border_images'] ) {
						$border = 'border-width: ' . $gllr_options['border_images_width'] . 'px; border-color:' . $gllr_options['border_images_color'] . ';border: ' . $gllr_options['border_images_width'] . 'px solid ' . $gllr_options['border_images_color'];
						$border_images = $gllr_options['border_images_width'] * 2;
					} else {
						$border = '';
						$border_images = 0;
					}
					if ( 'photo-thumb' != $gllr_options['image_size_photo'] ) {
						$width  = absint( get_option( $gllr_options['image_size_photo'] . '_size_w' ) );
						$height = absint( get_option( $gllr_options['image_size_photo'] . '_size_h' ) );
					} else {
						$width  = $gllr_options['custom_size_px']['photo-thumb'][0];
						$height = $gllr_options['custom_size_px']['photo-thumb'][1];
					}

					while ( $second_query->have_posts() ) {
						$second_query->the_post(); ?>
						<div class="gallery_box_single">
							<?php echo do_shortcode( get_the_content() );

							$images_id = get_post_meta( $post->ID, '_gallery_images', true );

							$posts = get_posts( array(
								"showposts"			=>	-1,
								"what_to_show"		=> "posts",
								"post_status"		=> "inherit",
								"post_type"			=> "attachment",
								"orderby"			=> $gllr_options['order_by'],
								"order"				=> $gllr_options['order'],
								"post_mime_type"	=> "image/jpeg,image/gif,image/jpg,image/png",
								'post__in'			=> explode( ',', $images_id ),
								'meta_key'			=> '_gallery_order_' . $post->ID
							));

							if ( 0 < count( $posts ) ) {
								$count_image_block = 0; ?>
								<div class="gallery clearfix gllr_grid" data-columns="<?php echo $gllr_options["custom_image_row_count"]; ?>" data-border-width="<?php echo $gllr_options['border_images_width']; ?>">
									<?php foreach ( $posts as $attachment ) {
										$image_attributes		= 	wp_get_attachment_image_src( $attachment->ID, $gllr_options['image_size_photo'] );
										$image_attributes_large	=	wp_get_attachment_image_src( $attachment->ID, 'large' );
										$image_attributes_full	=	wp_get_attachment_image_src( $attachment->ID, 'full' );
										$url_for_link = get_post_meta( $attachment->ID, 'gllr_link_url', true );
										$image_text = get_post_meta( $attachment->ID, 'gllr_image_text', true );
										$image_alt_tag = get_post_meta( $attachment->ID, 'gllr_image_alt_tag', true );
										
										if ( $count_image_block % $gllr_options['custom_image_row_count'] == 0 ) { ?>
											<div class="gllr_image_row">
										<?php } ?>
											<div class="gllr_image_block">
												<p style="<?php if ( $width ) echo 'width:' . ( $width + $border_images ) . 'px;'; if ( $height ) echo 'height:' . ( $height + $border_images ) . 'px;'; ?>">
													<?php if ( ! empty( $url_for_link ) ) { ?>
														<a href="<?php echo $url_for_link; ?>" title="<?php echo $image_text; ?>" target="_blank">
															<img <?php if ( $width ) echo 'width="' . $width . '"'; if ( $height ) echo 'height="' . $height . '"'; ?> style="<?php if ( $width ) echo 'width:' . $width . 'px;'; if ( $height ) echo 'height:' . $height . 'px;'; echo $border; ?>" alt="<?php echo $image_alt_tag; ?>" title="<?php echo $image_text; ?>" src="<?php echo $image_attributes[0]; ?>" />
														</a>
													<?php } else { ?>
														<a rel="gallery_fancybox<?php if ( 0 == $gllr_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $post->ID; ?>" href="<?php echo $image_attributes_large[0]; ?>" title="<?php echo $image_text; ?>">
															<img <?php if ( $width ) echo 'width="' . $width . '"'; if ( $height ) echo 'height="' . $height . '"'; ?> style="<?php if ( $width ) echo 'width:' . $width . 'px;'; if ( $height ) echo 'height:' . $height . 'px;'; echo $border; ?>" alt="<?php echo $image_alt_tag; ?>" title="<?php echo $image_text; ?>" src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
														</a>
													<?php } ?>
												</p>
												<?php if ( 1 == $gllr_options["image_text"] ) { ?>
													<div <?php if ( $width ) echo 'style="width:' . ( $width + $border_images ) . 'px;"'; ?> class="gllr_single_image_text"><?php echo $image_text; ?>&nbsp;</div>
												<?php } ?>
											</div><!-- .gllr_image_block -->
										<?php if ( $count_image_block%$gllr_options['custom_image_row_count'] == $gllr_options['custom_image_row_count']-1 ) { ?>
											</div><!-- .gllr_image_row -->
										<?php }
										$count_image_block++;
									}
									if ( 0 < $count_image_block && $count_image_block%$gllr_options['custom_image_row_count'] != 0 ) { ?>
										</div><!-- .gllr_image_row -->
									<?php } ?>
								</div><!-- .gallery.clearfix -->
							<?php }
							if ( 1 == $gllr_options['return_link_shortcode'] ) {
								if ( empty( $gllr_options['return_link_url'] ) ) {
									if ( ! empty( $gllr_options["page_id_gallery_template"] ) ) { ?>
										<div class="return_link gllr_return_link"><a href="<?php echo get_permalink( $gllr_options["page_id_gallery_template"] ); ?>"><?php echo $gllr_options['return_link_text']; ?></a></div>
									<?php }
								} else { ?>
									<div class="return_link gllr_return_link"><a href="<?php echo $gllr_options["return_link_url"]; ?>"><?php echo $gllr_options['return_link_text']; ?></a></div>
								<?php }
							} ?>
						</div><!-- .gallery_box_single -->
						<div class="gllr_clear"></div>
					<?php }
					if ( $gllr_options['enable_lightbox'] ) {
						$gllr_vars_for_inline_script['single_script'][] = array(
							'post_id' => $post->ID
						);

						if ( defined( 'BWS_ENQUEUE_ALL_SCRIPTS' ) ) {
							gllr_echo_inline_script();
						}
					}
				} else { ?>
					<div class="gallery_box_single">
						<p class="not_found"><?php _e( 'Sorry, nothing found.', 'gallery-plugin' ); ?></p>
					</div><!-- .gallery_box_single -->
				<?php }				
			}
			wp_reset_query();
			$wp_query = $old_wp_query;
		}
		$gllr_output = ob_get_clean();
		return $gllr_output;
	}
}

if ( ! function_exists( 'gllr_echo_inline_script' ) ) {
	function gllr_echo_inline_script() {
		global $gllr_vars_for_inline_script, $gllr_options;
		
		if ( isset( $gllr_vars_for_inline_script['single_script'] ) ) { ?>
			<script type="text/javascript">
				var gllr_onload = window.onload;
				function gllr_fancy_init() {
					<?php foreach ( $gllr_vars_for_inline_script['single_script'] as $vars ) { ?>
						jQuery("a[rel=gallery_fancybox<?php if ( 0 == $gllr_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $vars['post_id']; ?>]").fancybox( {
							'transitionIn'			: 'elastic',
							'transitionOut'			: 'elastic',
							'titlePosition' 		: 'inside',
							'speedIn'				:	500,
							'speedOut'				:	300,
							'titleFormat'			: function( title, currentArray, currentIndex, currentOpts ) {
								return '<div id="fancybox-title-inside">' + ( title.length ? '<span id="bws_gallery_image_title">' + title + '</span><br />' : '' ) + '<span id="bws_gallery_image_counter"><?php _e( "Image", "gallery-plugin" ); ?> ' + ( currentIndex + 1 ) + ' / ' + currentArray.length + '</span></div><?php if ( $gllr_options['lightbox_download_link'] ) { ?><a id="bws_gallery_download_link" href="' + jQuery( currentOpts.orig ).attr('rel') + '" download="' + jQuery( currentOpts.orig ).attr('rel').substring( jQuery( currentOpts.orig ).attr('rel').lastIndexOf('/') + 1 ) + '" target="_blank"><?php echo $gllr_options['lightbox_download_link_label']; ?></a><?php } ?>';
							}<?php if ( $gllr_options['start_slideshow'] == 1 ) { ?>,
							'onComplete': function() {
								clearTimeout( jQuery.fancybox.slider );
								jQuery.fancybox.slider = setTimeout("jQuery.fancybox.next()",<?php echo $gllr_options['slideshow_interval']; ?>);
							}<?php } ?>
						} );
					<?php } ?>
				}
				if ( typeof gllr_onload === 'function' ) {
					window.onload = function() {
						gllr_onload();
						gllr_fancy_init();
					}
				} else {
					window.onload = gllr_fancy_init;
				}
			</script>
			<?php unset( $gllr_vars_for_inline_script );
		}
	}
}

if ( ! function_exists ( 'gllr_update_image' ) ) {
	function gllr_update_image() {
		global $wpdb, $gllr_options;
		check_ajax_referer( plugin_basename( __FILE__ ), 'gllr_ajax_nonce_field' );

		$action	=	isset( $_REQUEST['action1'] ) ? $_REQUEST['action1'] : "";
		$id		=	isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : "";
		switch ( $action ) {
			case 'get_all_attachment':
				$result_parent_id	= $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE `post_type` = %s", $gllr_options['post_type_name'] ), ARRAY_N );
				$array_parent_id	=	array();

				while ( list( $key, $val ) = each( $result_parent_id ) )
					$array_parent_id[] = $val[0];

				$string_parent_id = implode( ",", $array_parent_id );

				$metas = $wpdb->get_results( $wpdb->prepare( "SELECT `meta_value` FROM $wpdb->postmeta WHERE `meta_key` = %s AND `post_id` IN (" . $string_parent_id . ")", '_gallery_images' ), ARRAY_A );

				$result_attachment_id = '';
				foreach ( $metas as $key => $value ) {
					if ( ! empty( $value['meta_value'] ) ) {
						$result_attachment_id .= $value['meta_value'] . ',';
					}
				}
				$result_attachment_id_array = explode( ",", rtrim( $result_attachment_id, ',' ) );
				echo json_encode( array_unique( $result_attachment_id_array ) );
				break;
			case 'update_image':
				$metadata	= wp_get_attachment_metadata( $id );
				$uploads	= wp_upload_dir();
				$path		= $uploads['basedir'] . "/" . $metadata['file'];
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				$metadata_new = gllr_wp_generate_attachment_metadata( $id, $path, $metadata );
				wp_update_attachment_metadata( $id, array_merge( $metadata, $metadata_new ) );
				break;
			case 'update_options':
				unset( $gllr_options['need_image_update'] );
				update_option( 'gllr_options', $gllr_options );
				break;
		}
		die();
	}
}

if ( ! function_exists ( 'gllr_wp_generate_attachment_metadata' ) ) {
	function gllr_wp_generate_attachment_metadata( $attachment_id, $file, $metadata ) {
		$attachment		= get_post( $attachment_id );
		$gllr_options	= get_option( 'gllr_options' );
		$image_size 	= array( 'thumbnail' );

		if ( 'album-thumb' == $gllr_options['image_size_album'] ) {
			add_image_size( 'album-thumb', $gllr_options['custom_size_px']['album-thumb'][0], $gllr_options['custom_size_px']['album-thumb'][1], true );
			$image_size[] = 'album-thumb';
		}
		if ( 'photo-thumb' == $gllr_options['image_size_photo'] ) {
			add_image_size( 'photo-thumb', $gllr_options['custom_size_px']['photo-thumb'][0], $gllr_options['custom_size_px']['photo-thumb'][1], true );
			$image_size[] = 'photo-thumb';
		}

		$metadata = array();
		if ( preg_match( '!^image/!', get_post_mime_type( $attachment ) ) && file_is_displayable_image( $file ) ) {
			$imagesize	= getimagesize( $file );
			$metadata['width']	=	$imagesize[0];
			$metadata['height']	=	$imagesize[1];
			list( $uwidth, $uheight )	= wp_constrain_dimensions( $metadata['width'], $metadata['height'], 128, 96 );
			$metadata['hwstring_small']	= "height='$uheight' width='$uwidth'";

			/* Make the file path relative to the upload dir */
			$metadata['file'] = _wp_relative_upload_path( $file );

			/* Make thumbnails and other intermediate sizes */
			global $_wp_additional_image_sizes;

			foreach ( $image_size as $s ) {
				$sizes[ $s ] = array( 'width' => '', 'height' => '', 'crop' => FALSE );
				if ( isset( $_wp_additional_image_sizes[ $s ]['width'] ) )
					$sizes[ $s ]['width'] = intval( $_wp_additional_image_sizes[ $s ]['width'] ); /* For theme-added sizes */
				else
					$sizes[ $s ]['width'] = get_option( "{$s}_size_w" ); /* For default sizes set in options */
				if ( isset( $_wp_additional_image_sizes[ $s ]['height'] ) )
					$sizes[ $s ]['height'] = intval( $_wp_additional_image_sizes[ $s ]['height'] ); /* For theme-added sizes */
				else
					$sizes[ $s ]['height'] = get_option( "{$s}_size_h" ); /* For default sizes set in options */
				if ( isset( $_wp_additional_image_sizes[ $s ]['crop'] ) )
					$sizes[ $s ]['crop'] = intval( $_wp_additional_image_sizes[$s]['crop'] ); /* For theme-added sizes */
				else
					$sizes[ $s ]['crop'] = get_option( "{$s}_crop" ); /* For default sizes set in options */
			}
			$sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );
			foreach ( $sizes as $size => $size_data ) {
				$resized = gllr_image_make_intermediate_size( $file, $size_data['width'], $size_data['height'], $size_data['crop'] );
				if ( $resized )
					$metadata['sizes'][$size] = $resized;
			}
			/* Fetch additional metadata from exif/iptc */
			$image_meta = wp_read_image_metadata( $file );
			if ( $image_meta )
				$metadata['image_meta'] = $image_meta;
		}
		return apply_filters( 'wp_generate_attachment_metadata', $metadata, $attachment_id );
	}
}

if ( ! function_exists ( 'gllr_image_make_intermediate_size' ) ) {
	function gllr_image_make_intermediate_size( $file, $width, $height, $crop=false ) {
		if ( $width || $height ) {
			$resized_file = gllr_image_resize( $file, $width, $height, $crop );
			if ( ! is_wp_error( $resized_file ) && $resized_file && $info = getimagesize( $resized_file ) ) {
				$resized_file = apply_filters( 'image_make_intermediate_size', $resized_file );
				return array(
					'file'		=>	wp_basename( $resized_file ),
					'width'		=>	$info[0],
					'height'	=>	$info[1]
				);
			}
		}
		return false;
	}
}

if ( ! function_exists ( 'gllr_image_resize' ) ) {
	function gllr_image_resize( $file, $max_w, $max_h, $crop = false, $suffix = null, $dest_path = null, $jpeg_quality = 90 ) {
		$size = @getimagesize( $file );
		if ( ! $size )
			return new WP_Error( 'invalid_image', __( 'Image size not defined', 'gallery-plugin' ), $file );

		$type = $size[2];

		if ( 3 == $type )
			$image = imagecreatefrompng( $file );
		else if ( 2 == $type )
			$image = imagecreatefromjpeg( $file );
		else if ( 1 == $type )
			$image = imagecreatefromgif( $file );
		else if ( 15 == $type )
			$image = imagecreatefromwbmp( $file );
		else if ( 16 == $type )
			$image = imagecreatefromxbm( $file );
		else
			return new WP_Error( 'invalid_image', __( 'Plugin updates only PNG, JPEG, GIF, WPMP or XBM filetype. For other, please reload images manually.', 'gallery-plugin' ), $file );

		if ( ! is_resource( $image ) )
			return new WP_Error( 'error_loading_image', $image, $file );

		/*$size = @getimagesize( $file );*/
		list( $orig_w, $orig_h, $orig_type ) = $size;

		$dims = gllr_image_resize_dimensions($orig_w, $orig_h, $max_w, $max_h, $crop);

		if ( ! $dims )
			return new WP_Error( 'error_getting_dimensions', __( 'Image size changes not defined', 'gallery-plugin' ) );
		list( $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h ) = $dims;

		$newimage = wp_imagecreatetruecolor( $dst_w, $dst_h );

		imagecopyresampled( $newimage, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );

		/* Convert from full colors to index colors, like original PNG. */
		if ( IMAGETYPE_PNG == $orig_type && function_exists( 'imageistruecolor' ) && !imageistruecolor( $image ) )
			imagetruecolortopalette( $newimage, false, imagecolorstotal( $image ) );

		/* We don't need the original in memory anymore */
		imagedestroy( $image );

		/* $suffix will be appended to the destination filename, just before the extension */
		if ( ! $suffix )
			$suffix = "{$dst_w}x{$dst_h}";

		$info	=	pathinfo($file);
		$dir	=	$info['dirname'];
		$ext	=	$info['extension'];
		$name	=	wp_basename( $file, ".$ext" );

		if ( ! is_null( $dest_path ) and $_dest_path = realpath( $dest_path ) )
			$dir = $_dest_path;
		$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";

		if ( IMAGETYPE_GIF == $orig_type ) {
			if ( !imagegif( $newimage, $destfilename ) )
				return new WP_Error( 'resize_path_invalid', __( 'Invalid path', 'gallery-plugin' ) );
		} elseif ( IMAGETYPE_PNG == $orig_type ) {
			if ( !imagepng( $newimage, $destfilename ) )
				return new WP_Error( 'resize_path_invalid', __( 'Invalid path', 'gallery-plugin' ) );
		} else {
			/* All other formats are converted to jpg */
			$destfilename = "{$dir}/{$name}-{$suffix}.jpg";
			if ( !imagejpeg( $newimage, $destfilename, apply_filters( 'jpeg_quality', $jpeg_quality, 'image_resize' ) ) )
				return new WP_Error( 'resize_path_invalid', __( 'Invalid path', 'gallery-plugin' ) );
		}
		imagedestroy( $newimage );

		/* Set correct file permissions */
		$stat = stat( dirname( $destfilename ));
		$perms = $stat['mode'] & 0000666; /* Same permissions as parent folder, strip off the executable bits */
		@chmod( $destfilename, $perms );
		return $destfilename;
	}
}

if ( ! function_exists ( 'gllr_image_resize_dimensions' ) ) {
	function gllr_image_resize_dimensions( $orig_w, $orig_h, $dest_w, $dest_h, $crop = false ) {
		if ( 0 >= $orig_w || 0 >= $orig_h )
			return false;
		/* At least one of dest_w or dest_h must be specific */
		if ( 0 >= $dest_w && 0 >= $dest_h )
			return false;

		if ( $crop ) {
			/* Crop the largest possible portion of the original image that we can size to $dest_w x $dest_h */
			$aspect_ratio = $orig_w / $orig_h;
			$new_w = min( $dest_w, $orig_w );
			$new_h = min( $dest_h, $orig_h );

			if ( ! $new_w )
				$new_w = intval( $new_h * $aspect_ratio );

			if ( ! $new_h )
				$new_h = intval( $new_w / $aspect_ratio );

			$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

			$crop_w	=	round( $new_w / $size_ratio );
			$crop_h	=	round( $new_h / $size_ratio );
			$s_x	=	floor( ( $orig_w - $crop_w ) / 2 );
			$s_y	=	0;

		} else {
			/* Don't crop, just resize using $dest_w x $dest_h as a maximum bounding box */
			$crop_w	=	$orig_w;
			$crop_h	=	$orig_h;
			$s_x	=	$s_y	=	0;

			list( $new_w, $new_h ) = wp_constrain_dimensions( $orig_w, $orig_h, $dest_w, $dest_h );
		}
		/* If the resulting image would be the same size or larger we don't want to resize it */
		if ( $new_w >= $orig_w && $new_h >= $orig_h )
			return false;
		/* The return array matches the parameters to imagecopyresampled() */
		/* Int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h */
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}
}

/* add a class with theme name */
if ( ! function_exists ( 'gllr_theme_body_classes' ) ) {
	function gllr_theme_body_classes( $classes ) {
		if ( function_exists( 'wp_get_theme' ) ) {
			$current_theme = wp_get_theme();
			$classes[] = 'gllr_' . basename( $current_theme->get( 'ThemeURI' ) );
		}
		return $classes;
	}
}

/* Create custom meta box for gallery post type */
if ( ! function_exists( 'gllr_media_custom_box' ) ) {
	function gllr_media_custom_box( $obj = '', $box = '' ) {
		require_once( dirname( __FILE__ ) . '/inc/class-gllr-settings.php' );
		$page = new Gllr_Settings_Tabs( plugin_basename( __FILE__ ) ); ?>
		<div style="padding-top:10px;">
			<?php $page->display_tabs(); ?>
		</div>
	<?php }
}

if ( ! class_exists( 'Gllr_Media_Table' ) ) {

	if ( ! class_exists( 'WP_List_Table' ) )
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	if ( ! class_exists( 'WP_Media_List_Table' ) )
		require_once( ABSPATH . 'wp-admin/includes/class-wp-media-list-table.php' );

	class Gllr_Media_Table extends WP_Media_List_Table {
		public function __construct( $args = array() ) {

			$this->modes = array(
				'list' => __( 'List View', 'gallery-plugin' ),
				'grid' => __( 'Grid View', 'gallery-plugin' )
			);

			parent::__construct( array(
				'plural' => 'media',
				'screen' => isset( $args['screen'] ) ? $args['screen'] : '',
			) );
		}

		function prepare_items() {
			global $wpdb, $wp_query, $gllr_mode, $original_post, $wp_version;

			$columns = $this->get_columns();
			$hidden  = array( 'order' );
			$sortable = array();
			$current_page = $this->get_pagenum();
			$this->_column_headers = array( $columns, $hidden, $sortable );
			$images_id = get_post_meta( $original_post->ID, '_gallery_images', true );
			if ( empty( $images_id  ) )
				$total_items = 0;
			else
				$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->posts . " WHERE ID IN( " . $images_id . " )" );

	 		$per_page = -1;

			$gllr_mode = get_user_option( 'gllr_media_library_mode', get_current_user_id() ) ? get_user_option( 'gllr_media_library_mode', get_current_user_id() ) : 'grid';
			$modes = array( 'grid', 'list' );

			if ( isset( $_GET['mode'] ) && in_array( $_GET['mode'], $modes ) ) {
				$gllr_mode = esc_attr( $_GET['mode'] );
				update_user_option( get_current_user_id(), 'gllr_media_library_mode', $gllr_mode );
			}

			$this->set_pagination_args( array(
				'total_items' 	=> $total_items,
				'total_pages' 	=> 1,
				'per_page' 		=> $per_page
			) );

			if ( $wp_version < '4.2' )
				$this->is_trash = isset( $_REQUEST['attachment-filter'] ) && 'trash' == $_REQUEST['attachment-filter'];
		}

		function extra_tablenav( $which ) {
			if ( 'bar' !== $which ) {
				return;
			} ?>
			<div class="actions">
				<?php if ( ! is_singular() ) {
					if ( ! $this->is_trash ) {
						$this->months_dropdown( 'attachment' );
					}

					/** This action is documented in wp-admin/includes/class-wp-posts-list-table.php */
					do_action( 'restrict_manage_posts' );
					submit_button( __( 'Filter', 'gallery-plugin' ), 'button', 'filter_action', false, array( 'id' => 'post-query-submit' ) );
				}

				if ( $this->is_trash && current_user_can( 'edit_others_posts' ) ) {
					submit_button( __( 'Empty Trash', 'gallery-plugin' ), 'apply', 'delete_all', false );
				} ?>
			</div>
		<?php }

		function has_items() {
			global $wpdb, $post, $original_post;

			$images_id = get_post_meta( $original_post->ID, '_gallery_images', true );
			if ( empty( $images_id  ) )
				$total_items = 0;
			else
				$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->posts . " WHERE ID IN( " . $images_id . " )" );

			if ( $total_items > 0 )
				return true;
			else
				return false;
		}

		function no_items() {
			_e( 'No images found', 'gallery-plugin' );
		}

		function get_views() {
			return false;
		}

		function display_tablenav( $which ) { ?>
			<div class="tablenav <?php echo esc_attr( $which ); ?>">
				<div class="alignleft actions bulkactions">
					<?php $this->bulk_actions( $which ); ?>
				</div>
				<?php $this->extra_tablenav( $which );
				$this->pagination( $which ); ?>
				<br class="clear" />
			</div>
		<?php }

		/**
		 * Display the bulk actions dropdown.
		 *
		 * @since 3.1.0
		 * @access protected
		 *
		 * @param string $which The location of the bulk actions: 'top' or 'bottom'.
		 *                      This is designated as optional for backwards-compatibility.
		 */
		function bulk_actions( $which = '' ) {
			if ( is_null( $this->_actions ) ) {
				$no_new_actions = $this->_actions = $this->get_bulk_actions();
				/**
				 * Filter the list table Bulk Actions drop-down.
				 *
				 * The dynamic portion of the hook name, `$this->screen->id`, refers
				 * to the ID of the current screen, usually a string.
				 *
				 * This filter can currently only be used to remove bulk actions.
				 *
				 * @since 3.5.0
				 *
				 * @param array $actions An array of the available bulk actions.
				 */
				$this->_actions = apply_filters( "bulk_actions-{$this->screen->id}", $this->_actions );
				$this->_actions = array_intersect_assoc( $this->_actions, $no_new_actions );
				$two = '';
			} else {
				$two = '2';
			}

			if ( empty( $this->_actions ) )
				return;

			echo "<label for='bulk-action-selector-" . esc_attr( $which ) . "' class='screen-reader-text'>" . __( 'Select bulk action', 'gallery-plugin' ) . "</label>";
			echo "<select name='action-" . esc_attr( $which ) . "' id='bulk-action-selector-" . esc_attr( $which ) . "'>\n";
			echo "<option value='-1' selected='selected'>" . __( 'Bulk Actions', 'gallery-plugin' ) . "</option>\n";

			foreach ( $this->_actions as $name => $title ) {
				$class = 'edit' == $name ? ' class="hide-if-no-js"' : '';

				echo "\t<option value='$name'$class>$title</option>\n";
			}

			echo "</select>\n";

			submit_button( __( 'Apply', 'gallery-plugin' ), 'action', '', false, array( 'id' => "doaction$two" ) );
			echo "\n";
		}

		function get_bulk_actions() {
			$actions = array();

			$actions['delete'] = __( 'Delete from Gallery', 'gallery-plugin' );

			return $actions;
		}

		public function views() {
			global $gllr_mode, $original_post; ?>
			<div class="gllr-wp-filter hide-if-no-js">
				<?php if ( $gllr_mode == 'grid' ) { ?>
					<a href="#" class="button media-button gllr-media-bulk-select-button hide-if-no-js"><?php _e( 'Bulk Select', 'gallery-plugin' ); ?></a>
					<a href="#" class="button media-button gllr-media-bulk-cansel-select-button hide-if-no-js"><?php _e( 'Cancel Selection', 'gallery-plugin' ); ?></a>
					<a href="#" class="button media-button button-primary gllr-media-bulk-delete-selected-button hide-if-no-js" disabled="disabled"><?php _e( 'Delete Selected', 'gallery-plugin' ); ?></a>
				<?php } else {
					$this->view_switcher( $gllr_mode );
				} ?>
			</div>
			<input type="hidden" name="gllr_mode" value="<?php echo $gllr_mode; ?>" />
		<?php }

		function get_columns() {
			$lists_columns = array(
				'cb'            		=> '<input type="checkbox" />',
				'title'					=> __( 'File', 'gallery-plugin' ),
				'dimensions'			=> __( 'Dimensions', 'gallery-plugin' ),
				'gllr_image_text'		=> __( 'Title', 'gallery-plugin' ) . bws_add_help_box( '<img src="' . plugins_url( 'images/image-title-example.png', __FILE__ ) . '" />' ),
				'gllr_image_alt_tag'	=> __( 'Alt Text', 'gallery-plugin' ),
				'gllr_link_url'			=> __( 'URL', 'gallery-plugin' ) . bws_add_help_box( __( 'Enter your custom URL to link this image to other page or file. Leave blank to open a full size image.', 'gallery-plugin' ) ),
				'order' 				=> ''
			);
			return $lists_columns;
		}

		function display_rows( $lists = array(), $level = 0 ) {
			global $post, $wp_query, $gllr_mode, $original_post, $gllr_options;

			add_filter( 'the_title','esc_html' );

			$images_id = get_post_meta( $original_post->ID, '_gallery_images', true );

			$old_post = $post;

			query_posts( array(
				'post__in'			=> explode( ',', $images_id ),
				'post_type'			=> 'attachment',
				'posts_per_page'	=> -1,
				'post_status'		=> 'inherit',
				'meta_key'			=> '_gallery_order_' . $original_post->ID,
				'orderby'			=> $gllr_options['order_by'],
				'order'				=> $gllr_options['order']
			) );

			while ( have_posts() ) {
				the_post();
				$this->single_row( $gllr_mode );
			}
			wp_reset_postdata();
			wp_reset_query();
			$post = $old_post;
		}

		function display_grid_rows() {
			global $post, $gllr_mode, $original_post, $gllr_plugin_info, $gllr_options;
			$old_post = $post;
			add_filter( 'the_title','esc_html' );

			$images_id = get_post_meta( $original_post->ID, '_gallery_images', true );
			query_posts( array(
				'post__in'			=> explode( ',', $images_id ),
				'post_type'			=> 'attachment',
				'posts_per_page'	=> -1,
				'post_status'		=> 'inherit',
				'meta_key'			=> '_gallery_order_' . $post->ID,
				'orderby'			=> $gllr_options['order_by'],
				'order'				=> $gllr_options['order']
			) );
			while ( have_posts() ) {
				the_post();
				$this->single_row( $gllr_mode );
			}
			wp_reset_postdata();
			wp_reset_query();
			$post = $old_post;
		}

		function single_row( $gllr_mode ) {
			global $post, $original_post, $gllr_options, $gllr_plugin_info, $wp_version;

			if ( empty( $gllr_options ) )
				gllr_settings();
			
			$attachment_metadata = wp_get_attachment_metadata( $post->ID );
			if ( $gllr_mode == 'grid' ) {
				$image_attributes = wp_get_attachment_image_src( $post->ID, 'medium' ); ?>
				<li tabindex="0" id="post-<?php echo $post->ID; ?>" class="gllr-media-attachment">
					<div class="gllr-media-attachment-preview">
						<div class="gllr-media-thumbnail">
							<div class="centered">
								<img src="<?php echo $image_attributes[0]; ?>" class="thumbnail" draggable="false" />
								<input type="hidden" name="_gallery_order_<?php echo $original_post->ID; ?>[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, '_gallery_order_'.$original_post->ID, true ); ?>" />
							</div>
						</div>
						<div class="gllr-media-attachment-details">
							<?php the_title(); ?>						
						</div>
					</div>
					<a href="#" class="gllr-media-actions-delete dashicons dashicons-trash" title="<?php _e( 'Remove Image from Gallery', 'gallery-plugin' ); ?>"></a>
					<input type="hidden" class="gllr_attachment_id" name="_gllr_attachment_id" value="<?php echo $post->ID; ?>" />
					<input type="hidden" class="gllr_post_id" name="_gllr_post_id" value="<?php echo $original_post->ID; ?>" />
					<a class="thickbox gllr-media-actions-edit dashicons dashicons-edit" href="<?php echo get_edit_post_link( $post->ID ); ?>#TB_inline?width=800&height=450&inlineId=gllr-media-attachment-details-box-<?php echo $post->ID; ?>" title="<?php _e( 'Edit Image Info', 'gallery-plugin' ); ?>"></a>
					<a class="gllr-media-check" tabindex="-1" title="<?php _e( 'Deselect', 'gallery-plugin' ); ?>" href="#"><div class="media-modal-icon"></div></a>
					<div id="gllr-media-attachment-details-box-<?php echo $post->ID; ?>" class="gllr-media-attachment-details-box">
						<?php $image_attributes = wp_get_attachment_image_src( $post->ID, 'large' ); ?>
						<div class="gllr-media-attachment-details-box-left">
							<div class="gllr_border_image">
								<img src="<?php echo $image_attributes[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="auto" width="<?php echo $image_attributes[1]; ?>" />
							</div>
						</div>
						<div class="gllr-media-attachment-details-box-right">
							<div class="attachment-details">
								<div class="attachment-info">
									<div class="details">
										<div><?php _e( 'File name', 'gallery-plugin' ); ?>: <?php the_title(); ?></div>
										<div><?php _e( 'File type', 'gallery-plugin' ); ?>: <?php echo get_post_mime_type( $post->ID ); ?></div>
										<div><?php _e( 'Dimensions', 'gallery-plugin' ); ?>: <?php echo $attachment_metadata['width']; ?> &times; <?php echo $attachment_metadata['height']; ?></div>
									</div>
								</div>						
								<label class="setting" data-setting="title">
									<span class="name">
										<?php _e( 'Title', 'gallery-plugin' );
										echo bws_add_help_box( '<img src="' . plugins_url( 'images/image-title-example.png', __FILE__ ) . '" />', 'bws-auto-width' ); ?>
									</span>
									<input type="text" name="gllr_image_text[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, 'gllr_image_text', true ); ?>" />
								</label>							
								<label class="setting" data-setting="alt">
									<span class="name"><?php _e( 'Alt Text', 'gallery-plugin' ); ?></span>
									<input type="text" name="gllr_image_alt_tag[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, 'gllr_image_alt_tag', true ); ?>" />
								</label>
								<label class="setting" data-setting="alt">
									<span class="name"><?php _e( 'URL', 'gallery-plugin' ); ?></span>
									<input type="text" name="gllr_link_url[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, 'gllr_link_url', true ); ?>" />
									<span class="bws_info"><?php _e( 'Enter your custom URL to link this image to other page or file. Leave blank to open a full size image.', 'gallery-plugin' ); ?></span>
								</label>
								<?php if ( ! bws_hide_premium_options_check( $gllr_options ) ) { ?>
									<div class="bws_pro_version_bloc gllr_like">
										<div class="bws_pro_version_table_bloc">
											<div class="bws_table_bg"></div>
											<label class="setting" data-setting="description">
												<span class="name"><?php _e( 'Description', 'gallery-plugin' );
												echo bws_add_help_box( '<img src="' . plugins_url( 'images/image-description-example.png', __FILE__ ) . '" />', 'bws-auto-width' ); ?></span>
												<textarea disabled name=""></textarea>
											</label>
											<label class="setting" data-setting="description">
												<span class="name">
													<?php _e( 'Lightbox Button URL', 'gallery-plugin' ); 
													echo bws_add_help_box( '<img src="' . plugins_url( 'images/image-button-example.png', __FILE__ ) . '" />', 'bws-auto-width' ); ?>
												</span>
												<input disabled type="text" name="" value="" />			
											</label>
											<label class="setting" data-setting="description">
												<span class="name">
													<?php _e( 'New Tab', 'gallery-plugin' ); ?>
												</span>
												<input disabled type="checkbox" name="" value="" />	<span class="bws_info"><?php _e( 'Enable to open URLs above in a new tab.', 'gallery-plugin' ); ?></span>				
											</label>
										</div>
										<div class="clear"></div>
										<div class="bws_pro_version_tooltip">							
											<a class="bws_button" href="https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=63a36f6bf5de0726ad6a43a165f38fe5&pn=79&v=<?php echo $gllr_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="<?php _e( 'Go Pro', 'gallery-plugin' ); ?>"><?php _e( 'Upgrade to Pro', 'bestwebsoft' ); ?></a>
											<div class="clear"></div>
										</div>
									</div>
								<?php } ?>
								<div class="gllr-media-attachment-actions">
									<a href="post.php?post=<?php echo $post->ID; ?>&amp;action=edit"><?php _e( 'Edit more details', 'gallery-plugin' ); ?></a>
									<span class="gllr-separator">|</span>
									<a href="#" class="gllr-media-actions-delete"><?php _e( 'Remove from Gallery', 'gallery-plugin' ); ?></a>
									<input type="hidden" class="gllr_attachment_id" name="_gllr_attachment_id" value="<?php echo $post->ID; ?>" />
									<input type="hidden" class="gllr_post_id" name="_gllr_post_id" value="<?php echo $original_post->ID; ?>" />
								</div>
							</div>
							<div class="gllr_clear"></div>
						</div>
					</div>
				</li>
			<?php } else {
				$user_can_edit = current_user_can( 'edit_post', $post->ID );
				$post_owner = ( get_current_user_id() == $post->post_author ) ? 'self' : 'other';
				$att_title = _draft_or_post_title(); ?>
				<tr id="post-<?php echo $post->ID; ?>" class="<?php if ( $wp_version < '4.3' ) echo 'gllr_add_responsive_column '; echo trim( ' author-' . $post_owner . ' status-' . $post->post_status ); ?>">
					<?php list( $columns, $hidden ) = $this->get_column_info();
					foreach ( $columns as $column_name => $column_display_name ) {

						$classes = "$column_name column-$column_name";
						if ( in_array( $column_name, $hidden ) )
							$classes .= ' hidden';

						if ( 'title' == $column_name )
							$classes .= ' column-primary has-row-actions';

						$attributes = "class='$classes'";
						switch ( $column_name ) {
							case 'order': ?>
								<th <?php echo $attributes; ?>>
									<input type="hidden" name="_gallery_order_<?php echo $original_post->ID; ?>[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, '_gallery_order_'.$original_post->ID, true ); ?>" />
								</th>
								<?php break;
							case 'cb': ?>
								<th scope="row" class="check-column">
									<?php if ( $user_can_edit ) { ?>
										<label class="screen-reader-text" for="cb-select-<?php the_ID(); ?>"><?php echo sprintf( __( 'Select %s', 'gallery-plugin' ), $att_title );?></label>
										<input type="checkbox" name="media[]" id="cb-select-<?php the_ID(); ?>" value="<?php the_ID(); ?>" />
									<?php } ?>
								</th>
								<?php break;
							case 'title': ?>
								<td <?php echo $attributes; ?>><strong>
									<?php $thumb = wp_get_attachment_image( $post->ID, array( 80, 60 ), true );
									if ( $this->is_trash || ! $user_can_edit ) {
										if ( $thumb )
											echo '<span class="media-icon image-icon">' . $thumb . '</span>';
										echo '<span aria-hidden="true">' . $att_title . '</span>';
									} else { ?>
										<a href="<?php echo get_edit_post_link( $post->ID ); ?>" title="<?php echo esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'gallery-plugin' ), $att_title ) ); ?>">
											<?php if ( $thumb ) echo '<span class="media-icon image-icon">' . $thumb . '</span>'; ?>
											<?php echo '<span aria-hidden="true">' . $att_title . '</span>'; ?>
										</a>
									<?php }
									_media_states( $post ); ?></strong>
									<p class="filename"><?php echo wp_basename( $post->guid ); ?></p>
									<?php echo $this->row_actions( $this->_get_row_actions( $post, $att_title ) ); ?>
									<a href="#" class="gllr_info_show hidden"><?php _e( 'Edit Attachment Info', 'gallery-plugin' ); ?></a>
								</td>
								<?php break;
							case 'dimensions': ?>
								<td <?php echo $attributes; ?> data-colname="<?php _e( 'Dimensions', 'gallery-plugin' ); ?>">
									<?php echo $attachment_metadata['width']; ?> &times; <?php echo $attachment_metadata['height']; ?>
								</td>
								<?php break;
							case 'gllr_image_text': ?>
								<td <?php echo $attributes; ?> data-colname="<?php _e( 'Title', 'gallery-plugin' ); ?>">
									<input type="text" name="<?php echo $column_name; ?>[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, $column_name, true ); ?>" />
								</td>
								<?php break;
							case 'gllr_image_alt_tag': ?>
								<td <?php echo $attributes; ?> data-colname="<?php _e( 'Alt Text', 'gallery-plugin' ); ?>">
									<input type="text" name="<?php echo $column_name; ?>[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, $column_name, true ); ?>" />
								</td>
								<?php break;
							case 'gllr_link_url': ?>
								<td <?php echo $attributes; ?> data-colname="<?php _e( 'URL', 'gallery-plugin' ); ?>">
									<input type="text" name="<?php echo $column_name; ?>[<?php echo $post->ID; ?>]" value="<?php echo get_post_meta( $post->ID, $column_name, true ); ?>" />
								</td>
								<?php break;
						}
					} ?>
				</tr>
			<?php }
		}
		/**
		 * @param WP_Post $post
		 * @param string  $att_title
		 */
		function _get_row_actions( $post, $att_title ) {
			$actions = array();

			if ( $this->detached ) {
				if ( current_user_can( 'edit_post', $post->ID ) )
					$actions['edit'] = '<a href="' . get_edit_post_link( $post->ID ) . '">' . __( 'Edit', 'gallery-plugin' ) . '</a>';
				if ( current_user_can( 'delete_post', $post->ID ) )
					if ( EMPTY_TRASH_DAYS && MEDIA_TRASH ) {
						$actions['trash'] = "<a class='submitdelete' href='" . wp_nonce_url( "post.php?action=trash&amp;post=$post->ID", 'trash-post_' . $post->ID ) . "'>" . __( 'Trash', 'gallery-plugin' ) . "</a>";
					} else {
						$delete_ays = !MEDIA_TRASH ? " onclick='return showNotice.warn();'" : '';
						$actions['delete'] = "<a class='submitdelete'$delete_ays href='" . wp_nonce_url( "post.php?action=delete&amp;post=$post->ID", 'delete-post_' . $post->ID ) . "'>" . __( 'Delete Permanently', 'gallery-plugin' ) . "</a>";
					}
				$actions['view'] = '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( __( 'View &#8220;%s&#8221;', 'gallery-plugin' ), $att_title ) ) . '" rel="permalink">' . __( 'View', 'gallery-plugin' ) . '</a>';
				if ( current_user_can( 'edit_post', $post->ID ) )
					$actions['attach'] = '<a href="#the-list" onclick="findPosts.open( \'media[]\',\''.$post->ID.'\' );return false;" class="hide-if-no-js">' . __( 'Attach', 'gallery-plugin' ) . '</a>';
			} else {
				if ( current_user_can( 'edit_post', $post->ID ) && !$this->is_trash )
					$actions['edit'] = '<a href="' . get_edit_post_link( $post->ID ) . '">' . __( 'Edit', 'gallery-plugin' ) . '</a>';
				if ( current_user_can( 'delete_post', $post->ID ) ) {
					if ( $this->is_trash )
						$actions['untrash'] = "<a class='submitdelete' href='" . wp_nonce_url( "post.php?action=untrash&amp;post=$post->ID", 'untrash-post_' . $post->ID ) . "'>" . __( 'Restore', 'gallery-plugin' ) . "</a>";
					elseif ( EMPTY_TRASH_DAYS && MEDIA_TRASH )
						$actions['trash'] = "<a class='submitdelete' href='" . wp_nonce_url( "post.php?action=trash&amp;post=$post->ID", 'trash-post_' . $post->ID ) . "'>" . __( 'Trash', 'gallery-plugin' ) . "</a>";
					if ( $this->is_trash || !EMPTY_TRASH_DAYS || !MEDIA_TRASH ) {
						$delete_ays = ( !$this->is_trash && !MEDIA_TRASH ) ? " onclick='return showNotice.warn();'" : '';
						$actions['delete'] = "<a class='submitdelete'$delete_ays href='" . wp_nonce_url( "post.php?action=delete&amp;post=$post->ID", 'delete-post_' . $post->ID ) . "'>" . __( 'Delete Permanently', 'gallery-plugin' ) . "</a>";
					}
				}

				if ( !$this->is_trash ) {
					$title =_draft_or_post_title( $post->post_parent );
					$actions['view'] = '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( __( 'View &#8220;%s&#8221;', 'gallery-plugin' ), $title ) ) . '" rel="permalink">' . __( 'View', 'gallery-plugin' ) . '</a>';
				}
			}
			return $actions;
		}
	}
}

if ( ! function_exists( 'gllr_delete_image' ) ) {
	function gllr_delete_image() {
		check_ajax_referer( plugin_basename( __FILE__ ), 'gllr_ajax_nonce_field' );

		$action				= isset( $_POST['action'] ) ? $_POST['action'] : "";
		$delete_id_array	= isset( $_POST['delete_id_array'] ) ? $_POST['delete_id_array'] : "";
		$post_id			= $_POST['post_id'];

		if ( $action == 'gllr_delete_image' && ! empty( $delete_id_array ) && ! empty( $post_id ) ) {
			if ( is_array( $delete_id_array ) )
				$delete_id = explode( ',', trim( $delete_id_array, ',' ) );
			else
				$delete_id[] = $delete_id_array;

			$gallery_images = get_post_meta( $post_id, '_gallery_images', true );

			$gallery_images_array = explode( ',', $gallery_images );
			$gallery_images_array = array_flip( $gallery_images_array );

			foreach ( $delete_id as $delete_id ) {
				delete_post_meta( $delete_id, '_gallery_order_' . $post_id );
				unset( $gallery_images_array[ $delete_id ] );
			}

			$gallery_images_array = array_flip( $gallery_images_array );
			$gallery_images = implode( ',', $gallery_images_array );
			/* Custom field has a value and this custom field exists in database */
			update_post_meta( $post_id, '_gallery_images', $gallery_images );
			echo 'updated';
		} else {
			echo 'error';
		}
		die();
	}
}

if ( ! function_exists( 'gllr_add_from_media' ) ) {
	function gllr_add_from_media() {
		global $original_post, $post;
		check_ajax_referer( plugin_basename( __FILE__ ), 'gllr_ajax_add_nonce' );

		$add_id				= isset( $_POST['add_id'] ) ? intval( $_POST['add_id'] ) : "";
		$original_post_id	= isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : "";
		$gllr_mode			= isset( $_POST['mode'] ) ? $_POST['mode'] : 'grid';

		if ( ! empty( $_POST['add_id'] ) && ! empty( $original_post_id ) ) {
			$post = get_post( $add_id );
			if ( ! empty( $post ) ) {
				if ( preg_match( '!^image/!', $post->post_mime_type ) ) {
					setup_postdata( $post );
					$original_post	= get_post( $original_post_id );
					$GLOBALS['hook_suffix'] = 'gallery';
					$wp_gallery_media_table = new Gllr_Media_Table();
					$wp_gallery_media_table->prepare_items();
					$wp_gallery_media_table->single_row( $gllr_mode );
				}
			}
		}
		die();
	}
}

if ( ! function_exists( 'gllr_change_view_mode' ) ) {
	function gllr_change_view_mode() {
		check_ajax_referer( plugin_basename( __FILE__ ), 'gllr_ajax_nonce_field' );
		if ( ! empty( $_POST['mode'] ) ) {
			update_user_option( 
				get_current_user_id(),
				'gllr_media_library_mode',
				esc_attr( $_POST['mode'] )
			);
		}
		die();
	}
}

/**
*	Add place for notice in media upoader for gallery
*
*	See wp_print_media_templates() in "wp-includes/media-template.php"
*/
if ( ! function_exists( 'gllr_print_media_notice' ) ) {
	function gllr_print_media_notice() {
		global $post, $gllr_options;
		if ( isset( $post ) ) {
			if ( $post->post_type == $gllr_options['post_type_name'] ) {
				$image_info = '<# gllr_notice_wiev( data.id ); #><div id="gllr_media_notice" class="upload-errors"></div>'; ?>
				<script type="text/javascript">
					( function ($) {
						$( '#tmpl-attachment-details' ).html(
							$( '#tmpl-attachment-details' ).html().replace( '<div class="attachment-info"', '<?php echo $image_info; ?>$&' )
						);
					} )(jQuery);
				</script>
			<?php }
		}
	}
}

/**
*	Add notises in media upoader for portfolio	and gallery
*/
if ( ! function_exists( 'gllr_media_check_ajax_action' ) ) {
	function gllr_media_check_ajax_action() {
		check_ajax_referer( plugin_basename( __FILE__ ), 'gllr_ajax_nonce_field' );
		if ( isset( $_POST['thumbnail_id'] ) ) {
			$thumbnail_id = intval( $_POST['thumbnail_id'] );
			/*get information about the selected item */
			$atachment_detail = get_post( $thumbnail_id );
			if ( ! empty( $atachment_detail ) ) {
				if ( ! preg_match( '!^image/!', $atachment_detail->post_mime_type ) ) {
					$notice_attach = "<div class='upload-error'><strong>" . __( 'Warning', 'gallery-plugin' ) . ": </strong>" . __( 'You can add only images to the gallery', 'gallery-plugin' ) . "</div>";
					wp_send_json_success( $notice_attach );
				}
			}
		}
		die();
	}
}

/* add shortcode content  */
if ( ! function_exists( 'gllr_shortcode_button_content' ) ) {
	function gllr_shortcode_button_content( $content ) {
		global $post, $gllr_options; ?>
		<div id="gllr" style="display:none;">
			<fieldset>
				<label>
					<?php $old_post = $post;
					$query = new WP_Query( 'post_type=' . $gllr_options['post_type_name'] . '&post_status=publish&posts_per_page=-1&order=DESC&orderby=date' );
					if ( $query->have_posts() ) {
						if ( is_plugin_active( 'gallery-categories/gallery-categories.php' ) ) {
							$cat_args = array(
								'orderby'		=> 'date',
								'order'         => 'DESC',
								'show_count'	=> 1,
								'hierarchical'	=> 1,
								'taxonomy'		=> 'gallery_categories',
								'name'			=> 'gllr_gallery_categories',
								'id'			=> 'gllr_gallery_categories'
							);
							wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) ); ?>
							<span class="title"><?php _e( 'Gallery Categories', 'gallery-plugin' ); ?></span>
							</label><br/>
							<p><?php _e( 'or', 'gallery-plugin' ); ?></p>
							<label>
						<?php } ?>
						<select name="gllr_list" id="gllr_shortcode_list" style="max-width: 350px;">
						<?php while ( $query->have_posts() ) {
							$query->the_post();
							if ( ! isset( $gllr_first ) ) $gllr_first = get_the_ID();
							$title = get_the_title( $post->ID );
							if ( empty( $title ) )
								$title = '(' . __( 'no title', 'gallery-plugin' ) . ')'; ?>
							<option value="<?php the_ID(); ?>"><?php echo $title; ?> (<?php echo get_the_date( 'Y-m-d' ); ?>)</option>
						<?php }
						wp_reset_postdata();
						$post = $old_post; ?>
						</select>
						<span class="title"><?php _e( 'Gallery', 'gallery-plugin' ); ?></span>
					<?php } else { ?>
						<span class="title"><?php _e( 'Sorry, no gallery found.', 'gallery-plugin' ); ?></span>
					<?php } ?>
				</label><br/>
				<label>
					<input type="checkbox" value="1" name="gllr_display_short" id="gllr_display_short" />
					<span class="checkbox-title">
						<?php _e( 'Display an album image with the description and the link to a single gallery page', 'gallery-plugin' ); ?>
					</span>
				</label>
			</fieldset>
			<?php if ( ! empty( $gllr_first ) ) { ?>
				<input class="bws_default_shortcode" type="hidden" name="default" value="[print_gllr id=<?php echo $gllr_first; ?>]" />
			<?php } ?>
			<script type="text/javascript">
				function gllr_shortcode_init() {
					(function($) {
						$( '.mce-reset #gllr_shortcode_list, .mce-reset #gllr_display_short' ).on( 'change', function() {
							var gllr_list = $( '.mce-reset #gllr_shortcode_list option:selected' ).val();
							if ( $( '.mce-reset #gllr_display_short' ).is( ':checked' ) )
								var shortcode = '[print_gllr id=' + gllr_list + ' display=short]';
							else
								var shortcode = '[print_gllr id=' + gllr_list + ']';

							$( '.mce-reset #bws_shortcode_display' ).text( shortcode );
						});
						$( '.mce-reset #gllr_gallery_categories' ).on( 'click', function() {
							var gllr_list = $( '.mce-reset #gllr_gallery_categories option:selected' ).val();
							var shortcode = '[print_gllr cat_id=' + gllr_list + ']';
							$( '.mce-reset #bws_shortcode_display' ).text( shortcode );
						});
					})(jQuery);
				}
			</script>
			<div class="clear"></div>
		</div>
	<?php }
}

/* add help tab  */
if ( ! function_exists( 'gllr_add_tabs' ) ) {
	function gllr_add_tabs() {
		global $gllr_options;
		$screen = get_current_screen();

		if ( ! empty( $screen->post_type ) && $gllr_options['post_type_name'] == $screen->post_type ) {
			$args = array(
				'id' 			=> 'gllr',
				'section' 		=> '200538899'
			);
			bws_help_tab( $screen, $args );
		}
	}
}

if ( ! function_exists ( 'gllr_admin_notices' ) ) {
	function gllr_admin_notices() {
		global $hook_suffix, $gllr_plugin_info, $gllr_BWS_demo_data, $gllr_options;

		$screen = get_current_screen();

		if ( 'plugins.php' == $hook_suffix || 
			( ! empty( $screen->post_type ) && $gllr_options['post_type_name'] == $screen->post_type ) ) {

			if ( ! $gllr_BWS_demo_data )
				gllr_include_demo_data();

			$gllr_BWS_demo_data->bws_handle_demo_notice( $gllr_options['display_demo_notice'] );

			if ( 'plugins.php' == $hook_suffix ) {
				if ( isset( $gllr_options['first_install'] ) && strtotime( '-1 week' ) > $gllr_options['first_install'] )
					bws_plugin_banner( $gllr_plugin_info, 'gllr', 'gallery', '01a04166048e9416955ce1cbe9d5ca16', '79', '//ps.w.org/gallery-plugin/assets/icon-128x128.png' );

				bws_plugin_banner_to_settings( $gllr_plugin_info, 'gllr_options', 'gallery-plugin', 'edit.php?post_type=bws-gallery&page=gallery-plugin.php', 'post-new.php?post_type=' . $gllr_options['post_type_name'] );
			} elseif ( isset( $_GET['page'] ) && $_GET['page'] == 'gallery-plugin.php' ) {
				bws_plugin_suggest_feature_banner( $gllr_plugin_info, 'gllr_options', 'gallery-plugin' );
			}
		}
	}
}

/**
 * Perform at uninstall
 */
if ( ! function_exists( 'gllr_plugin_uninstall' ) ) {
	function gllr_plugin_uninstall() {
		global $wpdb, $gllr_BWS_demo_data;

		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$all_plugins = get_plugins();

		if ( ! array_key_exists( 'gallery-plugin-pro/gallery-plugin-pro.php', $all_plugins ) ) {
			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				$old_blog = $wpdb->blogid;
				/* Get all blog ids */
				$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
				foreach ( $blogids as $blog_id ) {
					switch_to_blog( $blog_id );
					gllr_include_demo_data();
					$gllr_BWS_demo_data->bws_remove_demo_data();

					delete_option( 'gllr_options' );
				}
				switch_to_blog( $old_blog );
			} else {
				gllr_include_demo_data();
				$gllr_BWS_demo_data->bws_remove_demo_data();

				delete_option( 'gllr_options' );				
			}
			delete_metadata( 'user', null, 'wp_gllr_media_library_mode', '', true );
		}

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		bws_delete_plugin( plugin_basename( __FILE__ ) );
	}
}

/* Activate plugin */
register_activation_hook( __FILE__, 'gllr_plugin_activate' );

/* Additional links on the plugin page */
add_filter( 'plugin_action_links', 'gllr_plugin_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'gllr_register_plugin_links', 10, 2 );

add_action( 'admin_menu', 'add_gllr_admin_menu' );

add_action( 'init', 'gllr_init' );
add_action( 'admin_init', 'gllr_admin_init' );

add_action( 'plugins_loaded', 'gllr_plugins_loaded' );

add_filter( 'rewrite_rules_array', 'gllr_custom_permalinks' ); /* Add custom permalink for gallery */

/* this function returns custom content with images for PDF&Print plugin on Gallery page */
add_filter( 'bwsplgns_get_pdf_print_content', 'gllr_add_pdf_print_content', 10, 2 );

/* Save custom data from admin  */
add_action( 'save_post', 'gllr_save_postdata', 1, 2 );
/* check post content */
add_filter( 'content_save_pre', 'gllr_content_save_pre', 10, 1 );

add_action( 'pre_get_posts', 'gllr_manage_pre_get_posts', 1 );

add_action( 'admin_enqueue_scripts', 'gllr_admin_head' );
add_action( 'wp_head', 'gllr_wp_head' );
add_action( 'wp_footer', 'gllr_wp_footer' );

add_filter( 'pgntn_callback', 'gllr_pagination_callback' );

/* add theme name as class to body tag */
add_filter( 'body_class', 'gllr_theme_body_classes' );

add_shortcode( 'print_gllr', 'gllr_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );

add_action( 'wp_ajax_gllr_update_image', 'gllr_update_image' );
add_action( 'admin_notices', 'gllr_admin_notices' );

/*	Add place for notice in media upoader for portfolio	*/
add_action( 'print_media_templates', 'gllr_print_media_notice', 11 );
/*	Add notises in media upoader for gallery	*/
add_action( 'wp_ajax_gllr_media_check', 'gllr_media_check_ajax_action' );

/* custom filter for bws button in tinyMCE */
add_filter( 'bws_shortcode_button_content', 'gllr_shortcode_button_content' );

add_action( 'wp_ajax_gllr_delete_image', 'gllr_delete_image' );
add_action( 'wp_ajax_gllr_add_from_media', 'gllr_add_from_media' );
add_action( 'wp_ajax_gllr_change_view_mode', 'gllr_change_view_mode' );