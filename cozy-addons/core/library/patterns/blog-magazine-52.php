<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"48px","bottom":"48px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"}},"color":{"background":"#f6f6ff"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group has-background" style="background-color:#f6f6ff;margin-top:0;margin-bottom:0;padding-top:48px;padding-right:26px;padding-bottom:48px;padding-left:26px"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"spacing":{"blockGap":"8px","margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"24px","textTransform":"uppercase"}}} -->
<h2 class="wp-block-heading" style="margin-top:0;margin-bottom:0;font-size:24px;text-transform:uppercase">
<?php esc_html_e( 'Editor\'s Choice', 'cozy-addons' ); ?> ───</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"34px"}},"typography":{"fontSize":"16px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:34px;font-size:16px"><!-- wp:cozy-block/post-carousel {"blockClientId":"448cf72c-a066-413a-89e4-315583e08a35","hoverShow":false,"carouselOptions":{"pagination":{"enabled":false,"width":10,"height":10,"borderRadius":10,"activeWidth":10,"activeHeight":10,"activeBorder":{"width":"","style":"","color":""},"activeOffset":0,"gap":4,"activeBorderRadius":10,"activeColor":"#007cba","color":"#252525","activeColorHover":"#164861","colorHover":"#a5a5a5","align":"center","positionVertical":-20,"left":"0px","right":"0px"},"navigation":{"enabled":true,"iconSize":20,"iconBoxWidth":40,"iconBoxHeight":40,"border":{"width":"","style":"","color":""},"borderRadius":"4","backgroundColor":"#fff","color":"#670EB4","backgroundColorHover":"#670EB4","colorHover":"#fff","borderHover":""},"sliderOptions":{"autoplay":{"enabled":true,"pauseOnMouseEnter":true,"reverseDirection":false,"delay":2500},"loop":true,"centeredSlides":false,"slidesPerView":4,"spaceBetween":30,"speed":700,"slideAnimation":true}}} -->
<div class="cozy-block-post-carousel-wrapper  " id="cozyBlock_448cf72c_a066_413a_89e4_315583e08a35"><!-- wp:query {"queryId":1,"query":{"perPage":"6","postType":"post"},"lock":{"move":false,"remove":true},"className":"cozy-query swiper-container"} -->
<div class="wp-block-query cozy-query swiper-container"><!-- wp:post-template {"lock":{"move":false,"remove":true},"className":"cozy-layout-grid swiper-wrapper"} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"16px"}},"backgroundColor":"light-color","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group has-light-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:16px"><!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"250px","className":"is-style-monocle-image-zoom-in"} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"},"typography":{"fontSize":"16px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px;font-size:16px"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"8px"},"typography":{"fontSize":"12px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;font-size:12px"><!-- wp:post-terms {"term":"category","separator":"","className":"is-style-monocle-categories-tertiary","style":{"typography":{"textTransform":"uppercase","fontSize":"12px"},"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","cozyItemStyles":{"padding":{"top":"6px","right":"10px","bottom":"6px","left":"10px"},"border":{"width":"","style":"","color":""},"radius":"4px","primaryColor":{"text":"#ffffff","bg":"#670EB4","textHover":"","bgHover":""},"secondaryColor":{"text":"currentColor","bg":"#0EB467","textHover":"","bgHover":""},"gap":"4px","alternateColor":false}} /-->

<!-- wp:post-date {"format":"human-diff","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|heading-color"},":hover":{"color":{"text":"var:preset|color|primary"}}}},"spacing":{"margin":{"top":"16px"}},"typography":{"fontSize":"18px"}},"textColor":"heading-color"} /-->

<!-- wp:post-excerpt {"excerptLength":10,"style":{"spacing":{"margin":{"top":"16px"}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --><div class="swiper-button-prev cozy-block-button-prev"></div><div class="swiper-button-next cozy-block-button-next"></div></div>
<!-- /wp:cozy-block/post-carousel --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->