<?php
	get_header();
	the_post();
	$editing = bbp_is_single_user_edit();
?>
<section class="main-content">

	<header class="padding-top-big">
		<div class="container">
			<div class="alumni-header alumni-header--single-user <?php if ($editing) echo ' is-editing' ?>">
				<div class="profile-pic">
					<?php
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<p class="breadcrumbs" id="breadcrumbs">', '</p>' );
					}
					?>
					<img class="margin-bottom-small" src="<?php echo get_avatar_url( bbp_get_user_id(), array( 'size' => 300 ) ); ?>" alt="<?php bbp_displayed_user_field( 'user_nicename' ); ?>" loading="lazy" width="276" height="276">
				</div>
				<div class="right">
					<h1><?php echo $editing ? 'Edit your profile' : bbp_get_displayed_user_field( 'user_nicename' ); ?></h1>

					<?php if ( !$editing ) { ?>
					<ul class="body-big margin-top-large">
						<li class="margin-bottom-small"><strong>Email:</strong> <?php echo bbp_get_displayed_user_field( 'user_email' ); ?></li>
						<li class="margin-bottom-small"><strong>Course:</strong> <?php echo bbp_get_displayed_user_field( 'course' ); ?></li>
						<li class="margin-bottom-small"><strong>Year:</strong> <?php  echo bbp_get_displayed_user_field( 'year' ); ?></li>
					</ul>
					<?php } ?>

					<div id="bbpress-forums" class="bbpress-wrapper">
						<div id="bbp-user-wrapper">
							<div id="bbp-user-body">
								<?php if ( $editing ) bbp_get_template_part( 'form', 'user-edit' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
</section>
<?php get_footer(); ?>
