<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"color":{"text":"#4b504f","background":"#fffffe"},"elements":{"link":{"color":{"text":"#4b504f"}}},"typography":{"lineHeight":1.6,"fontStyle":"normal","fontWeight":"300","fontSize":"16px"},"spacing":{"padding":{"right":"26px","left":"26px","top":"80px","bottom":"80px"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"1180px"},"cozyCustomFont":"Inter"} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="color:#4b504f;background-color:#fffffe;margin-top:0;margin-bottom:0;padding-top:80px;padding-right:26px;padding-bottom:80px;padding-left:26px;font-size:16px;font-style:normal;font-weight:300;line-height:1.6"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:group {"style":{"spacing":{"blockGap":"5px","margin":{"bottom":"16px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group" style="margin-bottom:16px"><!-- wp:paragraph {"style":{"typography":{"textAlign":"center","fontSize":"13px"},"color":{"text":"#03201b"},"elements":{"link":{"color":{"text":"#03201b"}}},"border":{"color":"#e4e4e7","style":"solid","width":"1px","radius":{"topLeft":"100px","topRight":"100px","bottomLeft":"100px","bottomRight":"100px"}},"spacing":{"padding":{"right":"16px","left":"16px","top":"2px","bottom":"2px"}}}} -->
<p class="has-text-align-center has-border-color has-text-color has-link-color" style="border-color:#e4e4e7;border-style:solid;border-width:1px;border-top-left-radius:100px;border-top-right-radius:100px;border-bottom-left-radius:100px;border-bottom-right-radius:100px;color:#03201b;padding-top:2px;padding-right:16px;padding-bottom:2px;padding-left:16px;font-size:13px"><?php esc_html_e( 'Blogs & Articles', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"style":{"color":{"text":"#03201b"},"elements":{"link":{"color":{"text":"#03201b"}}},"typography":{"fontSize":"64px","fontStyle":"normal","fontWeight":"500","letterSpacing":"-2px","lineHeight":"1.2"}},"cozyCustomFont":"Miranda Sans"} -->
<h2 class="wp-block-heading has-text-color has-link-color" style="color:#03201b;font-size:64px;font-style:normal;font-weight:500;letter-spacing:-2px;line-height:1.2"><?php esc_html_e( 'Stay updated with expert news and insights', 'cozy-addons' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:buttons {"style":{"spacing":{"margin":{"top":"0px"}},"typography":{"fontSize":"16px"}},"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons has-custom-font-size" style="margin-top:0px;font-size:16px"><!-- wp:button {"style":{"spacing":{"padding":{"left":"28px","right":"28px","top":"12px","bottom":"12px"}},"color":{"text":"#0c574b","background":"#f0f3f3"},"elements":{"link":{"color":{"text":"#0c574b"}}},"border":{"radius":{"topLeft":"100px","topRight":"100px","bottomLeft":"100px","bottomRight":"100px"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color wp-element-button" href="#" style="border-top-left-radius:100px;border-top-right-radius:100px;border-bottom-left-radius:100px;border-bottom-right-radius:100px;color:#0c574b;background-color:#f0f3f3;padding-top:12px;padding-right:28px;padding-bottom:12px;padding-left:28px"><?php esc_html_e( 'Read More Articles', 'cozy-addons' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"20px"}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"height":"320px","style":{"border":{"radius":{"topLeft":"24px","topRight":"24px","bottomLeft":"24px","bottomRight":"24px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"12px","margin":{"top":"12px","bottom":"12px"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:12px;margin-bottom:12px"><!-- wp:post-terms {"term":"category","separator":"","style":{"typography":{"fontSize":"13px","fontStyle":"normal","fontWeight":"400","textDecoration":"none"}},"cozyItemStyles":{"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"},"border":{"width":"","style":"","color":""},"radius":"0px","primaryColor":{"text":"#878e8d","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#FF598E","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"color":{"text":"#5d6065"},"elements":{"link":{"color":{"text":"#5d6065"}}},"typography":{"fontSize":"13px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"color":{"text":"#03201b"},"elements":{"link":{"color":{"text":"#03201b"}}},"typography":{"fontSize":"18px","lineHeight":"1.4","fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"bottom":"12px"}}},"cozyCustomFont":"Miranda Sans"} /-->

<!-- wp:post-excerpt {"excerptLength":20} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p><?php esc_html_e( 'Oops! No posts found.', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->