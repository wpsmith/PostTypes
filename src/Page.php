<?php
/**
 * Post Type Page Class
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

use WPS\Core;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPS\PostTypes\Page' ) ) {
	class Page extends Core\Singleton {

		public $post_type = 'page';

		public function __construct() {
			add_action( 'core_acf_fields', array( $this, 'core_acf_fields' ) );
		}

		public function core_acf_fields( $fields ) {
			$content = $this->new_fields_builder();
			$content
				->addTextarea( 'page_description_value', array(
					'label'       => __( 'Page Description', 'wps' ),
					'description' => __( 'Define slide order. Ex. 1,2,3,4,...', 'wps' ),
				) )
				->setLocation( 'post_type', '==', $this->post_type );

			$fields->builder[] = $content;
		}

	}
}
