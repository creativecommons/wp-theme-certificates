<?php

class Certificates_Website {
	/*
	 * Render a simple card for an event
	 */
	public static function event_card( $post_id ) {
		?>
			<div class="fixed-card">
				<div class="left">
					<svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0)">
							<path
								d="M0 18.125C0 19.1602 0.879836 20 1.96429 20H16.369C17.4535 20 18.3333 19.1602 18.3333 18.125V7.5H0V18.125ZM13.0952 10.4688C13.0952 10.2109 13.3162 10 13.5863 10H15.2232C15.4933 10 15.7143 10.2109 15.7143 10.4688V12.0312C15.7143 12.2891 15.4933 12.5 15.2232 12.5H13.5863C13.3162 12.5 13.0952 12.2891 13.0952 12.0312V10.4688ZM13.0952 15.4688C13.0952 15.2109 13.3162 15 13.5863 15H15.2232C15.4933 15 15.7143 15.2109 15.7143 15.4688V17.0312C15.7143 17.2891 15.4933 17.5 15.2232 17.5H13.5863C13.3162 17.5 13.0952 17.2891 13.0952 17.0312V15.4688ZM7.85714 10.4688C7.85714 10.2109 8.07812 10 8.34821 10H9.98512C10.2552 10 10.4762 10.2109 10.4762 10.4688V12.0312C10.4762 12.2891 10.2552 12.5 9.98512 12.5H8.34821C8.07812 12.5 7.85714 12.2891 7.85714 12.0312V10.4688ZM7.85714 15.4688C7.85714 15.2109 8.07812 15 8.34821 15H9.98512C10.2552 15 10.4762 15.2109 10.4762 15.4688V17.0312C10.4762 17.2891 10.2552 17.5 9.98512 17.5H8.34821C8.07812 17.5 7.85714 17.2891 7.85714 17.0312V15.4688ZM2.61905 10.4688C2.61905 10.2109 2.84003 10 3.11012 10H4.74702C5.01711 10 5.2381 10.2109 5.2381 10.4688V12.0312C5.2381 12.2891 5.01711 12.5 4.74702 12.5H3.11012C2.84003 12.5 2.61905 12.2891 2.61905 12.0312V10.4688ZM2.61905 15.4688C2.61905 15.2109 2.84003 15 3.11012 15H4.74702C5.01711 15 5.2381 15.2109 5.2381 15.4688V17.0312C5.2381 17.2891 5.01711 17.5 4.74702 17.5H3.11012C2.84003 17.5 2.61905 17.2891 2.61905 17.0312V15.4688ZM16.369 2.5H14.4048V0.625C14.4048 0.28125 14.1101 0 13.75 0H12.4405C12.0804 0 11.7857 0.28125 11.7857 0.625V2.5H6.54762V0.625C6.54762 0.28125 6.25298 0 5.89286 0H4.58333C4.22321 0 3.92857 0.28125 3.92857 0.625V2.5H1.96429C0.879836 2.5 0 3.33984 0 4.375V6.25H18.3333V4.375C18.3333 3.33984 17.4535 2.5 16.369 2.5Z"
								fill="#333333" />
						</g>
						<defs>
							<clipPath id="clip0">
								<rect width="18.3333" height="20" fill="white" />
							</clipPath>
						</defs>
					</svg>
					<span class="title is-5"><?php echo get_field( 'start_date', $post_id ); ?></span>
					<span class="title is-5"><?php echo get_field( 'end_date', $post_id ); ?></span>
				</div>
				<div class="right">
					<a href="<?php echo get_permalink( get_field( 'related_course', $post_id ) ); ?>">
						<h3 class="subtitle is-5 margin-bottom-normal"><?php echo get_the_title( $post_id ); ?></h3>
					</a>
					<?php echo get_the_excerpt( $post_id ); ?>
					<a href="<?php echo get_permalink( get_field( 'related_course', $post_id ) ); ?>"" class="is-block has-text-weight-semibold margin-top-normal">see course details</a>
				</div>
			</div>
		<?php
	}

	public static function set_certificates_logo() {
		return 'products/certificates.svg#certificates';
	}
	public static function set_certificates_logo_image_size() {
		return '215 40';
	}
	// Add a class to the page body to override styles from the base theme
	public static function add_body_class( $classes ) {
		return array_merge( $classes, array( 'creativecommons-certificate' ) );
	}
	public static function modify_breadcrumb_seperator() {
		return '<i class="icon chevron-right is-6"></i>';
	}
	public static function get_upcoming_course_events( $post_id = null, $limit = null ) {
		$meta_query = array(
			array(
				'key'     => 'start_date',
				'compare' => '>=',
				'value'   => date( 'Ymd' ),
			),
		);

		// Filter by course if we're getting events related to a specific course.
		if ( $post_id ) {
			$meta_query[] = array(
				'key'     => 'related_course',
				'compare' => '=',
				'value'   => $post_id,
			);
		}

		$meta = array(
			'posts_per_page' => -1,
			'post_type'      => 'cc_events',
			'meta_key'       => 'start_date',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'meta_query'     => $meta_query,
		);

		if ($limit) { $meta['posts_per_page'] = $limit; }

		$posts = get_posts(	$meta );

		return $posts;
	}

	public static function get_upcoming_course_meta( $events ) {
		$upcoming_id = $events[0]->ID;
		$start       = get_field( 'start_date', $upcoming_id );
		$end         = get_field( 'end_date', $upcoming_id );

		return array(
			'start_date' => $start,
			'end_date'   => $end,
			'duration'   => numWeeks( $start, $end ),
			'language'   => get_field( 'language', $upcoming_id ),
		);
	}

	public static function register_columns_shortcode( $atts, $content ) {
		$a = shortcode_atts( array( 'cols' => '4' ), $atts );
		return '<div class="cols" style="--col-count: ' . $a['cols'] . ';">' . $content . '</div>';
	}
	public static function register_stats_shortcode( $atts, $content ) {
		return '<div class="stats has-text-black">' . do_shortcode( $content ) . '</div>';
	}
	public static function register_stat_shortcode( $atts, $content ) {
		$a = shortcode_atts(
			array(
				'title'    => '',
				'number'   => '',
				'subtitle' => '',
			),
			$atts
		);
		return '<div class="stat"><h3 class="title is-5">' . $a['title'] . '</h3><span class="number has-text-weight-bold	is-size-1">' . $a['number'] . '</span><p class="caption has-text-weight-bold">' . $a['subtitle'] . '</p></div>';
	}
	// @todo: Make this do more (add colors)/throw this out and use the card somehow
	public static function register_box_shortcode( $atts, $content ) {
		return '<div class="has-background-grey-lighter padding-vertical-big padding-horizontal-bigger cc-box margin-bottom-larger">' . $content . '</div>';
	}
	// Pressbooks hides the WordPress Admin bar, but doesn't remove the empty space :/
	public static function remove_admin_bar_top_whitespace() {
		if ( is_admin_bar_showing() ) {
			echo '<style type="text/css">html {margin-top: 0 !important;}</style>';
		}
	}
	public static function add_alumni_login_button( $items, $args ) {
		global $alumni;

		if ( $args->theme_location == 'main-navigation' ) {
			$items .= $alumni->show_alumni_menu_item();
		}
		return $items;
	}
};

