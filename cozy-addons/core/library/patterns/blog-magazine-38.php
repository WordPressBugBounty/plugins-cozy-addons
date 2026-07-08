<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"26px","left":"26px","top":"40px","bottom":"40px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:40px;padding-right:26px;padding-bottom:40px;padding-left:26px"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#0052ff","width":"2px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#0052ff;border-bottom-width:2px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"style":{"color":{"background":"#0052ff"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"border":{"radius":{"topLeft":"4px","topRight":"4px","bottomLeft":"0px","bottomRight":"4px"}},"spacing":{"padding":{"top":"8px","bottom":"8px","left":"16px","right":"16px"}}},"textColor":"background","fontSize":"normal"} -->
<h2 class="wp-block-heading has-background-color has-text-color has-background has-link-color has-normal-font-size" style="border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-left-radius:0px;border-bottom-right-radius:4px;background-color:#0052ff;padding-top:8px;padding-right:16px;padding-bottom:8px;padding-left:16px">
<?php
	esc_html_e( 'Categorized Post', 'cozy-addons' );
?>
</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"margin":{"top":"34px","bottom":"0"},"blockGap":{"top":"24px","left":"24px"}}}} -->
<div class="wp-block-columns" style="margin-top:34px;margin-bottom:0"><!-- wp:column {"verticalAlignment":"top","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:50%"><!-- wp:query {"queryId":27,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"style":{"typography":{"fontSize":"16px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group" style="font-size:16px"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"isUserOverlayColor":true,"minHeight":460,"contentPosition":"bottom left","className":"ca-pattern__responsive-cover","style":{"spacing":{"padding":{"top":"18px","bottom":"18px","left":"18px","right":"18px"}},"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left ca-pattern__responsive-cover" style="border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:18px;padding-right:18px;padding-bottom:18px;padding-left:18px;min-height:460px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:post-terms {"term":"category","separator":"","style":{"typography":{"fontSize":"12px"}},"cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#FFFFFF","bg":"#0052ff","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#2DC7BF","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /--></div></div>
<!-- /wp:cover -->

<!-- wp:post-title {"textAlign":"left","level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|dark-color"}}},"spacing":{"margin":{"top":"16px"}},"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"textColor":"dark-color","fontSize":"xx-large"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"4px","margin":{"top":"12px"}},"typography":{"textTransform":"capitalize","fontSize":"12px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"}} -->
<div class="wp-block-group" style="margin-top:12px;font-size:12px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"spacing":{"padding":{"right":"4px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|foreground","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}},"typography":{"textAlign":"left"}}} /-->

<!-- wp:post-date {"datetime":"2026-06-29T10:28:50.243Z","style":{"typography":{"fontSize":"12px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"textAlign":"left","excerptLength":28,"style":{"spacing":{"margin":{"top":"24px"}}}} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p>
<?php
	esc_html_e( 'Oops! Blogs Not Found', 'cozy-addons' );
?>
</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"stretch","width":"1px","style":{"color":{"background":"#0000001a"}},"layout":{"type":"default"},"cozyResponsiveShow":{"desktopShow":true,"tabletShow":false,"tabletViewport":980,"mobileShow":false,"mobileViewport":767}} -->
<div class="wp-block-column is-vertically-aligned-stretch has-background" style="background-color:#0000001a;flex-basis:1px"></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"50%","style":{"typography":{"fontSize":"16px"}}} -->
<div class="wp-block-column is-vertically-aligned-top" style="font-size:16px;flex-basis:50%"><!-- wp:query {"queryId":5,"query":{"perPage":3,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"default","columnCount":2}} -->
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"22px","left":"22px"},"padding":{"bottom":"24px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#0000001a","width":"1px"},"left":{"width":"0px","style":"none"}}}} -->
<div class="wp-block-columns" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#0000001a;border-bottom-width:1px;border-left-style:none;border-left-width:0px;padding-bottom:24px"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|dark-color"}}},"spacing":{"margin":{"top":"16px"}}},"textColor":"dark-color","fontSize":"large"} /-->

<!-- wp:post-excerpt {"excerptLength":18,"style":{"spacing":{"margin":{"top":"16px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"4px","margin":{"top":"16px"}},"typography":{"textTransform":"capitalize","fontSize":"12px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"}} -->
<div class="wp-block-group" style="margin-top:16px;font-size:12px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"spacing":{"padding":{"right":"4px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|foreground","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}},"typography":{"textAlign":"left"}}} /-->

<!-- wp:post-date {"datetime":"2026-06-29T10:28:50.243Z","style":{"typography":{"fontSize":"12px"}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"240px"} -->
<div class="wp-block-column" style="flex-basis:240px"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"200px","style":{"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}}} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p>
<?php
	esc_html_e( 'Oops! Blogs Not Found', 'cozy-addons' );
?>
</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->