<?php
/**
 * Post Type Product Class
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

if ( ! class_exists( 'WPS\PostTypes\Product' ) ) {
	class Product extends PostType {

		/**
		 * Post Type registered name
		 *
		 * @var string
		 */
		public $post_type = 'product';

		/**
		 * Whether to create a related types taxonomy.
		 *
		 * @var bool
		 */
		public $types = true;

		public function init() {
			add_filter( 'display_posts_shortcode_output', array( $this, 'display_posts_shortcode_output' ), 10, 9 );
		}

		/**
		 * @param $output        string, the original markup for an individual post
		 * @param $atts          array, all the attributes passed to the shortcode
		 * @param $image         string, the image part of the output
		 * @param $title         string, the title part of the output
		 * @param $date          string, the date part of the output
		 * @param $excerpt       string, the excerpt part of the output
		 * @param $inner_wrapper string, what html element to wrap each post in (default is li)
		 * @param $content       string, post content
		 * @param $class         array, post classes
		 *
		 * @return $output string, the modified markup for an individual post
		 */
		public function display_posts_shortcode_output( $output, $atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class ) {
			if ( $this->post_type === get_post_type() ) {
				echo 'Product Post Type';
				$price   = sprintf( ' <span class="cost">%s</span>', get_post_meta( get_the_ID(), 'cost', true ) );
				$excerpt = ' <span class="excerpt-dash">-</span> <span class="excerpt">' . get_the_excerpt() . '</span>';
				$output  = '<' . $inner_wrapper . ' class="' . implode( ' ', $class ) . '">' . $image . '<strong>' . $title . '</strong>' . $date . $excerpt . $price . '</' . $inner_wrapper . '>';
			}

			return $output;

		}

//	public function the_content( $content ) {
//		if ( $this->post_type === get_post_type() ) {
//			return get_the_excerpt();
//		}
//
//		return $content;
//	}

		public function core_acf_fields( $fields ) {
			$content = $this->new_fields_builder();
			$content
				->addText( 'cost' )
				->setLocation( 'post_type', '==', $this->post_type );

			$fields->builder[] = $content;
		}

		protected function get_supports() {
			return array(
				'title',
				'excerpt',
				'thumbnail',
				'genesis-seo',
				'genesis-cpt-archives-settings',
			);
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
				'menu_icon'           => 'dashicons-cart',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'show_in_rest'        => true,
			) );

//	new WPS\Schema\Entry_Schema( $this->post_type, 'video' );

//	new WPS\Templates\Simple_Sidebars( $this->post_type );
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
