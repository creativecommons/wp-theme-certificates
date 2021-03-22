<?php
/* Template name: FAQ Page */
/**
 * Frequently Asked Questions Template
 *
 * The template used for the Frequently Asked Questions page.
 *
 * @link Figma Doc https://www.figma.com/file/GFL1IJOfjKqRxBy1vYDBcc/Mockups?node-id=1203%3A594
 */

  get_header();

?>

<?php
	get_header();
	the_post();
?>

<main class="main-content">

	<header class="page-header">
		<div class="container">
			<div class="columns is-centered">
				<div class="column is-12">
					<?php get_template_part( 'inc/partials/entry/page', 'header' ); ?>
				</div>
			</div>
		</div>
	</header>

	<div class="container">
		<div class="columns is-centered is-variable is-8">
			<div class="column is-4">
				<aside class="sidebar faq-sidebar padding-top-xl padding-bottom-xl">
		  <?php
			if ( have_rows( 'faq_group' ) ) :
				while ( have_rows( 'faq_group' ) ) :
					the_row();

					$faqs_title = get_sub_field( 'title' );
					?>
			<section class="margin-bottom-bigger">
			  <h5 class="margin-bottom-normal">
					<?php echo $faqs_title; ?>
			  </h5>

					<?php
					if ( have_rows( 'questions' ) ) :
						while ( have_rows( 'questions' ) ) :
							the_row();
							// Get sub value.
							$question = get_sub_field( 'question' );
							$answer   = get_sub_field( 'answer' )
							?>
				<a class="is-block margin-bottom-normal" href="#<?php echo str_slug( $question ); ?>">
							<?php echo $question; ?>
				</a>
							<?php
				endwhile;
				endif;
					?>
			  </section>
					<?php
			  endwhile;
endif;
			?>
				</aside>
			</div>
			<div class="column is-8">
				<section class="entry-page-content padding-top-xl faqs">
					<div>
			<?php
			if ( have_rows( 'faq_group' ) ) :
				while ( have_rows( 'faq_group' ) ) :
					the_row();

					$faqs_title = get_sub_field( 'title' );
					?>

			  <section class="faq-group margin-bottom-xl body-big">
				<h2 class="margin-bottom-bigger">
					<?php echo $faqs_title; ?>
				</h2>

					<?php
					if ( have_rows( 'questions' ) ) :
						while ( have_rows( 'questions' ) ) :
							the_row();
							// Get sub value.
							$question = get_sub_field( 'question' );
							$answer   = get_sub_field( 'answer' )
							?>
				  <h3 class="margin-bottom-big margin-top-large faq-title subtitle" id="<?php echo str_slug( $question ); ?>">
					<a href="#<?php echo str_slug( $question ); ?>">
							<?php echo $question; ?>
					</a>
				  </h3>
							<?php echo $answer; ?>
							<?php
				endwhile;
				endif;
					?>
			  </section>

					<?php
			  endwhile;
endif;
			?>
					</div>
				</section>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
