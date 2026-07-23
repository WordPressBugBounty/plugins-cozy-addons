<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"40px","bottom":"40px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"}},"color":{"text":"#47474d","background":"#f6f6ff"},"elements":{"link":{"color":{"text":"#47474d"}}}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="color:#47474d;background-color:#f6f6ff;margin-top:0;margin-bottom:0;padding-top:40px;padding-right:26px;padding-bottom:40px;padding-left:26px"><!-- wp:group {"style":{"spacing":{"blockGap":"8px","margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"24px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;font-size:24px"><!-- wp:heading {"style":{"typography":{"textTransform":"uppercase","fontSize":"24px"}}} -->
<h2 class="wp-block-heading" style="font-size:24px;text-transform:uppercase">
<?php esc_html_e( 'Top Stories Of The Day', 'cozy-addons' ); ?> ───</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"margin":{"top":"34px"},"blockGap":{"top":"24px","left":"24px"}}}} -->
<div class="wp-block-columns" style="margin-top:34px"><!-- wp:column {"width":"50%","style":{"spacing":{"blockGap":"0","padding":{"right":"0","left":"0","top":"0","bottom":"0"}}}} -->
<div class="wp-block-column" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;flex-basis:50%"><!-- wp:query {"queryId":117,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"425px","className":"is-style-monocle-image-zoom-in"} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"typography":{"fontSize":"16px"}},"backgroundColor":"light-color","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group has-light-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px;font-size:16px"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","separator":"","className":"is-style-monocle-categories-secondary","style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}},"typography":{"textTransform":"uppercase","fontSize":"12px"}},"textColor":"light-color","cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#ffffff","bg":"#670eb4","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0"},"blockGap":"6px"},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}},"typography":{"textTransform":"capitalize","fontSize":"12px"}},"textColor":"foreground","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
<div class="wp-block-group has-foreground-color has-text-color has-link-color" style="margin-top:0;font-size:12px;text-transform:capitalize"><!-- wp:cozy-block/post-views {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"clientId":"9e88a285-1791-4546-9d8a-581a292bc506","postType":"post","contentGap":"4px","icon":{"size":"16px","position":"before","path":"M24.8489 7.69965C22.4952 3.1072 17.8355 0 12.5 0C7.16447 0 2.50345 3.10938 0.151018 7.70009C0.0517306 7.89649 0 8.11348 0 8.33355C0 8.55362 0.0517306 8.77061 0.151018 8.96701C2.50475 13.5595 7.16447 16.6667 12.5 16.6667C17.8355 16.6667 22.4965 13.5573 24.8489 8.96658C24.9482 8.77018 25 8.55319 25 8.33312C25 8.11304 24.9482 7.89605 24.8489 7.69965ZM12.5 14.5833C11.2638 14.5833 10.0555 14.2168 9.02766 13.53C7.99985 12.8433 7.19878 11.8671 6.72573 10.7251C6.25268 9.58307 6.12891 8.3264 6.37007 7.11402C6.61123 5.90164 7.20648 4.78799 8.08056 3.91392C8.95464 3.03984 10.0683 2.44458 11.2807 2.20343C12.493 1.96227 13.7497 2.08604 14.8917 2.55909C16.0338 3.03213 17.0099 3.83321 17.6967 4.86102C18.3834 5.88883 18.75 7.0972 18.75 8.33333C18.7504 9.15421 18.589 9.96711 18.275 10.7256C17.9611 11.484 17.5007 12.1732 16.9203 12.7536C16.3398 13.3341 15.6507 13.7944 14.8922 14.1084C14.1338 14.4223 13.3208 14.5837 12.5 14.5833ZM12.5 4.16667C12.1281 4.17186 11.7586 4.22719 11.4015 4.33116C11.6958 4.73119 11.8371 5.22347 11.7996 5.71873C11.7621 6.21398 11.5484 6.6794 11.1972 7.0306C10.846 7.38179 10.3806 7.5955 9.88537 7.63297C9.39012 7.67043 8.89784 7.52917 8.49781 7.23481C8.27001 8.07404 8.31113 8.96357 8.61538 9.77821C8.91962 10.5928 9.47167 11.2916 10.1938 11.776C10.916 12.2605 11.7719 12.5063 12.641 12.4788C13.5102 12.4514 14.3489 12.152 15.039 11.623C15.7291 11.0939 16.236 10.3617 16.4882 9.52951C16.7404 8.69729 16.7253 7.80693 16.445 6.98376C16.1647 6.16058 15.6333 5.44602 14.9256 4.94067C14.2179 4.43532 13.3696 4.16462 12.5 4.16667Z","view":"default","layout":"fill","viewBox":{"vx":0,"vy":0,"vw":25,"vh":17},"strokeWidth":1,"rotate":0,"opacity":100,"gap":"4px","color":"#670EB4"},"label":{"fontSize":"16px","fontFamily":"Inter","fontWeight":"400","letterCase":"none","decoration":"none","lineHeight":"","letterSpacing":"","color":""}} /-->

