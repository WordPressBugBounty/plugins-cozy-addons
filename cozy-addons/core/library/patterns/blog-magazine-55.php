<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"40px","bottom":"40px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"color":{"background":"#0e0e10","text":"#ffffff"},"elements":{"link":{"color":{"text":"#ffffff"}}}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="color:#ffffff;background-color:#0e0e10;margin-top:0;margin-bottom:0;padding-top:40px;padding-right:26px;padding-bottom:40px;padding-left:26px"><!-- wp:group {"style":{"spacing":{"blockGap":"8px","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"#fffffe"}}},"typography":{"textTransform":"uppercase","fontSize":"24px"},"color":{"text":"#fffffe"}}} -->
<h2 class="wp-block-heading has-text-color has-link-color" style="color:#fffffe;font-size:24px;text-transform:uppercase">
<?php esc_html_e( 'Featured News', 'cozy-addons' ); ?> ───</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px"}},"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group has-light-color-color has-text-color has-link-color" style="margin-top:34px"><!-- wp:query {"queryId":151,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"0","left":"0"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"500px","className":"is-style-monocle-image-zoom-in"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:group {"style":{"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"typography":{"fontSize":"16px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px;font-size:16px"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","separator":"","className":"is-style-monocle-categories-alternate","style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}},"typography":{"textTransform":"uppercase","fontSize":"12px"}},"textColor":"light-color","cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#ffffff","bg":"#670eb4","textHover":"","bgHover":""},"secondaryColor":{"text":"#ffffff","bg":"#0eb467","textHover":"","bgHover":""},"gap":"4px","alternateColor":true}} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0"},"blockGap":"6px"},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}},"typography":{"textTransform":"capitalize","fontSize":"12px"}},"textColor":"foreground","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
<div class="wp-block-group has-foreground-color has-text-color has-link-color" style="margin-top:0;font-size:12px;text-transform:capitalize"><!-- wp:cozy-block/post-views {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0","bottom":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"clientId":"0b8f9e07-4591-4ab2-9d05-15489215f4df","postType":"post","contentGap":"4px","icon":{"size":"24px","position":"before","path":"M24.8489 7.69965C22.4952 3.1072 17.8355 0 12.5 0C7.16447 0 2.50345 3.10938 0.151018 7.70009C0.0517306 7.89649 0 8.11348 0 8.33355C0 8.55362 0.0517306 8.77061 0.151018 8.96701C2.50475 13.5595 7.16447 16.6667 12.5 16.6667C17.8355 16.6667 22.4965 13.5573 24.8489 8.96658C24.9482 8.77018 25 8.55319 25 8.33312C25 8.11304 24.9482 7.89605 24.8489 7.69965ZM12.5 14.5833C11.2638 14.5833 10.0555 14.2168 9.02766 13.53C7.99985 12.8433 7.19878 11.8671 6.72573 10.7251C6.25268 9.58307 6.12891 8.3264 6.37007 7.11402C6.61123 5.90164 7.20648 4.78799 8.08056 3.91392C8.95464 3.03984 10.0683 2.44458 11.2807 2.20343C12.493 1.96227 13.7497 2.08604 14.8917 2.55909C16.0338 3.03213 17.0099 3.83321 17.6967 4.86102C18.3834 5.88883 18.75 7.0972 18.75 8.33333C18.7504 9.15421 18.589 9.96711 18.275 10.7256C17.9611 11.484 17.5007 12.1732 16.9203 12.7536C16.3398 13.3341 15.6507 13.7944 14.8922 14.1084C14.1338 14.4223 13.3208 14.5837 12.5 14.5833ZM12.5 4.16667C12.1281 4.17186 11.7586 4.22719 11.4015 4.33116C11.6958 4.73119 11.8371 5.22347 11.7996 5.71873C11.7621 6.21398 11.5484 6.6794 11.1972 7.0306C10.846 7.38179 10.3806 7.5955 9.88537 7.63297C9.39012 7.67043 8.89784 7.52917 8.49781 7.23481C8.27001 8.07404 8.31113 8.96357 8.61538 9.77821C8.91962 10.5928 9.47167 11.2916 10.1938 11.776C10.916 12.2605 11.7719 12.5063 12.641 12.4788C13.5102 12.4514 14.3489 12.152 15.039 11.623C15.7291 11.0939 16.236 10.3617 16.4882 9.52951C16.7404 8.69729 16.7253 7.80693 16.445 6.98376C16.1647 6.16058 15.6333 5.44602 14.9256 4.94067C14.2179 4.43532 13.3696 4.16462 12.5 4.16667Z","view":"default","layout":"fill","viewBox":{"vx":0,"vy":0,"vw":25,"vh":17},"strokeWidth":1,"rotate":0,"opacity":100,"gap":"4px","color":"#670EB4"},"label":{"fontSize":"16px","fontFamily":"Inter","fontWeight":"400","letterCase":"none","decoration":"none","lineHeight":"","letterSpacing":"","color":""},"textColor":"light-color"} /-->

<!-- wp:cozy-block/post-comments {"style":{"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"clientId":"78f8a31c-4a54-407d-ae39-d469d574ecd6","postType":"post","icon":{"size":"24px","position":"before","path":"M12 2C6.486 2 2 5.589 2 10C2 12.908 3.898 15.516 7 16.934V22L12.34 17.995C17.697 17.852 22 14.32 22 10C22 5.589 17.514 2 12 2ZM12 16H11.667L9 18V15.583L8.359 15.336C5.67 14.301 4 12.256 4 10C4 6.691 7.589 4 12 4C16.411 4 20 6.691 20 10C20 13.309 16.411 16 12 16Z","view":"default","layout":"fill","viewBox":{"vx":"0","vy":"0","vw":"24","vh":"24"},"strokeWidth":1,"rotate":0,"opacity":100,"gap":"4px","color":"#670EB4","colorHover":"#0EB467"},"textColor":"light-color"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#fffffd"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"spacing":{"margin":{"top":"16px"}},"typography":{"fontSize":"24px"},"color":{"text":"#fffffd"}}} /-->

<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":34,"style":{"spacing":{"margin":{"top":"12px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"16px"},"blockGap":"6px"},"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}},"typography":{"textTransform":"capitalize","fontSize":"12px"}},"textColor":"light-color","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group has-light-color-color has-text-color has-link-color" style="margin-top:16px;font-size:12px;text-transform:capitalize"><!-- wp:group {"style":{"spacing":{"blockGap":"6px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:avatar {"size":24,"style":{"border":{"radius":{"topLeft":"100%","topRight":"100%","bottomLeft":"100%","bottomRight":"100%"}}}} /-->

<!-- wp:post-author-name {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|foreground","style":"solid","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}},"spacing":{"padding":{"right":"6px"}}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-date {"format":"human-diff","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"spacing":{"padding":{"right":"6px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|foreground","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} /-->

