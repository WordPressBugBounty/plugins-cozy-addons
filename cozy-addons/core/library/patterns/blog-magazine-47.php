<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"40px","bottom":"40px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:40px;padding-right:26px;padding-bottom:40px;padding-left:26px"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#0052ff","style":"solid","width":"2px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#0052ff;border-bottom-style:solid;border-bottom-width:2px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"style":{"color":{"background":"#0052ff"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"top":"8px","bottom":"8px","left":"16px","right":"16px"}},"border":{"radius":{"topLeft":"4px","topRight":"4px","bottomLeft":"0px","bottomRight":"4px"}}},"textColor":"background","fontSize":"normal"} -->
<h2 class="wp-block-heading has-background-color has-text-color has-background has-link-color has-normal-font-size" style="border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-left-radius:0px;border-bottom-right-radius:4px;background-color:#0052ff;padding-top:8px;padding-right:16px;padding-bottom:8px;padding-left:16px"><?php esc_html_e( 'Categories List', 'cozy-addons' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:34px"><!-- wp:query {"queryId":6,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"default"}} -->
<!-- wp:columns {"style":{"spacing":{"padding":{"bottom":"34px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"var:preset|color|border-color","width":"1px"},"left":{"width":"0px","style":"none"}}}} -->
<div class="wp-block-columns" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:var(--wp--preset--color--border-color);border-bottom-width:1px;border-left-style:none;border-left-width:0px;padding-bottom:34px"><!-- wp:column {"width":"50%","style":{"spacing":{"padding":{"top":"0","bottom":"0"},"blockGap":"0"}}} -->
<div class="wp-block-column" style="padding-top:0;padding-bottom:0;flex-basis:50%"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"430px","style":{"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"typography":{"fontSize":"16px"}}} -->
<div class="wp-block-column" style="font-size:16px"><!-- wp:post-terms {"term":"category","separator":"","style":{"typography":{"fontSize":"12px"}},"cozyItemStyles":{"padding":{"top":"4px","right":"8px","bottom":"4px","left":"8px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#FFFFFF","bg":"#0052ff","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#2DC7BF","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|dark-color"}}},"spacing":{"margin":{"top":"16px"}},"typography":{"fontSize":"20px"}},"textColor":"dark-color"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"top":"16px"}},"typography":{"textTransform":"capitalize","fontSize":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:16px;font-size:12px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"spacing":{"padding":{"right":"6px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|border-color","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} /-->

<!-- wp:post-date {"datetime":"2026-07-02T10:24:04.663Z","style":{"typography":{"fontSize":"12px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"excerptLength":42,"style":{"spacing":{"margin":{"top":"16px"}}}} /-->

<!-- wp:read-more {"content":"Read More","style":{"spacing":{"padding":{"top":"8px","bottom":"8px","left":"16px","right":"16px"}},"border":{"color":"#0052ff","width":"1px"},"color":{"text":"#0052ff"},"elements":{"link":{"color":{"text":"#0052ff"}}},"typography":{"fontSize":"16px"}}} /--></div>
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