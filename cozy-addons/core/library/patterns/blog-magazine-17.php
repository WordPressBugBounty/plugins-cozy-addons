<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"12px","bottom":"12px","left":"26px","right":"26px"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:12px;padding-right:26px;padding-bottom:12px;padding-left:26px"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"24px","left":"24px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"10%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:10%"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"color":{"background":"#0052ff"},"typography":{"textAlign":"left"},"spacing":{"padding":{"top":"6px","bottom":"6px","left":"12px","right":"12px"}},"border":{"radius":{"topLeft":"4px","topRight":"4px","bottomLeft":"4px","bottomRight":"4px"}}},"textColor":"background","fontSize":"normal"} -->
<h3 class="wp-block-heading has-text-align-left has-background-color has-text-color has-background has-link-color has-normal-font-size" style="border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-left-radius:4px;border-bottom-right-radius:4px;background-color:#0052ff;padding-top:6px;padding-right:12px;padding-bottom:6px;padding-left:12px"><?php
    esc_html_e('Latest Post', 'cozy-addons');
?></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":""} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:cozy-block/post-slider {"blockClientId":"a4259708-030a-4e27-9126-0e14c1261737","carouselOptions":{"smoothTransition":true,"pagination":{"enabled":false,"width":10,"height":10,"borderRadius":10,"activeWidth":10,"activeHeight":10,"activeBorder":{"width":"","style":"","color":""},"activeOffset":0,"activeBorderRadius":10,"activeColor":"#007cba","color":"#252525","activeColorHover":"#164861","colorHover":"#a5a5a5","align":"center","positionVertical":5,"gap":4,"left":"0px","right":"0px"},"navigation":{"enabled":false,"iconSize":15,"iconBoxWidth":35,"iconBoxHeight":35,"border":{"width":"","style":"","color":""},"borderRadius":50,"backgroundColor":"#fff","color":"#007cba","backgroundColorHover":"#007cba","colorHover":"#fff","borderHover":""},"sliderOptions":{"loop":true,"autoplay":{"enabled":true,"pauseOnMouseEnter":true,"reverseDirection":false,"delay":0},"centeredSlides":false,"slidesPerView":3,"spaceBetween":30,"speed":4000}}} -->
<div class="cozy-block-post-slider-wrapper hover-show" id="cozyBlock_a4259708_030a_4e27_9126_0e14c1261737"><!-- wp:query {"queryId":1,"query":{"perPage":"6","postType":"post"},"lock":{"move":"false","remove":"true"},"className":"swiper-container"} -->
<div class="wp-block-query swiper-container"><!-- wp:post-template {"lock":{"move":"false","remove":"true"},"className":"cozy-block-post-slider__swiper-wrapper"} -->
<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:cozy-block/icon-picker {"blockClientId":"49980a53-708a-4d5a-8af9-5c72423a2c75","view":"stacked","iconSize":24,"iconViewBox":{"vx":"0","vy":"0","vw":"24","vh":"24"},"iconPath":"M12 0C18.627 0 24 5.373 24 12C24 18.627 18.627 24 12 24C5.373 24 0 18.627 0 12C0 5.373 5.373 0 12 0ZM12 1C5.925 1 1 5.925 1 12C1 18.075 5.925 23 12 23C18.075 23 23 18.075 23 12C23 5.925 18.075 1 12 1ZM14.123 7.385C14.209 7.385 14.291 7.42 14.352 7.482L18.319 11.525C18.41 11.618 18.462 11.744 18.462 11.875V12.125C18.46 12.256 18.409 12.381 18.319 12.475L14.352 16.518C14.291 16.58 14.209 16.615 14.123 16.615C14.037 16.615 13.954 16.58 13.894 16.518L13.435 16.05C13.374 15.989 13.34 15.905 13.34 15.818C13.34 15.732 13.374 15.649 13.435 15.588L16.31 12.659H5.861C5.683 12.659 5.538 12.512 5.538 12.33V11.67C5.538 11.488 5.683 11.341 5.861 11.341H16.31L13.435 8.412C13.373 8.35 13.339 8.266 13.339 8.178C13.339 8.09 13.373 8.005 13.435 7.943L13.894 7.482C13.954 7.42 14.037 7.385 14.123 7.385Z","iconColor":"#FFFFFF","boxStyles":{"padding":{"top":0,"right":0,"bottom":0,"left":0},"borderType":"none","borderWidth":1,"borderColor":"#000","borderColorHover":"","borderRadius":50,"bgColor":"#0052ff","bgColorHover":""}} -->
<div class="cozy-block-icon-picker stacked" id="cozyBlock_49980a53_708a_4d5a_8af9_5c72423a2c75"><svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="#FFFFFF"><path d="M12 0C18.627 0 24 5.373 24 12C24 18.627 18.627 24 12 24C5.373 24 0 18.627 0 12C0 5.373 5.373 0 12 0ZM12 1C5.925 1 1 5.925 1 12C1 18.075 5.925 23 12 23C18.075 23 23 18.075 23 12C23 5.925 18.075 1 12 1ZM14.123 7.385C14.209 7.385 14.291 7.42 14.352 7.482L18.319 11.525C18.41 11.618 18.462 11.744 18.462 11.875V12.125C18.46 12.256 18.409 12.381 18.319 12.475L14.352 16.518C14.291 16.58 14.209 16.615 14.123 16.615C14.037 16.615 13.954 16.58 13.894 16.518L13.435 16.05C13.374 15.989 13.34 15.905 13.34 15.818C13.34 15.732 13.374 15.649 13.435 15.588L16.31 12.659H5.861C5.683 12.659 5.538 12.512 5.538 12.33V11.67C5.538 11.488 5.683 11.341 5.861 11.341H16.31L13.435 8.412C13.373 8.35 13.339 8.266 13.339 8.178C13.339 8.09 13.373 8.005 13.435 7.943L13.894 7.482C13.954 7.42 14.037 7.385 14.123 7.385Z"></path></svg></div>
<!-- /wp:cozy-block/icon-picker -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"#0052ff"}}},"color":{"text":"#0052ff"}},"fontSize":"normal"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:cozy-block/post-slider --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->