<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"color":{"background":"#080a0f","text":"#999ea7"},"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"#999ea7"}}}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="color:#999ea7;background-color:#080a0f;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--40);font-size:16px"><!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"typography":{"fontSize":"54px"},"color":{"text":"#fffffe"},"elements":{"link":{"color":{"text":"#fffffe"}}}}} -->
<h2 class="wp-block-heading has-text-color has-link-color" style="color:#fffffe;font-size:54px">
<?php
	esc_html_e( 'Blogs & Insights', 'cozy-addons' );
?>
</h2>
<!-- /wp:heading -->

<!-- wp:buttons {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0"}}},"cozyCustomFont":"Inter"} -->
<div class="wp-block-buttons has-custom-font-size" style="margin-top:0;font-size:16px"><!-- wp:button {"type":"cozy-block-btn","style":{"spacing":{"padding":{"left":"0","right":"0","top":"0","bottom":"0"}},"color":{"background":"#ffffff00","text":"#fffffe"},"elements":{"link":{"color":{"text":"#fffffe"}}}},"icon":{"enabled":true,"path":"M20 12L20.3536 11.6464L20.7071 12L20.3536 12.3536L20 12ZM5 12.5C4.72386 12.5 4.5 12.2761 4.5 12C4.5 11.7239 4.72386 11.5 5 11.5V12.5ZM14.3536 5.64645L20.3536 11.6464L19.6464 12.3536L13.6464 6.35355L14.3536 5.64645ZM20.3536 12.3536L14.3536 18.3536L13.6464 17.6464L19.6464 11.6464L20.3536 12.3536ZM20 12.5H5V11.5H20V12.5Z","viewBox":{"vx":"0","vy":"0","vw":"24","vh":"24"},"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"},"margin":{"top":"0px","bottom":"0px"},"boxWidth":"24px","boxHeight":"24px","size":"24px","rotate":315,"gap":"6px","position":"after","border":{"width":"","style":"","color":""},"radius":"","color":{"text":"#0593ff","textHover":"#0593ff","bg":"","bgHover":"","borderHover":""},"animation":"enlarge"},"cozyHoverStyles":{"bgColor":"","color":"#0593ff","borderColor":""}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color wp-element-button" style="color:#fffffe;background-color:#ffffff00;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
<?php
	esc_html_e( 'View More', 'cozy-addons' );
?>
</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--70)"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:query {"queryId":1,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[],"excludeCurrent":null}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"default","columnCount":1}} -->
<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"480px","style":{"border":{"radius":{"topLeft":"34px","topRight":"34px","bottomLeft":"34px","bottomRight":"34px"}}}} /-->

<!-- wp:post-terms {"term":"category","className":"is-style-categories-background-with-round","style":{"elements":{"link":{"color":{"text":"#0593ff"}}},"spacing":{"margin":{"top":"34px"}},"color":{"text":"#0593ff"}},"cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"100px","primaryColor":{"text":"#0593ff","bg":"#0593ff1a","textHover":"#fffffe","bgHover":"#0593ff"},"secondaryColor":{"text":"currentColor","bg":"","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#fffffe"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"spacing":{"margin":{"top":"24px"}},"typography":{"fontSize":"44px","fontStyle":"normal","fontWeight":"600"},"color":{"text":"#fffffe"}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|40"}},"typography":{"fontSize":"16px"},"color":{"text":"#999ea7"},"elements":{"link":{"color":{"text":"#999ea7"}}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group has-text-color has-link-color" style="color:#999ea7;margin-top:var(--wp--preset--spacing--40);font-size:16px"><!-- wp:post-time-to-read {"displayAsRange":false} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results.","style":{"color":{"text":"#fffffe"},"elements":{"link":{"color":{"text":"#fffffe"}}}}} -->
<p class="has-text-color has-link-color" style="color:#fffffe">
<?php
	esc_html_e( 'Oops! Blogs Not Found.', 'cozy-addons' );
?>
</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:query {"queryId":15,"query":{"perPage":3,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[],"excludeCurrent":null}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"18px","bottom":"18px","left":"18px","right":"18px"},"margin":{"top":"0","bottom":"0"},"blockGap":{"top":"24px","left":"24px"}},"border":{"width":"1px","color":"#35393D","radius":{"topLeft":"24px","topRight":"24px","bottomLeft":"24px","bottomRight":"24px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center has-border-color" style="border-color:#35393D;border-width:1px;border-top-left-radius:24px;border-top-right-radius:24px;border-bottom-left-radius:24px;border-bottom-right-radius:24px;margin-top:0;margin-bottom:0;padding-top:18px;padding-right:18px;padding-bottom:18px;padding-left:18px"><!-- wp:column {"verticalAlignment":"center","width":"200px"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:200px"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"180px","style":{"border":{"radius":{"topLeft":"16px","topRight":"16px","bottomLeft":"16px","bottomRight":"16px"}}}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"typography":{"textTransform":"capitalize","fontSize":"12px"},"spacing":{"blockGap":"var:preset|spacing|30"},"color":{"text":"#999ea7"},"elements":{"link":{"color":{"text":"#999ea7"}}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group has-text-color has-link-color" style="color:#999ea7;font-size:12px;text-transform:capitalize"><!-- wp:post-author-name /-->

<!-- wp:post-time-to-read /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":4,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#fffffe"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"fontSize":"24px"},"color":{"text":"#fffffe"}},"cozyCustomFont":"Bricolage Grotesque"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p>
<?php
	esc_html_e( 'Oops! Blogs Not Found.', 'cozy-addons' );
?>
</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->