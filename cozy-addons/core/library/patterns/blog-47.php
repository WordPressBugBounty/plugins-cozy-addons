<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"26px","right":"26px"},"blockGap":"0","margin":{"top":"0","bottom":"0"}},"color":{"background":"#fffffe","text":"#131003"},"elements":{"link":{"color":{"text":"#131003"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":1.6}},"layout":{"type":"constrained","contentSize":"1180px"},"cozyCustomFont":"Arimo"} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="color:#131003;background-color:#fffffe;margin-top:0;margin-bottom:0;padding-top:80px;padding-right:26px;padding-bottom:80px;padding-left:26px;font-size:16px;font-style:normal;font-weight:400;line-height:1.6"><!-- wp:group {"style":{"spacing":{"blockGap":"26px","margin":{"bottom":"44px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="margin-bottom:44px"><!-- wp:heading {"style":{"typography":{"lineHeight":"1.2","fontSize":"36px","fontStyle":"normal","fontWeight":"600","letterSpacing":"-1px"},"color":{"text":"#131003"},"elements":{"link":{"color":{"text":"#131003"}}},"spacing":{"margin":{"bottom":"0px"}}},"cozyCustomFont":"Arimo"} -->
<h2 class="wp-block-heading has-text-color has-link-color" style="color:#131003;margin-bottom:0px;font-size:36px;font-style:normal;font-weight:600;letter-spacing:-1px;line-height:1.2"><?php esc_html_e( 'Latest News &amp; Articles', 'cozy-addons' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}},"typography":{"textDecoration":"none"}},"cozyCustomFont":"Public Sans"} -->
<p class="has-text-color has-link-color" style="color:#676767;margin-top:0;margin-bottom:0;text-decoration:none"><a href="#"><?php esc_html_e( 'View All Articles', 'cozy-addons' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":8,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"},"padding":{"right":"0px","left":"0px","top":"0px","bottom":"0px"}},"border":{"color":"#0000001f","style":"solid","width":"1px","radius":{"topLeft":"10px","topRight":"10px","bottomLeft":"0px","bottomRight":"0px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-border-color" style="border-color:#0000001f;border-style:solid;border-width:1px;border-top-left-radius:10px;border-top-right-radius:10px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;margin-top:0;margin-bottom:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"width":"","height":"280px","style":{"border":{"radius":{"topLeft":"10px","topRight":"10px","bottomLeft":"10px","bottomRight":"10px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"right":"16px","left":"16px","top":"16px","bottom":"16px"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group" style="padding-top:16px;padding-right:16px;padding-bottom:16px;padding-left:16px"><!-- wp:group {"style":{"spacing":{"blockGap":"4px","margin":{"top":"0"}},"typography":{"fontSize":"14px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0;font-size:14px"><!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><?php esc_html_e( '- by:', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-author-name /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#0e0e00"}}},"color":{"text":"#0e0e00"},"typography":{"fontSize":"18px","lineHeight":1.4,"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"10px","bottom":"10px"}}},"cozyCustomFont":"Arimo"} /-->

<!-- wp:read-more {"style":{"typography":{"textDecoration":"underline"},"color":{"text":"#131003"},"elements":{"link":{"color":{"text":"#131003"}}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p><?php esc_html_e( 'No posts found.', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->