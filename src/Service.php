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
 * @copyright  2015-2018 Travis Smith
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License v2
 * @link       https://github.com/wpsmith/WPS
 * @version    1.0.0
 * @since      0.1.0
 */

namespace WPS\PostTypes;

use WPS\PostTypes\PostType;

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
					'label'       => __( 'Slide Number Value', WPS_TEXT_DOMAIN ),
					'description' => __( 'Define slide order. Ex. 1,2,3,4,...', WPS_TEXT_DOMAIN ),
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
				'name'                  => _x( 'Services', 'Post Type General Name', WPS_TEXT_DOMAIN ),
				'singular_name'         => _x( 'Service', 'Post Type Singular Name', WPS_TEXT_DOMAIN ),
				'menu_name'             => __( 'Services', WPS_TEXT_DOMAIN ),
				'name_admin_bar'        => __( 'Services', WPS_TEXT_DOMAIN ),
				'archives'              => __( 'Item Archives', WPS_TEXT_DOMAIN ),
				'attributes'            => __( 'Item Attributes', WPS_TEXT_DOMAIN ),
				'parent_item_colon'     => __( 'Parent Item:', WPS_TEXT_DOMAIN ),
				'all_items'             => __( 'All Items', WPS_TEXT_DOMAIN ),
				'add_new_item'          => __( 'Add New Item', WPS_TEXT_DOMAIN ),
				'add_new'               => __( 'Add New', WPS_TEXT_DOMAIN ),
				'new_item'              => __( 'New Item', WPS_TEXT_DOMAIN ),
				'edit_item'             => __( 'Edit Item', WPS_TEXT_DOMAIN ),
				'update_item'           => __( 'Update Item', WPS_TEXT_DOMAIN ),
				'view_item'             => __( 'View Item', WPS_TEXT_DOMAIN ),
				'view_items'            => __( 'View Items', WPS_TEXT_DOMAIN ),
				'search_items'          => __( 'Search Item', WPS_TEXT_DOMAIN ),
				'not_found'             => __( 'Not found', WPS_TEXT_DOMAIN ),
				'not_found_in_trash'    => __( 'Not found in Trash', WPS_TEXT_DOMAIN ),
				'featured_image'        => __( 'Featured Image', WPS_TEXT_DOMAIN ),
				'set_featured_image'    => __( 'Set featured image', WPS_TEXT_DOMAIN ),
				'remove_featured_image' => __( 'Remove featured image', WPS_TEXT_DOMAIN ),
				'use_featured_image'    => __( 'Use as featured image', WPS_TEXT_DOMAIN ),
				'insert_into_item'      => __( 'Insert into item', WPS_TEXT_DOMAIN ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', WPS_TEXT_DOMAIN ),
				'items_list'            => __( 'Items list', WPS_TEXT_DOMAIN ),
				'items_list_navigation' => __( 'Items list navigation', WPS_TEXT_DOMAIN ),
				'filter_items_list'     => __( 'Filter items list', WPS_TEXT_DOMAIN ),
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
				'label'               => __( 'Services', WPS_TEXT_DOMAIN ),
				'description'         => __( 'For Services', WPS_TEXT_DOMAIN ),
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
				'name'                       => _x( 'Types', 'Taxonomy General Name', WPS_TEXT_DOMAIN ),
				'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', WPS_TEXT_DOMAIN ),
				'menu_name'                  => __( 'Types', WPS_TEXT_DOMAIN ),
				'all_items'                  => __( 'All Items', WPS_TEXT_DOMAIN ),
				'parent_item'                => __( 'Parent Item', WPS_TEXT_DOMAIN ),
				'parent_item_colon'          => __( 'Parent Item:', WPS_TEXT_DOMAIN ),
				'new_item_name'              => __( 'New Item Name', WPS_TEXT_DOMAIN ),
				'add_new_item'               => __( 'Add New Item', WPS_TEXT_DOMAIN ),
				'edit_item'                  => __( 'Edit Item', WPS_TEXT_DOMAIN ),
				'update_item'                => __( 'Update Item', WPS_TEXT_DOMAIN ),
				'view_item'                  => __( 'View Item', WPS_TEXT_DOMAIN ),
				'separate_items_with_commas' => __( 'Separate items with commas', WPS_TEXT_DOMAIN ),
				'add_or_remove_items'        => __( 'Add or remove items', WPS_TEXT_DOMAIN ),
				'choose_from_most_used'      => __( 'Choose from the most used', WPS_TEXT_DOMAIN ),
				'popular_items'              => __( 'Popular Items', WPS_TEXT_DOMAIN ),
				'search_items'               => __( 'Search Items', WPS_TEXT_DOMAIN ),
				'not_found'                  => __( 'Not Found', WPS_TEXT_DOMAIN ),
				'no_terms'                   => __( 'No items', WPS_TEXT_DOMAIN ),
				'items_list'                 => __( 'Items list', WPS_TEXT_DOMAIN ),
				'items_list_navigation'      => __( 'Items list navigation', WPS_TEXT_DOMAIN ),
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
				'title'     => __( 'Title', WPS_TEXT_DOMAIN ),
				'thumbnail' => __( 'Thumbnail', WPS_TEXT_DOMAIN ),
				'date'      => __( 'Date', WPS_TEXT_DOMAIN ),
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
