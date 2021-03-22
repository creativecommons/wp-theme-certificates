<?php
	get_header();
	the_post();

	// Use the local registration link, OR fallback to the global registration link
	$no_upcoming       = false;
	$events 					 = Certificates_Website::get_upcoming_course_events( get_the_ID() );
	$upcoming_meta     = count($events) > 0 ? Certificates_Website::get_upcoming_course_meta ( $events ) : [];

	if ( ! empty ($upcoming_meta) ) {
		$start_date        = $upcoming_meta['start_date'];
		$end_date          = $upcoming_meta['end_date'];
		$course_duration   = $upcoming_meta['duration'];
		$course_language   = $upcoming_meta['language'];
		$registration_link = $upcoming_meta['registration_link'] ?:  get_field( 'registration_link', 'options' );
	} else {
		$no_upcoming = true;
	}

?>
<section class="main-content">
	<header class="single-header single-header--course">
		<?php
			if( has_post_thumbnail() ) {
				echo get_the_post_thumbnail();
			}

		?>
		<div class="container">
			<?php get_template_part( 'inc/partials/entry/course', 'header' ); ?>
			<?php if ( get_field( 'featured_image_attribution' ) ) { ?>
				<div class="attribution attribution--right"><?php echo get_field( 'featured_image_attribution' ); ?></div>
			<?php } ?>
		</div>
	</header>
	<div class="container">
		<div class="columns margin-top-0 is-desktop">
		<div class="column is-3-desktop has-background-soft-gold course-sidebar is-full">
					<div class="entry-meta margin-top-xl">
						<h2 class="title is-3 margin-bottom-bigger">Course details</h2>


						<?php if (! $no_upcoming ) : ?>
						<div class="course-meta">
								<div>
																<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.25 18.125C1.25 19.1602 2.08984 20 3.125 20H16.875C17.9102 20 18.75 19.1602 18.75 18.125V7.5H1.25V18.125ZM13.75 10.4688C13.75 10.2109 13.9609 10 14.2188 10H15.7812C16.0391 10 16.25 10.2109 16.25 10.4688V12.0312C16.25 12.2891 16.0391 12.5 15.7812 12.5H14.2188C13.9609 12.5 13.75 12.2891 13.75 12.0312V10.4688ZM13.75 15.4688C13.75 15.2109 13.9609 15 14.2188 15H15.7812C16.0391 15 16.25 15.2109 16.25 15.4688V17.0312C16.25 17.2891 16.0391 17.5 15.7812 17.5H14.2188C13.9609 17.5 13.75 17.2891 13.75 17.0312V15.4688ZM8.75 10.4688C8.75 10.2109 8.96094 10 9.21875 10H10.7812C11.0391 10 11.25 10.2109 11.25 10.4688V12.0312C11.25 12.2891 11.0391 12.5 10.7812 12.5H9.21875C8.96094 12.5 8.75 12.2891 8.75 12.0312V10.4688ZM8.75 15.4688C8.75 15.2109 8.96094 15 9.21875 15H10.7812C11.0391 15 11.25 15.2109 11.25 15.4688V17.0312C11.25 17.2891 11.0391 17.5 10.7812 17.5H9.21875C8.96094 17.5 8.75 17.2891 8.75 17.0312V15.4688ZM3.75 10.4688C3.75 10.2109 3.96094 10 4.21875 10H5.78125C6.03906 10 6.25 10.2109 6.25 10.4688V12.0312C6.25 12.2891 6.03906 12.5 5.78125 12.5H4.21875C3.96094 12.5 3.75 12.2891 3.75 12.0312V10.4688ZM3.75 15.4688C3.75 15.2109 3.96094 15 4.21875 15H5.78125C6.03906 15 6.25 15.2109 6.25 15.4688V17.0312C6.25 17.2891 6.03906 17.5 5.78125 17.5H4.21875C3.96094 17.5 3.75 17.2891 3.75 17.0312V15.4688ZM16.875 2.5H15V0.625C15 0.28125 14.7188 0 14.375 0H13.125C12.7812 0 12.5 0.28125 12.5 0.625V2.5H7.5V0.625C7.5 0.28125 7.21875 0 6.875 0H5.625C5.28125 0 5 0.28125 5 0.625V2.5H3.125C2.08984 2.5 1.25 3.33984 1.25 4.375V6.25H18.75V4.375C18.75 3.33984 17.9102 2.5 16.875 2.5Z" fill="black"/>
							</svg>

								</div>
						<div>
							<ul>
								<?php if ( ! empty( $start_date ) ) : ?><li><strong>Start Date: </strong><?php echo $start_date; ?></li><?php endif; ?>
								<?php if ( ! empty( $end_date ) ) : ?><li><strong>End Date: </strong><?php echo $end_date; ?></li><?php endif; ?>
								<?php if ( ! empty( $course_duration ) ) : ?><li><strong>Duration: </strong><?php echo $course_duration; ?> weeks</li><?php endif; ?>
							</ul>
							</div>
						</div>
						<?php
							$course_duration = get_post_meta( get_the_ID(), 'course_duration', true );
							$course_url      = get_post_meta( get_the_ID(), 'course_apply_url', true );

							if ( ! empty( $course_language ) ) { ?>
								<div class="course-meta">
									<div>
											<svg width="20" height="20" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.0928 4.6875C9.66797 2.07129 8.66602 0.234375 7.5 0.234375C6.33398 0.234375 5.33203 2.07129 4.90723 4.6875H10.0928ZM4.6875 7.5C4.6875 8.15039 4.72266 8.77441 4.78418 9.375H10.2129C10.2744 8.77441 10.3096 8.15039 10.3096 7.5C10.3096 6.84961 10.2744 6.22559 10.2129 5.625H4.78418C4.72266 6.22559 4.6875 6.84961 4.6875 7.5ZM14.2002 4.6875C13.3623 2.69824 11.666 1.16016 9.57129 0.539062C10.2861 1.5293 10.7783 3.02051 11.0361 4.6875H14.2002ZM5.42578 0.539062C3.33398 1.16016 1.63477 2.69824 0.799805 4.6875H3.96387C4.21875 3.02051 4.71094 1.5293 5.42578 0.539062ZM14.5137 5.625H11.1533C11.2148 6.24023 11.25 6.87012 11.25 7.5C11.25 8.12988 11.2148 8.75977 11.1533 9.375H14.5107C14.6719 8.77441 14.7627 8.15039 14.7627 7.5C14.7627 6.84961 14.6719 6.22559 14.5137 5.625ZM3.75 7.5C3.75 6.87012 3.78516 6.24023 3.84668 5.625H0.486328C0.328125 6.22559 0.234375 6.84961 0.234375 7.5C0.234375 8.15039 0.328125 8.77441 0.486328 9.375H3.84375C3.78516 8.75977 3.75 8.12988 3.75 7.5ZM4.90723 10.3125C5.33203 12.9287 6.33398 14.7656 7.5 14.7656C8.66602 14.7656 9.66797 12.9287 10.0928 10.3125H4.90723ZM9.57422 14.4609C11.666 13.8398 13.3652 12.3018 14.2031 10.3125H11.0391C10.7812 11.9795 10.2891 13.4707 9.57422 14.4609ZM0.799805 10.3125C1.6377 12.3018 3.33398 13.8398 5.42871 14.4609C4.71387 13.4707 4.22168 11.9795 3.96387 10.3125H0.799805Z" fill="black"/></svg>
									</div>
									<p><strong>Language: </strong><?php echo $course_language; ?></p>
								</div>
							<?php } ?>

						 <a href="<?php echo $registration_link; ?>" class="button register middle margin-top-bigger">Register Here</a>
					<?php else : ?>
						<p class="margin-bottom-bigger">There are no upcoming events for this course. Subscribe to our newsletter to stay updated on course announcements.</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="column is-9">
				<section class="entry-page-content margin-top-xxl padding-horizontal-xxl">
					<div class="text-format body-big">
						<?php the_content(); ?>
					</div>
		  <?php
				if ( ! empty( $events ) ) { ?>
					<h3>Upcoming Dates</h3>
					<div class=" padding-top-bigger">
					<?php foreach ( $events as $event ) { ?>
						<div class="fixed-card fixed-card--simple">
							<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="margin-right-normal">
								<path d="M0.25 18.125C0.25 19.1602 1.08984 20 2.125 20H15.875C16.9102 20 17.75 19.1602 17.75 18.125V7.5H0.25V18.125ZM12.75 10.4688C12.75 10.2109 12.9609 10 13.2188 10H14.7812C15.0391 10 15.25 10.2109 15.25 10.4688V12.0312C15.25 12.2891 15.0391 12.5 14.7812 12.5H13.2188C12.9609 12.5 12.75 12.2891 12.75 12.0312V10.4688ZM12.75 15.4688C12.75 15.2109 12.9609 15 13.2188 15H14.7812C15.0391 15 15.25 15.2109 15.25 15.4688V17.0312C15.25 17.2891 15.0391 17.5 14.7812 17.5H13.2188C12.9609 17.5 12.75 17.2891 12.75 17.0312V15.4688ZM7.75 10.4688C7.75 10.2109 7.96094 10 8.21875 10H9.78125C10.0391 10 10.25 10.2109 10.25 10.4688V12.0312C10.25 12.2891 10.0391 12.5 9.78125 12.5H8.21875C7.96094 12.5 7.75 12.2891 7.75 12.0312V10.4688ZM7.75 15.4688C7.75 15.2109 7.96094 15 8.21875 15H9.78125C10.0391 15 10.25 15.2109 10.25 15.4688V17.0312C10.25 17.2891 10.0391 17.5 9.78125 17.5H8.21875C7.96094 17.5 7.75 17.2891 7.75 17.0312V15.4688ZM2.75 10.4688C2.75 10.2109 2.96094 10 3.21875 10H4.78125C5.03906 10 5.25 10.2109 5.25 10.4688V12.0312C5.25 12.2891 5.03906 12.5 4.78125 12.5H3.21875C2.96094 12.5 2.75 12.2891 2.75 12.0312V10.4688ZM2.75 15.4688C2.75 15.2109 2.96094 15 3.21875 15H4.78125C5.03906 15 5.25 15.2109 5.25 15.4688V17.0312C5.25 17.2891 5.03906 17.5 4.78125 17.5H3.21875C2.96094 17.5 2.75 17.2891 2.75 17.0312V15.4688ZM15.875 2.5H14V0.625C14 0.28125 13.7188 0 13.375 0H12.125C11.7812 0 11.5 0.28125 11.5 0.625V2.5H6.5V0.625C6.5 0.28125 6.21875 0 5.875 0H4.625C4.28125 0 4 0.28125 4 0.625V2.5H2.125C1.08984 2.5 0.25 3.33984 0.25 4.375V6.25H17.75V4.375C17.75 3.33984 16.9102 2.5 15.875 2.5Z" fill="black"/>
							</svg>
							<h3 class="title is-5">
								<?php echo get_field( 'start_date', $event->ID ); ?> -
								<?php echo get_field( 'end_date' , $event->ID ); ?>
							</h3>
						</div>
					<?php }
					echo '</div>';
				}
			?>
					<footer class="entry-footer">
						<?php get_template_part( 'inc/partials/entry/page', 'footer' ); ?>
					</footer>
				</section>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