// @todo: Move filter registration into class method.

// add filters
add_filter( 'cc_theme_base_set_default_size_logo', array( 'Certificates_Website', 'set_certificates_logo_image_size' ) );
add_filter( 'cc_theme_base_set_default_logo', array( 'Certificates_Website', 'set_certificates_logo' ) );
add_filter( 'body_class', array( 'Certificates_Website', 'add_body_class' ) );
add_filter( 'wpseo_breadcrumb_separator', array( 'Certificates_Website', 'modify_breadcrumb_seperator' ) );
add_filter( 'wp_head', array( 'Certificates_Website', 'remove_admin_bar_top_whitespace' ), 11 );
add_filter( 'wp_nav_menu_items', array( 'Certificates_Website', 'add_alumni_login_button' ), 10, 2 );

// Register shortcodes
add_shortcode( 'columns', array( 'Certificates_Website', 'register_columns_shortcode' ) );
add_shortcode( 'stats', array( 'Certificates_Website', 'register_stats_shortcode' ) );
add_shortcode( 'stat', array( 'Certificates_Website', 'register_stat_shortcode' ) );
add_shortcode( 'box', array( 'Certificates_Website', 'register_box_shortcode' ) );


// Helper functions
// @todo: Move these somewhere else?

function query_api( $url ) {
	$response  = wp_remote_get( $url );
	$http_code = wp_remote_retrieve_response_code( $response );
	if ( $http_code == 200 ) {
		$api_response = json_decode( wp_remote_retrieve_body( $response ) );
		return $api_response;
	} else {
		return false;
	}
}

function load_org_blog_posts() {
	$posts_url = 'https://creativecommons.org/wp-json/wp/v2/posts?per_page=50';
	$posts     = query_api( $posts_url );

	if ( ! $posts ) {
		return array();
	}

	return $posts;
}


/*
 * A custom function that calculates how many weeks occur
 * between two given dates.
 *
 * @param string $date_one Y-m-d format.
 * @param string $date_two Y-m-d format.
 * @return int
 */
function numWeeks( $date_one, $date_two ) {
	$first_date = new DateTime( $date_one );
	$secnd_date = new DateTime( $date_two );

	$difference_in_days  = $first_date->diff( $secnd_date )->days;
	$difference_in_weeks = $difference_in_days / 7;

	return floor( $difference_in_weeks );
}
