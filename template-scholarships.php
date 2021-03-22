<?php
  /*Template Name: Scholarships Page */
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
					</div>
				</section>
			</div>
		</div>
		<div class="columns">
			<div class="column is-12">
					<h2>Scholarship Recipients</h2>
					<?php
					if ( have_rows( 'scholarship_groups' ) ) :
						while ( have_rows( 'scholarship_groups' ) ) :
							the_row();
							?>
							<?php
							// Group subfields
							$title      = get_sub_field( 'title' );
							$recipients = get_sub_field( 'recipients' );
							?>
						<h3 class="subtitle is-3 margin-bottom-large margin-top-bigger"><?php echo $title; ?></h3>
						<div class="scholarship-recipients">
							<?php
							if ( have_rows( 'recipients' ) ) :
								while ( have_rows( 'recipients' ) ) :
									the_row();
									?>
									<?php
									// Recipient subfields
									$name        = get_sub_field( 'name' );
									$bio         = get_sub_field( 'bio' );
									$image 			 = get_sub_field( 'image' );
									$attribution = get_sub_field( 'attribution' );

									?>
								<div class="scholarship-recipient">
									<h4 class="subtitle is-5 margin-bottom-big has-text-weight-bold"><?php echo $name; ?></h4>
									<figure class="image is-5by3">
										<?php echo wp_get_attachment_image( $image, 'small' ); ?>
										<?php if ( $attribution ) { ?>
											<figcaption class="attribution">
												<?php echo $attribution; ?>
											</figcaption>
										<?php } ?>
									</figure>
									<div><?php echo $bio; ?></div>
								</div>
															<?php
							endwhile;
						endif;
							?>
						</div>
							<?php
					endwhile;
endif;
					?>

				</div>
			</div>
				</section>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
