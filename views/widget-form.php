<?php
/**
 * Admin view
 *
 * @package TM_Posts_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>

<div class="tm-image-grid-form-widget">
	<p>
		<?php echo $title_html ?>
	</p>

	<p>
		<label for="categories"><?php _e( 'Category', PHOTOLAB_BASE_TM_ALIAS ) ?></label>
		<?php echo $categories_html ?>
	</p>
	
	<p>
		<label for="cols_count"><?php _e( 'Count of columns', PHOTOLAB_BASE_TM_ALIAS ) ?></label>
		<?php echo $cols_count_html ?>
	</p>

	<p>
		<?php echo $posts_count_html ?>
	</p>

	<p>
		<?php echo $posts_offset_html ?>
	</p>

	<p>
		<?php echo $title_length_html ?>
	</p>

	<p>
		<?php echo $padding_html ?>
	</p>

	<p>&nbsp;</p>
</div>
