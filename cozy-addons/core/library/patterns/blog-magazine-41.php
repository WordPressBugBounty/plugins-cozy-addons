<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"26px","left":"26px","top":"40px","bottom":"40px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:40px;padding-right:26px;padding-bottom:40px;padding-left:26px"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#0052ff","width":"2px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#0052ff;border-bottom-width:2px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"level":3,"style":{"color":{"background":"#0052ff"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"top":"8px","bottom":"8px","left":"16px","right":"16px"}}},"textColor":"background","fontSize":"normal"} -->
<h3 class="wp-block-heading has-background-color has-text-color has-background has-link-color has-normal-font-size" style="background-color:#0052ff;padding-top:8px;padding-right:16px;padding-bottom:8px;padding-left:16px">
<?php
	esc_html_e( 'Trending Post', 'cozy-addons' );
?>
</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>
<?php
	esc_html_e( 'View All', 'cozy-addons' );
?>
</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px","bottom":"0"},"blockGap":"0","padding":{"right":"0","left":"0","top":"0","bottom":"0"}},"typography":{"fontSize":"16px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:34px;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:16px"><!-- wp:query {"queryId":28,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"24px","left":"24px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"430px","style":{"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:post-terms {"term":"category","separator":"","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"12px"}},"textColor":"background","cozyItemStyles":{"padding":{"top":"4px","right":"8px","bottom":"4px","left":"8px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"currentColor","bg":"#0052ff","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#2DC7BF","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|dark-color"}}},"spacing":{"margin":{"top":"16px"}},"typography":{"fontSize":"34px"}},"textColor":"dark-color"} /-->

<!-- wp:group {"style":{"typography":{"fontSize":"12px","textTransform":"capitalize"},"spacing":{"blockGap":"8px","margin":{"top":"16px"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:16px;font-size:12px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"spacing":{"padding":{"right":"6px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"#00000080","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} /-->

<!-- wp:post-date {"datetime":"2026-07-01T11:46:54.826Z","style":{"typography":{"fontSize":"12px","textTransform":"capitalize"}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"excerptLength":32} /-->

<!-- wp:read-more {"style":{"color":{"text":"#0052ff"},"elements":{"link":{"color":{"text":"#0052ff"}}},"border":{"color":"#0052ff","width":"1px"},"spacing":{"padding":{"top":"14px","bottom":"14px","left":"24px","right":"24px"}}}} /--></div>
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
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:34px"><!-- wp:query {"queryId":55,"query":{"perPage":3,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-bottom:0"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"customOverlayColor":"#8cae94","isUserOverlayColor":false,"minHeight":290,"contentPosition":"bottom left","isDark":false,"style":{"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light has-custom-content-position is-position-bottom-left" style="border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;min-height:290px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#8cae94"></span><div class="wp-block-cover__inner-container"><!-- wp:post-terms {"term":"category","separator":"","style":{"typography":{"fontSize":"12px"}},"cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#FFFFFF","bg":"#0052ff","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#2DC7BF","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /--></div></div>
<!-- /wp:cover -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|dark-color"}}},"spacing":{"margin":{"top":"24px"}}},"textColor":"dark-color","fontSize":"large"} /-->

<!-- wp:group {"style":{"typography":{"fontSize":"12px","textTransform":"capitalize"},"spacing":{"blockGap":"8px","margin":{"top":"16px"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:16px;font-size:12px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"spacing":{"padding":{"right":"6px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"#00000080","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} /-->

<!-- wp:post-date {"datetime":"2026-07-01T11:46:54.826Z","style":{"typography":{"fontSize":"12px","textTransform":"capitalize"}}} /--></div>
<!-- /wp:group --></div>
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
<!-- /wp:group --></div>
<!-- /wp:group -->