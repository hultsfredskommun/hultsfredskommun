<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<div id="sidebar-wrapper">
	<div id="nav-sidebar">
		<?php dynamic_sidebar('nav-sidebar'); ?>
	</div><!-- #nav-sidebar -->
	<div id="sidebar">
		<?php dynamic_sidebar('sidebar'); ?>
	</div><!-- #sidebar -->
</div><!-- #sidebar-wrapper -->