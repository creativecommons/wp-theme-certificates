<?php
/**
 * Class for working with BB Press and alumni.
 */
class CC_Alumni {
	private static $instance;

	public $home_page_id;
	public $login_page_id;
	public $members_page_id;
	public $forum_page_id;

	public $alumni;

	function __construct() {
		$this->home_page_id    = get_field( 'alumni_home_page', 'options' );
		$this->login_page_id   = get_field( 'alumni_login_page', 'options' );
		$this->members_page_id = get_field( 'alumni_members_page', 'options' );
		$this->forum_page_id   = get_field( 'alumni_forum_page', 'options' );

		$this->alumni = $this->get_alumni();
		$this->actions_manager();
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			$c              = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
  }

  public static function get_latest_posts( $count = 3 ) {
    $args = array(
        'post_type'   => 'topic',
        'numberposts' => $count,
    );

    return get_posts( $args );
	}

	public static function forum_card( $post_id ) {
		$author_id = get_post_field( 'post_author', $post_id );
		?>
		<article class="fixed-card fixed-card--stacked">
			<header>
				<a href="<?php echo get_the_permalink( $post_id ); ?>">
					<h3 class="subtitle is-5"><?php echo get_the_title( $post_id ) ?></h3>
				</a>
			</header>
			<footer class="foot">
				<p class="caption has-text-weight-semibold">
					Posted By
					<a href="<?php echo bbp_get_user_profile_url( $author_id ); ?>">
						<?php echo get_the_author_meta( 'display_name', $author_id ); ?>
					</a>
				</p>
				<p class="caption has-text-grey has-text-weight-semibold"><?php echo get_the_date( 'm/d/yy', $post_id ); ?></p>
			</footer>
		</article>
		<?php
	}

	public static function get_alumni() {
		$key = 'cc_alumni_members';

		if ( false === ( $results = get_transient( $key ) ) ) {
			$results = get_users(
				array(
					'role__in' => array( 'bbp_participant' ),
					'fields'   => array(
						'ID',
						'user_email',
						'display_name',
					),
				)
			);
			set_transient( $key, $results, HOUR_IN_SECONDS / 4 );
		}

		return $results;
	}

	public function render_alumni( $count = null ) {
		$alumni = array_slice( $this->alumni, 0, $count );
		?>
<div class="alumni-members">
<?php foreach ($alumni as $single_alumni ) { ?>
		<a href="<?php echo bbp_get_user_profile_url( $single_alumni->ID ); ?>" class="alumni-member" data-alumni-name="<?php echo strtolower($single_alumni->display_name); ?>">
			<img class="margin-bottom-small" src="<?php echo get_avatar_url( $single_alumni->ID, array( 'size' => 120 ) ); ?>" alt="<?php echo $single_alumni->display_name; ?>" loading="lazy" width="120" height="120">
			<span class="has-text-weight-bold"><?php echo get_user_meta( $single_alumni->ID, 'first_name' )[0]; ?> <?php echo get_user_meta( $single_alumni->ID, 'last_name' )[0]; ?></span>
		</a>
<?php } ?>
</div>
		<?php
	}

	/**
	 * Display a notice in the WordPress back-end if the alumni pages aren't linked correctly.
	 */
	public function notify_if_pages_unlinked() {
		?>
	<div class="update-nag notice">
		<p>One or more alumni pages are unlinked. Please go to the <a href="/wp-admin/admin.php?page=acf-options">options</a> page and connect them.</p>
	</div>
		<?php
	}

	/**
	 * Check if there is a logged in alumni
	 */
	public static function is_alumni() {
		if ( function_exists( 'bbp_get_current_user_id' ) ) {
			return ! empty( bbp_get_current_user_id() );
		} else {
			return is_user_logged_in();
		}
	}

	/**
	 * Redirect from the alumni login page to the alumni home page if the user is already logged in.
	 */
	public function redirect_if_logged_in() {
		if ( $this->is_alumni() && is_page( $this->login_page_id ) ) {
			wp_redirect( get_permalink( $this->alumni_home_id ) );
			exit;
		}
	}

	/**
	 * Redirect from alumni pages to the alumni login page if the user is not logged in.
	 */
	public function redirect_if_not_logged_in() {
		$is_alumni_page = is_page( $this->home_page_id ) || is_page( $this->members_page_id ) || is_page( $this->forum_page_id );

		if ( ! $this->is_alumni() && $is_alumni_page ) {
			wp_redirect( get_permalink( $this->login_page_id ) );
			exit;
		}
	}

	/*
	* Render a simple dropdown menu for logged-in alumni
	*/
	public function show_alumni_menu_item() {
		if ( $this->is_alumni() ) {
			return '<div class="navbar-item has-dropdown is-hoverable"><a class="button alumni is-dropdown"><svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" class="margin-right-small"><path d="M5 5.625C6.55273 5.625 7.8125 4.36523 7.8125 2.8125C7.8125 1.25977 6.55273 0 5 0C3.44727 0 2.1875 1.25977 2.1875 2.8125C2.1875 4.36523 3.44727 5.625 5 5.625ZM7.5 6.25H6.42383C5.99023 6.44922 5.50781 6.5625 5 6.5625C4.49219 6.5625 4.01172 6.44922 3.57617 6.25H2.5C1.11914 6.25 0 7.36914 0 8.75V9.0625C0 9.58008 0.419922 10 0.9375 10H9.0625C9.58008 10 10 9.58008 10 9.0625V8.75C10 7.36914 8.88086 6.25 7.5 6.25Z" fill="#767676"/></svg>

      ' . bbp_get_current_user_name() . ' <i class="icon caret-down"></i></a>
  <div class="alumni-dropdown navbar-dropdown">
    <a class="navbar-item" href="' . get_permalink( $this->home_page_id ) . '">Alumni</a>
    <a class="navbar-item" href="' . bbp_get_user_profile_edit_url( bbp_get_current_user_id() ) . '">Edit Profile</a>
    <a class="navbar-item" href="' . wp_logout_url( home_url() ) . '">Sign Out</a>
  </div>
</div>';
		} else {
			return '<div class="navbar-item"><a class="button alumni" href="' . get_permalink( $this->login_page_id ) . '"><svg class="margin-right-small" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5.625C6.55273 5.625 7.8125 4.36523 7.8125 2.8125C7.8125 1.25977 6.55273 0 5 0C3.44727 0 2.1875 1.25977 2.1875 2.8125C2.1875 4.36523 3.44727 5.625 5 5.625ZM7.5 6.25H6.42383C5.99023 6.44922 5.50781 6.5625 5 6.5625C4.49219 6.5625 4.01172 6.44922 3.57617 6.25H2.5C1.11914 6.25 0 7.36914 0 8.75V9.0625C0 9.58008 0.419922 10 0.9375 10H9.0625C9.58008 10 10 9.58008 10 9.0625V8.75C10 7.36914 8.88086 6.25 7.5 6.25Z" fill="#008000"/></svg>Alumni</a></div>';
		}
	}

	public function actions_manager() {
		add_action( 'template_redirect', array( $this, 'redirect_if_logged_in' ) );
		add_action( 'template_redirect', array( $this, 'redirect_if_not_logged_in' ) );

		if ( empty( $this->home_page_id ) || empty( $this->login_page_id ) ) {
			add_action( 'admin_notices', array( $this, 'notify_if_pages_unlinked' ) );
		}
	}
}
