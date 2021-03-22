<?php
  /*Template Name: Alumni Home Page */
	get_header();
	the_post();

	$upcoming_courses    = Certificates_Website::get_upcoming_course_events();
	$forum_latest_posts  = CC_Alumni::get_latest_posts();
?>
<section class="main-content has-background-grey-lighter">

	<header class="padding-top-big">
		<div class="container">
			<div class="alumni-header">
				<h1>Alumni</h1>
					<a target="_blank" rel="noreply noreferrer" href="https://slack.com/get-started?sig=zt-nkgoaqol-9k%7EKqpFIULx_rqdtqjKrNg&invite_id=I01QWT1LBKP&redir=%2Fshare%2Fzt-nkgoaqol-9k%7EKqpFIULx_rqdtqjKrNg#/sharedinvite" class="button slack" style="text-align: left;">
					<svg width="40" height="40" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" class="padding-right-small is-block">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M15 30C23.2843 30 30 23.2843 30 15C30 6.71573 23.2843 0 15 0C6.71573 0 0 6.71573 0 15C0 23.2843 6.71573 30 15 30ZM19.7394 12.3616C19.7394 13.5179 18.7948 14.4625 17.6384 14.4625C16.4821 14.4625 15.5375 13.5179 15.5375 12.3616V7.10098C15.5375 5.94463 16.4821 5 17.6384 5C18.7948 5 19.7394 5.94463 19.7394 7.10098V12.3616ZM10.2606 7.10099C10.2606 8.25735 11.2052 9.20197 12.3616 9.20197H14.4625V7.10099C14.4625 5.94464 13.5179 5.00002 12.3616 5.00002C11.2052 5.00002 10.2606 5.94464 10.2606 7.10099ZM9.20196 17.6384C9.20196 18.7948 8.25733 19.7394 7.10098 19.7394C5.94463 19.7394 5 18.7948 5 17.6384C5 16.4821 5.94463 15.5375 7.10098 15.5375H9.20196V17.6384ZM10.2606 17.6384C10.2606 16.4821 11.2052 15.5375 12.3616 15.5375C13.5179 15.5375 14.4625 16.4821 14.4625 17.6384V22.899C14.4625 24.0554 13.5179 25 12.3616 25C11.2052 25 10.2606 24.0554 10.2606 22.899V17.6384ZM12.3616 10.2606C13.5179 10.2606 14.4625 11.2052 14.4625 12.3616C14.4625 13.5179 13.5179 14.4625 12.3616 14.4625H7.10098C5.94463 14.4625 5 13.5179 5 12.3616C5 11.2052 5.94463 10.2606 7.10098 10.2606H12.3616ZM22.899 10.2606C21.7427 10.2606 20.7981 11.2052 20.7981 12.3616V14.4625H22.899C24.0554 14.4625 25 13.5179 25 12.3616C25 11.2052 24.0554 10.2606 22.899 10.2606ZM19.7394 22.899C19.7394 21.7427 18.7948 20.7981 17.6384 20.7981H15.5375V22.899C15.5375 24.0554 16.4821 25 17.6384 25C18.7948 25 19.7394 24.0554 19.7394 22.899ZM17.6384 19.7394C16.4821 19.7394 15.5375 18.7948 15.5375 17.6384C15.5375 16.4821 16.4821 15.5375 17.6384 15.5375H22.899C24.0554 15.5375 25 16.4821 25 17.6384C25 18.7948 24.0554 19.7394 22.899 19.7394H17.6384Z" fill="black"/>
					</svg>
					<div style="margin-left: 20px;">
						Join our slack channel<br /><small style="font-weight: 14px; text-align: right; display: block;">#cc-cert-alumni</small>
					</div>
					</a>
			</div>
		</div>
	</header>

	<section class="margin-top-larger">
		<div class="container">
			<div class="alumni-header margin-bottom-bigger">
				<h2>Members</h2>
				<a class="title is-5 has-text-forest-green" href="<?php echo get_permalink( $alumni->members_page_id ); ?>">
					See all <?php echo get_field( 'member_count_override', 'options' ) ?? count( $alumni->alumni ); ?> Members
				</a>
			</div>
			<div class="alumni-members-wrapper alumni-members-wrapper--single-row">
				<?php $alumni->render_alumni( 15 ); ?>
			</div>
		</div>
	</section>

	<section class="margin-top-xl">
	<div class="container">
		<div class="alumni-header margin-bottom-bigger">
			<h2>Forum Activity</h2>
			<a class="title is-5 has-text-forest-green" href="<?php echo get_permalink( $alumni->forum_page_id ); ?>">
				See all announcements
			</a>
		</div>
		<ul class="forum-posts">
			<?php foreach ( $forum_latest_posts as $forum_post ) { ?>
				<li>
					<?php echo CC_Alumni::forum_card( $forum_post->ID ); ?>
				</li>
			<?php } ?>
		</ul>
	</div>
	</section>

	<section class="margin-top-xl">
	<div class="container">
		<div class="alumni-header margin-bottom-bigger">
			<h2>Upcoming Courses</h2>
		</div>
		<div>
		<ul class="alumni-header">
			<?php if ( count( $upcoming_courses ) === 0 ) : ?>
				<p>There are no upcoming courses at this time.</p>
			<?php endif; ?>
			<?php foreach ( $upcoming_courses as $course ) : ?>
				<li>
					<?php echo Certificates_Website::event_card( $course->ID ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
		</div>
	</div>
	</section>

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
	</div>
</section>
<?php get_footer(); ?>
