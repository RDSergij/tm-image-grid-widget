<?php
/**
 * Frontend view
 *
 * @package TM_Image_Grid_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<!-- Widget area -->
<div class="tm-image-grid-widget">
	<h3><?php echo $title ?></h3>
	<!-- Grid area -->
	<div class="grid grid-<?php echo $cols_count ?>">
		<?php $index = 0; while ( $query->have_posts() ) : $index++; ?>
		<?php $query->the_post(); ?>
		<?php $images = null ?>
		<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
		<?php $images = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium', true ) ?>
		<?php endif; ?>
		<a href="<?php echo get_the_permalink(); ?>" style="
				<?php if ( ! empty( $images[0] ) ) : ?>
				background-image: url(<?php echo $images[0] ?>);
				<?php endif; ?>
				margin: <?php echo $padding ?>px;
		   ">
			<h4>
				<?php if ( $title_length < mb_strlen( get_the_title(), 'UTF-8' ) ) : ?>
				<?php echo substr( get_the_title(), 0, $title_length ) . '...'; ?>
				<?php else : ?>
				<?php echo get_the_title(); ?>
				<?php endif; ?>
			</h4>
		</a>
		<?php if ( 0 == $index % $cols_count ) : ?>
		<div class="clear"></div>
		<?php endif; ?>
		<?php endwhile; ?>
	</div>
	<!-- End grid area -->
</div>
<!-- End widget area -->
