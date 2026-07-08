<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"12px","bottom":"12px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:12px;padding-right:26px;padding-bottom:12px;padding-left:26px"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"24px","left":"24px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"15%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:15%"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"textAlign":"left"},"spacing":{"padding":{"top":"6px","bottom":"6px","left":"12px","right":"12px"}},"border":{"radius":{"topLeft":"100px","topRight":"100px","bottomLeft":"100px","bottomRight":"100px"}}},"backgroundColor":"dark-color","textColor":"background","fontSize":"normal"} -->
<h3 class="wp-block-heading has-text-align-left has-background-color has-dark-color-background-color has-text-color has-background has-link-color has-normal-font-size" style="border-top-left-radius:100px;border-top-right-radius:100px;border-bottom-left-radius:100px;border-bottom-right-radius:100px;padding-top:6px;padding-right:12px;padding-bottom:6px;padding-left:12px"><?php
	esc_html_e( 'Highlight News', 'cozy-addons' );
?></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":""} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:cozy-block/post-slider {"blockClientId":"818bc1f3-da1c-4946-9f6a-adfa3f351bbf","carouselOptions":{"smoothTransition":true,"pagination":{"enabled":false,"width":10,"height":10,"borderRadius":10,"activeWidth":10,"activeHeight":10,"activeBorder":{"width":"","style":"","color":""},"activeOffset":0,"activeBorderRadius":10,"activeColor":"#007cba","color":"#252525","activeColorHover":"#164861","colorHover":"#a5a5a5","align":"center","positionVertical":5,"gap":4,"left":"0px","right":"0px"},"navigation":{"enabled":false,"iconSize":15,"iconBoxWidth":35,"iconBoxHeight":35,"border":{"width":"","style":"","color":""},"borderRadius":50,"backgroundColor":"#fff","color":"#007cba","backgroundColorHover":"#007cba","colorHover":"#fff","borderHover":""},"sliderOptions":{"loop":true,"autoplay":{"enabled":true,"pauseOnMouseEnter":true,"reverseDirection":false,"delay":0},"centeredSlides":false,"slidesPerView":3,"spaceBetween":30,"speed":4000}}} -->
<div class="cozy-block-post-slider-wrapper hover-show" id="cozyBlock_818bc1f3_da1c_4946_9f6a_adfa3f351bbf"><!-- wp:query {"queryId":1,"query":{"perPage":"6","postType":"post"},"lock":{"move":"false","remove":"true"},"className":"swiper-container"} -->
<div class="wp-block-query swiper-container"><!-- wp:post-template {"lock":{"move":"false","remove":"true"},"className":"cozy-block-post-slider__swiper-wrapper"} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","width":"25px","height":"25px","style":{"border":{"radius":{"topLeft":"100px","topRight":"100px","bottomLeft":"100px","bottomRight":"100px"}}}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#0052ff"}}},"color":{"text":"#0052ff"}},"fontSize":"normal"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:cozy-block/post-slider --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->