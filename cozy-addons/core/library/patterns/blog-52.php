<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"color":{"background":"#f9f9f9","text":"#808080"},"elements":{"link":{"color":{"text":"#808080"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":1.6},"spacing":{"padding":{"right":"26px","left":"26px","top":"80px","bottom":"80px"}}},"layout":{"type":"constrained","contentSize":"1180px"},"cozyCustomFont":"Roboto Serif"} -->
<div class="wp-block-group has-text-color has-background has-link-color" style="color:#808080;background-color:#f9f9f9;padding-top:80px;padding-right:26px;padding-bottom:80px;padding-left:26px;font-size:16px;font-style:normal;font-weight:400;line-height:1.6"><!-- wp:heading {"style":{"color":{"text":"#23201e"},"elements":{"link":{"color":{"text":"#23201e"}}},"typography":{"fontSize":"28px","lineHeight":1.4,"fontStyle":"normal","fontWeight":"600"}}} -->
<h2 class="wp-block-heading has-text-color has-link-color" style="color:#23201e;font-size:28px;font-style:normal;font-weight:600;line-height:1.4"><?php esc_html_e( 'Most Read Post', 'cozy-addons' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:columns {"isStackedOnMobile":false,"style":{"spacing":{"margin":{"top":"8px","bottom":"36px"},"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"blockGap":{"top":"0","left":"0"}}}} -->
<div class="wp-block-columns is-not-stacked-on-mobile" style="margin-top:8px;margin-bottom:36px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"width":"50px","style":{"color":{"background":"#e91e00"}}} -->
<div class="wp-block-column has-background" style="background-color:#e91e00;flex-basis:50px"><!-- wp:spacer {"height":"3px"} -->
<div style="height:3px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"","style":{"color":{"background":"#24211f12"}}} -->
<div class="wp-block-column is-vertically-aligned-bottom has-background" style="background-color:#24211f12"><!-- wp:spacer {"height":"1px"} -->
<div style="height:1px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:query {"queryId":1,"query":{"perPage":4,"pages":0,"offset":"0","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"18px"}},"layout":{"type":"grid","columnCount":4}} -->
<!-- wp:post-featured-image {"isLink":true,"height":"150px"} /-->

<!-- wp:post-title {"textAlign":"left","level":3,"isLink":true,"linkTarget":"_blank","style":{"spacing":{"margin":{"top":"8px","bottom":"12px"}},"elements":{"link":{"color":{"text":"#23201e"},":hover":{"color":{"text":"#e91e00"}}}},"typography":{"fontSize":"16px","lineHeight":"1.5","fontStyle":"normal","fontWeight":"500"},"color":{"text":"#23201e"}},"cozyCustomFont":"Roboto Serif"} /-->

<!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}},"typography":{"textTransform":"capitalize"},"spacing":{"blockGap":"4px","padding":{"right":"0","left":"0"},"margin":{"top":"0px","bottom":"0"}}},"textColor":"light-color","fontSize":"x-small","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group has-light-color-color has-text-color has-link-color has-x-small-font-size" style="margin-top:0px;margin-bottom:0;padding-right:0;padding-left:0;text-transform:capitalize"><!-- wp:cozy-block/icon-picker {"blockClientId":"f262e21a-8f4f-4d06-a098-bdf845462551","iconSize":16,"iconViewBox":{"vx":"0","vy":"0","vw":"14","vh":"14"},"iconPath":"M9.1987 10.1335L10.132 9.20016L7.66536 6.7335V3.66683H6.33203V7.26683L9.1987 10.1335ZM6.9987 13.6668C6.07648 13.6668 5.20981 13.4918 4.3987 13.1418C3.58759 12.7918 2.88203 12.3168 2.28203 11.7168C1.68203 11.1168 1.20703 10.4113 0.857031 9.60016C0.507031 8.78905 0.332031 7.92239 0.332031 7.00016C0.332031 6.07794 0.507031 5.21127 0.857031 4.40016C1.20703 3.58905 1.68203 2.8835 2.28203 2.2835C2.88203 1.6835 3.58759 1.2085 4.3987 0.858496C5.20981 0.508496 6.07648 0.333496 6.9987 0.333496C7.92092 0.333496 8.78759 0.508496 9.5987 0.858496C10.4098 1.2085 11.1154 1.6835 11.7154 2.2835C12.3154 2.8835 12.7904 3.58905 13.1404 4.40016C13.4904 5.21127 13.6654 6.07794 13.6654 7.00016C13.6654 7.92239 13.4904 8.78905 13.1404 9.60016C12.7904 10.4113 12.3154 11.1168 11.7154 11.7168C11.1154 12.3168 10.4098 12.7918 9.5987 13.1418C8.78759 13.4918 7.92092 13.6668 6.9987 13.6668ZM6.9987 12.3335C8.47648 12.3335 9.73481 11.8141 10.7737 10.7752C11.8126 9.73627 12.332 8.47794 12.332 7.00016C12.332 5.52239 11.8126 4.26405 10.7737 3.22516C9.73481 2.18627 8.47648 1.66683 6.9987 1.66683C5.52092 1.66683 4.26259 2.18627 3.2237 3.22516C2.18481 4.26405 1.66536 5.52239 1.66536 7.00016C1.66536 8.47794 2.18481 9.73627 3.2237 10.7752C4.26259 11.8141 5.52092 12.3335 6.9987 12.3335Z","iconColor":"#808080"} -->
<div class="cozy-block-icon-picker default" id="cozyBlock_f262e21a_8f4f_4d06_a098_bdf845462551"><svg width="16" height="16" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="#808080"><path d="M9.1987 10.1335L10.132 9.20016L7.66536 6.7335V3.66683H6.33203V7.26683L9.1987 10.1335ZM6.9987 13.6668C6.07648 13.6668 5.20981 13.4918 4.3987 13.1418C3.58759 12.7918 2.88203 12.3168 2.28203 11.7168C1.68203 11.1168 1.20703 10.4113 0.857031 9.60016C0.507031 8.78905 0.332031 7.92239 0.332031 7.00016C0.332031 6.07794 0.507031 5.21127 0.857031 4.40016C1.20703 3.58905 1.68203 2.8835 2.28203 2.2835C2.88203 1.6835 3.58759 1.2085 4.3987 0.858496C5.20981 0.508496 6.07648 0.333496 6.9987 0.333496C7.92092 0.333496 8.78759 0.508496 9.5987 0.858496C10.4098 1.2085 11.1154 1.6835 11.7154 2.2835C12.3154 2.8835 12.7904 3.58905 13.1404 4.40016C13.4904 5.21127 13.6654 6.07794 13.6654 7.00016C13.6654 7.92239 13.4904 8.78905 13.1404 9.60016C12.7904 10.4113 12.3154 11.1168 11.7154 11.7168C11.1154 12.3168 10.4098 12.7918 9.5987 13.1418C8.78759 13.4918 7.92092 13.6668 6.9987 13.6668ZM6.9987 12.3335C8.47648 12.3335 9.73481 11.8141 10.7737 10.7752C11.8126 9.73627 12.332 8.47794 12.332 7.00016C12.332 5.52239 11.8126 4.26405 10.7737 3.22516C9.73481 2.18627 8.47648 1.66683 6.9987 1.66683C5.52092 1.66683 4.26259 2.18627 3.2237 3.22516C2.18481 4.26405 1.66536 5.52239 1.66536 7.00016C1.66536 8.47794 2.18481 9.73627 3.2237 10.7752C4.26259 11.8141 5.52092 12.3335 6.9987 12.3335Z"></path></svg></div>
<!-- /wp:cozy-block/icon-picker -->

<!-- wp:post-date {"datetime":"2026-06-24T09:16:39.571Z","style":{"typography":{"fontSize":"13px"}}} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p><?php esc_html_e( 'Oops! Blogs Not Found', 'cozy-addons' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->