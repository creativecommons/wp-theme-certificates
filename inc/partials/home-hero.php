<?php
  /**
   * Homepage Hero Section
   *
   * @link Figma Doc https://www.figma.com/file/GFL1IJOfjKqRxBy1vYDBcc/Mockups?node-id=1203%3A4
   */

  $title           = get_field( 'title' );
  $content         = get_field( 'content' );
  $image           = get_field( 'image' );
  $additional_info = get_field( 'additional_information' );
?>

<section class="home-hero has-padding-large">
  <div class="container margin-bottom-bigger">
	<div class="content padding-top-bigger padding-bottom-bigger body-bigger">
	  <h1 class="title is-1 has-text-black"><?php echo $title; ?></h1>
	  <?php echo $content; ?>
	</div>
  </div>

  <!-- Image -->
  <div class="img-wrapper container">
	<?php
	if ( $image ) {
		echo wp_get_attachment_image( $image, 'full' );
	}
	?>
  </div>

  <!-- Featured Courses -->
  <?php if ( have_rows( 'featured_courses' ) ) : ?>
	<div class="container">
	  <ul class="courses">
		<?php
		while ( have_rows( 'featured_courses' ) ) :
			the_row();
			$title           = get_sub_field( 'title' );
			$description     = get_sub_field( 'description' );
			$featured_course = get_sub_field( 'featured_course' );
			?>
		<li class="course padding-bigger has-background-white body-normal">
		  <h2 class="title is-3"><?php echo $title; ?></h2>
		  <p class="margin-top-big"><?php echo $description; ?></p>
			<?php if ( $featured_course ) : ?>
			<a
			  class="has-text-success is-block has-text-weight-bold margin-top-big course-link"
			  href="<?php echo $featured_course; ?>">
			  See course
			</a>
			<?php endif; ?>
		</li>
		<?php endwhile; ?>
	  </ul>
	  <div class="additional-info padding-top-small padding-bottom-bigger body-bigger">
		<?php echo $additional_info; ?>
	  </div>
	</div>
  <?php endif; ?>
</section>
