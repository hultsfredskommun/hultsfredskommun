<?php if ( is_active_sidebar("firstpage-top-content") ) : ?>
	<div id="firstpage-top-content">
		<?php dynamic_sidebar('firstpage-top-content'); ?>
	</div><!-- #firstpage-top-sidebar -->
<?php endif; ?>

<?php if (is_active_sidebar('firstpage-sidebar')) : ?>
<aside id="firstpage-sidebar" role="complementary">
	<?php dynamic_sidebar('firstpage-sidebar'); ?>
</aside><!-- #firstpage-sidebar -->
<?php endif; ?>

<?php if (is_active_sidebar('firstpage-content')) : ?>
<div id="primary">
	<?php dynamic_sidebar('firstpage-content'); ?>
</div><!-- #primary -->
<?php endif; ?>

<?php if (is_active_sidebar('firstpage-pre-footer-sidebar')) : ?>
<div id="firstpage-pre-footer-sidebar">
<?php dynamic_sidebar('firstpage-pre-footer-sidebar'); ?>
</div><!-- #firstpage-pre-footer-sidebar -->
<?php endif; ?>