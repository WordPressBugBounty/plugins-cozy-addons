<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"26px","left":"26px","top":"40px","bottom":"40px"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:40px;padding-right:26px;padding-bottom:40px;padding-left:26px"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#0052ff","width":"2px"},"left":{"width":"0px","style":"none"}},"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#0052ff;border-bottom-width:2px;border-left-style:none;border-left-width:0px;margin-top:0;margin-bottom:0"><!-- wp:heading {"style":{"color":{"background":"#0052ff"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"border":{"radius":{"topLeft":"4px","topRight":"4px","bottomLeft":"0px","bottomRight":"4px"}},"spacing":{"padding":{"top":"8px","bottom":"8px","left":"16px","right":"16px"}}},"textColor":"background","fontSize":"normal"} -->
<h2 class="wp-block-heading has-background-color has-text-color has-background has-link-color has-normal-font-size" style="border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-left-radius:0px;border-bottom-right-radius:4px;background-color:#0052ff;padding-top:8px;padding-right:16px;padding-bottom:8px;padding-left:16px"><?php esc_html_e( 'Editor\'s Pick', 'cozy-addons' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:34px"><!-- wp:query {"queryId":31,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"isUserOverlayColor":true,"minHeight":290,"contentPosition":"bottom left","style":{"spacing":{"padding":{"top":"15px","bottom":"15px","left":"15px","right":"15px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;margin-top:0;margin-bottom:0;padding-top:15px;padding-right:15px;padding-bottom:15px;padding-left:15px;min-height:290px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"placeholder":"Write title…","style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size"></p>
<!-- /wp:paragraph -->

<!-- wp:post-terms {"term":"category","separator":"","style":{"spacing":{"padding":{"right":"0"}}},"fontSize":"x-small","cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#FFFFFF","bg":"#0052ff","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#2DC7BF","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /--></div></div>
<!-- /wp:cover -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#101112"}}},"color":{"text":"#101112"},"typography":{"fontSize":"18px"}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"4px","margin":{"top":"12px"}},"typography":{"textTransform":"capitalize"}},"fontSize":"x-small","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"}} -->
<div class="wp-block-group has-x-small-font-size" style="margin-top:12px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"spacing":{"padding":{"right":"4px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|foreground","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}},"typography":{"textAlign":"left"}}} /-->

<!-- wp:post-date {"datetime":"2026-06-29T10:28:50.243Z"} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"excerptLength":12,"style":{"spacing":{"margin":{"top":"16px"}}}} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p><?php esc_html_e( 'Oops! Blogs Not Found', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->