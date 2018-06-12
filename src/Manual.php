<?php
/**
 * Post Type Manual Class
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


if ( ! class_exists( 'WPS\PostTypes\Manual' ) ) {
	class Manual extends PostType {

		/**
		 * Post Type registered name
		 *
		 * @var string
		 */
		public $post_type = 'manual';

		/**
		 * Plural Post Type registered name
		 *
		 * @var string
		 */
		public $plural = 'manuals';

		/**
		 * Post meta key for relationship post objects.
		 *
		 * @var string
		 */
		public $post_meta_key = 'manuals_vans';

		/**
		 * Remove Genesis Post Type Meta.
		 * @var bool
		 */
		public $remove_post_type_entry_meta = true;

		/**
		 * Sets the priority of the metabox.
		 * Accepts 'high', 'default', or 'low'.
		 * @var string
		 */
		public $mb_priority = 'high';

		/**
		 * What metaboxes to remove.
		 *
		 * Supports:
		 *  'genesis-cpt-archives-layout-settings'
		 *  'genesis-cpt-archives-seo-settings'
		 *  'genesis-cpt-archives-settings'
		 *  'wpseo_meta'
		 *  'rcp_meta_box'
		 *  'trackbacksdiv'
		 *  'postcustom'
		 *  'commentsdiv'
		 *  'slugdiv'
		 *  'authordiv'
		 *  'revisionsdiv'
		 *  'formatdiv'
		 *  'commentstatusdiv'
		 *  'categorydiv'
		 *  'tagsdiv-post_tag'
		 *  'pageparentdiv'
		 *
		 * @var array
		 */
		public $remove_metaboxes = array( 'wpseo_meta', 'slugdiv' );

		/**
		 * Van initializer.
		 */
		public function init() {

			add_action( 'genesis_entry_content', array( $this, 'field_manual' ), 14 );

			WPS\Plugins\ACF::get_instance()->add_bidirectional( 'manuals_vans' );

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
		 * Add ACF fields to the Page.
		 *
		 * @param $fields
		 */
		public function core_acf_fields( $fields ) {

			$content = $this->new_fields_builder();
			$content
				->addFile( 'manual', array(
					'label'    => __( 'Field Manual', WPS_TEXT_DOMAIN ),
					'multiple' => true,
				) )
				->addRelationship( 'manuals_vans', array(
					'label'                   => __( 'Connected Manuals & Vans', WPS_TEXT_DOMAIN ),
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
				'menu_icon'           => 'dashicons-book-alt',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => 'manuals',
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'show_in_rest'        => true,
			) );

			new WPS\Schema\Entry_Schema( $this->post_type, 'book' );

		}

		/**
		 * Gets supports array.
		 *
		 * @return array Array of post type supports.
		 */
		protected function get_supports() {
			return array(
				'title',
			);
		}

		/**
		 * Sets the proper canonical URL.
		 *
		 * @param string $url Canonical URL.
		 *
		 * @return false|string Canonical URL.
		 */
		public static function canonical_url( $url ) {
			if ( 'manual' === get_post_type() ) {
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

			return (int) get_post_meta( $id, 'manual', true );
		}

		/**
		 * Gets manual ID
		 *
		 * @return int Manual ID.
		 */
		public static function get_id() {
			$id = 0;
			if ( 'manual' !== get_post_type() ) {
				$post = get_post_meta( get_the_ID(), 'manuals_vans', true );
				if ( is_array( $post ) && ! empty( $post ) ) {
					$id = $post[0];
				}
			} else {
				$id = get_the_ID();
			}

			return (int) $id;
		}

		/**
		 * Embeds the PDF Viewer.
		 *
		 * @param int $manual_id Manual ID.
		 */
		public static function do_manual_embed( $manual_id ) {
			if ( is_numeric( $manual_id ) ) {
				echo \ZPDF_Viewer_Frontend::get_instance()->output( array(
					'url' => wp_get_attachment_url( $manual_id ),
				) );
			}
		}

		public function field_manual() {
			if ( ! $this->is_post_type() || ! ( $manuals_vans = get_post_meta( get_the_ID(), 'manuals_vans', true ) ) ) {
				return;
			}

//		echo 'HAS MANUALS';
//		WPS\printr( $manuals_vans );

			$title = get_post_meta( get_the_ID(), 'manual_title', true );
			$title = $title ? $title : _n( 'Field Manual', 'Field Manuals', count( $manuals_vans ), WPS_TEXT_DOMAIN );

			$slug = _n( 'manual', 'manuals', count( $manuals_vans ), WPS_TEXT_DOMAIN );

			echo '<div class="field-manual full-width clearfix" style="background-color: #141e28;color: #fff; padding: 2em 0 1em; margin-bottom: 1.5em;"><div class="content">';
			printf( '<div class="first two-thirds"><h3 style="color: #fff; margin: 0.5em 0;">%s</h3></div>', $title );
			echo '<div class="one-third"><div class="wrap">';
			printf( '<a target="_blank" href="%s" class="button accent alignright">%s</a>', get_permalink() . $slug . '/', __( 'Open', WPS_TEXT_DOMAIN ) );
			echo '</div></div>';
			echo '</div></div>';
		}

	}
}
