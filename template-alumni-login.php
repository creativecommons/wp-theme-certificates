<?php
  /*Template Name: Alumni Login Page */
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
						<?php the_content(); ?>

						<div class="alumni-login has-background-grey-lighter padding-vertical-bigger padding-horizontal-large">
							<?php wp_login_form( array ( 'redirect' => get_permalink( $alumni->home_page_id ) ) ); ?>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
