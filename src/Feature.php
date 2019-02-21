<?php
/**
 * Post Type Feature Class
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

if ( ! class_exists( 'WPS\PostTypes\Feature' ) ) {
	class Feature extends PostType {

		/**
		 * Post Type registered name
		 *
		 * @var string
		 */
		public $post_type = 'feature';

		/**
		 * Plural Post Type registered name
		 *
		 * @var string
		 */
		public $plural = 'features';

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
		public $remove_post_type_meta = true;

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
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 6.9,
				'menu_icon'           => 'dashicons-star-filled',
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
			);
		}

	}
}
