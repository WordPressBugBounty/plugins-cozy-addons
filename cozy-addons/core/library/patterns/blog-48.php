<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"color":{"text":"#434343","background":"#fffffe"},"elements":{"link":{"color":{"text":"#434343"}}},"typography":{"fontSize":"16px","lineHeight":1.6,"fontStyle":"normal","fontWeight":"300"},"spacing":{"padding":{"right":"26px","left":"26px","top":"80px","bottom":"80px"}}},"layout":{"type":"constrained","contentSize":"1180px"},"cozyHoverEffect":{"hasOverflow":true,"overflow":"hidden","hasZIndex":false,"zIndex":0,"boxShadow":{"enabled":false,"color":"#000","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"boxShadowHover":{"enabled":false,"color":"#000","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"transformEnabled":false,"transform":{"translateX":0,"translateY":0,"rotate":0,"scale":1},"transformDefaultEnabled":false,"transformDefault":{"translateX":0,"translateY":0,"rotate":0,"scale":1}},"cozyCustomFont":"Outfit"} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="color:#434343;background-color:#fffffe;padding-top:80px;padding-right:26px;padding-bottom:80px;padding-left:26px;font-size:16px;font-style:normal;font-weight:300;line-height:1.6"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"44px"},"blockGap":"0","padding":{"right":"0","left":"0","top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"625px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:44px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"#181717"}}},"color":{"text":"#181717"},"typography":{"fontSize":"36px","lineHeight":"1.2","fontStyle":"normal","fontWeight":"600","textTransform":"uppercase","textAlign":"center"},"spacing":{"margin":{"top":"0","bottom":"10px"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color has-link-color" style="color:#181717;margin-top:0;margin-bottom:10px;font-size:36px;font-style:normal;font-weight:600;line-height:1.2;text-transform:uppercase"><?php esc_html_e( 'Latest News & Articles', 'cozy-addons' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center"><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":8,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"},"padding":{"right":"0px","left":"0px","top":"0px","bottom":"0px"}}},"layout":{"type":"constrained"},"cozyHoverEffect":{"hasOverflow":false,"overflow":"hidden","hasZIndex":false,"zIndex":0,"boxShadow":{"enabled":true,"color":"#1716161c","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"boxShadowHover":{"enabled":false,"color":"#000","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"transformEnabled":false,"transform":{"translateX":0,"translateY":0,"rotate":0,"scale":1},"transformDefaultEnabled":false,"transformDefault":{"translateX":0,"translateY":0,"rotate":0,"scale":1}}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"width":"","height":"280px","style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"right":"26px","left":"26px","top":"20px","bottom":"20px"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group" style="padding-top:20px;padding-right:26px;padding-bottom:20px;padding-left:26px"><!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"top":"0"}},"typography":{"fontSize":"14px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-top:0;font-size:14px"><!-- wp:group {"style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><?php esc_html_e( 'By:', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-author-name /--></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><?php esc_html_e( '/', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#181717"}}},"color":{"text":"#181717"},"typography":{"fontSize":"18px","lineHeight":"1.5","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"10px","bottom":"10px"}}},"cozyCustomFont":"Outfit"} /-->

<!-- wp:post-excerpt {"excerptLength":20} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p><?php esc_html_e( 'No posts found.', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:buttons {"style":{"typography":{"fontSize":"18px"},"spacing":{"margin":{"top":"36px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons has-custom-font-size" style="margin-top:36px;font-size:18px"><!-- wp:button {"style":{"color":{"background":"#ffffff00","text":"#181717"},"elements":{"link":{"color":{"text":"#181717"}}},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"},"color":"#181717","style":"solid","width":"1px"},"spacing":{"padding":{"left":"36px","right":"36px","top":"14px","bottom":"14px"}}},"cozyHoverStyles":{"bgColor":"#c90d0d","color":"#fffffe","borderColor":"#c90d0d"}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color has-border-color wp-element-button" href="#" style="border-color:#181717;border-style:solid;border-width:1px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;color:#181717;background-color:#ffffff00;padding-top:14px;padding-right:36px;padding-bottom:14px;padding-left:36px"><?php esc_html_e( 'Read More', 'cozy-addons' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->