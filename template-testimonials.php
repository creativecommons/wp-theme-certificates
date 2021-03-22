<?php
  /* Template Name: Testimonials Page */
	get_header();
	the_post();
?>
<section class="main-content">

	<header class="page-header">
		<div class="container">
			<?php get_template_part( 'inc/partials/entry/page', 'header' ); ?>
		</div>
	</header>

	<div class="container">
		<div class="columns">
			<div class="column is-8">
				<section class="entry-page-content padding-top-xl">
					<div class="text-format content body-big">
			<?php
			if ( have_rows( 'testimonials' ) ) :
				while ( have_rows( 'testimonials' ) ) :
					the_row();
					?>
					<?php
					// Group subfields
					$testimonial = get_sub_field( 'testimonial' );
					$citation    = get_sub_field( 'citation' );
					?>
				<blockquote class="margin-bottom-big">
					<?php echo $testimonial; ?>
				  <cite><?php echo $citation; ?></cite>
				</blockquote>
				<?php endwhile; ?>
			<?php endif; ?>
						<?php the_content(); ?>
					</div>
				</section>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
