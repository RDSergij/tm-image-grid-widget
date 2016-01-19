<?php
/**
 * Plugin Name: TM Image Grid Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Image grid widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Image_Grid_Widget
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'TM_Image_Grid_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab-base-tm' );
	}

	/**
	 * Set constant path of text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_PATH' ) ) {
		define( 'PHOTOLAB_BASE_TM_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Adds register_tm_image_grid widget.
	 */
	class TM_Image_Grid_Widget extends WP_Widget {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $instance_default = array();
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'tm_image_grid_widget', // Base ID
				__( 'TM Image Grid Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Image grid widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'				=> __( 'List', PHOTOLAB_BASE_TM_ALIAS ),
				'categories'		=> 0,
				'cols_count'		=> 3,
				'posts_count'		=> 6,
				'posts_offset'		=> 0,
				'excerpt_length'	=> 20,
				'padding'			=> 0,
			);
		}

		/**
		 * Load languages
		 *
		 * @since 1.0.0
		 */
		public function include_languages() {
			load_plugin_textdomain( PHOTOLAB_BASE_TM_ALIAS, false, PHOTOLAB_BASE_TM_PATH );
		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {

			// Custom styles
			wp_register_style( 'tm-image-grid-frontend', plugins_url( 'assets/css/frontend.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-image-grid-frontend' );

			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			$query = new WP_Query( array( 'posts_per_page' => $posts_count, 'offset' => $posts_offset, 'cat' => $categories ) );

			if ( $query->have_posts() ) {
				require __DIR__ . '/views/frontend.php';
			}
		}

		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 */
		public function form( $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			// Custom styles
			wp_register_style( 'tm-image-grid-admin', plugins_url( 'assets/css/admin.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-image-grid-admin' );

			// include ui-elements
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-input.php';
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-select.php';

			$title_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'title' ),
						'name'			=> $this->get_field_name( 'title' ),
						'value'			=> $title,
						'placeholder'	=> __( 'New title', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Title widget', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$title_html = $title_field->output();

			$categories_list = get_categories( array( 'hide_empty' => 0 ) );
			$categories_array = array( '0' => 'not selected' );
			foreach ( $categories_list as $category_item ) {
				$categories_array[ $category_item->term_id ] = $category_item->name;
			}

			$category_field = new UI_Select_Fox(
							array(
								'id'				=> $this->get_field_id( 'categories' ),
								'name'				=> $this->get_field_name( 'categories' ),
								'default'			=> $categories,
								'options'			=> $categories_array,
							)
						);
			$categories_html = $category_field->output();

			$cols_count_field = new UI_Select_Fox(
							array(
								'id'				=> $this->get_field_id( 'cols_count' ),
								'name'				=> $this->get_field_name( 'cols_count' ),
								'default'			=> $cols_count,
								'options'			=> array( 2 => 2, 3 => 3 ),
							)
						);
			$cols_count_html = $cols_count_field->output();

			$posts_count_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'posts_count' ),
						'name'			=> $this->get_field_name( 'posts_count' ),
						'value'			=> $posts_count,
						'placeholder'	=> __( 'posts count', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Count of posts', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$posts_count_html = $posts_count_field->output();

			$posts_offset_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'posts_offset' ),
						'name'			=> $this->get_field_name( 'posts_offset' ),
						'value'			=> $posts_offset,
						'placeholder'	=> __( 'posts offset', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Offset', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$posts_offset_html = $posts_offset_field->output();

			$excerpt_length_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'excerpt_length' ),
						'name'			=> $this->get_field_name( 'excerpt_length' ),
						'value'			=> $excerpt_length,
						'placeholder'	=> __( 'excerpt length', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Excerpt length', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$excerpt_length_html = $excerpt_length_field->output();

			$padding_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'padding' ),
						'name'			=> $this->get_field_name( 'padding' ),
						'value'			=> $padding,
						'placeholder'	=> __( 'padding', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Padding', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$padding_html = $padding_field->output();

			// show view
			require 'views/widget-form.php';
		}

		/**
		 * Update settings
		 *
		 * @param type $new_instance array.
		 * @param type $old_instance array.
		 * @return type array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $new_instance[ $key ] ) ? $new_instance[ $key ] : $value;
			}

			return $instance;
		}
	}

	/**
	 * Register widget
	 */
	function register_tm_image_grid() {
		register_widget( 'tm_image_grid_widget' );
	}
	add_action( 'widgets_init', 'register_tm_image_grid' );

}
