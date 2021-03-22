<?php
/**
 * Home FAQ Section.
 */

$featured_faq_titles = get_field( 'featured_faqs' );
$faqs                = Certificates_ACF::get_faqs_by_titles( $featured_faq_titles );
?>

<div>
  <h2>Frequently Asked Questions</h2>
  <ul class="margin-top-large margin-bottom-large accordion">
	<?php foreach ( $faqs as $faq ) : ?>
	  <li class="accordion-item">
		<button class="accordion-header padding-top-big padding-bottom-big" id="<?php echo 'accordion-' . $faq['question']; ?>" aria-expanded="false" aria-controls="<?php echo 'section-' . $faq['question']; ?>">
		  <span class="has-color-dark-slate-gray has-text-left body-big">
				<?php echo $faq['question']; ?>
		  </span>
		  <span class="margin-left-small icon has-text-black">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1792 1792" class="caret">
			  <path fill="currentColor" d="M1426.44 407.864q0 26-19 45l-448 448q-19 19-45 19t-45-19l-448-448q-19-19-19-45t19-45q19-19 45-19h896q26 0 45 19t19 45z"/>
			</svg>
		  </span>
		</button>
		<div class="accordion-body accordion-body padding-left-small padding-right-small padding-vertical-normal body-big" role="region" aria-labelledby="<?php echo 'accordion-' . $faq['question']; ?>" id="<?php echo 'section-' . $faq['question']; ?>" hidden>
		  <?php echo $faq['answer']; ?>
		</div>
	  </li>
	<?php endforeach; ?>
  </ul>
  <a href="<?php echo get_page_link( 32 ); ?>" class="button register normal">See All FAQs</a>
</div>
