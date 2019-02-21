<?php
/**
 * Post Type Team Class
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

if ( ! class_exists( 'WPS\PostTypes\Team' ) ) {
	class Team extends PostType {

		/**
		 * Post Type registered name
		 *
		 * @var string
		 */
		public $post_type = 'team';

		/**
		 * Singular Post Type registered name
		 *
		 * @var string
		 */
		public $singular = 'team-member';

		/**
		 * Plural Post Type registered name
		 *
		 * @var string
		 */
		public $plural = 'team-members';

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

		public function core_acf_fields( $fields ) {
			$content = $this->new_fields_builder();
			$content
				->addText( 'position', array(
					// For use by "mcguffin/acf-quick-edit-fields",
					'allow_quickedit'      => true,
					'allow_bulkedit'       => true,
					'show_column'          => true,
					'show_column_sortable' => true,
				) )
				->addCheckbox( 'gt_alumni', array(
					'label' => '',
				) )
				->addChoice( 'yes', array(
					'label' => __( 'GT Alumni', 'wps' ),
				) )
				->setLocation( 'post_type', '==', $this->post_type );

			$social = $this->new_fields_builder( 'social', array(
				'title' => __( 'Social Settings', 'wps' ),
			) );

			$social
				->addRepeater(
					'social_accounts',
					array(
						'layout'       => 'table',
						'button_label' => __( 'Add Account', 'wps' ),
					)
				)
				->addText( 'account_name' )
				->addUrl( 'account_url' )
				->addText( 'account_icon' )
				->addColorPicker( 'account_color' )
				->endRepeater()
				->addMessage(
					__( 'Instructions', 'wps' ),
					__( 'See <a href="http://designpieces.com/2012/12/social-media-colours-hex-and-rgb/">This reference</a> for official social media account colors.', 'wps' )
				)
				->setLocation( 'post_type', '==', $this->post_type );

			$fields->builder[] = $content;
			$fields->builder[] = $social;
		}

		/**
		 * Register custom post type
		 */
		public function create_post_type() {

			$this->register_post_type( array(
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 6.9,
				'menu_icon'           => 'dashicons-groups',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => 'team',
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'show_in_rest'        => true,
			) );

//		WPS\Core\Fields::get_instance();

			new WPS\Schema\Entry_Schema( $this->post_type, 'person' );

//	new WPS\Templates\Simple_Sidebars( $this->post_type );
		}

		public function get_labels() {
			return array(
				'name'                  => _x( 'Team Members', 'Post Type General Name', 'wps' ),
				'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'wps' ),
				'menu_name'             => __( 'Team Members', 'wps' ),
				'name_admin_bar'        => __( 'Team Members', 'wps' ),
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
				'featured_image'        => __( 'Team Member Image', 'wps' ),
				'set_featured_image'    => __( 'Set team member image', 'wps' ),
				'remove_featured_image' => __( 'Remove team member image', 'wps' ),
				'use_featured_image'    => __( 'Use as team member image', 'wps' ),
				'insert_into_item'      => __( 'Insert into item', 'wps' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'wps' ),
				'items_list'            => __( 'Items list', 'wps' ),
				'items_list_navigation' => __( 'Items list navigation', 'wps' ),
				'filter_items_list'     => __( 'Filter items list', 'wps' ),
			);
		}

		/**
		 * Gets supports array.
		 *
		 * @return array Array of post type supports.
		 */
		protected function get_supports() {
			return array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'genesis-seo',
				'genesis-cpt-archives-settings',
				'genesis-simple-sidebars',
			);
		}

		// manage columns
		public function manage_posts_columns( $columns ) {
			return array(
				'cb'        => '<input type="checkbox" />',
				'title'     => __( 'Name', 'wps' ),
				'thumbnail' => __( 'Thumbnail', 'wps' ),
				'position'  => __( 'Title', 'wps' ),
				'alumni'    => __( 'GT Alumni', 'wps' ),
				'date'      => __( 'Date', 'wps' ),
			);
		}

		public function manage_posts_custom_column( $column, $post_id ) {
			switch ( $column ) {
				case 'alumni' :
					$alumni = get_post_meta( get_the_ID(), 'gt_alumni', true );
					if ( ! empty( $alumni ) && '' !== $alumni && count( $alumni ) > 0 ) {
						echo '<span class="dashicons dashicons-yes"></span>';
					} else {
						echo '<span class="dashicons dashicons-no"></span>';
					}
					break;
				case 'thumbnail' :
					if ( has_post_thumbnail( $post_id ) ) {
						echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
					}
					break;
			}
		}

	}
}
