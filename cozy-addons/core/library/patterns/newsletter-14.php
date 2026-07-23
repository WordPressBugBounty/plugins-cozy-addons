<!-- wp:group {"style":{"spacing":{"padding":{"top":"60px","bottom":"60px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"color":{"background":"#e8e8ff"}},"layout":{"type":"constrained","contentSize":"650px"}} -->
<div class="wp-block-group has-background" style="background-color:#e8e8ff;margin-top:0;margin-bottom:0;padding-top:60px;padding-right:26px;padding-bottom:60px;padding-left:26px"><!-- wp:heading {"style":{"typography":{"textAlign":"center","fontSize":"38px"},"color":{"text":"#0e0e10"},"elements":{"link":{"color":{"text":"#0e0e10"}}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color has-link-color" style="color:#0e0e10;font-size:38px">
<?php
	esc_html_e( 'Subscribe To Our Newsletter', 'cozy-addons' );
?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center","fontSize":"16px"},"spacing":{"margin":{"top":"16px"}},"color":{"text":"#47474d"},"elements":{"link":{"color":{"text":"#47474d"}}}}} -->
<p class="has-text-align-center has-text-color has-link-color" style="color:#47474d;margin-top:16px;font-size:16px">
<?php
	esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '' );
?>
</p>
<!-- /wp:paragraph -->
<?php
if ( class_exists( 'WPCF7' ) ) {
	?>
<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:34px;margin-bottom:0"><!-- wp:contact-form-7/contact-form-selector {"id":1881,"hash":"a1d05bf","title":"Contact form 1","className":"monocle-newsletter-form"} -->
<div class="wp-block-contact-form-7-contact-form-selector monocle-newsletter-form">[contact-form-7 id="a1d05bf" title="Contact form 1"]</div>
<!-- /wp:contact-form-7/contact-form-selector --></div>
<!-- /wp:group -->
	<?php
} else {
	?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p>
	<?php
	esc_html_e( 'Note: Please install and activate the WP-CF7 plugin. Add the additional CSS class name "monocle-newsletter-form" to the Contact Form block.', 'cozy-addons' );
	?>
</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>
	<?php
	esc_html_e( 'Use the following Contact Form 7 fields for the newsletter form:', 'cozy-addons' );
	?>
</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[email* your-email autocomplete:email placeholder "sample@example.com"]
[submit "Subscribe"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
	<?php
}
?>
</div>
<!-- /wp:group -->