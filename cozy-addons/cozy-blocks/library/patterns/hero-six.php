<?php
/**
 * Title: Hero Section with dark cover image
 * Description: This is a hero section.
 * Slug: cozy-block-patterns/hero-six
 * Categories: cozy-block-patterns, hero
 */

$images = array( CT_ASSETS_URL . 'images/hero_6.jpg' );
?>

<!-- wp:cover {"url":"<?php echo esc_url( $images[0] ); ?>","id":803,"dimRatio":50,"isUserOverlayColor":true,"metadata":{"name":"Hero"},"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0px","right":"0px"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-cover alignfull" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0px;padding-bottom:0;padding-left:0px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background wp-image-803" alt="" src="<?php echo esc_url( $images[0] ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"full","style":{"spacing":{"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}},"border":{"bottom":{"color":"#ffffff40","width":"1px"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group alignfull" style="border-bottom-color:#ffffff40;border-bottom-width:1px;margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"10px","bottom":"10px"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained","contentSize":"1180px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:navigation {"customTextColor":"#fffffe","customOverlayTextColor":"#090b10","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500","textDecoration":"none"}},"cozyHoverColor":{"menuText":"#fa9805","menuBg":"","submenuText":"","submenuBg":""}} -->
<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Home', 'cozy-addons' ); ?>","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"<?php esc_html_e( 'About Us', 'cozy-addons' ); ?>","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Services', 'cozy-addons' ); ?>","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Contact Us', 'cozy-addons' ); ?>","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:buttons {"style":{"typography":{"fontSize":"14px","textDecoration":"none","fontStyle":"normal","fontWeight":"500"}},"cozyCustomFont":"Public Sans"} -->
<div class="wp-block-buttons has-custom-font-size" style="font-size:14px;font-style:normal;font-weight:500;text-decoration:none"><!-- wp:button {"style":{"border":{"radius":"100px"},"color":{"text":"#090b10","background":"#fffffe"},"elements":{"link":{"color":{"text":"#090b10"}}}},"cozyHoverEffect":{"boxShadow":{"enabled":false,"color":"#000","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"boxShadowHover":{"enabled":false,"color":"#000","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"transformEnabled":true,"transform":{"translateX":0,"translateY":"-2","rotate":0,"scale":1}},"cozyHoverStyles":{"bgColor":"#f49805","color":"#fffffe","borderColor":""}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color wp-element-button" style="border-radius:100px;color:#090b10;background-color:#fffffe"><?php esc_html_e( 'Get in Touch', 'cozy-addons' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"140px","bottom":"140px","left":"10px","right":"10px"}}},"layout":{"type":"constrained","contentSize":"1180px"}} -->
<div class="wp-block-group" style="padding-top:140px;padding-right:10px;padding-bottom:140px;padding-left:10px"><!-- wp:group {"style":{"spacing":{"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"blockGap":"6px"}},"layout":{"type":"constrained","contentSize":"792px","justifyContent":"left"},"cozyCustomFont":"Inter"} -->
<div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:heading {"style":{"typography":{"lineHeight":"1.3","fontSize":"55px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"#fffffe"}}},"color":{"text":"#fffffe"}},"cozyCustomFont":"Inter","cozyAnimation":{"type":"flip-up","easingFunction":"ease-in","anchorPlacement":"top-bottom","duration":600}} -->
<h2 class="wp-block-heading has-text-color has-link-color" style="color:#fffffe;font-size:55px;font-style:normal;font-weight:600;line-height:1.3"><?php esc_html_e( 'Creative Effective Hero Section in just A Few Clicks', 'cozy-addons' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#fffffe"}}},"color":{"text":"#fffffe"}}} -->
<p class="has-text-color has-link-color" style="color:#fffffe"><?php esc_html_e( 'Frustrated by a slow website? We’ll help you tame those speed demons so you can keep visitors coming back for more!', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"typography":{"fontSize":"18px","textDecoration":"none","fontStyle":"normal","fontWeight":"500"},"spacing":{"blockGap":"12px","margin":{"top":"36px","bottom":"36px"}}}} -->
<div class="wp-block-buttons has-custom-font-size" style="margin-top:36px;margin-bottom:36px;font-size:18px;font-style:normal;font-weight:500;text-decoration:none"><!-- wp:button {"style":{"border":{"radius":"100px"},"color":{"background":"#01ae8f","text":"#fffffe"},"elements":{"link":{"color":{"text":"#fffffe"}}},"spacing":{"padding":{"left":"32px","right":"32px","top":"14px","bottom":"14px"}}},"cozyHoverEffect":{"boxShadow":{"enabled":false,"color":"#000","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"boxShadowHover":{"enabled":false,"color":"#ebaf4e","horizontal":-10,"vertical":10,"blur":10,"spread":0,"position":""},"transformEnabled":false,"transform":{"translateX":0,"translateY":0,"rotate":0,"scale":1}},"cozyHoverStyles":{"bgColor":"#f49805","color":"#fffffe","borderColor":""},"cozyAnimation":{"type":"none","easingFunction":"ease-in","anchorPlacement":"bottom-center","duration":600}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color wp-element-button" style="border-radius:100px;color:#fffffe;background-color:#01ae8f;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px"><?php esc_html_e( 'Try it for Free', 'cozy-addons' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"style":{"border":{"radius":"100px","color":"#fffffe","width":"1px"},"color":{"background":"#fffffe00","text":"#fffffe"},"elements":{"link":{"color":{"text":"#fffffe"}}},"spacing":{"padding":{"left":"32px","right":"32px","top":"14px","bottom":"14px"}}},"cozyHoverEffect":{"boxShadow":{"enabled":false,"color":"#000","horizontal":0,"vertical":0,"blur":10,"spread":0,"position":""},"boxShadowHover":{"enabled":false,"color":"#ebaf4e","horizontal":10,"vertical":10,"blur":5,"spread":0,"position":""},"transformEnabled":false,"transform":{"translateX":0,"translateY":0,"rotate":0,"scale":1}},"cozyHoverStyles":{"bgColor":"#f49805","color":"#fffffe","borderColor":"#f49805"},"cozyAnimation":{"type":"none","easingFunction":"ease-in","anchorPlacement":"bottom-center","duration":600}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-link-color has-border-color wp-element-button" style="border-color:#fffffe;border-width:1px;border-radius:100px;color:#fffffe;background-color:#fffffe00;padding-top:14px;padding-right:32px;padding-bottom:14px;padding-left:32px"><?php esc_html_e( 'Request Quote', 'cozy-addons' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->