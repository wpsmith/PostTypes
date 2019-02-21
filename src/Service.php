<?php
/**
 * Post Type Service Class
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

if ( ! class_exists( 'WPS\PostTypes\Service' ) ) {
	class Service extends PostType {

		public $post_type = 'service';
		public $remove_post_type_entry_meta = true;

		public function core_acf_fields( $fields ) {
			$content = $this->new_fields_builder();
			$content
				->addText( 'slide_number_value', array(
					'label'       => __( 'Slide Number Value', 'wps' ),
					'description' => __( 'Define slide order. Ex. 1,2,3,4,...', 'wps' ),
				) )
				->addUrl( 'video', array( 'label' => 'Video URL' ) )
				->setLocation( 'post_type', '==', $this->post_type );

			$fields->builder[] = $content;
		}

		/**
		 * Register custom post type
		 */
		public function create_post_type() {

			$labels   = array(
				'name'                  => _x( 'Services', 'Post Type General Name', 'wps' ),
				'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'wps' ),
				'menu_name'             => __( 'Services', 'wps' ),
				'name_admin_bar'        => __( 'Services', 'wps' ),
				'archives'              => __( 'Item Archives', 'wps' ),
				'attributes'            => __( 'Item Attributes', 'wps' ),
				'parent_item_colon'     => __( 'Parent Item:', 'wps' ),
				'all_items'             => __( 'All Items', 'wps' ),
				'add_new_item'          => __( 'Add New Item', 'wps' ),
				'add_new'               => __( 'Add New', 'wps' ),
				'new_item'              => __( 'New Item', 'wps' ),
				'edit_item'             => __( 'Edit Item', 'wps' ),
				'update_item'           => __( 'Update Item', 'wps' ),
				'view_item'             => __( 'View Item', 'wps' ),
				'view_items'            => __( 'View Items', 'wps' ),
				'search_items'          => __( 'Search Item', 'wps' ),
				'not_found'             => __( 'Not found', 'wps' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'wps' ),
				'featured_image'        => __( 'Featured Image', 'wps' ),
				'set_featured_image'    => __( 'Set featured image', 'wps' ),
				'remove_featured_image' => __( 'Remove featured image', 'wps' ),
				'use_featured_image'    => __( 'Use as featured image', 'wps' ),
				'insert_into_item'      => __( 'Insert into item', 'wps' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'wps' ),
				'items_list'            => __( 'Items list', 'wps' ),
				'items_list_navigation' => __( 'Items list navigation', 'wps' ),
				'filter_items_list'     => __( 'Filter items list', 'wps' ),
			);
			$rewrite  = array(
				'slug'       => $this->post_type,
				'with_front' => true,
				'pages'      => true,
				'feeds'      => true,
			);
			$supports = array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'genesis-seo',
				'genesis-scripts',
				'genesis-layouts',
				'genesis-cpt-archives-settings',
				'genesis-simple-sidebars',
			);
			$args     = array(
				'label'               => __( 'Services', 'wps' ),
				'description'         => __( 'For Services', 'wps' ),
				'labels'              => $labels,
				'supports'            => $supports,
				'hierarchical'        => true,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 6.9,
				'menu_icon'           => 'dashicons-star-filled',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'page',
				'show_in_rest'        => true,
			);
			register_post_type( $this->post_type, $args );

//	new WPS\Schema\Entry_Schema( $this->post_type, 'video' );

//	new WPS\Templates\Simple_Sidebars( $this->post_type );
		}

		/**
		 * Register Custom Taxonomy
		 */
		function create_taxonomy() {

			$labels  = array(
				'name'                       => _x( 'Types', 'Taxonomy General Name', 'wps' ),
				'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'wps' ),
				'menu_name'                  => __( 'Types', 'wps' ),
				'all_items'                  => __( 'All Items', 'wps' ),
				'parent_item'                => __( 'Parent Item', 'wps' ),
				'parent_item_colon'          => __( 'Parent Item:', 'wps' ),
				'new_item_name'              => __( 'New Item Name', 'wps' ),
				'add_new_item'               => __( 'Add New Item', 'wps' ),
				'edit_item'                  => __( 'Edit Item', 'wps' ),
				'update_item'                => __( 'Update Item', 'wps' ),
				'view_item'                  => __( 'View Item', 'wps' ),
				'separate_items_with_commas' => __( 'Separate items with commas', 'wps' ),
				'add_or_remove_items'        => __( 'Add or remove items', 'wps' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'wps' ),
				'popular_items'              => __( 'Popular Items', 'wps' ),
				'search_items'               => __( 'Search Items', 'wps' ),
				'not_found'                  => __( 'Not Found', 'wps' ),
				'no_terms'                   => __( 'No items', 'wps' ),
				'items_list'                 => __( 'Items list', 'wps' ),
				'items_list_navigation'      => __( 'Items list navigation', 'wps' ),
			);
			$rewrite = array(
				'slug'         => 'service-type',
				'with_front'   => true,
				'hierarchical' => true,
			);
			$args    = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => false,
				'show_tagcloud'     => false,
				'rewrite'           => $rewrite,
				'show_in_rest'      => true,
			);
			register_taxonomy( 'service-type', array( $this->post_type ), $args );

		}

		// manage columns
		public function manage_posts_columns( $columns ) {
			return array(
				'cb'        => '<input type="checkbox" />',
				'title'     => __( 'Title', 'wps' ),
				'thumbnail' => __( 'Thumbnail', 'wps' ),
				'date'      => __( 'Date', 'wps' ),
			);
		}

		public function manage_posts_custom_column( $column, $post_id ) {
			switch ( $column ) {
				case 'thumbnail' :
					if ( has_post_thumbnail( $post_id ) ) {
						echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
					}
					break;
			}
		}
	}
}
