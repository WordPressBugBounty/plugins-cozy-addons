<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"40px","bottom":"40px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:40px;padding-right:26px;padding-bottom:40px;padding-left:26px"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#0052ff","width":"2px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#0052ff;border-bottom-width:2px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"level":3,"style":{"color":{"background":"#0052ff"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"top":"8px","bottom":"8px","left":"16px","right":"16px"}},"border":{"radius":{"topLeft":"4px","topRight":"4px","bottomLeft":"0px","bottomRight":"4px"}}},"textColor":"background","fontSize":"normal"} -->
<h3 class="wp-block-heading has-background-color has-text-color has-background has-link-color has-normal-font-size" style="border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-left-radius:0px;border-bottom-right-radius:4px;background-color:#0052ff;padding-top:8px;padding-right:16px;padding-bottom:8px;padding-left:16px"><?php esc_html_e( 'Editor\'s Pick', 'cozy-addons' ); ?></h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:34px"><!-- wp:query {"queryId":14,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:columns {"style":{"spacing":{"padding":{"bottom":"16px"},"blockGap":{"top":"18px","left":"18px"},"margin":{"top":"0","bottom":"0"}},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#0000001a","width":"1px"},"left":{"width":"0px","style":"none"}}}} -->
<div class="wp-block-columns" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#0000001a;border-bottom-width:1px;border-left-style:none;border-left-width:0px;margin-top:0;margin-bottom:0;padding-bottom:16px"><!-- wp:column {"width":"160px"} -->
<div class="wp-block-column" style="flex-basis:160px"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"isUserOverlayColor":true,"minHeight":120,"contentPosition":"bottom left","style":{"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"12px","right":"12px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:12px;padding-right:12px;padding-bottom:12px;padding-left:12px;min-height:120px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size"></p>
<!-- /wp:paragraph -->

<!-- wp:post-terms {"term":"category","separator":"","fontSize":"x-small","cozyItemStyles":{"padding":{"top":"4px","right":"8px","bottom":"4px","left":"8px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"currentColor","bg":"#0052ff","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#2DC7BF","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /--></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:post-title {"level":4,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#101112"}}},"spacing":{"margin":{"right":"0","left":"0"}},"color":{"text":"#101112"},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500"}}} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"16px"},"blockGap":"8px"},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}},"typography":{"textTransform":"capitalize"}},"textColor":"foreground","fontSize":"x-small","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group has-foreground-color has-text-color has-link-color has-x-small-font-size" style="margin-top:16px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"spacing":{"padding":{"right":"8px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"#0000001a","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} /-->

<!-- wp:post-date {"datetime":"2026-06-30T11:31:39.594Z"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p><?php esc_html_e( 'Oops! Blogs Not Found', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->