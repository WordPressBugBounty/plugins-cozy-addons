<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"44px","left":"26px"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"style":{"typography":{"lineHeight":"1.3","fontSize":"32px","fontStyle":"normal","fontWeight":"600"}}} -->
<h2 class="wp-block-heading" style="font-size:32px;font-style:normal;font-weight:600;line-height:1.3">Subscribe to Our Newsletter to Unlock the Full Article</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"16px","bottom":"16px"}}}} -->
<p style="margin-top:16px;margin-bottom:16px">Enter your email to unlock the complete article and get our latest insights delivered to your inbox.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"0","padding":{"right":"0px","left":"0px","top":"0px","bottom":"0px"}},"typography":{"fontSize":"16px"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:16px"><?php echo \CozyAddons\Core\Forms\Form_Patterns::newsletter_form_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Serialized block markup built from JSON-encoded attributes. ?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->