<!-- wp:post-time-to-read {"displayAsRange":false} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
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
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px"}},"elements":{"link":{"color":{"text":"#d6d6e6"}}},"color":{"text":"#d6d6e6"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group has-text-color has-link-color" style="color:#d6d6e6;margin-top:34px"><!-- wp:query {"queryId":161,"query":{"perPage":3,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"250px","className":"is-style-monocle-image-zoom-in"} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"typography":{"fontSize":"16px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;font-size:16px"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"8px"},"typography":{"fontSize":"12px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;font-size:12px"><!-- wp:post-terms {"term":"category","separator":"","className":"is-style-monocle-categories-alternate","style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}},"typography":{"textTransform":"uppercase","fontSize":"12px"}},"textColor":"light-color","cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#ffffff","bg":"#670eb4","textHover":"","bgHover":""},"secondaryColor":{"text":"#ffffff","bg":"#0eb467","textHover":"","bgHover":""},"gap":"4px","alternateColor":true}} /-->

<!-- wp:post-date {"datetime":"2026-07-06T06:48:04.669Z","style":{"color":{"text":"#d6d6e6"},"elements":{"link":{"color":{"text":"#d6d6e6"}}}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":4,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#ffffff"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"spacing":{"margin":{"top":"16px"}},"typography":{"fontSize":"18px"},"color":{"text":"#ffffff"}}} /-->

<!-- wp:post-excerpt {"excerptLength":10,"style":{"spacing":{"margin":{"top":"16px"}},"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}}},"textColor":"foreground-alt"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p>
<?php esc_html_e( 'Oops! Blogs Not Found', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->