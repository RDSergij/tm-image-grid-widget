<?php
/**
 * Description: Fox ui-elements
 * Version: 0.1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 *
 * @package ui_input_fox
 *
 * @since 0.1.0
 */
?>

<select <?php echo $attributes ?>>
	<?php foreach ( $options as $value => $title ) : ?>
	<option value="<?php echo $value ?>"
		<?php if ( $default == $value ) : ?>
		selected="selected"
		<?php endif; ?>
	>
		<?php echo $title ?>
	</option>
	<?php endforeach; ?>
</select>