<!-- wp:cozy-block/post-comments {"clientId":"de2501f9-0239-4f6c-b922-2c1836d0f32e","postType":"post","icon":{"size":"16px","position":"before","path":"M18.0556 6.94444C18.0556 3.10764 14.0148 0 9.02778 0C4.0408 0 0 3.10764 0 6.94444C0 8.43316 0.611979 9.80469 1.64931 10.9375C1.06771 12.2483 0.108507 13.2899 0.0954861 13.3029C0 13.4028 -0.0260417 13.5503 0.0303819 13.6806C0.0868056 13.8108 0.208333 13.8889 0.347222 13.8889C1.93576 13.8889 3.25087 13.355 4.19705 12.8038C5.59462 13.4852 7.24826 13.8889 9.02778 13.8889C14.0148 13.8889 18.0556 10.7812 18.0556 6.94444ZM23.3507 16.4931C24.388 15.3646 25 13.9887 25 12.5C25 9.59635 22.678 7.10937 19.388 6.07205C19.4271 6.35851 19.4444 6.6493 19.4444 6.94444C19.4444 11.5408 14.77 15.2778 9.02778 15.2778C8.55903 15.2778 8.1033 15.2431 7.65191 15.1953C9.0191 17.691 12.2309 19.4444 15.9722 19.4444C17.7517 19.4444 19.4054 19.0451 20.8029 18.3594C21.7491 18.9106 23.0642 19.4444 24.6528 19.4444C24.7917 19.4444 24.9175 19.362 24.9696 19.2361C25.026 19.1102 25 18.9627 24.9045 18.8585C24.8915 18.8455 23.9323 17.8082 23.3507 16.4931Z","view":"default","layout":"fill","viewBox":{"vx":0,"vy":0,"vw":25,"vh":20},"strokeWidth":1,"rotate":0,"opacity":100,"gap":"4px","color":"#670EB4","colorHover":"#0EB467"}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#0e0e10"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"spacing":{"margin":{"top":"16px"}},"typography":{"fontSize":"24px"},"color":{"text":"#0e0e10"}}} /-->

<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":34,"style":{"spacing":{"margin":{"top":"12px"}}}} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"12px"},"blockGap":"6px"},"elements":{"link":{"color":{"text":"#47474d"}}},"typography":{"textTransform":"capitalize","fontSize":"12px"},"color":{"text":"#47474d"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group has-text-color has-link-color" style="color:#47474d;margin-top:12px;font-size:12px;text-transform:capitalize"><!-- wp:post-author-name {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|foreground","style":"solid","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}},"spacing":{"padding":{"right":"6px"}}}} /-->

<!-- wp:post-date {"format":"human-diff","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"spacing":{"padding":{"right":"6px"}},"border":{"top":{"width":"0px","style":"none"},"right":{"color":"var:preset|color|foreground","width":"1px"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}}} /-->

<!-- wp:post-time-to-read {"displayAsRange":false} /--></div>
<!-- /wp:group --></div>
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
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:query {"queryId":143,"query":{"perPage":3,"pages":0,"offset":"1","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"24px"}}} -->
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":{"top":"0","left":"0"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"light-color"} -->
<div class="wp-block-columns are-vertically-aligned-center has-light-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"verticalAlignment":"center","width":"250px"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:250px"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"225px","className":"is-style-monocle-image-zoom-out"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"8px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:post-terms {"term":"category","separator":"","className":"is-style-monocle-categories-secondary","style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}},"typography":{"textTransform":"uppercase","fontSize":"12px"}},"textColor":"light-color","cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#ffffff","bg":"#670eb4","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /-->

<!-- wp:post-date {"datetime":"2026-07-06T06:48:04.669Z"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#000000"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"spacing":{"margin":{"top":"12px"}},"typography":{"fontSize":"18px"},"color":{"text":"#000000"}}} /-->

<!-- wp:post-excerpt {"excerptLength":10,"style":{"spacing":{"margin":{"top":"12px"}},"typography":{"fontSize":"16px"}}} /--></div>
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
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->