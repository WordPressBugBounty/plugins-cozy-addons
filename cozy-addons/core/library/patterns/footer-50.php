<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"60px","right":"26px","left":"26px","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#fffffe1a","style":"solid","width":"1px"},"left":{"width":"0px","style":"none"}},"color":{"background":"#0e0e10","text":"#ffffff"},"elements":{"link":{"color":{"text":"#ffffff"}}},"typography":{"fontSize":"16px"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#fffffe1a;border-bottom-style:solid;border-bottom-width:1px;border-left-style:none;border-left-width:0px;color:#ffffff;background-color:#0e0e10;margin-top:0;margin-bottom:0;padding-top:60px;padding-right:26px;padding-bottom:0;padding-left:26px;font-size:16px"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"40%","style":{"border":{"top":{"width":"0px","style":"none"},"right":{"color":"#fffffe1a","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} -->
<div class="wp-block-column" style="border-top-style:none;border-top-width:0px;border-right-color:#fffffe1a;border-right-width:1px;border-bottom-style:none;border-bottom-width:0px;border-left-style:none;border-left-width:0px;flex-basis:40%"><!-- wp:group {"fontSize":"mega","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group has-mega-font-size"><!-- wp:site-logo {"width":44} /-->

<!-- wp:site-title {"level":2,"style":{"elements":{"link":{"color":{"text":"#fffffe"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"typography":{"fontSize":"44px"},"color":{"text":"#fffffe"}}} /--></div>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"typography":{"fontSize":"16px"}},"textColor":"foreground-alt"} -->
<p class="has-foreground-alt-color has-text-color has-link-color" style="font-size:16px">
<?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"light-color","iconColorValue":"#FFFFFE","customIconBackgroundColor":"#fffffe1a","iconBackgroundColorValue":"#fffffe1a","className":"is-style-default","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}},"spacing":{"margin":{"top":"28px"}}}} -->
<ul class="wp-block-social-links has-icon-color has-icon-background-color is-style-default" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;margin-top:28px"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"youtube"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%","style":{"border":{"top":{"width":"0px","style":"none"},"right":{"color":"#fffffe1a","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} -->
<div class="wp-block-column" style="border-top-style:none;border-top-width:0px;border-right-color:#fffffe1a;border-right-width:1px;border-bottom-style:none;border-bottom-width:0px;border-left-style:none;border-left-width:0px;flex-basis:25%"><!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"#fffffe"}}},"typography":{"textTransform":"uppercase","fontSize":"24px"},"color":{"text":"#fffffe"}}} -->
<h3 class="wp-block-heading has-text-color has-link-color" style="color:#fffffe;font-size:24px;text-transform:uppercase">
<?php esc_html_e( 'Categories', 'cozy-addons' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:categories {"className":"cozy-addons__no-list-style","style":{"spacing":{"padding":{"right":"0","left":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|light-color"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"typography":{"lineHeight":"1.8","fontSize":"16px"}},"textColor":"light-color"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"#fffffe"}}},"typography":{"textTransform":"uppercase","fontSize":"16px"},"color":{"text":"#fffffe"}}} -->
<h3 class="wp-block-heading has-text-color has-link-color" style="color:#fffffe;font-size:16px;text-transform:uppercase">
<?php esc_html_e( 'Featured Articles', 'cozy-addons' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"24px"}},"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}}},"textColor":"foreground-alt","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group has-foreground-alt-color has-text-color has-link-color" style="margin-top:24px"><!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"140px"} -->
<div class="wp-block-column" style="flex-basis:140px"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"120px"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:post-title {"level":4,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#fffffe"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"color":{"text":"#fffffe"},"typography":{"fontSize":"16px"}}} /-->

<!-- wp:post-date {"datetime":"2026-07-07T12:41:14.011Z","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"spacing":{"padding":{"left":"6px"},"margin":{"top":"12px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"width":"0px","style":"none"},"left":{"color":"var:preset|color|foreground-alt","width":"1px"}}},"textColor":"foreground-alt","fontSize":"x-small"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p>
<?php esc_html_e( 'Oops! Blogs Not Found', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"16px","bottom":"16px"},"margin":{"top":"0","bottom":"0"}},"border":{"top":{"color":"#fffffe1a","style":"solid","width":"1px"},"right":{"width":"0px","style":"none"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group" style="border-top-color:#fffffe1a;border-top-style:solid;border-top-width:1px;border-right-style:none;border-right-width:0px;border-bottom-style:none;border-bottom-width:0px;border-left-style:none;border-left-width:0px;margin-top:0;margin-bottom:0;padding-top:16px;padding-bottom:16px"><!-- wp:paragraph {"style":{"typography":{"textAlign":"center"},"elements":{"link":{"color":{"text":"#fffffe"}}},"color":{"text":"#fffffe"}}} -->
<p class="has-text-align-center has-text-color has-link-color" style="color:#fffffe">
<?php esc_html_e( 'Proudly powered by WordPress | Monocle by CozyThemes.', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->