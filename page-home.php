<?php
/* Template name: Home Page */
/**
 * Home Page Template
 *
 * The template used for the main site's home page.
 *
 * Sections:
 * - Hero w/ featured course blocks
 * - FAQ section
 * - Featured blog posts from creativecommons.org
 *
 * @link Figma Doc https://www.figma.com/file/GFL1IJOfjKqRxBy1vYDBcc/Mockups?node-id=1203%3A1
 */

  get_header();
  $featured_posts = Certificates_ACF::load_home_featured_posts();
?>

<main>
  <?php
	// Hero Image and featured courses
	include get_template_part( 'inc/partials/home', 'hero' );
	?>

  <section class="has-background-grey-lighter padding-top-bigger padding-bottom-xl">
	<div class="container">

	  <div class="columns is-variable is-6 padding-bottom-large">
		<div class="column is-two-thirds">
		  <?php include get_template_part( 'inc/partials/home', 'faq' ); ?>
		</div>
		<?php // Links Section (Hardcoded for now) ?>
		<div class="column after-faq">
		  <h5 class="margin-bottom-normal"><a href="/course-content" class="has-text-forest-green">Course Content</a></h5>
		  <p>Access current course content here. Unless otherwise noted, all course content is licensed CC BY 4.0. Also available in audio and remixed for a book publication!</p>

		  <hr />

		  <h5 class="margin-bottom-normal"><a href="/registration" class="has-text-forest-green">Registration</a></h5>
		  <p>Register for one of our upcoming courses, and join a growing number of CC Certified professionals working in education, libraries, and cultural heritage.</p>
		</div>
	  </div>

	  <div class="columns is-variable is-6 is-desktop">
		<div class="column is-half-desktop is-full-tablet">
		  <?php include get_template_part( 'inc/partials/home', 'featured-testimonials' ); ?>
		</div>
		<div class="column is-half">
		  <div class="columns is-vcentered is-gapless">
			<?php if ( get_field('featured_upcoming_event') ) : ?>
			<div class="column">
			  <h3>Upcoming Courses</h3>
			</div>
			<div class="column is-narrow">
			  <?php // @todo: Don't hardcode this link ?>
			  <a href="/calendar" class="title is-5 has-text-grey-dark">See Calendar</a>
			</div>
		  </div>
		  <div>
				<?php
					$upcoming_courses  = Certificates_Website::get_upcoming_course_events( null, 2 );
				?>
				<?php foreach ( $upcoming_courses as $course ) : ?>
				<div style="margin-bottom: 20px;">
					<?php echo Certificates_Website::event_card( $course->ID ); ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
	  </div>

	</div>
  </section>
  <section class="padding-top-xl padding-bottom-xxl">
	<div class="container">

	  <section class="padding-bottom-lg">
		<h2>Education News From The Blog</h2>

		<div class="education-news-home margin-top-bigger">
		<?php
		if ( have_rows( 'featured_news' ) ) :
			while ( have_rows( 'featured_news' ) ) :
				the_row();
				$post        = $featured_posts[ get_sub_field( 'post_id' ) ];
				$date        = new DateTime( $post->date );
				$pretty_date = $date->format( 'F d, Y' );

				$link        = get_sub_field( 'additional_link' );
				$link_url    = $link['url'];
				$link_title  = $link['title'];
				$link_target = $link['target'] ? $link['target'] : '_self';
				?>
		  <div class="education-news-home__post">
			<div class="has-background-soft-gold">
			  <figure class="image is-5by3">
				<a href="<?php echo $post->link; ?>">
				  <img src="<?php echo $post->featured_media_url; ?>" alt="<?php echo $post->featured_media_alt_text; ?>">
				</a>
			  </figure>
			  <div class="padding-big body">
				<h4 class="subtitle is-5">
				  <a href="<?php echo $post->link; ?>">
					<?php echo $post->title->rendered; ?>
				  </a>
				</h4>
				<p class="small-caption margin-top-normal">
				  <span><?php echo $post->author_name; ?></span>
				  <svg class="margin-horizontal-small" width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
				  <circle opacity="0.2" cx="3" cy="3" r="3" fill="black" />
				</svg>
				<span><?php echo $pretty_date; ?></span>
			  </p>
			</div>
		  </div>
			<a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>" class="is-block margin-top-big has-text-weight-bold margin-bottom-large">
				<?php echo $link_title; ?>
			</a>
		</div>
					<?php
		endwhile;
endif;
		?>
	  </div>

	</section>

	  <div class="home-tweets">
		<div class="margin-bottom-big home-tweets__header">
		  <h2>Conversations in the Community</h2>
		  <a class="button small twitter margin-right-big" target="_blank" rel="noreferrer nofollow" href="https://twitter.com/hashtag/OpenGLAM">See #OpenGLAM Posts</a>
		</div>
		<div class="home-tweets__tweets">
		  <?php
			if ( have_rows( 'featured_tweets' ) ) :
				while ( have_rows( 'featured_tweets' ) ) :
					the_row();
					$tweet = get_sub_field( 'tweet_url' );
					?>
			  <div class="tweet">
				<div class="embed-container">
					<?php echo $tweet; ?>
				</div>
			  </div>
						  <?php
		endwhile;
endif;
			?>
		</div>
	  </div>
	</div>
  </section>
</main>

<?php get_footer(); ?>
