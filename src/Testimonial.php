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
 * @copyright  2015-2018 Travis Smith
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License v2
 * @link       https://github.com/wpsmith/WPS
 * @version    1.0.0
 * @since      0.1.0
 */

namespace WPS\PostTypes;

use WPS\PostType\PostType;

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
//			'label'               => __( 'Testimonials', WPS_TEXT_DOMAIN ),
//			'description'         => __( 'For Testimonials', WPS_TEXT_DOMAIN ),
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
				'name'                      => _x( 'Testimonials', 'Post Type General Name', WPS_TEXT_DOMAIN ),
				'singular_name'             => _x( 'Testimonial', 'Post Type Singular Name', WPS_TEXT_DOMAIN ),
				'menu_name'                 => __( 'Testimonials', WPS_TEXT_DOMAIN ),
				'name_admin_bar'            => __( 'Testimonials', WPS_TEXT_DOMAIN ),
				'archives'                  => __( 'Item Archives', WPS_TEXT_DOMAIN ),
				'attributes'                => __( 'Item Attributes', WPS_TEXT_DOMAIN ),
				'parent_item_colon'         => __( 'Parent Item:', WPS_TEXT_DOMAIN ),
				'all_items'                 => __( 'All Items', WPS_TEXT_DOMAIN ),
				'add_new_item'              => __( 'Add New Item', WPS_TEXT_DOMAIN ),
				'add_new'                   => __( 'Add New', WPS_TEXT_DOMAIN ),
				'new_item'                  => __( 'New Item', WPS_TEXT_DOMAIN ),
				'edit_item'                 => __( 'Edit Item', WPS_TEXT_DOMAIN ),
				'update_item'               => __( 'Update Item', WPS_TEXT_DOMAIN ),
				'view_item'                 => __( 'View Item', WPS_TEXT_DOMAIN ),
				'view_items'                => __( 'View Items', WPS_TEXT_DOMAIN ),
				'search_items'              => __( 'Search Item', WPS_TEXT_DOMAIN ),
				'not_found'                 => __( 'Not found', WPS_TEXT_DOMAIN ),
				'not_found_in_trash'        => __( 'Not found in Trash', WPS_TEXT_DOMAIN ),
				'testimoniald_image'        => __( 'Testimoniald Image', WPS_TEXT_DOMAIN ),
				'set_testimoniald_image'    => __( 'Set testimoniald image', WPS_TEXT_DOMAIN ),
				'remove_testimoniald_image' => __( 'Remove testimoniald image', WPS_TEXT_DOMAIN ),
				'use_testimoniald_image'    => __( 'Use as testimoniald image', WPS_TEXT_DOMAIN ),
				'insert_into_item'          => __( 'Insert into item', WPS_TEXT_DOMAIN ),
				'uploaded_to_this_item'     => __( 'Uploaded to this item', WPS_TEXT_DOMAIN ),
				'items_list'                => __( 'Items list', WPS_TEXT_DOMAIN ),
				'items_list_navigation'     => __( 'Items list navigation', WPS_TEXT_DOMAIN ),
				'filter_items_list'         => __( 'Filter items list', WPS_TEXT_DOMAIN ),
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
				'label'               => __( 'Testimonials', WPS_TEXT_DOMAIN ),
				'description'         => __( 'For Testimonials', WPS_TEXT_DOMAIN ),
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
