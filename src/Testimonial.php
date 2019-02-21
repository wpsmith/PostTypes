<?php
/**
 * Post Type Testimonial Class
 *
 * You may copy, distribute and modify the software as long as you track changes/dates in source files.
 * Any modifications to or software including (via compiler) GPL-licensed code must also be made
 * available under the GPL along with build & install instructions.
 *
 * @package    WPS\PostTypes
 * @author     Travis Smith <t@wpsmith.net>
 * @copyright  2015-2019 Travis Smith
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License v2
 * @link       https://github.com/wpsmith/WPS
 * @version    1.0.0
 * @since      0.1.0
 */

namespace WPS\WP\PostTypes;

use WPS\WP\PostTypes\PostType;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPS\PostTypes\Testimonial' ) ) {
	class Testimonial extends PostType {

		/**
		 * Post Type registered name
		 *
		 * @var string
		 */
		public $post_type = 'testimonial';

		/**
		 * Singular Post Type registered name
		 *
		 * @var string
		 */
		public $singular = 'testimonial';

		/**
		 * Plural Post Type registered name
		 *
		 * @var string
		 */
		public $plural = 'testimonials';

		/**
		 * What metaboxes to remove.
		 *
		 * Supports 'genesis-cpt-archives-layout-settings', 'genesis-cpt-archives-seo-settings',
		 * and 'genesis-cpt-archives-settings'.
		 *
		 * @var array
		 */
		public $remove_metaboxes = array(
			'genesis-cpt-archives-layout-settings'
		);

		/**
		 * Whether to remove meta functions from post type display.
		 *
		 * @var bool
		 */
		public $remove_post_type_entry_meta = true;

		/**
		 * Whether to create a related types taxonomy.
		 *
		 * @var bool
		 */
		public $types = true;

		/**
		 * Register custom post type
		 */
		public function create_post_type() {
			$this->register_post_type( array(
//			'label'               => __( 'Testimonials', 'wps' ),
//			'description'         => __( 'For Testimonials', 'wps' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 6.9,
				'menu_icon'           => 'dashicons-format-quote',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'register_rating'     => 'add_rating_metabox',
				'show_in_rest'        => true,
			) );
		}

		/**
		 * Register custom post type
		 */
		public function create_post_type_bak() {

			$labels   = array(
				'name'                      => _x( 'Testimonials', 'Post Type General Name', 'wps' ),
				'singular_name'             => _x( 'Testimonial', 'Post Type Singular Name', 'wps' ),
				'menu_name'                 => __( 'Testimonials', 'wps' ),
				'name_admin_bar'            => __( 'Testimonials', 'wps' ),
				'archives'                  => __( 'Item Archives', 'wps' ),
				'attributes'                => __( 'Item Attributes', 'wps' ),
				'parent_item_colon'         => __( 'Parent Item:', 'wps' ),
				'all_items'                 => __( 'All Items', 'wps' ),
				'add_new_item'              => __( 'Add New Item', 'wps' ),
				'add_new'                   => __( 'Add New', 'wps' ),
				'new_item'                  => __( 'New Item', 'wps' ),
				'edit_item'                 => __( 'Edit Item', 'wps' ),
				'update_item'               => __( 'Update Item', 'wps' ),
				'view_item'                 => __( 'View Item', 'wps' ),
				'view_items'                => __( 'View Items', 'wps' ),
				'search_items'              => __( 'Search Item', 'wps' ),
				'not_found'                 => __( 'Not found', 'wps' ),
				'not_found_in_trash'        => __( 'Not found in Trash', 'wps' ),
				'testimoniald_image'        => __( 'Testimoniald Image', 'wps' ),
				'set_testimoniald_image'    => __( 'Set testimoniald image', 'wps' ),
				'remove_testimoniald_image' => __( 'Remove testimoniald image', 'wps' ),
				'use_testimoniald_image'    => __( 'Use as testimoniald image', 'wps' ),
				'insert_into_item'          => __( 'Insert into item', 'wps' ),
				'uploaded_to_this_item'     => __( 'Uploaded to this item', 'wps' ),
				'items_list'                => __( 'Items list', 'wps' ),
				'items_list_navigation'     => __( 'Items list navigation', 'wps' ),
				'filter_items_list'         => __( 'Filter items list', 'wps' ),
			);
			$supports = array(
				'title',
				'editor',
//			'excerpt',
				'thumbnail',
//		'genesis-seo',
//		'genesis-scripts',
//		'genesis-layouts',
//		'genesis-cpt-archives-settings',
//		'genesis-simple-sidebars',
			);
			$args     = array(
				'label'               => __( 'Testimonials', 'wps' ),
				'description'         => __( 'For Testimonials', 'wps' ),
				'labels'              => $labels,
				'supports'            => $supports,
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 6.9,
				'menu_icon'           => 'dashicons-format-quote',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'register_rating'     => 'add_rating_metabox',
				'show_in_rest'        => true,
			);
			register_post_type( 'testimonial', $args );

//	new WPS\Schema\Entry_Schema( 'testimonial', 'video' );

//	new WPS\Templates\Simple_Sidebars( 'testimonial' );
		}

		protected function get_supports() {
			return array(
				'title',
				'editor',
//			'excerpt',
				'thumbnail',
//		'genesis-seo',
//		'genesis-scripts',
//		'genesis-layouts',
//		'genesis-cpt-archives-settings',
//		'genesis-simple-sidebars',
			);
		}

	}
}
