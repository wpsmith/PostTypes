<?php
/**
 * Post Type Video Class
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

use WPS;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPS\PostTypes\Video' ) ) {
	class Video extends WPS\PostTypes\PostType {

		/**
		 * Post Type registered name
		 *
		 * @var string
		 */
		public $post_type = 'video';

		/**
		 * Plural Post Type registered name
		 *
		 * @var string
		 */
		public $plural = 'videos';

		/**
		 * Post meta key for relationship post objects.
		 *
		 * @var string
		 */
		public $post_meta_key = 'videos_vans';

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
		 * Whether to remove footer functions from post type display.
		 *
		 * @var bool
		 */
		public $remove_post_type_entry_footer = true;

		/**
		 * Whether to create a related types taxonomy.
		 *
		 * @var bool
		 */
		public $types = true;

		/**
		 * Van initializer.
		 */
		public function init() {

			add_action( 'genesis_entry_content', array( $this, 'video' ), 14 );
			add_filter( 'genesis_attr_entry-content', array( $this, 'genesis_attributes_entry_content' ) );

			WPS\Plugins\ACF::get_instance()->add_bidirectional( 'videos_vans' );

			$template_loader = $this->get_template_loader();

			new WPS\Rewrite\Rewrite_Endpoint( array(
				'template'  => $template_loader->get_template_part( 'single', $this->post_type ),
				'var'       => $this->post_type,
				'post_type' => $this->post_type,
				'post_meta' => $this->post_meta_key,
			) );

			new WPS\Rewrite\Rewrite_Endpoint( array(
				'template'  => $template_loader->get_template_part( 'archive', $this->plural ),
				'var'       => $this->plural,
				'post_type' => $this->post_type,
				'post_meta' => $this->post_meta_key,
			) );
		}

		/**
		 * Add attributes for entry content element.
		 *
		 * @since 2.0.0
		 *
		 * @param array $attributes Existing attributes for entry content element.
		 *
		 * @return array Amended attributes for entry content element.
		 */
		public function genesis_attributes_entry_content( $attributes ) {

			if ( ! is_main_query() && ! genesis_is_blog_template() ) {
				return $attributes;
			}

			if ( $this->is_post_type() ) {
				$attributes['class'] .= ' full-width';
			}

			return $attributes;

		}

		/**
		 * Add ACF fields to the Page.
		 *
		 * @param $fields
		 */
		public function core_acf_fields( $fields ) {

			$content = $this->new_fields_builder();
			$content
				->addRelationship( 'videos_vans', array(
					'label'                   => __( 'Connected Videos & Vans', WPS_TEXT_DOMAIN ),
					'acf_relationship_create' => 1,
					'post_type'               => array( 'van', )
				) )
				->setLocation( 'post_type', '==', $this->post_type );

			$fields->builder[] = $content;
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
				'menu_icon'           => 'dashicons-format-video',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => 'videos',
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'register_rating'     => 'add_rating_metabox',
				'show_in_rest'        => true,
			) );

			new WPS\Schema\Entry_Schema( 'video', 'video' );

		}

		protected function get_supports() {
			return array(
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
				'genesis-seo',
				'genesis-scripts',
				'genesis-cpt-archives-settings',
			);
		}

		public function video() {
			if ( ! $this->is_post_type() || ! ( $videos_vans = get_post_meta( get_the_ID(), 'videos_vans', true ) ) ) {
				return;
			}
			$title = get_post_meta( get_the_ID(), 'manual_title', true );
			$title = $title ? $title : __( 'Field Manual', WPS_TEXT_DOMAIN );

			echo '<div class="field-manual full-width clearfix" style="background-color: #141e28;color: #fff; padding: 2em 0 1em; margin-bottom: 1.5em;"><div class="content">';
			printf( '<div class="first two-thirds"><h3 style="color: #fff; margin: 0.5em 0;">%s</h3></div>', $title );
			echo '<div class="one-third"><div class="wrap">';
			printf( '<a target="_blank" href="%s" class="button accent alignright">%s</a>', get_permalink() . 'manual/', __( 'Open', WPS_TEXT_DOMAIN ) );
			echo '</div></div>';
			echo '</div></div>';
		}

		public function videos() {
			if ( ! $this->is_post_type() || ! ( $videos_vans = get_post_meta( get_the_ID(), 'videos_vans', true ) ) ) {
				return;
			}

			// Do Title
			$title = get_post_meta( get_the_ID(), 'videos_title', true );
			$title = $title ? $title : __( 'Repair Videos', WPS_TEXT_DOMAIN );
			printf( '<h3>%s</h3>', $title );

			// Do Videos
			$columns = get_post_meta( get_the_ID(), 'video_columns', true );
			$columns = $columns ? $columns : 'one-third';
			$counter = 0;
			echo '<div class="videos">';
			foreach ( $videos_vans as $video_id ) {
				$video        = get_post( $video_id );
				$column_class = WPS\get_column_classes_by_column_class( $columns, $counter );
				printf( '<div class="%s">%s</div>', $column_class, apply_filters( 'the_content', $video->post_content ) );
				$counter ++;
			}
			echo '</div>';
		}

		/**
		 * Sets the proper canonical URL.
		 *
		 * @param string $url Canonical URL.
		 *
		 * @return false|string Canonical URL.
		 */
		public static function canonical_url( $url ) {
			if ( 'video' === get_post_type() ) {
				return $url;
			}

			return get_permalink( self::get_attachment_id() );
		}

		/**
		 * Gets the attachment ID from manual ID.
		 *
		 * @return int Attachment ID.
		 */
		public static function get_attachment_id() {
			$id = self::get_id();

			return (int) get_post_meta( $id, 'video', true );
		}

		/**
		 * Gets manual ID
		 *
		 * @return int Manual ID.
		 */
		public static function get_id() {
			$id = 0;
			if ( 'video' !== get_post_type() ) {
				$post = get_post_meta( get_the_ID(), 'videos_vans', true );
				if ( is_array( $post ) && ! empty( $post ) ) {
					$id = $post[0];
				}
			} else {
				$id = get_the_ID();
			}

			return (int) $id;
		}

	}
}
