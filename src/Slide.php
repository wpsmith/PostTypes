<?php
/**
 * Post Type Slide Class
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

if ( ! class_exists( 'WPS\PostTypes\Slide' ) ) {
	class Slide extends PostType {

		public $post_type = 'slide';
		public $remove_post_type_entry_meta = true;

		public function core_acf_fields( $fields ) {
			$content = $this->new_fields_builder();
			$content
				->addText( 'slide_number_value', array(
					'label'                => __( 'Slide Number Value', 'wps' ),
					'description'          => __( 'Define slide order. Ex. 1,2,3,4,...', 'wps' ),
					// For use by "mcguffin/acf-quick-edit-fields",
					'allow_quickedit'      => true,
					'allow_bulkedit'       => true,
					'show_column'          => true,
					'show_column_sortable' => true,
				) )
				->addUrl( 'video', array( 'label' => 'Video URL' ) )
				->setInstructions( __( 'YouTube or Vimeo URL.', 'wps' ) )
				->addTrueFalse( 'no_title', array(
					// For use by "mcguffin/acf-quick-edit-fields",
					'allow_quickedit'      => true,
					'allow_bulkedit'       => true,
					'show_column'          => true,
					'show_column_sortable' => true,
				) )
				->setInstructions( __( 'Whether to show the title in the caption or not.', 'wps' ) )
				->setLocation( 'post_type', '==', $this->post_type );

			$fields->builder[] = $content;
		}

		/**
		 * Register custom post type
		 */
		public function create_post_type() {
			$labels   = array(
				'name'                  => _x( 'Slides', 'Post Type General Name', 'wps' ),
				'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'wps' ),
				'menu_name'             => __( 'Slides', 'wps' ),
				'name_admin_bar'        => __( 'Slides', 'wps' ),
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
			);
			$args     = array(
				'label'               => __( 'Slides', 'wps' ),
				'description'         => __( 'For Slides', 'wps' ),
				'labels'              => $labels,
				'supports'            => $supports,
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 6.9,
				'menu_icon'           => 'dashicons-slides',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'post',
				'show_in_rest'        => true,
			);
			register_post_type( $this->post_type, $args );

		}

		/**
		 * Register Custom Taxonomy
		 */
		function create_taxonomy() {

			$labels  = array(
				'name'                       => _x( 'Slideshows', 'Taxonomy General Name', 'wps' ),
				'singular_name'              => _x( 'Slideshow', 'Taxonomy Singular Name', 'wps' ),
				'menu_name'                  => __( 'Slideshows', 'wps' ),
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
				'slug'         => 'slideshow',
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
			register_taxonomy( 'slideshow', array( $this->post_type ), $args );

		}

		// manage slide columns
		public function manage_posts_columns( $columns ) {
			return array(
				'cb'        => '<input type="checkbox" />',
				'thumbnail' => __( 'Thumbnail', 'wps' ),
				'title'     => __( 'Title', 'wps' ),
				'slideshow' => __( 'Slideshow', 'wps' ),
//			'slide_order' => __( 'Slide Order', 'wps' ),
				'date'      => __( 'Date', 'wps' ),
			);
		}

		public function manage_posts_custom_column( $column, $post_id ) {
			switch ( $column ) {
				case 'thumbnail' :
					if ( has_post_thumbnail( $post_id ) ) {
						echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
					} else if ( $html = genesis_get_image( array(
						'post_id' => $post_id,
						'size'    => array( 50, 88 )
					) ) ) {
						echo $html;
					}
					break;

				case 'slideshow' :
					$terms = get_the_term_list( $post_id, 'slideshow', '', ',', '' );
					if ( is_string( $terms ) ) {
						echo $terms;
					} else {
						_e( 'Unable to get author(s)', 'wps' );
					}
					break;

//			case 'slide_order' :
//				echo get_post_meta( $post_id, 'slide_number_value', true );
//				break;
			}
		}
	}
}
