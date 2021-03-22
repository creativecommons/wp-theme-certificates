<?php
/**
 * Functionality related to Advanced Custom Fields, which is used to
 * register metaboxes per template, page, or on a global settings page.
 */
class Certificates_ACF {
	public static function init() {
		// Register global settings page
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page();
		}
	}

	/**
	 * This only runs on the back-end, when editing a page using the page-home.php template.
	 *
	 * @todo Maybe add a short transient here? Not sure if necessary since on the back-end only.
	 * @todo Maybe need to load more than 50 most recent posts? Download multiple pages and build list.
	 */
	public static function acf_load_blog_posts( $field ) {
		// reset choices
		$field['choices'] = array();
		$blog_posts       = load_org_blog_posts();

		foreach ( $blog_posts as $post ) {
			$field['choices'][ $post->id ] = $post->title->rendered;
		}

		// return the field
		return $field;
	}

	/**
	 * Populate the 'Featured FAQs' dropdown on the homepage edit page with the actual FAQs.
	 */
	public static function acf_load_featured_faq_choices( $field ) {
		$field['choices'] = array();

		// @todo: FAQ page id is hardcoded here, find a way to make this dynamic
		$faq_groups = get_field( 'faq_group', 32 );

		foreach ( $faq_groups as $faqGroup ) {
			foreach ( $faqGroup['questions'] as $question ) {
				$field['choices'][ $question['question'] ] = $question['question'];
			}
		}

		return $field;
	}

	/**
	 * Populate the 'Featured Testimonials' slider on the homepage edit page with the actual Testimonials.
	 */
	public static function acf_load_featured_testimonials( $field ) {
		$field['choices'] = array();

		// @todo: Testimonials page id is hardcoded here, find a way to make this dynamic
		$testimonials = get_field( 'testimonials', 16 );

		foreach ( $testimonials as $testimonial ) {
			$field['choices'][ $testimonial['citation'] ] = $testimonial['citation'];
		}

		return $field;
	}

	/**
	 * Retrieve the list of featured FAQs from a list of FAQ titles.
	 * Basically, FAQ string titles are being treated as a unique ID for retrieval.
	 **/
	public static function get_faqs_by_titles( $titles = array() ) {
		// @todo: FAQ page id is hardcoded here, find a way to make this dynamic
		$faq_groups    = get_field( 'faq_group', 32 );
		$filtered_faqs = array();

		foreach ( $faq_groups as $faq_group ) {
			foreach ( $faq_group['questions'] as $question ) {
				if ( in_array( $question['question'], $titles ) ) {
					array_push( $filtered_faqs, $question );
				}
			}
		}

		return $filtered_faqs;
	}

	/**
	 * Retrieve the list of featured testimonials from a list of testimonial citations.
	 * Basically, FAQ string titles are being treated as a unique ID for retrieval.
	 **/
	public static function get_testimonials_by_cite( $citations = array() ) {
		// @todo: FAQ page id is hardcoded here, find a way to make this dynamic
		$testimonials          = get_field( 'testimonials', 16 );
		$filtered_testimonials = array();

		foreach ( $testimonials as $testimonial ) {
			if ( in_array( $testimonial['citation'], $citations ) ) {
				array_push( $filtered_testimonials, $testimonial );
			}
		}

		return $filtered_testimonials;
	}


	// @todo: Also store in transient (even if short)
	public static function load_home_featured_posts() {
		$url        = 'https://creativecommons.org/wp-json/wp/v2/posts?per_page=50';
		$media_url  = 'https://creativecommons.org/wp-json/wp/v2/media';
		$author_url = 'https://creativecommons.org/wp-json/wp/v2/users';

		$transient_key = 'home_posts' . $url;

		foreach ( get_field( 'featured_news', get_option( 'page_on_front' ) ) as $news ) {
			if ( $news['post_id'] ) {
				$url .= '&include[]=' . $news['post_id'];
			}
		}

		if ( false === ( $results = get_transient( $transient_key ) ) ) {

			$posts = query_api( $url );

			foreach ( $posts as $post ) {
				// Attach featured image info
				if ( ! empty( $post->featured_media ) ) {
					$api_response = query_api( $media_url . '/' . $post->featured_media );

					if ( ! empty( $api_response ) ) {
						$post->featured_media_url = $api_response->media_details->sizes->cc_list_post_thumbnail->source_url;
						$post->alt_text           = $api_response->alt_text;
					}
				}

				// Attach author info
				if ( ! empty( $post->author ) ) {
					$api_response = query_api( $author_url . '/' . $post->author );

					if ( ! empty( $api_response ) ) {
						$post->author_name = $api_response->name;
						$post->author_url  = $api_response->link;
					}
				}
			}

			$results = array();
			foreach ( $posts as $post ) {
				$results[ $post->id ] = $post;
			}

			set_transient( $transient_key, $results, HOUR_IN_SECONDS ); // @todo Maybe longer?
		}

		return $results;
	}
}

add_action( 'acf/init', array( 'Certificates_ACF', 'init' ) );
add_filter( 'acf/load_field/name=post_id', array( 'Certificates_ACF', 'acf_load_blog_posts' ) );
add_filter( 'acf/load_field/name=featured_faqs', array( 'Certificates_ACF', 'acf_load_featured_faq_choices' ) );
add_filter( 'acf/load_field/name=featured_testimonials', array( 'Certificates_ACF', 'acf_load_featured_testimonials' ) );
