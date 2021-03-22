<?php
  /**
   * Home Testimonials Slider
   */
  $featured_testimonial_citations = get_field( 'featured_testimonials' );
  $testimonials                   = Certificates_ACF::get_testimonials_by_cite( $featured_testimonial_citations );
?>

<div class="testimonials-slider">
  <div class="glide__track" data-glide-el="track">
	<ul class="glide__slides">
	  <?php foreach ( $testimonials as $testimonial ) : ?>
	  <li class="glide__slide">
			<?php if ( $testimonial['image'] ) : ?>
		<div class="margin-right-bigger img-wrap">
				<?php echo wp_get_attachment_image( $testimonial['image'] ); ?>
		</div>
		<?php endif; ?>
		<blockquote class="body-bigger">
		  <svg width="46" height="32" viewBox="0 0 46 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="margin-bottom-normal">
			<path fill-rule="evenodd" clip-rule="evenodd"
			  d="M27.3836 26.8797C25.8676 24.1902 25 21.0676 25 17.737C25 11.3769 29.1325 2.81312 39.3401 0L41.196 5.31367C36.3588 7.02275 33.1774 10.4191 32.8559 12.5458C33.8727 12.1893 34.9648 11.9956 36.1017 11.9956C41.5684 11.9956 46 16.4737 46 21.9978C46 27.5219 41.5684 32 36.1017 32C32.3717 32 29.1235 29.9151 27.4362 26.8357L27.3836 26.8797Z"
			  fill="#333333" />
			<path fill-rule="evenodd" clip-rule="evenodd"
			  d="M2.38359 26.8797C0.867634 24.1902 -1.90735e-06 21.0676 -1.90735e-06 17.737C-1.90735e-06 11.3769 4.13252 2.81312 14.3401 0L16.196 5.31367C11.3588 7.02275 8.17739 10.4191 7.85587 12.5458C8.87269 12.1893 9.96483 11.9956 11.1017 11.9956C16.5684 11.9956 21 16.4737 21 21.9978C21 27.5219 16.5684 32 11.1017 32C7.37168 32 4.12352 29.9151 2.43624 26.8357L2.38359 26.8797Z"
			  fill="#333333" />
		  </svg>

			<?php echo $testimonial['testimonial']; ?>

		  <cite>
			<p><?php echo $testimonial['citation']; ?></p>
		  </cite>
		</blockquote>
	  </li>
	  <?php endforeach; ?>
	</ul>
  </div>

  <div class="testimonial-slider-controls">
	<div class="glide__arrows" data-glide-el="controls">
	  <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
		<span class="is-sr-only">Previous</span>
		<svg width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
		  <path
			d="M0.823834 6.00283L6.51768 0.309277C6.79219 0.0347656 7.23751 0.0347656 7.51202 0.309277L8.17618 0.973438C8.4504 1.24766 8.45069 1.6918 8.17735 1.9666L3.66475 6.5L8.17706 11.0337C8.45069 11.3085 8.4501 11.7526 8.17589 12.0269L7.51172 12.691C7.23721 12.9655 6.7919 12.9655 6.51739 12.691L0.823834 6.99717C0.549323 6.72266 0.549323 6.27734 0.823834 6.00283V6.00283Z"
			fill="black" />
		</svg>
	  </button>

	  <div class="glide__bullets" data-glide-el="controls[nav]">
      <?php for ( $i = 0; $i < count( $testimonials ); $i++ ) { ?>
        <button class="glide__bullet" data-glide-dir="=<?php echo $i; ?>"></button>
      <?php } ?>
	  </div>

	  <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
		<span class="is-sr-only">Next</span>
		<svg width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
		  <path
			d="M8.17606 6.99723L2.48239 12.6909C2.20779 12.9655 1.7626 12.9655 1.48803 12.6909L0.823954 12.0268C0.549823 11.7527 0.549296 11.3084 0.822783 11.0336L5.33512 6.50003L0.822783 1.96649C0.549296 1.69171 0.549823 1.24742 0.823954 0.973293L1.48803 0.309221C1.76263 0.0346216 2.20782 0.0346216 2.48239 0.309221L8.17604 6.00286C8.45063 6.27743 8.45064 6.72263 8.17606 6.99723Z"
			fill="black" />
		</svg>
	  </button>
	</div>
	<a href="/testimonials" class="has-text-weight-semi-bold">Read What Graduates Say</a>
  </div>

</div>
