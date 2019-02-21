<?php
/**
 * Post Type Van Class
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

use WPS;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPS\PostTypes\Van' ) ) {
	class Van extends WPS\PostTypes\PostType {

		/**
		 * Post Type registered name
		 *
		 * @var string
		 */
		public $post_type = 'van';

		/**
		 * Plural Post Type registered name
		 *
		 * @var string
		 */
		public $plural = 'vans';

		/**
		 * Remove Genesis Post Type Meta.
		 * @var bool
		 */
		public $remove_post_type_entry_meta = true;

		/**
		 * Envira Gallery Support.
		 *
		 * @var bool
		 */
		public $gallery = true;

		/**
		 * Args for the gallery shortcode.
		 *
		 * @var array
		 */
		public $gallery_args = array(
			'size'    => 'van',
			'columns' => 4,
			'link'    => 'file',
		);

		/**
		 * Template Loader.
		 *
		 * @var WPS\Templates\Template_Loader
		 */
		public $template_loader;

		/**
		 * Whether to create a related types taxonomy.
		 *
		 * @var bool
		 */
		public $types = true;

		/**
		 * Initialize dependent post types.
		 */
		public function plugins_loaded() {
			Manual::get_instance();
			Video::get_instance();
		}

		/**
		 * Van initializer.
		 */
		public function init() {

			\WPS\add_image_size( 'van', 600, 450, true );

			// Fitvids
			WPS\Scripts\Fitvids::get_instance();

			add_action( 'genesis_entry_content', array( $this, 'gallery_title' ), 14 );
			add_action( 'genesis_entry_content', array( $this, 'field_manual' ), 18 );
			add_action( 'genesis_entry_content', array( $this, 'videos' ), 20 );

		}

		/**
		 * Add ACF fields to the Page.
		 *
		 * @param $fields
		 */
		public function core_acf_fields( $fields ) {

			$specs = $this->new_fields_builder( 'specifications' );
			$specs
				->addText( 'make', array(
					'label' => __( 'Make', 'wps' ),
				) )
				->addText( 'model', array(
					'label' => __( 'Model', 'wps' ),
				) )
				->addText( 'ramp-width', array(
					'label' => __( 'Ramp width (inches)', 'wps' ),
				) )
				->addText( 'ramp-length', array(
					'label' => __( 'Ramp length (inches)', 'wps' ),
				) )
				->addText( 'ramp-angle', array(
					'label' => __( 'Ramp angle (degrees)', 'wps' ),
				) )
				->addText( 'door-opening-height', array(
					'label' => __( 'Door opening height (inches)', 'wps' ),
				) )
				->addText( 'interior-smallest-width', array(
					'label' => __( 'Interior width smallest (inches)', 'wps' ),
				) )
				->addText( 'interior-depth', array(
					'label' => __( 'Interior depth (inches)', 'wps' ),
				) )
				->addText( 'ground-clearance', array(
					'label' => __( 'Ground Clearance (inches)', 'wps' ),
				) )
				->setLocation( 'post_type', '==', $this->post_type );

			$column_choices = array(
				'choices' => array(
					array( '' => __( 'Full Width', 'wps' ) ),
					array( 'one-half' => __( 'One Half', 'wps' ) ),
					array( 'one-third' => __( 'One Third', 'wps' ) ),
					array( 'one-fourth' => __( 'One Fourth', 'wps' ) ),
					array( 'one-sixth' => __( 'One Sixth', 'wps' ) ),
				),
			);

			$manuals = $this->new_fields_builder( 'manuals' );
			$manuals
				->addText( 'manual_title', array(
					'default'     => __( 'Field Manual', 'wps' ),
					'placeholder' => __( 'Field Manual', 'wps' ),
				) )
				->addRelationship( 'manuals_vans', array(
					'label'                   => __( 'Connected Manuals & Vans', 'wps' ),
					'acf_relationship_create' => 1,
					'post_type'               => array( 'manual', )
				) )
				->setLocation( 'post_type', '==', $this->post_type );

			$galleries = $this->new_fields_builder( 'galleries' );
			$galleries
				->addText( 'gallery_title', array(
					'default'     => __( 'Gallery', 'wps' ),
					'placeholder' => __( 'Gallery', 'wps' ),
				) )
				->addSelect( 'gallery_columns', $column_choices )
				->setDefaultValue( 'one-third' )
				->addGallery( 'gallery' )
				->setLocation( 'post_type', '==', $this->post_type );

			$videos = $this->new_fields_builder( 'videos' );
			$videos
				->addText( 'videos_title', array(
					'default'     => __( 'Repair Videos', 'wps' ),
					'placeholder' => __( 'Repair Videos', 'wps' ),
				) )
				->addSelect( 'video_columns', $column_choices )
				->setDefaultValue( 'one-third' )
				->addRelationship( 'videos_vans', array(
					'label'                   => __( 'Connected Videos & Vans', 'wps' ),
					'acf_relationship_create' => 1,
					'post_type'               => array( 'video', )
				) )
				->setLocation( 'post_type', '==', $this->post_type );

			$fields->builder[] = $specs;
			$fields->builder[] = $manuals;
			$fields->builder[] = $galleries;
			$fields->builder[] = $videos;
		}

		/**
		 * Register custom post type
		 */
		public function create_post_type() {

			$this->register_post_type( array(
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
				'capability_type'     => 'page',
				'show_in_rest'        => true,
			) );

			new WPS\Schema\Entry_Schema( $this->post_type, 'vehicle' );

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
//			'custom-fields',
				'genesis-seo',
//			'genesis-scripts',
//			'genesis-layouts',
				'genesis-cpt-archives-settings',
//			'genesis-simple-sidebars',
			);
		}

		public function field_manual() {
			if ( ! $this->is_post_type() || ! ( $manuals_vans = get_post_meta( get_the_ID(), 'manuals_vans', true ) ) ) {
				return;
			}

			WPS\printr( $manuals_vans );

			// The Field Manual
			if ( rcp_is_active() ) {

				// Manual Title
				$title = get_post_meta( get_the_ID(), 'manual_title', true );
				$title = $title ? $title : _n( 'Field Manual', 'Field Manuals', count( $manuals_vans ), 'wps' );

				// Field Slug
				$slug = _n( 'manual', 'manuals', count( $manuals_vans ), 'wps' );
				$slug = count( $manuals_vans ) > 1 ? $slug . '/' : $slug . '/' . get_post( $manuals_vans[0] )->post_name . '/';

				// The HTML
				echo '<div class="field-manual full-width clearfix" style="background-color: #141e28;color: #fff; padding: 2em 0 1em; margin-bottom: 1.5em;"><div class="content">';
				printf( '<div class="first two-thirds"><h3 style="color: #fff; margin: 0.5em 0;">%s</h3></div>', $title );
				echo '<div class="one-third"><div class="wrap">';
				printf( '<a target="_blank" href="%s" data-id="%s" class="button accent alignright">%s</a>', get_permalink() . $slug, $manuals_vans[0], __( 'Open', 'wps' ) );
				echo '</div></div>';
				echo '</div></div>';

			}

		}


		public function videos() {
			if ( ! $this->is_post_type() || ! ( $videos_vans = get_post_meta( get_the_ID(), 'videos_vans', true ) ) ) {
				return;
			}

			if ( rcp_is_active() ) {

				// Do Title
				$title = get_post_meta( get_the_ID(), 'videos_title', true );
				$title = $title ? $title : __( 'Repair Videos', 'wps' );
				printf( '<h3>%s</h3>', $title );

				// Do Videos
				$columns = $this->get_columns( 'video_columns' );
				$counter = 0;
				echo '<div class="videos">';
				foreach ( $videos_vans as $video_id ) {
					$video        = get_post( $video_id );
					$column_class = WPS\get_column_classes_by_column_class( $columns, $counter );
					printf( '<div class="%s">%s</div>', $column_class, apply_filters( 'the_content', $video->post_content ) );
					$counter ++;

				}

				// Do view all button
//			$slug = _n( 'video', 'videos', count( $videos_vans ), 'wps' );
//			echo '<div class="field-manual full-width clearfix" style="padding: 2em 0 1em; margin-bottom: 1.5em;"><div class="content">';
//			echo '<div class="first two-thirds"><h3 style="margin: 0.5em 0;">&nbsp;</h3></div>';
//			echo '<div class="one-third"><div class="wrap">';
//			printf( '<a target="_blank" href="%s" class="button accent alignright">%s</a>', get_permalink() . $slug . '/', __( 'See All', 'wps' ) );
//			echo '</div></div>';
//			echo '</div></div>';

				echo '</div>';
			}
		}

		public function gallery_title() {
			if ( ! $this->is_post_type() ) {
				return;
			}

			$title = get_post_meta( get_the_ID(), 'gallery_title', true );
			$title = $title ? $title : __( 'Gallery', 'wps' );
			printf( '<h3>%s</h3>', $title );

			$this->gallery_args['columns'] = WPS\get_column_class_num_by_column_class_name( $this->get_columns( 'gallery_columns' ) );
		}

		private function get_columns( $key ) {
			$columns = get_post_meta( get_the_ID(), $key, true );
			$columns = $columns ? $columns : 'one-third';

			return $columns;
		}

	}
}
