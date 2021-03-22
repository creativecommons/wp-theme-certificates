<?php
  /*Template Name: Alumni Forum */
	get_header();
	the_post();

	$forum_id = get_field('alumni_forum', 'options');
?>
<section class="main-content">

	<header class="padding-top-big">
		<div class="container">
			<div class="alumni-header">
				<div>
					<?php
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<p class="breadcrumbs" id="breadcrumbs">', '</p>' );
					}
					?>
					<h1>Forum</h1>

					<div class="text-format content body-bigger margin-bottom-xl margin-top-big">
						<?php the_content(); ?>
					</div>

					<a id="forum-topic-form-button" class="button is-success" href="<?php echo bbp_forum_topics_link(); ?>">Submit a Post</a>
					<div id="forum-topic-form">
						<?php echo do_shortcode("[bbp-topic-form forum_id=$forum_id]") ?>
					</div>
				</div>

				<div class="alumni-members-wrapper alumni-members-wrapper--fancy">
					<?php $alumni->render_alumni( 40 ); ?>
				</div>

			</div>
		</div>
	</header>

	<div class="container">
		<div class="columns">
			<div class="column is-12">
				<section class="entry-page-content padding-top-xl">
					<div class="text-format content body-big">
						<?php echo do_shortcode("[bbp-single-forum id=$forum_id]") ?>
					</div>
				</section>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
