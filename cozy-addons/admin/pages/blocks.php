<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div style="display:flex;justify-content:space-between;align-items:center">
	<h2><?php esc_html_e( 'Control Settings for Blocks', 'cozy-addons' ); ?></h2>
	<div style="font-size:14px;font-weight:500;cursor:pointer;color:#fff">
		<span style="padding:12px 26px;border-radius:4px;background-color:#5566ca;" id="cozy-blocks-enable-super"><?php esc_html_e( 'Enable All', 'cozy-addons' ); ?></span>
		<span style="margin:0 4px;"></span>
		<span style="padding:12px 26px;border-radius:4px;background-color:#d63638;" id="cozy-blocks-disable-super"><?php esc_html_e( 'Disable All', 'cozy-addons' ); ?></span>
	</div>
</div>
<p><?php esc_html_e( 'Enable or Disable Block as Your Needs and Requirement.', 'cozy-addons' ); ?></p>

<ul class="blocks-holder">
	<li>
		<a href="https://cozyblock.cozythemes.com/accordion-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M41.4629 5.51172C46.2183 5.75264 50 9.68468 50 14.5C50 19.3153 46.2183 23.2474 41.4629 23.4883L41 23.5H9C4.02944 23.5 0 19.4706 0 14.5C0 9.52944 4.02944 5.5 9 5.5H41L41.4629 5.51172ZM9 7.5C5.13401 7.5 2 10.634 2 14.5C2 18.366 5.13401 21.5 9 21.5H41C44.866 21.5 48 18.366 48 14.5C48 10.7549 45.0589 7.69633 41.3604 7.50879L41 7.5H9ZM42.293 12.793C42.6835 12.4024 43.3165 12.4024 43.707 12.793C44.0976 13.1835 44.0976 13.8165 43.707 14.207L41.1211 16.793C39.9496 17.9643 38.0504 17.9643 36.8789 16.793L34.293 14.207C33.9024 13.8165 33.9024 13.1835 34.293 12.793C34.6835 12.4024 35.3165 12.4024 35.707 12.793L38.293 15.3789C38.6835 15.7692 39.3165 15.7692 39.707 15.3789L42.293 12.793Z" fill="#0c50ff"/>
					<path d="M41.4629 26.5117C46.2183 26.7526 50 30.6847 50 35.5C50 40.3153 46.2183 44.2474 41.4629 44.4883L41 44.5H9C4.02944 44.5 0 40.4706 0 35.5C0 30.5294 4.02944 26.5 9 26.5H41L41.4629 26.5117ZM9 28.5C5.13401 28.5 2 31.634 2 35.5C2 39.366 5.13401 42.5 9 42.5H41C44.866 42.5 48 39.366 48 35.5C48 31.7549 45.0589 28.6963 41.3604 28.5088L41 28.5H9ZM42.293 33.793C42.6835 33.4024 43.3165 33.4024 43.707 33.793C44.0976 34.1835 44.0976 34.8165 43.707 35.207L41.1211 37.793C39.9496 38.9643 38.0504 38.9643 36.8789 37.793L34.293 35.207C33.9024 34.8165 33.9024 34.1835 34.293 33.793C34.6835 33.4024 35.3165 33.4024 35.707 33.793L38.293 36.3789C38.6835 36.7692 39.3165 36.7692 39.707 36.3789L42.293 33.793Z" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Accordion', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--accordion' );
				?>
				<input type="checkbox" class="cozy-block-active" name="accordion" id="cozy-block--accordion" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/advanced-gallery-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M37 1C43.6274 1 49 6.37258 49 13V37C49 43.6274 43.6274 49 37 49H13C6.37258 49 1 43.6274 1 37V13C1 6.37258 6.37258 1 13 1H37ZM13 3C7.47715 3 3 7.47715 3 13V37C3 42.5228 7.47715 47 13 47H37C42.5228 47 47 42.5228 47 37V13C47 7.47715 42.5228 3 37 3H13Z" fill="#0c50ff"/>
					<rect x="19.5" y="16.5" width="15" height="15" stroke="#0c50ff"/>
					<path d="M15.75 35.25H31V36H15V20H15.75V35.25Z" fill="#0c50ff"/>
					<path d="M21 30L27 24L33 30" stroke="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Advanced Gallery', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--advanced-gallery' );
				?>
				<input type="checkbox" class="cozy-block-active" name="advanced-gallery" id="cozy-block--advanced-gallery" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/mega-menu-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<rect x="7" y="13.5" width="34" height="8" rx="4" stroke="#0c50ff"/>
					<path d="M34 17L35.2929 18.2929C35.6834 18.6834 36.3166 18.6834 36.7071 18.2929L38 17" stroke="#0c50ff" stroke-linecap="round"/>
					<line x1="10.5" y1="17.5" x2="17.5" y2="17.5" stroke="#A0C1FF" stroke-linecap="round"/>
					<path d="M15 21.5V36.5C15 36.7761 15.2239 37 15.5 37H38.5081C38.7811 37 39.0036 36.7811 39.0081 36.5082L39.25 21.75" stroke="#0c50ff" stroke-linecap="round"/>
					<circle cx="22.25" cy="29.25" r="4.75" fill="#A0C1FF"/>
					<line x1="28.5" y1="25.25" x2="35.5" y2="25.25" stroke="#A0C1FF" stroke-linecap="round"/>
					<line x1="28.5" y1="28.75" x2="35.5" y2="28.75" stroke="#A0C1FF" stroke-linecap="round"/>
					<line x1="28.5" y1="32.25" x2="35.5" y2="32.25" stroke="#A0C1FF" stroke-linecap="round"/>
				</svg>

				<?php esc_html_e( 'Advanced Mega Menu', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--mega-menu' );
				?>
				<input type="checkbox" class="cozy-block-active" name="mega-menu" id="cozy-block--mega-menu" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/advanced-tabs-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M28.8887 2.62073C30.6326 2.30365 32.367 3.22078 33.0869 4.84045L34.1016 7.12268C34.1061 7.13283 34.1091 7.14372 34.1133 7.15393H44.041C47.3547 7.15393 50.041 9.84023 50.041 13.1539V41.442C50.0408 44.7555 47.3546 47.442 44.041 47.442H6C2.68653 47.4419 0.000257081 44.7555 0 41.442V9.16565C0 5.852 2.68637 3.16574 6 3.16565H10.5791C12.325 3.16574 13.9219 4.15112 14.7051 5.71155C15.149 6.5956 16.0537 7.15385 17.043 7.15393H17.1631C16.7434 5.06929 18.1108 3.00834 20.2422 2.62073C21.9861 2.30372 23.7205 3.22078 24.4404 4.84045L25.4551 7.12268C25.4596 7.13285 25.4626 7.1437 25.4668 7.15393H25.8096C25.3899 5.06931 26.7573 3.00835 28.8887 2.62073ZM2 41.442C2.00026 43.6509 3.7911 45.4419 6 45.442H44.041C46.25 45.442 48.0408 43.6509 48.041 41.442V16.6959H2V41.442ZM6 5.16565C3.79094 5.16574 2 6.95657 2 9.16565V14.6959H48.041V13.1539C48.041 10.9448 46.2501 9.15393 44.041 9.15393H17.043C15.2971 9.15385 13.7002 8.1684 12.917 6.60803C12.4731 5.72389 11.5684 5.16574 10.5791 5.16565H6ZM31.2598 5.65295C30.9145 4.87641 30.0822 4.43648 29.2461 4.5885C28.175 4.78355 27.5057 5.85998 27.8047 6.90686L27.875 7.15393H31.9268L31.2598 5.65295ZM22.6133 5.65295C22.2681 4.87641 21.4357 4.43654 20.5996 4.5885C19.5285 4.78354 18.8592 5.85996 19.1582 6.90686L19.2285 7.15393H23.2803L22.6133 5.65295Z" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Advanced Tabs', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--advanced-tab' );
				?>
				<input type="checkbox" class="cozy-block-active" name="advanced-tab" id="cozy-block--advanced-tab" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/back-to-top-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 47 46" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="1" width="45" height="44" rx="22" stroke="#0c50ff" stroke-width="2"/>
					<path d="M16 27L22.5858 20.4142C23.3668 19.6332 24.6332 19.6332 25.4142 20.4142L32 27" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
				</svg>

				<?php esc_html_e( 'Back to Top', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--back-to-top' );
				?>
				<input type="checkbox" class="cozy-block-active" name="back-to-top" id="cozy-block--back-to-top" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/related-post-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12ZM15.293 17.293C15.6835 16.9024 16.3165 16.9024 16.707 17.293L24.4141 25L16.707 32.707C16.3165 33.0976 15.6835 33.0976 15.293 32.707C14.9024 32.3165 14.9024 31.6835 15.293 31.293L21.5859 25L15.293 18.707C14.9024 18.3165 14.9024 17.6835 15.293 17.293ZM24.293 17.293C24.6835 16.9024 25.3165 16.9024 25.707 17.293L33.4141 25L25.707 32.707C25.3165 33.0976 24.6835 33.0976 24.293 32.707C23.9024 32.3165 23.9024 31.6835 24.293 31.293L30.5859 25L24.293 18.707C23.9024 18.3165 23.9024 17.6835 24.293 17.293Z" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Breadcrumbs', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--breadcrumb' );
				?>
				<input type="checkbox" class="cozy-block-active" name="breadcrumb" id="cozy-block--breadcrumb" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M39.5664 7.74902C45.3783 8.04382 50 12.8492 50 18.7344C50 24.8095 45.0751 29.7344 39 29.7344H31V27.7344H39C43.9706 27.7344 48 23.7049 48 18.7344C48 13.7638 43.9706 9.73438 39 9.73438H11C6.02944 9.73438 2 13.7638 2 18.7344C2 23.7049 6.02944 27.7344 11 27.7344H19V29.7344H11C4.92487 29.7344 0 24.8095 0 18.7344C0 12.8492 4.6217 8.04382 10.4336 7.74902L11 7.73438H39L39.5664 7.74902Z" fill="#2874FF"/>
				<rect x="20.5" y="17.4844" width="9" height="4" rx="2" fill="#2874FF"/>
				<path d="M24 28.9844C25.2426 28.9844 26.25 29.9917 26.25 31.2344V35.0898L28.7227 35.4717C31.0396 35.8284 32.75 37.8217 32.75 40.166V41.7344H31.25V40.166C31.25 38.5619 30.0796 37.198 28.4941 36.9541L25.7812 36.5361C25.1881 36.4446 24.75 35.9342 24.75 35.334V31.2344C24.75 30.8202 24.4142 30.4844 24 30.4844C23.5859 30.4845 23.25 30.8202 23.25 31.2344V39.4482C23.2497 40.3872 22.188 40.9335 21.4238 40.3877L19.6191 39.0986C19.3085 38.877 18.8832 38.9119 18.6133 39.1816C18.3083 39.4867 18.3083 39.9821 18.6133 40.2871L19.5303 41.2041L18.4697 42.2646L17.5527 41.3477C16.662 40.4568 16.662 39.012 17.5527 38.1211C18.3412 37.3329 19.5839 37.2301 20.4912 37.8779L21.75 38.7764V31.2344C21.75 29.9918 22.7574 28.9845 24 28.9844ZM24.3643 25.7402C25.29 25.6979 26.2114 25.8898 27.043 26.2988C27.8748 26.708 28.5905 27.3216 29.1221 28.0811C29.6534 28.8404 29.9844 29.7221 30.084 30.6436C30.1538 31.2901 30.1079 31.9417 29.9512 32.5684C29.8404 33.0111 29.35 33.2098 28.9287 33.0342C28.5075 32.8584 28.3177 32.3738 28.3994 31.9248C28.4655 31.5623 28.4793 31.1904 28.4395 30.8213C28.3698 30.1767 28.1383 29.5595 27.7666 29.0283C27.3949 28.4973 26.8951 28.0683 26.3135 27.7822C25.7318 27.4961 25.087 27.3619 24.4395 27.3916C23.792 27.4213 23.1624 27.6141 22.6094 27.9521C22.0562 28.2903 21.597 28.7632 21.2754 29.3262C20.9538 29.8891 20.7799 30.5247 20.7695 31.1729C20.7636 31.544 20.8112 31.9127 20.9102 32.2676C21.0328 32.7074 20.8889 33.2073 20.4854 33.4209C20.0818 33.6344 19.5746 33.4817 19.4238 33.0508C19.2105 32.441 19.1058 31.7958 19.1162 31.1455C19.1312 30.2187 19.3801 29.3107 19.8398 28.5059C20.2997 27.7009 20.9562 27.0256 21.7471 26.542C22.5379 26.0585 23.4383 25.7827 24.3643 25.7402Z" fill="#2874FF"/>
			</svg>

			<?php esc_html_e( 'Cozy Button', 'cozy-addons' ); ?>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--button' );
				?>
				<input type="checkbox" class="cozy-block-active" name="button" id="cozy-block--button" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/contact-form-styler-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M38.3096 3.00391C44.7939 3.16811 50 8.47608 50 15V25H48V15C48 9.64975 43.7983 5.28054 38.5146 5.0127L38 5H12C6.47715 5 2 9.47715 2 15V35C2 40.5228 6.47715 45 12 45H31V47H12C5.47608 47 0.168106 41.7939 0.00390625 35.3096L0 35V15C0 8.47608 5.20608 3.16811 11.6904 3.00391L12 3H38L38.3096 3.00391Z" fill="#2874FF"/>
					<path d="M14 17L20.8946 22.3219C22.9559 23.913 25.8082 23.9929 27.9554 22.5197L36 17" stroke="#2874FF" stroke-width="2" stroke-linecap="round"/>
					<path d="M44.7273 32.8788L48.4606 36.7576M48.4606 36.7576L49.9468 35.3324C51.0931 34.2333 51.1652 32.4245 50.1102 31.2376C49.016 30.0067 47.1266 29.9081 45.9104 31.0186L37.0444 39.1136C36.9959 39.1579 36.9633 39.2168 36.9516 39.2813L36.0775 44.0747C36.04 44.2806 36.2195 44.4607 36.4255 44.4238L41.2446 43.5613C41.3025 43.551 41.356 43.5238 41.3986 43.4833L48.4606 36.7576Z" stroke="#2874FF" stroke-width="1.5"/>
				</svg>

				<p>
					<?php esc_html_e( 'Contact Form 7 Styler', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--cf7-styler' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="cf7-styler" id="cozy-block--cf7-styler" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/cozy-container-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12ZM23.5 18C24.0523 18 24.5 18.4477 24.5 19V24H30C30.5523 24 31 24.4477 31 25C31 25.5523 30.5523 26 30 26H24.5V31C24.5 31.5523 24.0523 32 23.5 32C22.9477 32 22.5 31.5523 22.5 31V26H18C17.4477 26 17 25.5523 17 25C17 24.4477 17.4477 24 18 24H22.5V19C22.5 18.4477 22.9477 18 23.5 18Z" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Cozy Container', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--container' );
				?>
				<input type="checkbox" class="cozy-block-active" name="container" id="cozy-block--container" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/countdown-timer-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 40 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M20 5C31.0457 5 40 13.9543 40 25C40 36.0457 31.0457 45 20 45C8.9543 45 0 36.0457 0 25C0 13.9543 8.9543 5 20 5ZM20 7C10.0589 7 2 15.0589 2 25C2 34.9411 10.0589 43 20 43C29.9411 43 38 34.9411 38 25C38 15.0589 29.9411 7 20 7ZM20 15.7637C20.5523 15.7637 21 16.2114 21 16.7637V25.4062C21.0001 26.4498 21.5429 27.4185 22.4326 27.9639L29.6406 32.3818C30.111 32.6705 30.259 33.2861 29.9707 33.7568C29.6821 34.2275 29.0655 34.3754 28.5947 34.0869L21.3867 29.6689C19.904 28.76 19.0001 27.1454 19 25.4062V16.7637C19 16.2114 19.4477 15.7637 20 15.7637Z" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Countdown Timer', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--countdown-timer' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="countdown-timer" id="cozy-block--countdown-timer" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/counter-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12ZM31.0107 20.6787C31.69 20.6787 32.2799 20.8064 32.7803 21.0615C33.2841 21.3134 33.6741 21.6535 33.9492 22.0811C34.2242 22.5086 34.3613 22.9811 34.3613 23.498C34.3646 24.0713 34.1958 24.5517 33.8545 24.9395C33.5165 25.3271 33.0724 25.5808 32.5225 25.7002V25.7803C33.2381 25.8798 33.7869 26.1444 34.168 26.5752C34.5523 27.0027 34.7425 27.5347 34.7393 28.1709C34.7393 28.7409 34.5767 29.2514 34.252 29.7021C33.9305 30.1496 33.4867 30.5016 32.9199 30.7568C32.3565 31.012 31.7096 31.1396 30.9805 31.1396C30.2647 31.1396 29.628 31.0167 29.0713 30.7715C28.5179 30.5262 28.0802 30.1845 27.7588 29.7471C27.4374 29.3096 27.267 28.8037 27.2471 28.2305H29.1162C29.1328 28.5056 29.2239 28.7467 29.3896 28.9521C29.5553 29.1542 29.7759 29.3112 30.0508 29.4238C30.3258 29.5365 30.6343 29.5927 30.9756 29.5928C31.3401 29.5928 31.6636 29.5302 31.9453 29.4043C32.227 29.275 32.4474 29.0959 32.6064 28.8672C32.7655 28.6386 32.8431 28.3753 32.8398 28.0771C32.8432 27.769 32.7639 27.497 32.6016 27.2617C32.4392 27.0264 32.2037 26.8425 31.8955 26.71C31.5906 26.5774 31.2228 26.5108 30.792 26.5107H29.8916V25.0889H30.792C31.1466 25.0889 31.4566 25.0279 31.7217 24.9053C31.9901 24.7827 32.2001 24.6097 32.3525 24.3877C32.505 24.1624 32.5804 23.9023 32.5771 23.6074C32.5805 23.3191 32.5154 23.0686 32.3828 22.8564C32.2536 22.6411 32.0696 22.4738 31.8311 22.3545C31.5958 22.2352 31.319 22.1758 31.001 22.1758C30.6894 22.1758 30.4009 22.232 30.1357 22.3447C29.8706 22.4574 29.6565 22.6183 29.4941 22.8271C29.3319 23.0326 29.2453 23.2776 29.2354 23.5625H27.4609C27.4742 22.9926 27.6384 22.4923 27.9531 22.0615C28.2713 21.6274 28.6954 21.2888 29.2256 21.0469C29.7559 20.8016 30.3512 20.6787 31.0107 20.6787ZM16.0459 31H14.2021V22.6133H14.1416L11.7607 24.1338V22.4443L14.291 20.8184H16.0459V31ZM22.0225 20.6787C22.7048 20.6788 23.3045 20.8065 23.8213 21.0615C24.3381 21.3166 24.7394 21.6665 25.0244 22.1104C25.3127 22.5544 25.457 23.0619 25.457 23.6318C25.457 24.013 25.3841 24.388 25.2383 24.7559C25.0924 25.1237 24.8356 25.5312 24.4678 25.9785C24.1032 26.426 23.5912 26.9681 22.9316 27.6045L21.1768 29.3896V29.459H25.6113V31H18.6318V29.668L22.166 26.2021C22.5041 25.8608 22.7864 25.5581 23.0117 25.293C23.237 25.0279 23.4059 24.7709 23.5186 24.5225C23.6312 24.2739 23.6875 24.0083 23.6875 23.7266C23.6875 23.4051 23.6146 23.13 23.4688 22.9014C23.3229 22.6694 23.1224 22.4902 22.8672 22.3643C22.612 22.2383 22.3219 22.1758 21.9971 22.1758C21.6624 22.1758 21.369 22.2447 21.1172 22.3838C20.8653 22.5197 20.6695 22.7139 20.5303 22.9658C20.3944 23.2177 20.3271 23.5182 20.3271 23.8662H18.5713C18.5713 23.2199 18.7197 22.6579 19.0146 22.1807C19.3096 21.7034 19.7154 21.3331 20.2324 21.0713C20.7527 20.8096 21.3498 20.6787 22.0225 20.6787Z" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Counter', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--counter' );
				?>
				<input type="checkbox" class="cozy-block-active" name="counter" id="cozy-block--counter" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/call-to-action-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="12" y="26" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="22" y="26" width="14" height="2" rx="1" fill="#94AAE0"/>
					<rect x="9" y="22" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="19" y="22" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="29" y="22" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="19.5" y="31" width="9" height="3" rx="1.5" fill="#0c50ff"/>
					<rect x="22.5" y="16" width="3" height="3" rx="1.5" fill="#0c50ff"/>
					<rect x="1" y="2" width="46" height="46" rx="11" stroke="#0c50ff" stroke-width="2"/>
				</svg>

				<?php esc_html_e( 'Call to Action(CTA)', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--cta' );
				?>
				<input type="checkbox" class="cozy-block-active" name="cta" id="cozy-block--cta" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/date-and-time-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M42.7812 33C47.4757 33 51.2812 36.8056 51.2812 41.5C51.2812 46.1944 47.4757 50 42.7812 50C38.0868 50 34.2812 46.1944 34.2812 41.5C34.2812 36.8056 38.0868 33 42.7812 33ZM37.7812 0C38.3335 0 38.7812 0.447715 38.7812 1V2.83789C45.0445 3.2404 50 8.44756 50 14.8125V33.293C49.3818 32.8153 48.7127 32.4005 48 32.0615V14.8125C48 9.55262 43.9389 5.24338 38.7812 4.84473V6C38.7812 6.55228 38.3335 7 37.7812 7C37.229 7 36.7812 6.55228 36.7812 6V4.8125H12C11.9269 4.8125 11.854 4.81582 11.7812 4.81738V6C11.7812 6.55228 11.3335 7 10.7812 7C10.229 7 9.78125 6.55228 9.78125 6V5.06152C5.32642 6.07091 2 10.0523 2 14.8125V36.8125C2 42.3353 6.47715 46.8125 12 46.8125H33.3887C33.7366 47.5263 34.1608 48.1954 34.6484 48.8125H12C5.37258 48.8125 0 43.4399 0 36.8125V14.8125C0 8.94329 4.21403 4.06046 9.78125 3.01953V1C9.78125 0.447715 10.229 0 10.7812 0C11.3335 0 11.7812 0.447715 11.7812 1V2.81445L12 2.8125H36.7812V1C36.7812 0.447715 37.229 0 37.7812 0ZM42.7812 35C39.1914 35 36.2812 37.9101 36.2812 41.5C36.2812 45.0899 39.1914 48 42.7812 48C46.3711 48 49.2812 45.0899 49.2812 41.5C49.2812 37.9101 46.3711 35 42.7812 35ZM41.2812 38.5C41.5574 38.5 41.7812 38.7239 41.7812 39V43H44.7812C45.0574 43 45.2812 43.2239 45.2812 43.5C45.2812 43.7761 45.0574 44 44.7812 44H40.7812V39C40.7812 38.7239 41.0051 38.5 41.2812 38.5Z" fill="#0c50ff"/>
					<rect width="5" height="5" rx="2.5" transform="matrix(-1 0 0 1 14.0312 24.5)" fill="#0c50ff"/>
					<rect width="5" height="5" rx="2.5" transform="matrix(-1 0 0 1 21.1406 24.5)" fill="#7EA2FF"/>
					<rect width="5" height="5" rx="2.5" transform="matrix(-1 0 0 1 14.0312 31.5)" fill="#B9C7EB"/>
					<rect width="5" height="5" rx="2.5" transform="matrix(-1 0 0 1 21.1406 31.5)" fill="#E6EDFF"/>
				</svg>

				<?php esc_html_e( 'Date & Time', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--current-time' );
				?>
				<input type="checkbox" class="cozy-block-active" name="current-time" id="cozy-block--current-time" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/featured-content-box-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<path d="M33.4474 12.9985H15.5526C12.7621 12.9985 10.5 15.2607 10.5 18.0512V20.9985C10.5 23.789 12.7621 26.0512 15.5526 26.0512H33.4474C36.2379 26.0512 38.5 23.789 38.5 20.9985V18.0512C38.5 15.2607 36.2379 12.9985 33.4474 12.9985Z" fill="#0c50ff"/>
					<rect x="15.1328" y="28.3657" width="16.8421" height="1.26316" fill="#A0B3D5"/>
					<rect x="12.1875" y="30.8906" width="24" height="1.26316" fill="#A0B3D5"/>
					<rect x="18.9219" y="34.2583" width="10.9474" height="3.36842" rx="1.68421" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Featured Content Box', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--featured-content-box' );
				?>
				<input type="checkbox" class="cozy-block-active" name="featured-content-box" id="cozy-block--featured-content-box" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/icon-list-gutenberg-block/" target="_blank" rel="noopener">

			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12ZM15.8613 28.5254C17.1592 28.5254 18.2119 29.5772 18.2119 30.875C18.2118 32.1728 17.1591 33.2246 15.8613 33.2246C14.5637 33.2244 13.5118 32.1727 13.5117 30.875C13.5117 29.5773 14.5636 28.5256 15.8613 28.5254ZM17.1191 29.9473C17.0599 29.8881 16.9635 29.8881 16.9043 29.9473L15.4824 31.3691L14.8184 30.7051C14.7591 30.646 14.6637 30.6459 14.6045 30.7051L14.3896 30.9189C14.3305 30.9781 14.3305 31.0746 14.3896 31.1338L15.375 32.1191C15.4342 32.1784 15.5306 32.1783 15.5898 32.1191L17.333 30.376C17.3922 30.3168 17.3922 30.2203 17.333 30.1611L17.1191 29.9473ZM33.4863 29.7002C34.1352 29.7003 34.6611 30.2261 34.6611 30.875C34.6611 31.5238 34.1351 32.0497 33.4863 32.0498H20.5615C19.9127 32.0498 19.3868 31.5238 19.3867 30.875C19.3867 30.2261 19.9126 29.7002 20.5615 29.7002H33.4863ZM15.8613 22.6504C17.1592 22.6504 18.2119 23.7022 18.2119 25C18.2119 26.2978 17.1592 27.3496 15.8613 27.3496C14.5636 27.3494 13.5117 26.2977 13.5117 25C13.5117 23.7023 14.5636 22.6506 15.8613 22.6504ZM17.1191 24.0723C17.0599 24.0131 16.9635 24.0131 16.9043 24.0723L15.4824 25.4941L14.8184 24.8301C14.7591 24.7711 14.6636 24.771 14.6045 24.8301L14.3896 25.0439C14.3305 25.1031 14.3306 25.1996 14.3896 25.2588L15.375 26.2441C15.4342 26.3034 15.5306 26.3033 15.5898 26.2441L17.333 24.501C17.3922 24.4418 17.3922 24.3453 17.333 24.2861L17.1191 24.0723ZM33.4863 23.8252C34.1352 23.8253 34.6611 24.3511 34.6611 25C34.6611 25.6489 34.1352 26.1747 33.4863 26.1748H20.5615C19.9126 26.1748 19.3867 25.6489 19.3867 25C19.3867 24.3511 19.9126 23.8252 20.5615 23.8252H33.4863ZM15.8613 16.7754C17.1591 16.7754 18.2118 17.8272 18.2119 19.125C18.2119 20.4228 17.1592 21.4746 15.8613 21.4746C14.5636 21.4744 13.5117 20.4227 13.5117 19.125C13.5118 17.8273 14.5637 16.7756 15.8613 16.7754ZM17.1191 18.1973C17.0599 18.1381 16.9635 18.1381 16.9043 18.1973L15.4824 19.6191L14.8184 18.9551C14.7592 18.8962 14.6636 18.896 14.6045 18.9551L14.3896 19.1699C14.3309 19.2291 14.3308 19.3247 14.3896 19.3838L15.375 20.3691C15.4342 20.4284 15.5306 20.4283 15.5898 20.3691L17.333 18.626C17.3922 18.5668 17.3922 18.4703 17.333 18.4111L17.1191 18.1973ZM33.4863 17.9502C34.1351 17.9503 34.6611 18.4762 34.6611 19.125C34.6611 19.7739 34.1352 20.2997 33.4863 20.2998H20.5615C19.9126 20.2998 19.3867 19.7739 19.3867 19.125C19.3868 18.4762 19.9127 17.9502 20.5615 17.9502H33.4863Z" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Icon List', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--icon-list' );
				?>
				<input type="checkbox" class="cozy-block-active" name="icon-list" id="cozy-block--icon-list" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/icon-picker-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M24.1152 3.81934C24.4904 3.10819 25.5096 3.10819 25.8848 3.81934L31.2979 14.0801C31.7319 14.9026 32.5231 15.4771 33.4395 15.6357L44.8711 17.6133C45.6632 17.7506 45.9773 18.7194 45.417 19.2959L37.332 27.6152C36.6838 28.2823 36.3813 29.2122 36.5137 30.1328L38.165 41.6152C38.2795 42.4111 37.4559 43.0099 36.7344 42.6553L26.3242 37.5361C25.4894 37.1257 24.5105 37.1257 23.6758 37.5361L13.2656 42.6553C12.5441 43.0099 11.7205 42.4111 11.835 41.6152L13.4863 30.1328C13.6187 29.2122 13.3162 28.2823 12.668 27.6152L4.58301 19.2959C4.02268 18.7194 4.33685 17.7506 5.12891 17.6133L16.5605 15.6357C17.4769 15.4771 18.2681 14.9026 18.7021 14.0801L24.1152 3.81934Z" stroke="#0c50ff" stroke-width="2"/>
				</svg>

				<?php esc_html_e( 'Icon Picker', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--icon-picker' );
				?>
				<input type="checkbox" class="cozy-block-active" name="icon-picker" id="cozy-block--icon-picker" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/before-after-image-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 49 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="1.5" width="47" height="47" rx="23.5" stroke="#0c50ff" stroke-width="2"/>
					<path d="M24 48.4932C11.2522 48.2271 1 37.8116 1 25C1 12.1884 11.2522 1.77195 24 1.50586V48.4932Z" fill="#CFE0FF" stroke="#0c50ff" stroke-width="2"/>
					<rect x="20" y="22.5" width="8" height="8" rx="4" fill="#0c50ff"/>
					<line x1="22.75" y1="25" x2="22.75" y2="28" stroke="white" stroke-width="0.5"/>
					<line x1="23.75" y1="25" x2="23.75" y2="28" stroke="white" stroke-width="0.5"/>
					<line x1="24.75" y1="25" x2="24.75" y2="28" stroke="white" stroke-width="0.5"/>
				</svg>

				<p>
					<?php esc_html_e( 'Before/After Image', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--img-compare' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="img-compare" id="cozy-block--img-compare" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/popup-builder-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M38.3096 2.88281C44.7939 3.04701 50 8.35499 50 14.8789V36.8789C50 43.5063 44.6274 48.8789 38 48.8789H12C5.37258 48.8789 0 43.5063 0 36.8789V14.8789C0 8.35499 5.20608 3.04701 11.6904 2.88281L12 2.87891H38L38.3096 2.88281ZM12 4.87891C6.47715 4.87891 2 9.35606 2 14.8789V36.8789C2 42.4018 6.47715 46.8789 12 46.8789H38C43.5228 46.8789 48 42.4018 48 36.8789V14.8789C48 9.52866 43.7983 5.15945 38.5146 4.8916L38 4.87891H12Z" fill="#0c50ff"/>
					<rect width="11" height="11" rx="5.5" transform="matrix(-1 0 0 1 50.9375 1.12109)" fill="#C2D3FF"/>
					<path d="M47.1797 8.36572L44.9068 6.09288L42.937 4.12308" stroke="#0c50ff" stroke-linecap="round"/>
					<path d="M43.1797 8.3667L45.4525 6.09386L47.4223 4.12406" stroke="#0c50ff" stroke-linecap="round"/>
					<rect x="14" y="26.8789" width="14" height="2" rx="1" fill="#94AAE0"/>
					<rect x="29" y="26.8789" width="9" height="2" rx="1" fill="#0c50ff"/>
					<rect x="11" y="22.8789" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="21" y="22.8789" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="31" y="22.8789" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="21" y="31.8789" width="9" height="3" rx="1.5" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Popup Builder', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--modal' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="modal" id="cozy-block--modal" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/portfolio-gallery-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<path d="M32.3778 24L27 32H38L32.3778 24Z" fill="#A1B3D5"/>
					<path d="M20 17L9 32.5H31.5L20 17Z" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Portfolio Gallery', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--portfolio-gallery' );
				?>
				<input type="checkbox" class="cozy-block-active" name="portfolio-gallery" id="cozy-block--portfolio-gallery" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/pricing-table-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="2" y="2" width="46" height="46" rx="23" stroke="#0c50ff" stroke-width="2"/>
					<path d="M23.936 36.3428C22.6538 36.2031 21.4731 35.8794 20.394 35.3716C19.3276 34.8638 18.4326 34.2163 17.709 33.4292L18.4326 32.3057C18.5596 32.1152 18.6992 31.9756 18.8516 31.8867C19.0039 31.7852 19.1943 31.7344 19.4229 31.7344C19.5879 31.7344 19.791 31.8232 20.0322 32.001C20.2861 32.1787 20.5972 32.3818 20.9653 32.6104C21.3335 32.8389 21.7715 33.0674 22.2793 33.2959C22.7998 33.5117 23.4155 33.6641 24.1265 33.7529L24.6216 26.8784C23.8853 26.688 23.1553 26.4658 22.4316 26.2119C21.708 25.9453 21.0605 25.5962 20.4893 25.1646C19.918 24.7329 19.4546 24.1997 19.0991 23.5649C18.7563 22.9175 18.585 22.105 18.585 21.1274C18.585 20.4292 18.7246 19.7437 19.0039 19.0708C19.2959 18.3853 19.7275 17.7695 20.2988 17.2236C20.8701 16.6777 21.5874 16.2271 22.4507 15.8716C23.314 15.5161 24.3232 15.3066 25.4785 15.2432L25.7642 11.3584H27.6875L27.4019 15.3003C28.4683 15.4399 29.4395 15.7129 30.3154 16.1191C31.1914 16.5254 31.9341 17.0332 32.5435 17.6426L31.7817 18.8804C31.6802 19.0327 31.5723 19.1597 31.458 19.2612C31.3564 19.3501 31.2168 19.3945 31.0391 19.3945C30.8867 19.3945 30.7026 19.3311 30.4868 19.2041C30.2837 19.0645 30.0298 18.9058 29.7251 18.728C29.4331 18.5503 29.0776 18.3726 28.6587 18.1948C28.2524 18.0171 27.77 17.8901 27.2114 17.814L26.7544 24.2886C27.5034 24.5044 28.2461 24.7456 28.9824 25.0122C29.7188 25.2661 30.3789 25.6025 30.9629 26.0215C31.5596 26.4277 32.0356 26.9482 32.3911 27.583C32.7593 28.2051 32.9434 28.9795 32.9434 29.9062C32.9434 30.7695 32.772 31.5757 32.4292 32.3247C32.0991 33.0737 31.623 33.7402 31.001 34.3242C30.3789 34.8955 29.6362 35.3652 28.7729 35.7334C27.9097 36.0889 26.9448 36.3047 25.8784 36.3809L25.5928 40.3418H23.6504L23.936 36.3428ZM30.0107 30.3823C30.0107 29.9507 29.9155 29.5825 29.7251 29.2778C29.5474 28.9604 29.2998 28.6875 28.9824 28.459C28.6777 28.2305 28.3096 28.0337 27.8779 27.8687C27.459 27.6909 27.0083 27.5322 26.5259 27.3926L26.0688 33.772C26.7417 33.7212 27.3257 33.6006 27.8208 33.4102C28.3159 33.207 28.7222 32.9595 29.0396 32.6675C29.3696 32.3628 29.6108 32.02 29.7632 31.6392C29.9282 31.2456 30.0107 30.8267 30.0107 30.3823ZM21.689 20.8608C21.689 21.2544 21.7651 21.6035 21.9175 21.9082C22.0825 22.2002 22.3047 22.4604 22.584 22.689C22.876 22.9048 23.2124 23.1016 23.5933 23.2793C23.9868 23.4443 24.4058 23.5967 24.8501 23.7363L25.2881 17.7759C24.6406 17.8394 24.0884 17.9663 23.6313 18.1567C23.1743 18.3345 22.7998 18.563 22.5078 18.8423C22.2285 19.1216 22.019 19.4326 21.8794 19.7754C21.7524 20.1182 21.689 20.48 21.689 20.8608Z" fill="#0c50ff"/>
				</svg>	

				<?php esc_html_e( 'Pricing Table', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--pricing-table' );
				?>
				<input type="checkbox" class="cozy-block-active" name="pricing-table" id="cozy-block--pricing-table" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/progress-bar-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 57 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="6.5" width="54.9941" height="16" rx="8" stroke="#0c50ff" stroke-width="2"/>
					<rect x="18" y="9" width="35" height="11" rx="5.5" fill="#0c50ff"/>
					<rect x="1" y="27.5" width="54.9941" height="16" rx="8" stroke="#0c50ff" stroke-width="2"/>
					<rect x="6" y="32" width="2" height="8" rx="1" fill="#0c50ff"/>
					<rect x="11" y="32" width="2" height="8" rx="1" fill="#0c50ff"/>
					<rect x="16" y="32" width="2" height="8" rx="1" fill="#0c50ff"/>
					<rect x="21" y="32" width="2" height="8" rx="1" fill="#0c50ff"/>
					<rect x="26" y="32" width="2" height="8" rx="1" fill="#0c50ff"/>
				</svg>

				<?php esc_html_e( 'Progress Bar', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--progress-bar' );
				?>
				<input type="checkbox" class="cozy-block-active" name="progress-bar" id="cozy-block--progress-bar" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/scroll-animation-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="1" width="48" height="48" rx="11" stroke="#0c50ff" stroke-width="2"/>
					<path d="M29.5 20.5C31.857 20.5 33.0355 20.5 33.7678 21.2322C34.5 21.9645 34.5 23.143 34.5 25.5C34.5 27.857 34.5 29.0355 33.7678 29.7678C33.0355 30.5 31.857 30.5 29.5 30.5H21.5C19.143 30.5 17.9645 30.5 17.2322 29.7678C16.5 29.0355 16.5 27.857 16.5 25.5C16.5 23.143 16.5 21.9645 17.2322 21.2322C17.9645 20.5 19.143 20.5 21.5 20.5H29.5Z" stroke="#0c50ff" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M30.5 15.5C30.3955 16.047 30.2107 16.4495 29.8838 16.7678C29.1316 17.5 27.9211 17.5 25.5 17.5C23.0789 17.5 21.8683 17.5 21.1162 16.7678C20.7893 16.4495 20.6045 16.047 20.5 15.5" stroke="#0c50ff" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M30.5 35.5C30.3955 34.953 30.2107 34.5505 29.8838 34.2322C29.1316 33.5 27.9211 33.5 25.5 33.5C23.0789 33.5 21.8683 33.5 21.1162 34.2322C20.7893 34.5505 20.6045 34.953 20.5 35.5" stroke="#0c50ff" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				<p>
					<?php esc_html_e( 'Scroll Animation', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--scroll-animation' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="modal" id="cozy-block--scroll-animation" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/sidebar-panel-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M35 2C41.6274 2 47 7.37258 47 14V36C47 42.6274 41.6274 48 35 48H12L11.6904 47.9961C5.20608 47.8319 0 42.5239 0 36V14C0 7.47608 5.20608 2.16811 11.6904 2.00391L12 2H35ZM12 4C6.47715 4 2 8.47715 2 14V36C2 41.5228 6.47715 46 12 46H35C40.5228 46 45 41.5228 45 36V14C45 8.47715 40.5228 4 35 4H12Z" fill="#0c50ff"/>
					<rect width="11" height="11" rx="5.5" transform="matrix(-1 0 0 1 57.9688 4)" fill="#0c50ff"/>
					<path d="M54.2109 11.2444L51.9381 8.97154L49.9683 7.00174" stroke="white" stroke-linecap="round"/>
					<path d="M50.2109 11.2456L52.4838 8.97276L54.4536 7.00296" stroke="white" stroke-linecap="round"/>
					<rect x="6.99219" y="14.4375" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="16.9922" y="14.4375" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="26.9922" y="14.4375" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="6.99219" y="20.4375" width="23" height="2" rx="1" fill="#94AAE0"/>
					<rect x="6.99219" y="26.4375" width="9" height="2" rx="1" fill="#94AAE0"/>
					<rect x="16.9922" y="26.4375" width="16" height="2" rx="1" fill="#94AAE0"/>
					<rect x="6.99219" y="32.4375" width="15" height="2" rx="1" fill="#94AAE0"/>
				</svg>

				<?php esc_html_e( 'Sidebar Panel', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--sidebar-panel' );
				?>
				<input type="checkbox" class="cozy-block-active" name="sidebar-panel" id="cozy-block--sidebar-panel" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/slider-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M38.3096 2.00391C44.7939 2.16811 50 7.47608 50 14V30L49.9961 30.3096C49.8319 36.7939 44.5239 42 38 42H12C5.47608 42 0.168106 36.7939 0.00390625 30.3096L0 30V14C2.53686e-07 7.47608 5.20608 2.16811 11.6904 2.00391L12 2H38L38.3096 2.00391ZM12 4C6.47715 4 2 8.47715 2 14V30C2 35.5228 6.47715 40 12 40H38C43.5228 40 48 35.5228 48 30V14C48 8.64975 43.7983 4.28054 38.5146 4.0127L38 4H12ZM12.8311 17.2568C13.2415 16.8874 13.8737 16.9206 14.2432 17.3311C14.6126 17.7415 14.5794 18.3737 14.1689 18.7432L10.8203 21.7568C10.3793 22.154 10.3793 22.846 10.8203 23.2432L14.1689 26.2568C14.5794 26.6263 14.6126 27.2585 14.2432 27.6689C13.8737 28.0794 13.2415 28.1126 12.8311 27.7432L9.48242 24.7295C8.15882 23.5378 8.15882 21.4622 9.48242 20.2705L12.8311 17.2568ZM37.7568 17.3311C38.1263 16.9206 38.7585 16.8874 39.1689 17.2568L42.5176 20.2705C43.8412 21.4622 43.8412 23.5378 42.5176 24.7295L39.1689 27.7432C38.7585 28.1126 38.1263 28.0794 37.7568 27.6689C37.3874 27.2585 37.4206 26.6263 37.8311 26.2568L41.1797 23.2432C41.6207 22.846 41.6207 22.154 41.1797 21.7568L37.8311 18.7432C37.4206 18.3737 37.3874 17.7415 37.7568 17.3311Z" fill="#0c50ff"/>
					<rect x="16.5" y="45" width="3" height="3" rx="1.5" fill="#CAD5F2"/>
					<rect x="22.5" y="45" width="3" height="3" rx="1.5" fill="#0c50ff"/>
					<rect x="28.5" y="45" width="3" height="3" rx="1.5" fill="#CAD5F2"/>
				</svg>

				<?php esc_html_e( 'Slider', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--slider' );
				?>
				<input type="checkbox" class="cozy-block-active" name="slider" id="cozy-block--slider" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M14.8799 45.625C17.9505 47.1445 21.4084 48 25.0664 48C28.5759 48 31.9011 47.2123 34.877 45.8066C35.2897 46.3719 35.7679 46.8859 36.3018 47.3369C32.9237 49.0394 29.1075 50 25.0664 50C21.0168 50 17.193 49.0354 13.8096 47.3262C14.228 46.8045 14.5887 46.2348 14.8799 45.625ZM7.97656 32.9414C12.1187 32.9414 15.4766 36.2993 15.4766 40.4414C15.4766 44.5835 12.1187 47.9414 7.97656 47.9414C3.83443 47.9414 0.476562 44.5835 0.476562 40.4414C0.476562 36.2993 3.83443 32.9414 7.97656 32.9414ZM42.3125 32.9414C46.4546 32.9414 49.8125 36.2993 49.8125 40.4414C49.8125 44.5835 46.4546 47.9414 42.3125 47.9414C38.1704 47.9414 34.8125 44.5835 34.8125 40.4414C34.8125 36.2993 38.1704 32.9414 42.3125 32.9414ZM7.97656 34.9414C4.939 34.9414 2.47656 37.4038 2.47656 40.4414C2.47656 43.479 4.939 45.9414 7.97656 45.9414C11.0141 45.9414 13.4766 43.479 13.4766 40.4414C13.4766 37.4038 11.0141 34.9414 7.97656 34.9414ZM42.3125 34.9414C39.2749 34.9414 36.8125 37.4038 36.8125 40.4414C36.8125 43.479 39.2749 45.9414 42.3125 45.9414C45.3501 45.9414 47.8125 43.479 47.8125 40.4414C47.8125 37.4038 45.3501 34.9414 42.3125 34.9414ZM43.8086 37.7344C44.652 37.7348 45.3296 38.4303 45.3076 39.2734L45.2188 42.6455C45.1971 43.4578 44.5323 44.1052 43.7197 44.1055H40.3223C39.4939 44.1055 38.8223 43.4338 38.8223 42.6055V39.2344C38.8223 38.4059 39.4938 37.7344 40.3223 37.7344H43.8086ZM8.81152 36.5078C8.81936 36.5066 8.82699 36.5038 8.83496 36.5029C9.10946 36.4734 9.35609 36.6718 9.38574 36.9463L9.60254 38.9561C9.62899 39.2016 9.83604 39.3877 10.083 39.3877C10.8867 39.3877 11.6041 40.0527 11.5068 40.9248C11.4551 41.3887 11.3618 41.9056 11.2012 42.3408C11.0549 42.7372 10.7898 43.2409 10.2812 43.3984C10.0203 43.4792 9.69637 43.5013 9.38086 43.5C9.0553 43.4987 8.69453 43.4713 8.33887 43.4316C7.66281 43.3563 6.97479 43.231 6.51855 43.1338L5.15332 43.2139C4.29231 43.2638 3.56661 42.5792 3.56641 41.7168V40.5996C3.56641 39.7712 4.23798 39.0996 5.06641 39.0996H6.35254C6.51589 38.6475 6.76513 38.0863 7.08984 37.6074C7.27678 37.3317 7.50022 37.0633 7.7627 36.8604C8.02662 36.6563 8.35472 36.5 8.7334 36.5C8.76007 36.5 8.78599 36.5038 8.81152 36.5078ZM40.3223 38.7344C40.0461 38.7344 39.8223 38.9582 39.8223 39.2344V42.6055C39.8223 42.8815 40.0462 43.1055 40.3223 43.1055H43.7197C43.9903 43.1052 44.2123 42.8897 44.2197 42.6191L44.3076 39.2471C44.3148 38.9663 44.0894 38.7348 43.8086 38.7344H40.3223ZM8.375 37.6523C8.22513 37.7682 8.06916 37.9436 7.91699 38.168C7.61236 38.6173 7.37177 39.184 7.23242 39.6074C7.19649 39.7166 7.13498 39.8139 7.05566 39.8926V42.2227C7.45709 42.2997 7.95898 42.3837 8.4502 42.4385C8.78527 42.4758 9.10734 42.4989 9.38477 42.5C9.67231 42.5011 9.87295 42.4781 9.98535 42.4434C10.0059 42.437 10.1289 42.3602 10.2637 41.9951C10.3842 41.6686 10.465 41.2412 10.5127 40.8135C10.5356 40.6061 10.3654 40.3877 10.083 40.3877C9.32522 40.3877 8.68957 39.8169 8.6084 39.0635L8.4502 37.5996C8.42613 37.6151 8.40091 37.6323 8.375 37.6523ZM5.06641 40.0996C4.79026 40.0996 4.56641 40.3235 4.56641 40.5996V41.7168C4.56661 42.0042 4.80878 42.2325 5.0957 42.2158L6.05566 42.1592V40.0996H5.06641ZM41.9814 39.6504C42.5518 39.7082 42.9971 40.1898 42.9971 40.7754L42.9912 40.8906C42.9335 41.461 42.4518 41.9062 41.8662 41.9062L41.751 41.9004C41.2185 41.8465 40.7951 41.4231 40.7412 40.8906L40.7354 40.7754C40.7354 40.1509 41.2417 39.6445 41.8662 39.6445L41.9814 39.6504ZM41.8662 40.0449C41.4626 40.0449 41.1357 40.3718 41.1357 40.7754C41.1358 41.179 41.4626 41.5059 41.8662 41.5059C42.2697 41.5058 42.5966 41.1789 42.5967 40.7754C42.5967 40.3718 42.2698 40.045 41.8662 40.0449ZM1.62012 16.3066C2.12758 16.783 2.69171 17.1988 3.30176 17.5439C2.50094 19.8821 2.06641 22.3903 2.06641 25C2.06641 28.0944 2.67905 31.0454 3.78711 33.7402C3.15697 33.9891 2.56312 34.3091 2.01465 34.6904C0.760347 31.7103 0.0664062 28.4362 0.0664062 25C0.0664062 21.9429 0.615805 19.0143 1.62012 16.3066ZM48.5059 16.291C49.5139 19.0031 50.0664 21.9369 50.0664 25C50.0664 28.3833 49.3918 31.6086 48.1738 34.5518C47.6855 34.0532 47.1385 33.6128 46.543 33.2422C47.5257 30.6832 48.0664 27.9049 48.0664 25C48.0664 22.4594 47.6533 20.0155 46.8926 17.7305C47.4886 17.3187 48.0299 16.8345 48.5059 16.291ZM41.7109 2.61719C45.8531 2.61719 49.2109 5.97505 49.2109 10.1172C49.2109 14.2593 45.8531 17.6172 41.7109 17.6172C37.5688 17.6172 34.2109 14.2593 34.2109 10.1172C34.2109 5.97505 37.5688 2.61719 41.7109 2.61719ZM7.5 2.14062C11.6421 2.14062 15 5.49849 15 9.64062C15 13.7828 11.6421 17.1406 7.5 17.1406C3.35786 17.1406 0 13.7828 0 9.64062C0 5.49849 3.35786 2.14062 7.5 2.14062ZM41.7109 4.61719C38.6734 4.61719 36.2109 7.07962 36.2109 10.1172C36.2109 13.1548 38.6734 15.6172 41.7109 15.6172C44.7485 15.6172 47.2109 13.1548 47.2109 10.1172C47.2109 7.07962 44.7485 4.61719 41.7109 4.61719ZM7.5 4.14062C4.46243 4.14062 2 6.60306 2 9.64062C2 12.6782 4.46243 15.1406 7.5 15.1406C10.5376 15.1406 13 12.6782 13 9.64062C13 6.60306 10.5376 4.14062 7.5 4.14062ZM9.35938 6.73145C9.63504 6.71523 9.87148 6.92551 9.8877 7.20117C9.90382 7.47677 9.69358 7.71328 9.41797 7.72949L8.18945 7.80176C7.92041 7.81765 7.71204 8.04408 7.71875 8.31348L7.74121 9.19531L8.67676 9.14258L8.7793 9.14648C9.00907 9.18036 9.19133 9.37231 9.20508 9.61328C9.21869 9.85419 9.05939 10.0653 8.83496 10.125L8.73438 10.1406L7.76465 10.1953L7.82324 12.9863C7.82887 13.2623 7.60992 13.4903 7.33398 13.4961C7.058 13.5017 6.82901 13.2828 6.82324 13.0068L6.76562 10.2529L5.72266 10.3125C5.44698 10.3282 5.21009 10.1175 5.19434 9.8418C5.17862 9.56619 5.38947 9.33031 5.66504 9.31445L6.74219 9.25293L6.71973 8.33984C6.69899 7.53106 7.32323 6.85129 8.13086 6.80371L9.35938 6.73145ZM39.5664 7.71582C39.5666 6.56668 40.8058 5.84469 41.8057 6.41113L44.8213 8.12012C45.8205 8.68662 45.8384 10.1199 44.8535 10.7109L41.8379 12.5205C40.8382 13.12 39.5664 12.3992 39.5664 11.2334V7.71582ZM41.3125 7.28125C40.9793 7.09265 40.5666 7.33293 40.5664 7.71582V11.2334C40.5664 11.622 40.99 11.862 41.3232 11.6621L44.3389 9.85352C44.6672 9.65649 44.6613 9.17806 44.3281 8.98926L41.3125 7.28125ZM25.0664 0C29.4912 0 33.6465 1.15127 37.252 3.16797C36.6411 3.55679 36.0821 4.01907 35.5869 4.54297C32.434 2.91825 28.8576 2 25.0664 2C21.2509 2 17.6529 2.92998 14.4854 4.57422C14.0559 4.02345 13.5628 3.52556 13.0156 3.0918C16.5896 1.12171 20.6969 0 25.0664 0Z" fill="#0c50ff"/>
			</svg>

			<?php esc_html_e( 'Social Icons', 'cozy-addons' ); ?>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--social-icon' );
				?>
				<input type="checkbox" class="cozy-block-active" name="social-icon" id="cozy-block--social-icon" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/related-post-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 45 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M37.7295 0.77832C41.7791 0.983907 45 4.33291 45 8.43359L44.9893 8.82812C44.7837 12.8776 41.4354 16.0984 37.335 16.0986L36.9404 16.0879C34.6741 15.973 32.6688 14.8724 31.3408 13.208L14.9023 22.168C14.8972 22.1708 14.891 22.1721 14.8857 22.1748C15.1731 22.98 15.3301 23.8471 15.3301 24.751L15.3193 25.1455C15.2702 26.114 15.039 27.0341 14.6631 27.875C14.692 27.8879 14.7208 27.9021 14.749 27.918L31.0947 37.1162C32.4849 35.1705 34.7614 33.9014 37.335 33.9014L37.7295 33.9111C41.7791 34.1167 45 37.4657 45 41.5664L44.9893 41.9609C44.7838 46.0104 41.4355 49.2312 37.335 49.2314L36.9404 49.2207C33.0213 49.0221 29.8786 45.88 29.6797 41.9609L29.6699 41.5664C29.6699 40.6222 29.8411 39.7181 30.1533 38.8828L13.7686 29.6602C13.7181 29.6318 13.6714 29.5988 13.6279 29.5635C12.223 31.3025 10.0748 32.416 7.66504 32.416L7.27051 32.4053C3.35134 32.2067 0.208575 29.0646 0.00976562 25.1455L0 24.751C6.70057e-05 20.5179 3.43191 17.0859 7.66504 17.0859L8.05957 17.0957C10.5119 17.2201 12.6584 18.4987 13.9717 20.3975L30.3066 11.4941C29.9474 10.6706 29.7276 9.77217 29.6797 8.82812L29.6699 8.43359C29.6699 4.20042 33.1018 0.768555 37.335 0.768555L37.7295 0.77832ZM37.335 35.9014C34.2064 35.9014 31.6699 38.4378 31.6699 41.5664C31.6701 44.6948 34.2065 47.2314 37.335 47.2314C40.4632 47.2312 42.9998 44.6947 43 41.5664C43 38.438 40.4633 35.9016 37.335 35.9014ZM7.66504 19.0859C4.53648 19.0859 2.00007 21.6224 2 24.751C2.00011 27.8795 4.53651 30.416 7.66504 30.416C10.7935 30.4159 13.33 27.8794 13.3301 24.751C13.33 21.6225 10.7935 19.086 7.66504 19.0859ZM37.335 2.76855C34.2064 2.76855 31.6699 5.30499 31.6699 8.43359C31.6702 11.562 34.2065 14.0986 37.335 14.0986C40.4632 14.0984 42.9998 11.5618 43 8.43359C43 5.30516 40.4633 2.76882 37.335 2.76855Z" fill="#0c50ff"/>
				</svg>


				<?php esc_html_e( 'Social Shares', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--social-share' );
				?>
				<input type="checkbox" class="cozy-block-active" name="social-share" id="cozy-block--social-share" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/team-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 49 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="23.4993" cy="7.66653" r="6.27273" stroke="#0c50ff" stroke-width="2"/>
					<mask id="path-2-inside-1_1419_622" fill="white">
					<path d="M23.5 17.105C29.0227 17.105 33.4998 21.5823 33.5 27.105V29.2485C33.4999 32.3731 32.066 35.1619 29.8213 36.9956C30.3448 37.9889 30.6426 39.1199 30.6426 40.3208V42.4634C30.6426 46.4082 27.4448 49.6058 23.5 49.606C19.5551 49.606 16.3564 46.4083 16.3564 42.4634V40.3208C16.3564 39.1197 16.654 37.9881 17.1777 36.9946C14.9336 35.1609 13.5001 32.3726 13.5 29.2485V27.105C13.5002 21.5823 17.9773 17.105 23.5 17.105Z"/>
					</mask>
					<path d="M33.5 27.105H35.5V27.1049L33.5 27.105ZM33.5 29.2485L35.5 29.2486V29.2485H33.5ZM29.8213 36.9956L28.556 35.4467L27.2894 36.4814L28.052 37.9281L29.8213 36.9956ZM23.5 49.606V51.606H23.5001L23.5 49.606ZM17.1777 36.9946L18.9469 37.9273L19.7096 36.4807L18.4432 35.4459L17.1777 36.9946ZM13.5 29.2485H11.5V29.2486L13.5 29.2485ZM13.5 27.105L11.5 27.1049V27.105H13.5ZM23.5 17.105V19.105C27.9181 19.105 31.4998 22.6868 31.5 27.1051L33.5 27.105L35.5 27.1049C35.4998 20.4778 30.1274 15.105 23.5 15.105V17.105ZM33.5 27.105H31.5V29.2485H33.5H35.5V27.105H33.5ZM33.5 29.2485L31.5 29.2485C31.4999 31.7467 30.3562 33.9762 28.556 35.4467L29.8213 36.9956L31.0866 38.5445C33.7758 36.3476 35.4999 32.9994 35.5 29.2486L33.5 29.2485ZM29.8213 36.9956L28.052 37.9281C28.4285 38.6425 28.6426 39.4545 28.6426 40.3208H30.6426H32.6426C32.6426 38.7854 32.2611 37.3353 31.5906 36.0631L29.8213 36.9956ZM30.6426 40.3208H28.6426V42.4634H30.6426H32.6426V40.3208H30.6426ZM30.6426 42.4634H28.6426C28.6426 45.3035 26.3403 47.6059 23.4999 47.606L23.5 49.606L23.5001 51.606C28.5493 51.6058 32.6426 47.5128 32.6426 42.4634H30.6426ZM23.5 49.606V47.606C20.6593 47.606 18.3564 45.3033 18.3564 42.4634H16.3564H14.3564C14.3564 47.5132 18.4509 51.606 23.5 51.606V49.606ZM16.3564 42.4634H18.3564V40.3208H16.3564H14.3564V42.4634H16.3564ZM16.3564 40.3208H18.3564C18.3564 39.4538 18.5705 38.6414 18.9469 37.9273L17.1777 36.9946L15.4085 36.0619C14.7375 37.3347 14.3564 38.7856 14.3564 40.3208H16.3564ZM17.1777 36.9946L18.4432 35.4459C16.6435 33.9753 15.5001 31.7463 15.5 29.2485L13.5 29.2485L11.5 29.2486C11.5001 32.9988 13.2238 36.3465 15.9122 38.5433L17.1777 36.9946ZM13.5 29.2485H15.5V27.105H13.5H11.5V29.2485H13.5ZM13.5 27.105L15.5 27.105C15.5002 22.6868 19.0819 19.105 23.5 19.105V17.105V15.105C16.8726 15.105 11.5002 20.4778 11.5 27.1049L13.5 27.105Z" fill="#0c50ff" mask="url(#path-2-inside-1_1419_622)"/>
					<circle cx="10" cy="11.4329" r="3.5" stroke="#0c50ff" stroke-width="2"/>
					<path d="M11.5069 20.0499C8.69824 19.6062 3.20375 20.1354 1.50391 25.9329C-0.195939 31.7303 2.78786 34.8393 4.76613 35.6527V45.9314" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<circle cx="4.5" cy="4.5" r="3.5" transform="matrix(-1 0 0 1 43.5 6.93286)" stroke="#0c50ff" stroke-width="2"/>
					<path d="M37.5009 20.0499C40.3096 19.6062 45.8041 20.1354 47.5039 25.9329C49.2038 31.7303 46.22 34.8393 44.2417 35.6527V45.9314" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
				</svg>

				<?php esc_html_e( 'Teams', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--teams' );
				?>
				<input type="checkbox" class="cozy-block-active" name="teams" id="cozy-block--teams" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/testimonial-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 50 48" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M33.0283 2.80444C41.9978 3.03205 49.199 10.374 49.1992 19.3982C49.1992 26.7506 44.4193 32.9824 37.7998 35.1648V47.3455L36.0674 45.4792L27.2646 35.9988H16.5996C7.43161 35.9988 0 28.566 0 19.3982C6.32724e-05 16.8188 0.587903 14.3767 1.6377 12.199H3.89551C2.68895 14.3235 2.00007 16.7803 2 19.3982C2 27.4616 8.53634 33.9988 16.5996 33.9988H28.1367L28.4326 34.3181L35.7998 42.2517V33.6667L36.5312 33.4626C42.6855 31.7459 47.1992 26.0979 47.1992 19.3982C47.199 11.4612 40.8653 5.00361 32.9766 4.80347L32.5996 4.79858H23V2.79858H32.5996L33.0283 2.80444Z" fill="#0c50ff"/>
					<path d="M10.2557 1.00072C10.2147 0.999769 10.1728 0.999754 10.1301 1.00072M10.1301 1.00072C8.44627 1.03867 5.60893 2.59968 6.31334 8.55471C6.37092 9.04144 6.79265 9.4 7.28277 9.4H9.60313C10.1554 9.4 10.6031 8.95228 10.6031 8.4V6.20058C10.6031 5.6483 10.1554 5.20058 9.60313 5.20058H8.77704C8.34572 5.20058 7.95357 4.91852 7.96398 4.48733C7.9857 3.58728 8.44536 2.23235 10.1301 1.00072Z" stroke="#0c50ff" stroke-width="2"/>
					<path d="M17.8495 1.00072C17.8084 0.999769 17.7665 0.999754 17.7239 1.00072M17.7239 1.00072C16.04 1.03867 13.2027 2.59968 13.9071 8.55471C13.9647 9.04144 14.3864 9.4 14.8765 9.4H17.1969C17.7492 9.4 18.1969 8.95228 18.1969 8.4V6.20058C18.1969 5.6483 17.7492 5.20058 17.1969 5.20058H16.3708C15.9395 5.20058 15.5473 4.91852 15.5577 4.48733C15.5794 3.58728 16.0391 2.23235 17.7239 1.00072Z" stroke="#0c50ff" stroke-width="2"/>
					<path d="M12.6016 14.1477L36.002 14.6008" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M12.6016 18.6008L35.8008 18.6516" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M12.6016 22.6516L35.8008 22.7024" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M12.6016 26.8293H12.6015" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M15.6016 26.7024L36.0012 26.9563" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
				</svg>

				<?php esc_html_e( 'Testimonials', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--testimonial' );
				?>
				<input type="checkbox" class="cozy-block-active" name="testimonial" id="cozy-block--testimonial" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/pricing-table-gutenberg-block/#toggle-content" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="11.5" width="46" height="27" rx="13.5" stroke="#0c50ff" stroke-width="2"/>
					<rect x="26.5" y="18" width="14" height="14" rx="7" stroke="#0c50ff" stroke-width="2"/>
				</svg>

				<p>
					<?php esc_html_e( 'Toggle Content', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--toggle-content' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="toggle-content" id="cozy-block--toggle-content" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>
</ul>

<!-- Post and Magazine Blocks -->
<h2 class="mt-34"><?php esc_html_e( 'Post and Magazine Blocks', 'cozy-addons' ); ?></h2>
<ul class="blocks-holder">
	<li>
		<a href="https://cozyblock.cozythemes.com/advertisement-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 46 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M22.1191 36.5L42.4139 32.2508C43.9627 31.9266 44.5393 30.0171 43.4288 28.8898L36.9957 22.359L18.0737 3.14948C16.9552 2.01407 15.023 2.57903 14.6923 4.13811L10.3745 24.5M10.3745 24.5L22.1191 36.5M10.3745 24.5L4.80364 30.9437C2.09525 34.0765 2.26257 38.7681 5.18723 41.7C8.20521 44.7254 12.9367 45.206 16.5014 42.8493L17.0298 42.5M22.1191 36.5L26.0803 41.2218C27.7935 43.2639 27.5551 46.302 25.5445 48.052C24.6104 48.8651 23.2044 48.8088 22.3382 47.9238L17.0298 42.5M22.1191 36.5L17.0298 42.5M25.0553 9.3L29.2374 7.61737C32.394 6.34733 36.0081 7.19667 38.2687 9.73974C40.749 12.5301 40.988 16.6588 38.8463 19.7168L36.9957 22.359" stroke="#0c50ff" stroke-width="2"/>
				</svg>

				<?php esc_html_e( 'Advertisement', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--ad' );
				?>
				<input type="checkbox" class="cozy-block-active" name="ad" id="cozy-block--ad" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/advanced-categories-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="1" width="21" height="21" rx="4" stroke="#0c50ff" stroke-width="2"/>
					<rect x="1" y="28" width="21" height="21" rx="4" stroke="#0c50ff" stroke-width="2"/>
					<rect x="28" y="1" width="21" height="21" rx="4" stroke="#0c50ff" stroke-width="2"/>
					<path d="M27.4922 30H48.4922" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M38.4922 38L48.4922 38" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M27.4922 46H48.4922" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
				</svg>

				<p>
					<?php esc_html_e( 'Advanced Categories', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--advanced-categories' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="advanced-categories" id="cozy-block--advanced-categories" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/categorized-post-tabs-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M28.8887 2.62109C30.6326 2.30402 32.367 3.22115 33.0869 4.84082L34.1016 7.12305C34.1061 7.13319 34.1091 7.14409 34.1133 7.1543H44.041C47.3547 7.1543 50.041 9.8406 50.041 13.1543V41.4424C50.0408 44.7559 47.3546 47.4424 44.041 47.4424H6C2.68653 47.4423 0.000257081 44.7558 0 41.4424V9.16602C0 5.85236 2.68637 3.16611 6 3.16602H10.5791C12.325 3.1661 13.9219 4.15149 14.7051 5.71191C15.149 6.59597 16.0537 7.15421 17.043 7.1543H17.1631C16.7434 5.06966 18.1108 3.00871 20.2422 2.62109C21.9861 2.30408 23.7205 3.22115 24.4404 4.84082L25.4551 7.12305C25.4596 7.13321 25.4626 7.14407 25.4668 7.1543H25.8096C25.3899 5.06968 26.7573 3.00872 28.8887 2.62109ZM6 5.16602C3.79094 5.16611 2 6.95693 2 9.16602V41.4424C2.00026 43.6512 3.7911 45.4423 6 45.4424H44.041C46.25 45.4424 48.0408 43.6513 48.041 41.4424V13.1543C48.041 10.9452 46.2501 9.1543 44.041 9.1543H17.043C15.2971 9.15421 13.7002 8.16876 12.917 6.6084C12.4731 5.72425 11.5684 5.16611 10.5791 5.16602H6ZM15 36.5586H7V35.5586H15V36.5586ZM12 34.5586H7V33.5586H12V34.5586ZM18 34.5586H13V33.5586H18V34.5586ZM20 32.5586H7V31.5586H20V32.5586ZM23 29.5586H7V15.5586H23V29.5586ZM8 28.5586H22V16.5586H8V28.5586ZM18.2236 24.291H12L13.7734 21.709L15.0811 23.1396L17.041 20.6816L18.2236 24.291ZM12.5273 20.5586C12.8023 20.5586 13.0254 20.7817 13.0254 21.0566C13.0254 21.3316 12.8023 21.5547 12.5273 21.5547C12.2525 21.5545 12.0293 21.3315 12.0293 21.0566C12.0293 20.7818 12.2525 20.5588 12.5273 20.5586ZM31.2598 5.65332C30.9145 4.87678 30.0822 4.43684 29.2461 4.58887C28.175 4.78392 27.5057 5.86035 27.8047 6.90723L27.875 7.1543H31.9268L31.2598 5.65332ZM22.6133 5.65332C22.2681 4.87678 21.4357 4.43691 20.5996 4.58887C19.5285 4.7839 18.8592 5.86032 19.1582 6.90723L19.2285 7.1543H23.2803L22.6133 5.65332Z" fill="#0c50ff"/>
					<rect x="25.25" y="15.8086" width="8.5" height="7.5" rx="1.75" stroke="#0c50ff" stroke-width="0.5"/>
					<path d="M31.059 18.6328L31.7765 20.8232H28L29.0763 19.2559L29.8694 20.1245L31.059 18.6328Z" fill="#0c50ff"/>
					<circle cx="28.3217" cy="18.8607" r="0.302122" fill="#0c50ff"/>
					<line x1="36" y1="19.3086" x2="39.3333" y2="19.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="40" y1="19.3086" x2="43.3333" y2="19.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="36" y1="17.3086" x2="44.6667" y2="17.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="36" y1="21.3086" x2="41.3333" y2="21.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<rect x="25.25" y="24.8086" width="8.5" height="7.5" rx="1.75" stroke="#0c50ff" stroke-width="0.5"/>
					<path d="M31.059 27.6328L31.7765 29.8232H28L29.0763 28.2559L29.8694 29.1245L31.059 27.6328Z" fill="#0c50ff"/>
					<circle cx="28.3217" cy="27.8607" r="0.302122" fill="#0c50ff"/>
					<line x1="36" y1="28.3086" x2="39.3333" y2="28.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="40" y1="28.3086" x2="43.3333" y2="28.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="36" y1="26.3086" x2="44.6667" y2="26.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="36" y1="30.3086" x2="41.3333" y2="30.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<rect x="25.25" y="33.8086" width="8.5" height="7.5" rx="1.75" stroke="#0c50ff" stroke-width="0.5"/>
					<path d="M31.059 36.6328L31.7765 38.8232H28L29.0763 37.2559L29.8694 38.1245L31.059 36.6328Z" fill="#0c50ff"/>
					<circle cx="28.3217" cy="36.8607" r="0.302122" fill="#0c50ff"/>
					<line x1="36" y1="37.3086" x2="39.3333" y2="37.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="40" y1="37.3086" x2="43.3333" y2="37.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="36" y1="35.3086" x2="44.6667" y2="35.3086" stroke="#9FC0FF" stroke-width="0.5"/>
					<line x1="36" y1="39.3086" x2="41.3333" y2="39.3086" stroke="#9FC0FF" stroke-width="0.5"/>
				</svg>

				<p>
					<?php esc_html_e( 'Categorized Post Tabs', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--categorized-post-tabs' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="categorized-post-tabs" id="cozy-block--categorized-post-tabs" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/featured-post-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="1" width="48" height="48" rx="11" stroke="#0C50FF" stroke-width="2"/>
					<rect x="10.5" y="8.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M18.041 12.125L19.2235 15.7346H13L14.7737 13.1519L16.0806 14.5833L18.041 12.125Z" fill="#0c50ff"/>
					<circle cx="13.5272" cy="12.4979" r="0.497878" fill="#0c50ff"/>
					<line x1="10.5" y1="23.5" x2="15.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="16.5" y1="23.5" x2="21.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="10.5" y1="21.5" x2="23.5" y2="21.5" stroke="#A0C1FF"/>
					<rect x="26.5" y="8.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M34.041 12.125L35.2235 15.7346H29L30.7737 13.1519L32.0806 14.5833L34.041 12.125Z" fill="#0c50ff"/>
					<circle cx="29.5272" cy="12.4979" r="0.497878" fill="#0c50ff"/>
					<line x1="26.5" y1="23.5" x2="31.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="32.5" y1="23.5" x2="37.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="26.5" y1="21.5" x2="39.5" y2="21.5" stroke="#A0C1FF"/>
					<rect x="10.5" y="27.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M18.041 31.125L19.2235 34.7346H13L14.7737 32.1519L16.0806 33.5833L18.041 31.125Z" fill="#0c50ff"/>
					<circle cx="13.5272" cy="31.4979" r="0.497878" fill="#0c50ff"/>
					<line x1="10.5" y1="42.5" x2="15.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="16.5" y1="42.5" x2="21.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="10.5" y1="40.5" x2="23.5" y2="40.5" stroke="#A0C1FF"/>
					<rect x="26.5" y="27.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M34.041 31.125L35.2235 34.7346H29L30.7737 32.1519L32.0806 33.5833L34.041 31.125Z" fill="#0c50ff"/>
					<circle cx="29.5272" cy="31.4979" r="0.497878" fill="#0c50ff"/>
					<line x1="26.5" y1="42.5" x2="31.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="32.5" y1="42.5" x2="37.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="26.5" y1="40.5" x2="39.5" y2="40.5" stroke="#A0C1FF"/>
				</svg>

				<p>
					<?php esc_html_e( 'Featured Post', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--featured-post' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="featured-post" id="cozy-block--featured-post" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/featured-post-tabs-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M28.8887 2.62109C30.6326 2.30402 32.367 3.22115 33.0869 4.84082L34.1016 7.12305C34.1061 7.13319 34.1091 7.14409 34.1133 7.1543H44.041C47.3547 7.1543 50.041 9.8406 50.041 13.1543V41.4424C50.0408 44.7559 47.3546 47.4424 44.041 47.4424H6C2.68653 47.4423 0.000257081 44.7558 0 41.4424V9.16602C0 5.85236 2.68637 3.16611 6 3.16602H10.5791C12.325 3.1661 13.9219 4.15149 14.7051 5.71191C15.149 6.59597 16.0537 7.15421 17.043 7.1543H17.1631C16.7434 5.06966 18.1108 3.00871 20.2422 2.62109C21.9861 2.30408 23.7205 3.22115 24.4404 4.84082L25.4551 7.12305C25.4596 7.13321 25.4626 7.14407 25.4668 7.1543H25.8096C25.3899 5.06968 26.7573 3.00872 28.8887 2.62109ZM6 5.16602C3.79094 5.16611 2 6.95693 2 9.16602V41.4424C2.00026 43.6512 3.7911 45.4423 6 45.4424H44.041C46.25 45.4424 48.0408 43.6513 48.041 41.4424V13.1543C48.041 10.9452 46.2501 9.1543 44.041 9.1543H17.043C15.2971 9.15421 13.7002 8.16876 12.917 6.6084C12.4731 5.72425 11.5684 5.16611 10.5791 5.16602H6ZM31.2598 5.65332C30.9145 4.87678 30.0822 4.43684 29.2461 4.58887C28.175 4.78392 27.5057 5.86035 27.8047 6.90723L27.875 7.1543H31.9268L31.2598 5.65332ZM22.6133 5.65332C22.2681 4.87678 21.4357 4.43691 20.5996 4.58887C19.5285 4.7839 18.8592 5.86032 19.1582 6.90723L19.2285 7.1543H23.2803L22.6133 5.65332Z" fill="#0c50ff"/>
					<rect x="10.0195" y="14.5" width="14" height="11" stroke="#0c50ff"/>
					<path d="M18.5605 18.125L19.743 21.7346H13.5195L15.2932 19.1519L16.6002 20.5833L18.5605 18.125Z" fill="#0c50ff"/>
					<circle cx="14.0467" cy="18.4979" r="0.497878" fill="#0c50ff"/>
					<line x1="27.5195" y1="19.5" x2="32.5195" y2="19.5" stroke="#9FC0FF"/>
					<line x1="33.5195" y1="19.5" x2="38.5195" y2="19.5" stroke="#9FC0FF"/>
					<line x1="27.5195" y1="16.5" x2="40.5195" y2="16.5" stroke="#9FC0FF"/>
					<line x1="27.5195" y1="22.5" x2="35.5195" y2="22.5" stroke="#9FC0FF"/>
					<rect x="10.0195" y="28.5" width="14" height="11" stroke="#0c50ff"/>
					<path d="M18.5605 32.125L19.743 35.7346H13.5195L15.2932 33.1519L16.6002 34.5833L18.5605 32.125Z" fill="#0c50ff"/>
					<circle cx="14.0467" cy="32.4979" r="0.497878" fill="#0c50ff"/>
					<line x1="27.5195" y1="33.5" x2="32.5195" y2="33.5" stroke="#9FC0FF"/>
					<line x1="33.5195" y1="33.5" x2="38.5195" y2="33.5" stroke="#9FC0FF"/>
					<line x1="27.5195" y1="30.5" x2="40.5195" y2="30.5" stroke="#9FC0FF"/>
					<line x1="27.5195" y1="36.5" x2="35.5195" y2="36.5" stroke="#9FC0FF"/>
				</svg>

				<p>
					<?php esc_html_e( 'Featured Post Tabs', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--featured-post-tabs' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="featured-post-tabs" id="cozy-block--featured-post-tabs" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/magazine-grid-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<rect x="6.40436" y="13.4044" width="13.209" height="12.1307" stroke="#0c50ff" stroke-width="0.808713"/>
					<path d="M15.0159 17.8516L16.2451 21.6256H9.77539L11.6193 18.9252L12.9779 20.4218L15.0159 17.8516Z" fill="#0c50ff"/>
					<circle cx="10.3145" cy="18.3907" r="0.539142" fill="#0c50ff"/>
					<path d="M7.07812 27.9805H11.3913" stroke="#0c50ff" stroke-width="0.808713"/>
					<path d="M12.4688 27.9805H17.321" stroke="#0c50ff" stroke-width="0.808713"/>
					<path d="M7.07812 30.1406H18.9393" stroke="#0c50ff" stroke-width="0.808713"/>
					<path d="M7.07812 32.3008H14.087" stroke="#0c50ff" stroke-width="0.808713"/>
					<rect x="22.3346" y="13.3171" width="8.24374" height="6.97547" stroke="#0c50ff" stroke-width="0.634134"/>
					<path d="M27.1166 15.6211L27.8664 17.9101H23.9199L25.0447 16.2723L25.8734 17.18L27.1166 15.6211Z" fill="#0c50ff"/>
					<circle cx="24.2532" cy="15.8548" r="0.315721" fill="#0c50ff"/>
					<line x1="22.334" y1="23.5618" x2="25.5047" y2="23.5618" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="26.1367" y1="23.5618" x2="29.3074" y2="23.5618" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="22.334" y1="22.2923" x2="30.5777" y2="22.2923" stroke="#A0C1FF" stroke-width="0.634134"/>
					<rect x="32.4811" y="13.3171" width="8.24374" height="6.97547" stroke="#0c50ff" stroke-width="0.634134"/>
					<path d="M37.2631 15.6211L38.0129 17.9101H34.0664L35.1912 16.2723L36.0199 17.18L37.2631 15.6211Z" fill="#0c50ff"/>
					<circle cx="34.3997" cy="15.8548" r="0.315721" fill="#0c50ff"/>
					<line x1="32.4805" y1="23.5618" x2="35.6511" y2="23.5618" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="36.2832" y1="23.5618" x2="39.4539" y2="23.5618" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="32.4805" y1="22.2923" x2="40.7242" y2="22.2923" stroke="#A0C1FF" stroke-width="0.634134"/>
					<rect x="22.3346" y="26.5319" width="8.24374" height="6.97547" stroke="#0c50ff" stroke-width="0.634134"/>
					<path d="M27.1166 28.8359L27.8664 31.1249H23.9199L25.0447 29.4871L25.8734 30.3948L27.1166 28.8359Z" fill="#0c50ff"/>
					<circle cx="24.2532" cy="29.0696" r="0.315721" fill="#0c50ff"/>
					<line x1="22.334" y1="36.7767" x2="25.5047" y2="36.7767" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="26.1367" y1="36.7767" x2="29.3074" y2="36.7767" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="22.334" y1="35.5072" x2="30.5777" y2="35.5072" stroke="#A0C1FF" stroke-width="0.634134"/>
					<rect x="32.4811" y="26.5319" width="8.24374" height="6.97547" stroke="#0c50ff" stroke-width="0.634134"/>
					<path d="M37.2631 28.8359L38.0129 31.1249H34.0664L35.1912 29.4871L36.0199 30.3948L37.2631 28.8359Z" fill="#0c50ff"/>
					<circle cx="34.3997" cy="29.0696" r="0.315721" fill="#0c50ff"/>
					<line x1="32.4805" y1="36.7767" x2="35.6511" y2="36.7767" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="36.2832" y1="36.7767" x2="39.4539" y2="36.7767" stroke="#A0C1FF" stroke-width="0.634134"/>
					<line x1="32.4805" y1="35.5072" x2="40.7242" y2="35.5072" stroke="#A0C1FF" stroke-width="0.634134"/>
				</svg>

				<p>
					<?php esc_html_e( 'Magazine Grid', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--magazine-grid' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="magazine-grid" id="cozy-block--magazine-grid" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/magazine-list-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="1" width="48" height="48" rx="11" stroke="#0C50FF" stroke-width="2"/>
					<rect x="10" y="12.5" width="14" height="11" stroke="#0c50ff"/>
					<path d="M18.541 16.125L19.7235 19.7346H13.5L15.2737 17.1519L16.5806 18.5833L18.541 16.125Z" fill="#0c50ff"/>
					<circle cx="14.0272" cy="16.4979" r="0.497878" fill="#0c50ff"/>
					<line x1="27.5" y1="17.5" x2="32.5" y2="17.5" stroke="#9FC0FF"/>
					<line x1="33.5" y1="17.5" x2="38.5" y2="17.5" stroke="#9FC0FF"/>
					<line x1="27.5" y1="14.5" x2="40.5" y2="14.5" stroke="#9FC0FF"/>
					<line x1="27.5" y1="20.5" x2="35.5" y2="20.5" stroke="#9FC0FF"/>
					<line x1="9.5" y1="31.5" x2="14.5" y2="31.5" stroke="#9FC0FF"/>
					<line x1="15.5" y1="31.5" x2="20.5" y2="31.5" stroke="#9FC0FF"/>
					<line x1="9.5" y1="28.5" x2="22.5" y2="28.5" stroke="#9FC0FF"/>
					<line x1="9.5" y1="34.5" x2="17.5" y2="34.5" stroke="#9FC0FF"/>
					<rect x="26" y="26.5" width="14" height="11" stroke="#0c50ff"/>
					<path d="M34.541 30.125L35.7235 33.7346H29.5L31.2737 31.1519L32.5806 32.5833L34.541 30.125Z" fill="#0c50ff"/>
					<circle cx="30.0272" cy="30.4979" r="0.497878" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Magazine List', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--magazine-list' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="magazine-list" id="cozy-block--magazine-list" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/news-ticker-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<circle cx="13" cy="25" r="3" fill="#0c50ff"/>
					<circle cx="24" cy="25" r="3" fill="#0c50ff"/>
					<circle cx="35" cy="25" r="3" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'News Ticker', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--news-ticker' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="news-ticker" id="cozy-block--news-ticker" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/popular-post-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<path d="M21.3096 30.4863L17.5967 33.8281C16.4881 34.8254 14.8155 34.8569 13.6699 33.9023L12 32.5117L13.2812 30.9746L14.9502 32.3662C15.3321 32.6843 15.8893 32.6732 16.2588 32.3408L19.9717 29L21.3096 30.4863ZM35.6406 33.7432H23.6406V31.7432H35.6406V33.7432ZM21.3096 22.4863L17.5967 25.8281C16.4881 26.8254 14.8155 26.8569 13.6699 25.9023L12 24.5117L13.2812 22.9746L14.9502 24.3662C15.3321 24.6843 15.8893 24.6732 16.2588 24.3408L19.9717 21L21.3096 22.4863ZM35.6406 25.7432H23.6406V23.7432H35.6406V25.7432ZM21.3096 14.4863L17.5967 17.8281C16.4881 18.8254 14.8155 18.8569 13.6699 17.9023L12 16.5117L13.2812 14.9746L14.9502 16.3662C15.3321 16.6843 15.8893 16.6732 16.2588 16.3408L19.9717 13L21.3096 14.4863ZM35.6406 17.7432H23.6406V15.7432H35.6406V17.7432Z" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Popular Post', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--popular-post' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="popular-post" id="cozy-block--popular-post" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/post-carousel-gutenberg-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<rect x="9.05469" y="14.0547" width="11.447" height="11.447" stroke="#0c50ff"/>
					<path d="M19.4463 12.9707H7.97266V24.4463H7V12H19.4463V12.9707Z" fill="#0c50ff"/>
					<path d="M16.707 19.1289L17.8895 22.7385H11.666L13.4397 20.1558L14.7466 21.5872L16.707 19.1289Z" fill="#0c50ff"/>
					<circle cx="12.1932" cy="19.5018" r="0.497878" fill="#0c50ff"/>
					<line x1="7.5" y1="30.5" x2="12.5" y2="30.5" stroke="#A0C1FF"/>
					<line x1="13.5" y1="30.5" x2="18.5" y2="30.5" stroke="#A0C1FF"/>
					<line x1="7.5" y1="28.5" x2="20.5" y2="28.5" stroke="#A0C1FF"/>
					<line x1="7.5" y1="32.5" x2="15.5" y2="32.5" stroke="#A0C1FF"/>
					<rect x="26.0566" y="14.0547" width="11.447" height="11.447" stroke="#0c50ff"/>
					<path d="M36.4482 12.9707H24.9746V24.4463H24.002V12H36.4482V12.9707Z" fill="#0c50ff"/>
					<path d="M33.709 19.1289L34.8914 22.7385H28.668L30.4417 20.1558L31.7486 21.5872L33.709 19.1289Z" fill="#0c50ff"/>
					<circle cx="29.1951" cy="19.5018" r="0.497878" fill="#0c50ff"/>
					<line x1="24.502" y1="30.5" x2="29.502" y2="30.5" stroke="#A0C1FF"/>
					<line x1="30.502" y1="30.5" x2="35.502" y2="30.5" stroke="#A0C1FF"/>
					<line x1="24.502" y1="28.5" x2="37.502" y2="28.5" stroke="#A0C1FF"/>
					<line x1="24.502" y1="32.5" x2="32.502" y2="32.5" stroke="#A0C1FF"/>
					<rect x="18.5" y="38" width="2" height="2" rx="1" fill="#CAD5F2"/>
					<rect x="22.5" y="38" width="2" height="2" rx="1" fill="#0c50ff"/>
					<rect x="26.5" y="38" width="2" height="2" rx="1" fill="#CAD5F2"/>
				</svg>

				<?php esc_html_e( 'Post Grid/Carousel', 'cozy-addons' ); ?>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php
				$checked = get_option( 'cozy-block--post-carousel' );
				?>
				<input type="checkbox" class="cozy-block-active" name="post-carousel" id="cozy-block--post-carousel" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<span class="cozy-toggle-slider round"></span>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/post-comments-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 46 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M23 2.83984C35.6075 2.83984 45.9997 12.1238 46 23.7773C46 35.4312 35.6077 44.7148 23 44.7148C19.7978 44.7148 16.7448 44.1191 13.9697 43.04C13.9599 43.0362 13.954 43.0368 13.9521 43.0371L4.04492 47.0088C2.28436 47.7143 0.622086 45.8013 1.56641 44.1562L5.4707 37.3555V37.3496C5.46961 37.3413 5.46505 37.3301 5.45508 37.3193C2.06149 33.6788 0 28.952 0 23.7773C0.000292769 12.1238 10.3925 2.83984 23 2.83984ZM23 4.83984C11.3073 4.83984 2.00028 13.409 2 23.7773C2 28.4032 3.83948 32.6525 6.91797 35.9551C7.5105 36.5907 7.65946 37.56 7.20508 38.3516L3.30078 45.1523L13.208 41.1807C13.693 40.9862 14.2245 40.9932 14.6943 41.1758C17.239 42.1653 20.0466 42.7148 23 42.7148L23.5459 42.709C34.9812 42.4472 44 33.984 44 23.7773C43.9997 13.409 34.6927 4.83984 23 4.83984ZM28 25.9961C28.5523 25.9961 29 26.4438 29 26.9961C29 27.5484 28.5523 27.9961 28 27.9961H11C10.4477 27.9961 10 27.5484 10 26.9961C10 26.4438 10.4477 25.9961 11 25.9961H28ZM28 19.9961C28.5523 19.9961 29 20.4438 29 20.9961C29 21.5484 28.5523 21.9961 28 21.9961H11C10.4477 21.9961 10 21.5484 10 20.9961C10 20.4438 10.4477 19.9961 11 19.9961H28Z" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Post Comments', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--post-comments' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="post-comments" id="cozy-block--post-comments" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/post-slider-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="18.9902" y="44.5" width="3" height="3" rx="1.5" fill="#CAD5F2"/>
					<rect x="24.9902" y="44.5" width="3" height="3" rx="1.5" fill="#0c50ff"/>
					<rect x="30.9902" y="44.5" width="3" height="3" rx="1.5" fill="#CAD5F2"/>
					<path d="M35.5039 2.5C42.1313 2.5 47.5039 7.87258 47.5039 14.5V28.5C47.5039 35.0239 42.2978 40.3319 35.8135 40.4961L35.5039 40.5H15.5039L15.1943 40.4961C8.71 40.3319 3.50391 35.0239 3.50391 28.5V14.5C3.50391 7.87259 8.8765 2.50001 15.5039 2.5H35.5039ZM15.5039 4.5C10.1537 4.50001 5.78445 8.70168 5.5166 13.9854L5.50391 14.5V28.5C5.50391 34.0228 9.98107 38.5 15.5039 38.5H35.5039C41.0268 38.5 45.5039 34.0228 45.5039 28.5V14.5C45.5039 8.97715 41.0268 4.5 35.5039 4.5H15.5039ZM1.00684 17.5C1.55901 17.5007 2.0064 17.9488 2.00586 18.501L2 23.001L2.00586 27.499C2.0064 28.0512 1.55901 28.4993 1.00684 28.5C0.454701 28.5005 0.00657835 28.0532 0.00585938 27.501L0 23.001V22.999L0.00585938 18.499C0.00657835 17.9468 0.454701 17.4995 1.00684 17.5ZM50.0049 17.5C50.5568 17.501 51.0044 17.949 51.0039 18.501L50.998 23.001L51.0039 27.499C51.0044 28.051 50.5568 28.499 50.0049 28.5C49.4527 28.5005 49.0046 28.0532 49.0039 27.501L48.998 23.001V22.999L49.0039 18.499C49.0046 17.9468 49.4527 17.4995 50.0049 17.5Z" fill="#0c50ff"/>
					<rect x="13.0566" y="16.0547" width="11.447" height="11.447" stroke="#0c50ff"/>
					<path d="M23.4482 14.9707H11.9746V26.4463H11.002V14H23.4482V14.9707Z" fill="#0c50ff"/>
					<path d="M20.709 21.1289L21.8914 24.7385H15.668L17.4417 22.1558L18.7486 23.5872L20.709 21.1289Z" fill="#0c50ff"/>
					<circle cx="16.1951" cy="21.5018" r="0.497878" fill="#0c50ff"/>
					<line x1="28.0039" y1="20.5" x2="33.0039" y2="20.5" stroke="#0c50ff"/>
					<line x1="34.0039" y1="20.5" x2="39.0039" y2="20.5" stroke="#0c50ff"/>
					<line x1="28.0039" y1="17.5" x2="41.0039" y2="17.5" stroke="#0c50ff"/>
					<line x1="28.0039" y1="23.5" x2="36.0039" y2="23.5" stroke="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Post Slider', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--post-slider' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="post-slider" id="cozy-block--post-slider" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/post-views-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M23.6386 6.62682C10.4276 8.25449 3.33028 18.6645 1.12154 24.3431C0.931564 24.8315 0.966059 25.3657 1.20724 25.831C3.74265 30.7222 12.1603 43.99 27.0819 43.4497C38.9031 43.0217 46.1016 32.0002 48.555 26.2295C48.7492 25.7726 48.7447 25.2556 48.5577 24.7958C42.3261 9.46836 29.8773 5.8827 23.6386 6.62682Z" stroke="#0c50ff" stroke-width="2"/>
					<circle cx="25.1219" cy="25.9032" r="9.61492" stroke="#0c50ff" stroke-width="2.32653"/>
					<mask id="path-3-inside-1_3074_1846" fill="white">
					<path d="M25.1201 15.1289C31.0725 15.129 35.8982 19.9539 35.8984 25.9062C35.8984 31.8588 31.0726 36.6845 25.1201 36.6846C19.1675 36.6846 14.3418 31.8589 14.3418 25.9062C14.3418 25.1716 14.4156 24.4541 14.5557 23.7607C15.6573 25.1338 17.3478 26.0136 19.2451 26.0137C22.5648 26.0137 25.2559 23.3227 25.2559 20.0029C25.2558 18.1169 24.3864 16.435 23.0273 15.333C23.7044 15.1998 24.404 15.1289 25.1201 15.1289Z"/>
					</mask>
					<path d="M25.1201 15.1289L25.1202 12.8024H25.1201V15.1289ZM35.8984 25.9062H38.225V25.9062L35.8984 25.9062ZM25.1201 36.6846V39.0111H25.1202L25.1201 36.6846ZM14.3418 25.9062L12.0153 25.9062V25.9062H14.3418ZM14.5557 23.7607L16.3703 22.3048L13.2596 18.4276L12.2752 23.3L14.5557 23.7607ZM19.2451 26.0137L19.2451 28.3402H19.2451V26.0137ZM25.2559 20.0029H27.5824V20.0029L25.2559 20.0029ZM23.0273 15.333L22.5781 13.0503L17.7016 14.0099L21.562 17.1401L23.0273 15.333ZM25.1201 15.1289L25.1201 17.4554C29.7878 17.4555 33.5717 21.239 33.5719 25.9063L35.8984 25.9062L38.225 25.9062C38.2247 18.6687 32.3572 12.8025 25.1202 12.8024L25.1201 15.1289ZM35.8984 25.9062H33.5719C33.5719 30.5739 29.7878 34.358 25.1201 34.358L25.1201 36.6846L25.1202 39.0111C32.3575 39.011 38.225 33.1438 38.225 25.9062H35.8984ZM25.1201 36.6846V34.358C20.4524 34.358 16.6683 30.574 16.6683 25.9062H14.3418H12.0153C12.0153 33.1438 17.8826 39.0111 25.1201 39.0111V36.6846ZM14.3418 25.9062L16.6683 25.9063C16.6683 25.3277 16.7264 24.7645 16.8361 24.2215L14.5557 23.7607L12.2752 23.3C12.1048 24.1437 12.0153 25.0154 12.0153 25.9062L14.3418 25.9062ZM14.5557 23.7607L12.741 25.2167C14.2644 27.1154 16.6112 28.3401 19.2451 28.3402L19.2451 26.0137L19.2452 23.6871C18.0845 23.6871 17.0502 23.1522 16.3703 22.3048L14.5557 23.7607ZM19.2451 26.0137V28.3402C23.8498 28.3402 27.5824 24.6076 27.5824 20.0029H25.2559H22.9293C22.9293 22.0378 21.2799 23.6871 19.2451 23.6871V26.0137ZM25.2559 20.0029L27.5824 20.0029C27.5823 17.3847 26.3722 15.0499 24.4926 13.5259L23.0273 15.333L21.562 17.1401C22.4007 17.8201 22.9293 18.849 22.9293 20.003L25.2559 20.0029ZM23.0273 15.333L23.4765 17.6158C24.0087 17.511 24.558 17.4554 25.1201 17.4554V15.1289V12.8024C24.2501 12.8024 23.4 12.8885 22.5781 13.0503L23.0273 15.333Z" fill="#0c50ff" mask="url(#path-3-inside-1_3074_1846)"/>
				</svg>

				<p>
					<?php esc_html_e( 'Post Views', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--post-views' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="post-views" id="cozy-block--post-views" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/related-post-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 56 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="0.75" y="7.85938" width="24.5" height="22.5" rx="5.25" stroke="#0c50ff" stroke-width="1.5"/>
					<path d="M16.72 16.1094L19 23.1094H7L10.42 18.1008L12.94 20.8766L16.72 16.1094Z" fill="#0c50ff"/>
					<circle cx="8" cy="17.1094" r="1" fill="#0c50ff"/>
					<path d="M2 34.8906H10" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M12 34.8906H21" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M2 38.8906H24" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M2 42.8906H15" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
					<rect x="30.5332" y="7.85938" width="24.5" height="22.5" rx="5.25" stroke="#0c50ff" stroke-width="1.5"/>
					<path d="M46.5032 16.1094L48.7832 23.1094H36.7832L40.2032 18.1008L42.7232 20.8766L46.5032 16.1094Z" fill="#0c50ff"/>
					<circle cx="37.7832" cy="17.1094" r="1" fill="#0c50ff"/>
					<path d="M31.7832 34.8906H39.7832" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M41.7832 34.8906H50.7832" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M31.7832 38.8906H53.7832" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M31.7832 42.8906H44.7832" stroke="#0c50ff" stroke-width="1.5" stroke-linecap="round"/>
				</svg>

				<p>
					<?php esc_html_e( 'Related Post', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--related-post' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="related-post" id="cozy-block--related-post" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/trending-post-gutenberg-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<rect x="8.5" y="12.5" width="14" height="11" rx="2.5" stroke="#0c50ff"/>
					<path d="M18.0498 16C18.2983 16 18.5 16.2017 18.5 16.4502V18.25C18.5 18.3881 18.3881 18.5 18.25 18.5C18.1119 18.5 18 18.3881 18 18.25V16.8535L16.2168 18.6367C15.964 18.8895 15.568 18.9287 15.2705 18.7305L14.4521 18.1855C14.353 18.1195 14.221 18.1326 14.1367 18.2168L13.4268 18.9268C13.3291 19.0244 13.1709 19.0244 13.0732 18.9268C12.9756 18.8291 12.9756 18.6709 13.0732 18.5732L13.7832 17.8633C14.036 17.6105 14.432 17.5713 14.7295 17.7695L15.5479 18.3145C15.647 18.3805 15.779 18.3674 15.8633 18.2832L17.6465 16.5H16.25C16.1119 16.5 16 16.3881 16 16.25C16 16.1119 16.1119 16 16.25 16H18.0498Z" fill="#0c50ff"/>
					<line x1="26" y1="17.5" x2="31" y2="17.5" stroke="#9FC0FF"/>
					<line x1="32" y1="17.5" x2="37" y2="17.5" stroke="#9FC0FF"/>
					<line x1="26" y1="14.5" x2="39" y2="14.5" stroke="#9FC0FF"/>
					<line x1="26" y1="20.5" x2="34" y2="20.5" stroke="#9FC0FF"/>
					<rect x="8.5" y="26.5" width="14" height="11" rx="2.5" stroke="#0c50ff"/>
					<path d="M18.0498 30C18.2983 30 18.5 30.2017 18.5 30.4502V32.25C18.5 32.3881 18.3881 32.5 18.25 32.5C18.1119 32.5 18 32.3881 18 32.25V30.8535L16.2168 32.6367C15.964 32.8895 15.568 32.9287 15.2705 32.7305L14.4521 32.1855C14.353 32.1195 14.221 32.1326 14.1367 32.2168L13.4268 32.9268C13.3291 33.0244 13.1709 33.0244 13.0732 32.9268C12.9756 32.8291 12.9756 32.6709 13.0732 32.5732L13.7832 31.8633C14.036 31.6105 14.432 31.5713 14.7295 31.7695L15.5479 32.3145C15.647 32.3805 15.779 32.3674 15.8633 32.2832L17.6465 30.5H16.25C16.1119 30.5 16 30.3881 16 30.25C16 30.1119 16.1119 30 16.25 30H18.0498Z" fill="#0c50ff"/>
					<line x1="26" y1="31.5" x2="31" y2="31.5" stroke="#9FC0FF"/>
					<line x1="32" y1="31.5" x2="37" y2="31.5" stroke="#9FC0FF"/>
					<line x1="26" y1="28.5" x2="39" y2="28.5" stroke="#9FC0FF"/>
					<line x1="26" y1="34.5" x2="34" y2="34.5" stroke="#9FC0FF"/>
				</svg>

				<p>
					<?php esc_html_e( 'Trending Post', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--trending-post' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() ? 'cozy-block-upsell' : ''; ?>" name="trending-post" id="cozy-block--trending-post" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php esc_html_e( 'Please', 'cozy-addons' ); ?> <a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a> <?php esc_html_e( ' to enable this block!', 'cozy-addons' ); ?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>
</ul>

<!-- WooCommerce Blocks -->
<h2 class="mt-34"><?php esc_html_e( 'WooCommerce Blocks', 'cozy-addons' ); ?></h2>
<ul class="blocks-holder">
	<li>
		<a href="https://cozyblock.cozythemes.com/product-add-to-cart-woocommerce-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 54 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M38.3096 3.00391C44.7939 3.16811 50 8.47608 50 15V25H48V15C48 9.64975 43.7983 5.28054 38.5146 5.0127L38 5H12C6.47715 5 2 9.47715 2 15V35C2 40.5228 6.47715 45 12 45H31V47H12C5.47608 47 0.168106 41.7939 0.00390625 35.3096L0 35V15C0 8.47608 5.20608 3.16811 11.6904 3.00391L12 3H38L38.3096 3.00391Z" fill="#0c50ff"/>
					<path d="M31.5 25H25.0714H19.5" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M25 19V25.4286V31" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M40.25 40.25C41.6307 40.25 42.75 41.3693 42.75 42.75C42.75 44.1307 41.6307 45.25 40.25 45.25C38.8693 45.25 37.75 44.1307 37.75 42.75C37.75 41.3693 38.8693 40.25 40.25 40.25ZM49.25 40.25C50.6307 40.25 51.75 41.3693 51.75 42.75C51.75 44.1307 50.6307 45.25 49.25 45.25C47.8693 45.25 46.75 44.1307 46.75 42.75C46.75 41.3693 47.8693 40.25 49.25 40.25ZM49.25 41.75C48.6977 41.75 48.25 42.1977 48.25 42.75C48.25 43.3023 48.6977 43.75 49.25 43.75C49.8023 43.75 50.25 43.3023 50.25 42.75C50.25 42.1977 49.8023 41.75 49.25 41.75ZM40.25 41.75C39.6977 41.75 39.25 42.1977 39.25 42.75C39.25 43.3023 39.6977 43.75 40.25 43.75C40.8023 43.75 41.25 43.3023 41.25 42.75C41.25 42.1977 40.8023 41.75 40.25 41.75ZM37.4814 27.584L38.0303 30H52.8662C53.5491 30.0003 54.0504 30.6421 53.8848 31.3047L52.0342 38.7051C51.9172 39.1723 51.4973 39.5 51.0156 39.5H39.4893C38.9991 39.4999 38.5745 39.1606 38.4658 38.6826L36.7002 30.916L36.1514 28.5H33.75C33.3358 28.5 33 28.1642 33 27.75C33 27.3358 33.3358 27 33.75 27H37.3486L37.4814 27.584ZM39.8486 38H50.6641L52.29 31.5H38.3711L39.8486 38Z" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Add to Cart', 'cozy-addons' ); ?>
				</p>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo ! is_woocommerce_active() ? '<span class="cozy-toggle-slider round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--add-to-cart' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="add-to-cart" id="cozy-block--add-to-cart" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<?php if ( ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/featured-product-woocommerce-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="1" width="48" height="48" rx="11" stroke="#0c50ff" stroke-width="2"/>
					<rect x="10.5" y="8.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M15.4414 15.4619C15.9063 15.4619 16.283 15.8389 16.2832 16.3037C16.2832 16.7687 15.9064 17.1455 15.4414 17.1455C14.9766 17.1453 14.5996 16.7686 14.5996 16.3037C14.5998 15.839 14.9767 15.4621 15.4414 15.4619ZM18.4736 15.4619C18.9383 15.4621 19.3152 15.839 19.3154 16.3037C19.3154 16.7686 18.9384 17.1453 18.4736 17.1455C18.0087 17.1454 17.6318 16.7687 17.6318 16.3037C17.632 15.8389 18.0088 15.462 18.4736 15.4619ZM18.4736 15.9668C18.2878 15.9669 18.1369 16.1179 18.1367 16.3037C18.1367 16.4897 18.2877 16.6405 18.4736 16.6406C18.6595 16.6404 18.8105 16.4896 18.8105 16.3037C18.8104 16.118 18.6593 15.967 18.4736 15.9668ZM15.4414 15.9668C15.2557 15.967 15.1047 16.118 15.1045 16.3037C15.1045 16.4896 15.2556 16.6404 15.4414 16.6406C15.6274 16.6406 15.7783 16.4897 15.7783 16.3037C15.7781 16.1179 15.6273 15.9668 15.4414 15.9668ZM14.5098 11.1973L14.6943 12.0107H19.6904C19.9203 12.0109 20.0898 12.2272 20.0342 12.4502L19.4111 14.9424C19.3718 15.0997 19.2295 15.2099 19.0674 15.21H15.1855C15.0206 15.2098 14.8774 15.0955 14.8408 14.9346L14.2471 12.3193L14.0615 11.5059H13.2529C13.1134 11.5059 13 11.3924 13 11.2529C13.0001 11.1135 13.1135 11 13.2529 11H14.4648L14.5098 11.1973ZM15.3066 14.7051H18.9492L19.4971 12.5156H14.8096L15.3066 14.7051Z" fill="#0c50ff"/>
					<line x1="10.5" y1="23.5" x2="15.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="16.5" y1="23.5" x2="21.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="10.5" y1="21.5" x2="23.5" y2="21.5" stroke="#A0C1FF"/>
					<rect x="26.5" y="8.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M31.4414 15.4619C31.9063 15.4619 32.283 15.8389 32.2832 16.3037C32.2832 16.7687 31.9064 17.1455 31.4414 17.1455C30.9766 17.1453 30.5996 16.7686 30.5996 16.3037C30.5998 15.839 30.9767 15.4621 31.4414 15.4619ZM34.4736 15.4619C34.9383 15.4621 35.3152 15.839 35.3154 16.3037C35.3154 16.7686 34.9384 17.1453 34.4736 17.1455C34.0087 17.1454 33.6318 16.7687 33.6318 16.3037C33.632 15.8389 34.0088 15.462 34.4736 15.4619ZM34.4736 15.9668C34.2878 15.9669 34.1369 16.1179 34.1367 16.3037C34.1367 16.4897 34.2877 16.6405 34.4736 16.6406C34.6595 16.6404 34.8105 16.4896 34.8105 16.3037C34.8104 16.118 34.6593 15.967 34.4736 15.9668ZM31.4414 15.9668C31.2557 15.967 31.1047 16.118 31.1045 16.3037C31.1045 16.4896 31.2556 16.6404 31.4414 16.6406C31.6274 16.6406 31.7783 16.4897 31.7783 16.3037C31.7781 16.1179 31.6273 15.9668 31.4414 15.9668ZM30.5098 11.1973L30.6943 12.0107H35.6904C35.9203 12.0109 36.0898 12.2272 36.0342 12.4502L35.4111 14.9424C35.3718 15.0997 35.2295 15.2099 35.0674 15.21H31.1855C31.0206 15.2098 30.8774 15.0955 30.8408 14.9346L30.2471 12.3193L30.0615 11.5059H29.2529C29.1134 11.5059 29 11.3924 29 11.2529C29.0001 11.1135 29.1135 11 29.2529 11H30.4648L30.5098 11.1973ZM31.3066 14.7051H34.9492L35.4971 12.5156H30.8096L31.3066 14.7051Z" fill="#0c50ff"/>
					<line x1="26.5" y1="23.5" x2="31.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="32.5" y1="23.5" x2="37.5" y2="23.5" stroke="#A0C1FF"/>
					<line x1="26.5" y1="21.5" x2="39.5" y2="21.5" stroke="#A0C1FF"/>
					<rect x="10.5" y="27.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M15.4414 34.4619C15.9063 34.4619 16.283 34.8389 16.2832 35.3037C16.2832 35.7687 15.9064 36.1455 15.4414 36.1455C14.9766 36.1453 14.5996 35.7686 14.5996 35.3037C14.5998 34.839 14.9767 34.4621 15.4414 34.4619ZM18.4736 34.4619C18.9383 34.4621 19.3152 34.839 19.3154 35.3037C19.3154 35.7686 18.9384 36.1453 18.4736 36.1455C18.0087 36.1454 17.6318 35.7687 17.6318 35.3037C17.632 34.8389 18.0088 34.462 18.4736 34.4619ZM18.4736 34.9668C18.2878 34.9669 18.1369 35.1179 18.1367 35.3037C18.1367 35.4897 18.2877 35.6405 18.4736 35.6406C18.6595 35.6404 18.8105 35.4896 18.8105 35.3037C18.8104 35.118 18.6593 34.967 18.4736 34.9668ZM15.4414 34.9668C15.2557 34.967 15.1047 35.118 15.1045 35.3037C15.1045 35.4896 15.2556 35.6404 15.4414 35.6406C15.6274 35.6406 15.7783 35.4897 15.7783 35.3037C15.7781 35.1179 15.6273 34.9668 15.4414 34.9668ZM14.5098 30.1973L14.6943 31.0107H19.6904C19.9203 31.0109 20.0898 31.2272 20.0342 31.4502L19.4111 33.9424C19.3718 34.0997 19.2295 34.2099 19.0674 34.21H15.1855C15.0206 34.2098 14.8774 34.0955 14.8408 33.9346L14.2471 31.3193L14.0615 30.5059H13.2529C13.1134 30.5059 13 30.3924 13 30.2529C13.0001 30.1135 13.1135 30 13.2529 30H14.4648L14.5098 30.1973ZM15.3066 33.7051H18.9492L19.4971 31.5156H14.8096L15.3066 33.7051Z" fill="#0c50ff"/>
					<line x1="10.5" y1="42.5" x2="15.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="16.5" y1="42.5" x2="21.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="10.5" y1="40.5" x2="23.5" y2="40.5" stroke="#A0C1FF"/>
					<rect x="26.5" y="27.5" width="13" height="11" stroke="#0c50ff"/>
					<path d="M31.4414 34.4619C31.9063 34.4619 32.283 34.8389 32.2832 35.3037C32.2832 35.7687 31.9064 36.1455 31.4414 36.1455C30.9766 36.1453 30.5996 35.7686 30.5996 35.3037C30.5998 34.839 30.9767 34.4621 31.4414 34.4619ZM34.4736 34.4619C34.9383 34.4621 35.3152 34.839 35.3154 35.3037C35.3154 35.7686 34.9384 36.1453 34.4736 36.1455C34.0087 36.1454 33.6318 35.7687 33.6318 35.3037C33.632 34.8389 34.0088 34.462 34.4736 34.4619ZM34.4736 34.9668C34.2878 34.9669 34.1369 35.1179 34.1367 35.3037C34.1367 35.4897 34.2877 35.6405 34.4736 35.6406C34.6595 35.6404 34.8105 35.4896 34.8105 35.3037C34.8104 35.118 34.6593 34.967 34.4736 34.9668ZM31.4414 34.9668C31.2557 34.967 31.1047 35.118 31.1045 35.3037C31.1045 35.4896 31.2556 35.6404 31.4414 35.6406C31.6274 35.6406 31.7783 35.4897 31.7783 35.3037C31.7781 35.1179 31.6273 34.9668 31.4414 34.9668ZM30.5098 30.1973L30.6943 31.0107H35.6904C35.9203 31.0109 36.0898 31.2272 36.0342 31.4502L35.4111 33.9424C35.3718 34.0997 35.2295 34.2099 35.0674 34.21H31.1855C31.0206 34.2098 30.8774 34.0955 30.8408 33.9346L30.2471 31.3193L30.0615 30.5059H29.2529C29.1134 30.5059 29 30.3924 29 30.2529C29.0001 30.1135 29.1135 30 29.2529 30H30.4648L30.5098 30.1973ZM31.3066 33.7051H34.9492L35.4971 31.5156H30.8096L31.3066 33.7051Z" fill="#0c50ff"/>
					<line x1="26.5" y1="42.5" x2="31.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="32.5" y1="42.5" x2="37.5" y2="42.5" stroke="#A0C1FF"/>
					<line x1="26.5" y1="40.5" x2="39.5" y2="40.5" stroke="#A0C1FF"/>
				</svg>

				<p>
					<?php esc_html_e( 'Featured Product', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--featured-product' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="featured-product" id="cozy-block--featured-product" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() || ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						if ( false === cozy_addons_premium_access() ) {
							esc_html_e( 'Please', 'cozy-addons' );
							?>
							<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a>
							<?php
							esc_html_e( ' to enable this block!', 'cozy-addons' );
						}
						if ( ! is_woocommerce_active() ) {
							esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						}
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/featured-products-tab-woocommerce-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="1" y="8.5" width="46" height="38" rx="11" stroke="#0c50ff" stroke-width="2"/>
					<rect x="10" y="19.5" width="13.9984" height="11.447" stroke="#0c50ff"/>
					<path d="M15.0371 26.5947C15.502 26.5947 15.8787 26.9717 15.8789 27.4365C15.8789 27.9015 15.5021 28.2783 15.0371 28.2783C14.5723 28.2781 14.1953 27.9014 14.1953 27.4365C14.1955 26.9718 14.5724 26.595 15.0371 26.5947ZM18.0693 26.5947C18.534 26.5949 18.9109 26.9718 18.9111 27.4365C18.9111 27.9014 18.5342 28.2781 18.0693 28.2783C17.6044 28.2782 17.2275 27.9015 17.2275 27.4365C17.2277 26.9717 17.6045 26.5948 18.0693 26.5947ZM18.0693 27.0996C17.8835 27.0997 17.7326 27.2507 17.7324 27.4365C17.7324 27.6225 17.8834 27.7734 18.0693 27.7734C18.2552 27.7732 18.4062 27.6224 18.4062 27.4365C18.4061 27.2508 18.255 27.0998 18.0693 27.0996ZM15.0371 27.0996C14.8514 27.0998 14.7004 27.2508 14.7002 27.4365C14.7002 27.6224 14.8513 27.7732 15.0371 27.7734C15.2231 27.7734 15.374 27.6225 15.374 27.4365C15.3738 27.2507 15.223 27.0996 15.0371 27.0996ZM14.1055 22.3301L14.29 23.1436H19.2861C19.516 23.1437 19.6855 23.36 19.6299 23.583L19.0068 26.0752C18.9675 26.2325 18.8252 26.3427 18.6631 26.3428H14.7812C14.6163 26.3426 14.4731 26.2283 14.4365 26.0674L13.8428 23.4521L13.6572 22.6387H12.8486C12.7091 22.6387 12.5957 22.5252 12.5957 22.3857C12.5958 22.2463 12.7092 22.1328 12.8486 22.1328H14.0605L14.1055 22.3301ZM14.9023 25.8379H18.5449L19.0928 23.6484H14.4053L14.9023 25.8379Z" fill="#0c50ff"/>
					<line x1="10.5" y1="33.9453" x2="23.5" y2="33.9453" stroke="#A0C1FF"/>
					<line x1="11.5" y1="35.9453" x2="16.5" y2="35.9453" stroke="#A0C1FF"/>
					<line x1="17.5" y1="35.9453" x2="22.5" y2="35.9453" stroke="#A0C1FF"/>
					<line x1="13" y1="37.9453" x2="21" y2="37.9453" stroke="#A0C1FF"/>
					<rect x="27.998" y="19.5" width="13.9984" height="11.447" stroke="#0c50ff"/>
					<path d="M33.0352 26.5947C33.5 26.5947 33.8768 26.9717 33.877 27.4365C33.877 27.9015 33.5002 28.2783 33.0352 28.2783C32.5704 28.2781 32.1934 27.9014 32.1934 27.4365C32.1936 26.9718 32.5705 26.595 33.0352 26.5947ZM36.0674 26.5947C36.5321 26.5949 36.909 26.9718 36.9092 27.4365C36.9092 27.9014 36.5322 28.2781 36.0674 28.2783C35.6025 28.2782 35.2256 27.9015 35.2256 27.4365C35.2258 26.9717 35.6026 26.5948 36.0674 26.5947ZM36.0674 27.0996C35.8816 27.0997 35.7307 27.2507 35.7305 27.4365C35.7305 27.6225 35.8815 27.7734 36.0674 27.7734C36.2532 27.7732 36.4043 27.6224 36.4043 27.4365C36.4041 27.2508 36.2531 27.0998 36.0674 27.0996ZM33.0352 27.0996C32.8495 27.0998 32.6984 27.2508 32.6982 27.4365C32.6982 27.6224 32.8494 27.7732 33.0352 27.7734C33.2212 27.7734 33.3721 27.6225 33.3721 27.4365C33.3719 27.2507 33.221 27.0996 33.0352 27.0996ZM32.1035 22.3301L32.2881 23.1436H37.2842C37.514 23.1437 37.6835 23.36 37.6279 23.583L37.0049 26.0752C36.9655 26.2325 36.8233 26.3427 36.6611 26.3428H32.7793C32.6143 26.3426 32.4711 26.2283 32.4346 26.0674L31.8408 23.4521L31.6553 22.6387H30.8467C30.7072 22.6387 30.5938 22.5252 30.5938 22.3857C30.5938 22.2463 30.7072 22.1328 30.8467 22.1328H32.0586L32.1035 22.3301ZM32.9004 25.8379H36.543L37.0908 23.6484H32.4033L32.9004 25.8379Z" fill="#0c50ff"/>
					<line x1="28.498" y1="33.9453" x2="41.498" y2="33.9453" stroke="#A0C1FF"/>
					<line x1="29.498" y1="35.9453" x2="34.498" y2="35.9453" stroke="#A0C1FF"/>
					<line x1="35.498" y1="35.9453" x2="40.498" y2="35.9453" stroke="#A0C1FF"/>
					<line x1="30.998" y1="37.9453" x2="38.998" y2="37.9453" stroke="#A0C1FF"/>
					<rect x="11" y="2.5" width="8" height="4" rx="2" fill="#0c50ff"/>
					<rect x="20" y="2.5" width="8" height="4" rx="2" fill="#0c50ff"/>
					<rect x="29" y="2.5" width="8" height="4" rx="2" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Featured Product Tabs', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--featured-product-tabs' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="featured-product-tabs" id="cozy-block--featured-product-tabs" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() || ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						if ( false === cozy_addons_premium_access() ) {
							esc_html_e( 'Please', 'cozy-addons' );
							?>
							<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a>
							<?php
							esc_html_e( ' to enable this block!', 'cozy-addons' );
						}
						if ( ! is_woocommerce_active() ) {
							esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						}
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/product-categories-woocommerce-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 55 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M38.3096 3.00391C44.7939 3.16811 50 8.47608 50 15V25H48V15C48 9.64975 43.7983 5.28054 38.5146 5.0127L38 5H12C6.47715 5 2 9.47715 2 15V35C2 40.5228 6.47715 45 12 45H31V47H12C5.47608 47 0.168106 41.7939 0.00390625 35.3096L0 35V15C0 8.47608 5.20608 3.16811 11.6904 3.00391L12 3H38L38.3096 3.00391Z" fill="#0c50ff"/>
					<rect x="11.5" y="19.75" width="7" height="6" rx="1.5" stroke="#0c50ff"/>
					<rect x="21.5" y="19.75" width="7" height="6" rx="1.5" stroke="#0c50ff"/>
					<rect x="31.5" y="19.75" width="7" height="6" rx="1.5" stroke="#0c50ff"/>
					<path d="M41.25 41.25C42.6307 41.25 43.75 42.3693 43.75 43.75C43.75 45.1307 42.6307 46.25 41.25 46.25C39.8693 46.25 38.75 45.1307 38.75 43.75C38.75 42.3693 39.8693 41.25 41.25 41.25ZM50.25 41.25C51.6307 41.25 52.75 42.3693 52.75 43.75C52.75 45.1307 51.6307 46.25 50.25 46.25C48.8693 46.25 47.75 45.1307 47.75 43.75C47.75 42.3693 48.8693 41.25 50.25 41.25ZM50.25 42.75C49.6977 42.75 49.25 43.1977 49.25 43.75C49.25 44.3023 49.6977 44.75 50.25 44.75C50.8023 44.75 51.25 44.3023 51.25 43.75C51.25 43.1977 50.8023 42.75 50.25 42.75ZM41.25 42.75C40.6977 42.75 40.25 43.1977 40.25 43.75C40.25 44.3023 40.6977 44.75 41.25 44.75C41.8023 44.75 42.25 44.3023 42.25 43.75C42.25 43.1977 41.8023 42.75 41.25 42.75ZM38.4814 28.584L39.0303 31H53.8662C54.5491 31.0003 55.0504 31.6421 54.8848 32.3047L53.0342 39.7051C52.9172 40.1723 52.4973 40.5 52.0156 40.5H40.4893C39.9991 40.4999 39.5745 40.1606 39.4658 39.6826L37.7002 31.916L37.1514 29.5H34.75C34.3358 29.5 34 29.1642 34 28.75C34 28.3358 34.3358 28 34.75 28H38.3486L38.4814 28.584ZM40.8486 39H51.6641L53.29 32.5H39.3711L40.8486 39Z" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Product Category', 'cozy-addons' ); ?>
				</p>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo ! is_woocommerce_active() ? '<span class="cozy-toggle-slider round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--product-category' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="product-category" id="cozy-block--product-category" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<?php if ( ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/product-carousel-woocommerce-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 48 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M36 1C42.6274 1 48 6.37258 48 13V37C48 43.6274 42.6274 49 36 49H12C5.37258 49 0 43.6274 0 37V13C0 6.37258 5.37258 1 12 1H36ZM12 3C6.47715 3 2 7.47715 2 13V37C2 42.5228 6.47715 47 12 47H36C41.5228 47 46 42.5228 46 37V13C46 7.47715 41.5228 3 36 3H12Z" fill="#0c50ff"/>
					<rect x="9.05469" y="14.0547" width="11.447" height="11.447" stroke="#0c50ff"/>
					<path d="M19.4463 12.9707H7.97266V24.4463H7V12H19.4463V12.9707Z" fill="#0c50ff"/>
					<path d="M13.1074 21.4658C13.5723 21.4658 13.949 21.8428 13.9492 22.3076C13.9492 22.7726 13.5724 23.1494 13.1074 23.1494C12.6426 23.1492 12.2656 22.7725 12.2656 22.3076C12.2658 21.8429 12.6427 21.466 13.1074 21.4658ZM16.1396 21.4658C16.6043 21.466 16.9813 21.8429 16.9814 22.3076C16.9814 22.7725 16.6045 23.1492 16.1396 23.1494C15.6747 23.1493 15.2979 22.7726 15.2979 22.3076C15.298 21.8428 15.6748 21.4659 16.1396 21.4658ZM16.1396 21.9707C15.9538 21.9708 15.8029 22.1218 15.8027 22.3076C15.8027 22.4936 15.9537 22.6445 16.1396 22.6445C16.3255 22.6443 16.4766 22.4935 16.4766 22.3076C16.4764 22.1219 16.3253 21.9709 16.1396 21.9707ZM13.1074 21.9707C12.9217 21.9709 12.7707 22.1219 12.7705 22.3076C12.7705 22.4935 12.9216 22.6443 13.1074 22.6445C13.2934 22.6445 13.4443 22.4936 13.4443 22.3076C13.4441 22.1218 13.2933 21.9707 13.1074 21.9707ZM12.1758 17.2012L12.3604 18.0146H17.3564C17.5863 18.0148 17.7558 18.2311 17.7002 18.4541L17.0771 20.9463C17.0378 21.1036 16.8955 21.2138 16.7334 21.2139H12.8516C12.6866 21.2137 12.5434 21.0994 12.5068 20.9385L11.9131 18.3232L11.7275 17.5098H10.9189C10.7794 17.5098 10.666 17.3963 10.666 17.2568C10.6661 17.1174 10.7795 17.0039 10.9189 17.0039H12.1309L12.1758 17.2012ZM12.9727 20.709H16.6152L17.1631 18.5195H12.4756L12.9727 20.709Z" fill="#0c50ff"/>
					<line x1="7.50195" y1="30.5" x2="12.502" y2="30.5" stroke="#A0C1FF"/>
					<line x1="13.502" y1="30.5" x2="18.502" y2="30.5" stroke="#A0C1FF"/>
					<line x1="7.50195" y1="28.5" x2="20.502" y2="28.5" stroke="#A0C1FF"/>
					<line x1="7.50195" y1="32.5" x2="15.502" y2="32.5" stroke="#A0C1FF"/>
					<rect x="26.0566" y="14.0547" width="11.447" height="11.447" stroke="#0c50ff"/>
					<path d="M36.4482 12.9707H24.9746V24.4463H24.002V12H36.4482V12.9707Z" fill="#0c50ff"/>
					<path d="M30.1094 21.4658C30.5743 21.4658 30.951 21.8428 30.9512 22.3076C30.9512 22.7726 30.5744 23.1494 30.1094 23.1494C29.6446 23.1492 29.2676 22.7725 29.2676 22.3076C29.2678 21.8429 29.6447 21.466 30.1094 21.4658ZM33.1416 21.4658C33.6063 21.466 33.9832 21.8429 33.9834 22.3076C33.9834 22.7725 33.6064 23.1492 33.1416 23.1494C32.6767 23.1493 32.2998 22.7726 32.2998 22.3076C32.3 21.8428 32.6768 21.4659 33.1416 21.4658ZM33.1416 21.9707C32.9558 21.9708 32.8049 22.1218 32.8047 22.3076C32.8047 22.4936 32.9557 22.6445 33.1416 22.6445C33.3274 22.6443 33.4785 22.4935 33.4785 22.3076C33.4783 22.1219 33.3273 21.9709 33.1416 21.9707ZM30.1094 21.9707C29.9237 21.9709 29.7727 22.1219 29.7725 22.3076C29.7725 22.4935 29.9236 22.6443 30.1094 22.6445C30.2954 22.6445 30.4463 22.4936 30.4463 22.3076C30.4461 22.1218 30.2953 21.9707 30.1094 21.9707ZM29.1777 17.2012L29.3623 18.0146H34.3584C34.5883 18.0148 34.7578 18.2311 34.7021 18.4541L34.0791 20.9463C34.0397 21.1036 33.8975 21.2138 33.7354 21.2139H29.8535C29.6885 21.2137 29.5454 21.0994 29.5088 20.9385L28.915 18.3232L28.7295 17.5098H27.9209C27.7814 17.5098 27.668 17.3963 27.668 17.2568C27.6681 17.1174 27.7815 17.0039 27.9209 17.0039H29.1328L29.1777 17.2012ZM29.9746 20.709H33.6172L34.165 18.5195H29.4775L29.9746 20.709Z" fill="#0c50ff"/>
					<line x1="24.5039" y1="30.5" x2="29.5039" y2="30.5" stroke="#A0C1FF"/>
					<line x1="30.5039" y1="30.5" x2="35.5039" y2="30.5" stroke="#A0C1FF"/>
					<line x1="24.5039" y1="28.5" x2="37.5039" y2="28.5" stroke="#A0C1FF"/>
					<line x1="24.5039" y1="32.5" x2="32.5039" y2="32.5" stroke="#A0C1FF"/>
					<rect x="18.5" y="38" width="2" height="2" rx="1" fill="#CAD5F2"/>
					<rect x="22.5" y="38" width="2" height="2" rx="1" fill="#0c50ff"/>
					<rect x="26.5" y="38" width="2" height="2" rx="1" fill="#CAD5F2"/>
				</svg>

				<p>
					<?php esc_html_e( 'Product Grid/Carousel', 'cozy-addons' ); ?>
				</p>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo ! is_woocommerce_active() ? '<span class="cozy-toggle-slider round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--product-carousel' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="product-carousel" id="cozy-block--product-carousel" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<?php if ( ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<a href="https://cozyblock.cozythemes.com/all-product-reviews-woocommerce-block/" target="_blank" rel="noopener">
			<div class="cozy-display-flex">
				<svg width="26" height="26" viewBox="0 0 49 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15 7.9375C6.71591 7.93771 0 14.6534 0 22.9375C0 29.9449 4.80512 35.8239 11.2988 37.4727V47.4854L13.0312 45.6191L20.1641 37.9375H34C42.284 37.9373 49 31.2217 49 22.9375C49 20.9578 48.6157 19.0682 47.9189 17.3379H45.7354C46.546 19.0337 47 20.9325 47 22.9375C47 30.117 41.1796 35.9373 34 35.9375H19.292L18.9961 36.2568L13.2988 42.3916V35.8525L12.4902 35.6943C6.51147 34.5254 2 29.2577 2 22.9375C2 15.7579 7.82048 9.93771 15 9.9375H26.0996V7.9375H15Z" fill="#0c50ff"/>
					<path d="M34.1445 12.0723C35.1401 12.0723 35.9471 12.8795 35.9473 13.875C35.9473 14.8707 35.1402 15.6777 34.1445 15.6777C33.149 15.6776 32.3418 14.8706 32.3418 13.875C32.342 12.8796 33.1491 12.0724 34.1445 12.0723ZM40.6357 12.0723C41.6312 12.0724 42.4383 12.8795 42.4385 13.875C42.4385 14.8706 41.6313 15.6776 40.6357 15.6777C39.6401 15.6777 38.833 14.8707 38.833 13.875C38.8332 12.8795 39.6402 12.0723 40.6357 12.0723ZM40.6357 13.1543C40.2377 13.1544 39.9152 13.4769 39.915 13.875C39.915 14.2732 40.2375 14.5966 40.6357 14.5967C41.0339 14.5966 41.3574 14.2732 41.3574 13.875C41.3572 13.477 41.0338 13.1544 40.6357 13.1543ZM34.1445 13.1543C33.7465 13.1545 33.424 13.477 33.4238 13.875C33.4238 14.2732 33.7464 14.5965 34.1445 14.5967C34.5428 14.5967 34.8662 14.2733 34.8662 13.875C34.866 13.4769 34.5427 13.1543 34.1445 13.1543ZM32.1475 2.93652L32.5439 4.67969H43.2422C43.7348 4.67969 44.0969 5.14224 43.9775 5.62012L42.6426 10.957C42.558 11.2937 42.2554 11.5303 41.9082 11.5303H33.5957C33.2426 11.5299 32.9358 11.2848 32.8574 10.9404L31.585 5.33984L31.1885 3.59766H29.457C29.1586 3.59744 28.9162 3.35507 28.916 3.05664C28.916 2.75806 29.1585 2.51584 29.457 2.51562H32.0518L32.1475 2.93652ZM33.8545 10.4482H41.6553L42.8271 5.76074H32.79L33.8545 10.4482Z" fill="#0c50ff"/>
					<path d="M14.5576 18.6357C14.7453 18.2806 15.2547 18.2806 15.4424 18.6357L16.1621 20.001C16.3792 20.4123 16.7751 20.7 17.2334 20.7793L18.7539 21.042C19.1498 21.1108 19.3065 21.5946 19.0264 21.8828L17.9512 22.9893C17.627 23.3228 17.4758 23.7886 17.542 24.249L17.7617 25.7754C17.8189 26.1732 17.4075 26.4729 17.0469 26.2959L15.6621 25.6152C15.2447 25.41 14.7553 25.41 14.3379 25.6152L12.9531 26.2959C12.5925 26.4729 12.1811 26.1732 12.2383 25.7754L12.458 24.249C12.5242 23.7886 12.373 23.3228 12.0488 22.9893L10.9736 21.8828C10.6935 21.5946 10.8502 21.1108 11.2461 21.042L12.7666 20.7793C13.2249 20.7 13.6208 20.4123 13.8379 20.001L14.5576 18.6357Z" stroke="#0c50ff"/>
					<path d="M25.2236 18.6357C25.4113 18.2806 25.9207 18.2806 26.1084 18.6357L26.8281 20.001C27.0452 20.4123 27.4411 20.7 27.8994 20.7793L29.4199 21.042C29.8158 21.1108 29.9725 21.5946 29.6924 21.8828L28.6172 22.9893C28.293 23.3228 28.1418 23.7886 28.208 24.249L28.4277 25.7754C28.4849 26.1732 28.0736 26.4729 27.7129 26.2959L26.3281 25.6152C25.9107 25.41 25.4213 25.41 25.0039 25.6152L23.6191 26.2959C23.2585 26.4729 22.8471 26.1732 22.9043 25.7754L23.124 24.249C23.1902 23.7886 23.039 23.3228 22.7148 22.9893L21.6396 21.8828C21.3595 21.5946 21.5163 21.1108 21.9121 21.042L23.4326 20.7793C23.8909 20.7 24.2869 20.4123 24.5039 20.001L25.2236 18.6357Z" stroke="#0c50ff"/>
					<path d="M35.2236 18.6357C35.4113 18.2806 35.9207 18.2806 36.1084 18.6357L36.8281 20.001C37.0452 20.4123 37.4411 20.7 37.8994 20.7793L39.4199 21.042C39.8158 21.1108 39.9725 21.5946 39.6924 21.8828L38.6172 22.9893C38.293 23.3228 38.1418 23.7886 38.208 24.249L38.4277 25.7754C38.4849 26.1732 38.0736 26.4729 37.7129 26.2959L36.3281 25.6152C35.9107 25.41 35.4213 25.41 35.0039 25.6152L33.6191 26.2959C33.2585 26.4729 32.8471 26.1732 32.9043 25.7754L33.124 24.249C33.1902 23.7886 33.039 23.3228 32.7148 22.9893L31.6396 21.8828C31.3595 21.5946 31.5163 21.1108 31.9121 21.042L33.4326 20.7793C33.8909 20.7 34.2869 20.4123 34.5039 20.001L35.2236 18.6357Z" stroke="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'All Product Reviews', 'cozy-addons' ); ?>
				</p>
			</div>
		</a>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo ! is_woocommerce_active() ? '<span class="cozy-toggle-slider round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--product-review' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="product-review" id="cozy-block--product-review" <?php echo '1' === $checked || '' == $checked ? 'checked' : ''; ?>>
				<?php if ( ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;align-items:center;gap:10px;" href="https://cozyblock.cozythemes.com/product-slider-woocommerce-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 64 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M44.8223 1.50391C51.3065 1.66825 56.5127 6.97618 56.5127 13.5V29.5L56.5088 29.8096C56.3446 36.2938 51.0365 41.4999 44.5127 41.5H18.5127C11.9888 41.5 6.6808 36.2939 6.5166 29.8096L6.5127 29.5V13.5C6.5127 6.97608 11.7188 1.66811 18.2031 1.50391L18.5127 1.5H44.5127L44.8223 1.50391ZM18.5127 3.5C12.9898 3.5 8.5127 7.97715 8.5127 13.5V29.5C8.5127 35.0228 12.9898 39.5 18.5127 39.5H44.5127C50.0354 39.4999 54.5127 35.0228 54.5127 29.5V13.5C54.5127 8.14985 50.3109 3.78068 45.0273 3.5127L44.5127 3.5H18.5127ZM4.34082 16.7568C4.7513 16.3874 5.38346 16.4206 5.75293 16.8311C6.12237 17.2415 6.08917 17.8737 5.67871 18.2432L2.33008 21.2568C1.88916 21.654 1.88916 22.346 2.33008 22.7432L5.67871 25.7568C6.08917 26.1263 6.12237 26.7585 5.75293 27.1689C5.38346 27.5794 4.7513 27.6126 4.34082 27.2432L0.992188 24.2295C-0.331347 23.0378 -0.331344 20.9622 0.992188 19.7705L4.34082 16.7568ZM57.2695 16.8311C57.639 16.4207 58.2712 16.3874 58.6816 16.7568L62.0303 19.7705C63.3537 20.9621 63.3537 23.0378 62.0303 24.2295L58.6816 27.2432C58.2712 27.6126 57.639 27.5793 57.2695 27.1689C56.9001 26.7585 56.9333 26.1263 57.3438 25.7568L60.6924 22.7432C61.1332 22.346 61.1332 21.654 60.6924 21.2568L57.3438 18.2432C56.9333 17.8737 56.9001 17.2415 57.2695 16.8311Z" fill="#0c50ff"/>
					<rect x="23.9883" y="45.5" width="3" height="3" rx="1.5" fill="#CAD5F2"/>
					<rect x="29.9883" y="45.5" width="3" height="3" rx="1.5" fill="#0c50ff"/>
					<rect x="35.9883" y="45.5" width="3" height="3" rx="1.5" fill="#CAD5F2"/>
					<rect x="16.4937" y="16.4937" width="13.8969" height="13.8969" stroke="#0c50ff" stroke-width="1.21403"/>
					<path d="M28.1104 14.002H14.001V28.1104H13V13H28.1104V14.002Z" fill="#0c50ff"/>
					<path d="M22.4082 24.2939C22.8731 24.2939 23.2498 24.6709 23.25 25.1357C23.25 25.6007 22.8732 25.9775 22.4082 25.9775C21.9434 25.9773 21.5664 25.6006 21.5664 25.1357C21.5666 24.6711 21.9435 24.2942 22.4082 24.2939ZM25.4404 24.2939C25.9051 24.2942 26.282 24.671 26.2822 25.1357C26.2822 25.6006 25.9052 25.9773 25.4404 25.9775C24.9755 25.9775 24.5986 25.6007 24.5986 25.1357C24.5988 24.671 24.9756 24.294 25.4404 24.2939ZM25.4404 24.7988C25.2546 24.7989 25.1037 24.95 25.1035 25.1357C25.1035 25.3217 25.2545 25.4726 25.4404 25.4727C25.6262 25.4724 25.7773 25.3216 25.7773 25.1357C25.7772 24.95 25.6261 24.799 25.4404 24.7988ZM22.4082 24.7988C22.2225 24.7991 22.0715 24.95 22.0713 25.1357C22.0713 25.3216 22.2224 25.4724 22.4082 25.4727C22.5942 25.4727 22.7451 25.3217 22.7451 25.1357C22.7449 24.9499 22.5941 24.7988 22.4082 24.7988ZM21.4766 20.0293L21.6611 20.8428H26.6572C26.8871 20.8429 27.0566 21.0592 27.001 21.2822L26.3779 23.7744C26.3386 23.9317 26.1963 24.0419 26.0342 24.042H22.1523C21.9874 24.0418 21.8442 23.9275 21.8076 23.7666L21.2139 21.1514L21.0283 20.3379H20.2197C20.0802 20.3379 19.9668 20.2245 19.9668 20.085C19.9669 19.9455 20.0803 19.832 20.2197 19.832H21.4316L21.4766 20.0293ZM22.2734 23.5371H25.916L26.4639 21.3477H21.7764L22.2734 23.5371Z" fill="#0c50ff"/>
					<line x1="34.6406" y1="21.393" x2="40.7108" y2="21.393" stroke="#0c50ff" stroke-width="1.21403"/>
					<line x1="41.9258" y1="21.393" x2="47.9959" y2="21.393" stroke="#0c50ff" stroke-width="1.21403"/>
					<line x1="34.6406" y1="17.7524" x2="50.423" y2="17.7524" stroke="#0c50ff" stroke-width="1.21403"/>
					<line x1="34.6406" y1="25.0336" x2="44.3528" y2="25.0336" stroke="#0c50ff" stroke-width="1.21403"/>
				</svg>

				<p>
					<?php esc_html_e( 'Product Slider', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--product-slider' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="product-slider" id="cozy-block--product-slider" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() || ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						if ( false === cozy_addons_premium_access() ) {
							esc_html_e( 'Please', 'cozy-addons' );
							?>
							<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a>
							<?php
							esc_html_e( ' to enable this block!', 'cozy-addons' );
						}
						if ( ! is_woocommerce_active() ) {
							esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						}
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/product-showcase-tabs-woocommerce-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 51 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M28.8887 2.62109C30.6326 2.30402 32.367 3.22115 33.0869 4.84082L34.1016 7.12305C34.1061 7.13319 34.1091 7.14409 34.1133 7.1543H44.041C47.3547 7.1543 50.041 9.8406 50.041 13.1543V41.4424C50.0408 44.7559 47.3546 47.4424 44.041 47.4424H6C2.68653 47.4423 0.000257081 44.7558 0 41.4424V9.16602C0 5.85236 2.68637 3.16611 6 3.16602H10.5791C12.325 3.1661 13.9219 4.15149 14.7051 5.71191C15.149 6.59597 16.0537 7.15421 17.043 7.1543H17.1631C16.7434 5.06966 18.1108 3.00871 20.2422 2.62109C21.9861 2.30408 23.7205 3.22115 24.4404 4.84082L25.4551 7.12305C25.4596 7.13321 25.4626 7.14407 25.4668 7.1543H25.8096C25.3899 5.06968 26.7573 3.00872 28.8887 2.62109ZM6 5.16602C3.79094 5.16611 2 6.95693 2 9.16602V41.4424C2.00026 43.6512 3.7911 45.4423 6 45.4424H44.041C46.25 45.4424 48.0408 43.6513 48.041 41.4424V13.1543C48.041 10.9452 46.2501 9.1543 44.041 9.1543H17.043C15.2971 9.15421 13.7002 8.16876 12.917 6.6084C12.4731 5.72425 11.5684 5.16611 10.5791 5.16602H6ZM31.2598 5.65332C30.9145 4.87678 30.0822 4.43684 29.2461 4.58887C28.175 4.78392 27.5057 5.86035 27.8047 6.90723L27.875 7.1543H31.9268L31.2598 5.65332ZM22.6133 5.65332C22.2681 4.87678 21.4357 4.43691 20.5996 4.58887C19.5285 4.7839 18.8592 5.86032 19.1582 6.90723L19.2285 7.1543H23.2803L22.6133 5.65332Z" fill="#0c50ff"/>
					<rect x="12.0547" y="19.6133" width="11.447" height="11.447" stroke="#0c50ff"/>
					<path d="M22.4463 18.5293H10.9727V30.0049H10V17.5586H22.4463V18.5293Z" fill="#0c50ff"/>
					<path d="M16.1074 27.0244C16.5723 27.0244 16.949 27.4014 16.9492 27.8662C16.9492 28.3312 16.5724 28.708 16.1074 28.708C15.6426 28.7078 15.2656 28.3311 15.2656 27.8662C15.2658 27.4015 15.6427 27.0246 16.1074 27.0244ZM19.1396 27.0244C19.6043 27.0246 19.9813 27.4015 19.9814 27.8662C19.9814 28.3311 19.6045 28.7078 19.1396 28.708C18.6747 28.7079 18.2979 28.3312 18.2979 27.8662C18.298 27.4014 18.6748 27.0245 19.1396 27.0244ZM19.1396 27.5293C18.9538 27.5294 18.8029 27.6804 18.8027 27.8662C18.8027 28.0522 18.9537 28.203 19.1396 28.2031C19.3255 28.2029 19.4766 28.0521 19.4766 27.8662C19.4764 27.6805 19.3253 27.5295 19.1396 27.5293ZM16.1074 27.5293C15.9217 27.5295 15.7707 27.6805 15.7705 27.8662C15.7705 28.0521 15.9216 28.2029 16.1074 28.2031C16.2934 28.2031 16.4443 28.0522 16.4443 27.8662C16.4441 27.6804 16.2933 27.5293 16.1074 27.5293ZM15.1758 22.7598L15.3604 23.5732H20.3564C20.5863 23.5734 20.7558 23.7897 20.7002 24.0127L20.0771 26.5049C20.0378 26.6622 19.8955 26.7724 19.7334 26.7725H15.8516C15.6866 26.7723 15.5434 26.658 15.5068 26.4971L14.9131 23.8818L14.7275 23.0684H13.9189C13.7794 23.0684 13.666 22.9549 13.666 22.8154C13.6661 22.676 13.7795 22.5625 13.9189 22.5625H15.1309L15.1758 22.7598ZM15.9727 26.2676H19.6152L20.1631 24.0781H15.4756L15.9727 26.2676Z" fill="#0c50ff"/>
					<line x1="10.502" y1="36.0586" x2="15.502" y2="36.0586" stroke="#A0C1FF"/>
					<line x1="16.502" y1="36.0586" x2="21.502" y2="36.0586" stroke="#A0C1FF"/>
					<line x1="10.502" y1="34.0586" x2="23.502" y2="34.0586" stroke="#A0C1FF"/>
					<line x1="10.502" y1="38.0586" x2="18.502" y2="38.0586" stroke="#A0C1FF"/>
					<rect x="29.0566" y="19.6133" width="11.447" height="11.447" stroke="#0c50ff"/>
					<path d="M39.4482 18.5293H27.9746V30.0049H27.002V17.5586H39.4482V18.5293Z" fill="#0c50ff"/>
					<path d="M33.1094 27.0244C33.5743 27.0244 33.951 27.4014 33.9512 27.8662C33.9512 28.3312 33.5744 28.708 33.1094 28.708C32.6446 28.7078 32.2676 28.3311 32.2676 27.8662C32.2678 27.4015 32.6447 27.0246 33.1094 27.0244ZM36.1416 27.0244C36.6063 27.0246 36.9832 27.4015 36.9834 27.8662C36.9834 28.3311 36.6064 28.7078 36.1416 28.708C35.6767 28.7079 35.2998 28.3312 35.2998 27.8662C35.3 27.4014 35.6768 27.0245 36.1416 27.0244ZM36.1416 27.5293C35.9558 27.5294 35.8049 27.6804 35.8047 27.8662C35.8047 28.0522 35.9557 28.203 36.1416 28.2031C36.3274 28.2029 36.4785 28.0521 36.4785 27.8662C36.4783 27.6805 36.3273 27.5295 36.1416 27.5293ZM33.1094 27.5293C32.9237 27.5295 32.7727 27.6805 32.7725 27.8662C32.7725 28.0521 32.9236 28.2029 33.1094 28.2031C33.2954 28.2031 33.4463 28.0522 33.4463 27.8662C33.4461 27.6804 33.2953 27.5293 33.1094 27.5293ZM32.1777 22.7598L32.3623 23.5732H37.3584C37.5883 23.5734 37.7578 23.7897 37.7021 24.0127L37.0791 26.5049C37.0397 26.6622 36.8975 26.7724 36.7354 26.7725H32.8535C32.6885 26.7723 32.5454 26.658 32.5088 26.4971L31.915 23.8818L31.7295 23.0684H30.9209C30.7814 23.0684 30.668 22.9549 30.668 22.8154C30.6681 22.676 30.7815 22.5625 30.9209 22.5625H32.1328L32.1777 22.7598ZM32.9746 26.2676H36.6172L37.165 24.0781H32.4775L32.9746 26.2676Z" fill="#0c50ff"/>
					<line x1="27.5039" y1="36.0586" x2="32.5039" y2="36.0586" stroke="#A0C1FF"/>
					<line x1="33.5039" y1="36.0586" x2="38.5039" y2="36.0586" stroke="#A0C1FF"/>
					<line x1="27.5039" y1="34.0586" x2="40.5039" y2="34.0586" stroke="#A0C1FF"/>
					<line x1="27.5039" y1="38.0586" x2="35.5039" y2="38.0586" stroke="#A0C1FF"/>
				</svg>

				<p>
					<?php esc_html_e( 'Product Showcase Tabs', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--product-tab' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="product-tab" id="cozy-block--product-tab" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() || ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						if ( false === cozy_addons_premium_access() ) {
							esc_html_e( 'Please', 'cozy-addons' );
							?>
							<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a>
							<?php
							esc_html_e( ' to enable this block!', 'cozy-addons' );
						}
						if ( ! is_woocommerce_active() ) {
							esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						}
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/product-quick-view-woocommerce-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="17.3817" cy="20.3817" r="16.3817" stroke="#0c50ff" stroke-width="2"/>
					<path d="M30.1895 30.9023L48.4806 46.094" stroke="#0c50ff" stroke-width="2" stroke-linecap="round"/>
					<path d="M39.0215 38.3555L49.1182 47.0002" stroke="#0c50ff" stroke-width="3.86261" stroke-linecap="round"/>
					<path d="M15.1699 23.6426C16.1655 23.6426 16.9724 24.4498 16.9727 25.4453C16.9727 26.441 16.1656 27.248 15.1699 27.248C14.1744 27.2479 13.3672 26.4409 13.3672 25.4453C13.3674 24.4499 14.1745 23.6428 15.1699 23.6426ZM21.6611 23.6426C22.6566 23.6427 23.4637 24.4499 23.4639 25.4453C23.4639 26.4409 22.6567 27.2479 21.6611 27.248C20.6655 27.248 19.8584 26.441 19.8584 25.4453C19.8586 24.4498 20.6656 23.6427 21.6611 23.6426ZM21.6611 24.7246C21.263 24.7247 20.9406 25.0473 20.9404 25.4453C20.9404 25.8435 21.2629 26.1669 21.6611 26.167C22.0593 26.1669 22.3828 25.8435 22.3828 25.4453C22.3826 25.0473 22.0592 24.7247 21.6611 24.7246ZM15.1699 24.7246C14.7719 24.7248 14.4494 25.0473 14.4492 25.4453C14.4492 25.8435 14.7718 26.1668 15.1699 26.167C15.5682 26.167 15.8916 25.8436 15.8916 25.4453C15.8914 25.0472 15.5681 24.7246 15.1699 24.7246ZM13.1729 14.5068L13.5693 16.25H24.2676C24.7602 16.25 25.1223 16.7126 25.0029 17.1904L23.668 22.5273C23.5834 22.864 23.2808 23.1006 22.9336 23.1006H14.6211C14.268 23.1002 13.9612 22.8551 13.8828 22.5107L12.6104 16.9102L12.2139 15.168H10.4824C10.184 15.1678 9.94158 14.9254 9.94141 14.627C9.94141 14.3284 10.1839 14.0861 10.4824 14.0859H13.0771L13.1729 14.5068ZM14.8799 22.0186H22.6807L23.8525 17.3311H13.8154L14.8799 22.0186Z" fill="#0c50ff"/>
				</svg>

				<p>
					<?php esc_html_e( 'Quick View', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--quick-view' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="quick-view" id="cozy-block--quick-view" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() || ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						if ( false === cozy_addons_premium_access() ) {
							esc_html_e( 'Please', 'cozy-addons' );
							?>
							<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a>
							<?php
							esc_html_e( ' to enable this block!', 'cozy-addons' );
						}
						if ( ! is_woocommerce_active() ) {
							esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						}
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>

	<li>
		<div class="cozy-display-flex">
			<a style="display:flex;gap:10px;align-items:center;" href="https://cozyblock.cozythemes.com/product-wishlist-woocommerce-block/" target="_blank" rel="noopener">
				<svg width="26" height="26" viewBox="0 0 47 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M22.9375 9.91211C30.6459 -0.365283 47 5.0866 47 17.9336V18.4902L46.9951 18.8584C46.9366 21.0106 46.3669 23.0949 45.3604 24.9512C44.8072 24.2643 44.1852 23.6356 43.502 23.0781C44.1518 21.6539 44.4999 20.0919 44.5 18.4902V17.9336C44.5 7.48913 31.2044 3.05674 24.9375 11.4121L22.8887 14.1426L20.9033 11.3662C15.163 3.33702 2.50031 7.3976 2.5 17.2676V18.8594C2.5001 21.8696 3.7734 24.7393 6.00488 26.7598L22.9756 42.126L25.2588 40.1543C25.7441 40.8362 26.2951 41.4672 26.9033 42.0391L22.9375 45.4629L4.32715 28.6133C1.65818 26.1968 0.0997122 22.7961 0.00488281 19.207L0 18.8594V17.2676C0.000309461 4.96605 15.783 -0.0951033 22.9375 9.91211Z" fill="#0c50ff"/>
					<circle cx="36.5" cy="33.5" r="7.5" stroke="#0c50ff" stroke-width="2"/>
					<path d="M40 34H36.7857H34" stroke="#0c50ff" stroke-linecap="round"/>
					<path d="M36.75 31V34.2143V37" stroke="#0c50ff" stroke-linecap="round"/>
				</svg>

				<p>
					<?php esc_html_e( 'Wishlist', 'cozy-addons' ); ?>
				</p>
			</a>
			<p class="cozy-block-pro-label"><img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . 'admin/assets/img/crown.png' ); ?>" /></p>
		</div>
		<div class="cozy-block-toggle">
			<label class="switch">
				<?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? '<span class="cozy-toggle-slider cozy-pro-block round"></span>' : ''; ?>
				<?php
				$checked = get_option( 'cozy-block--wishlist' );
				?>
				<input type="checkbox" class="cozy-block-active <?php echo false === cozy_addons_premium_access() || ! is_woocommerce_active() ? 'cozy-block-upsell' : ''; ?>" name="wishlist" id="cozy-block--wishlist" <?php echo cozy_addons_premium_access() && ( '1' === $checked || '' == $checked ) ? 'checked' : ''; ?>>
				<?php if ( false === cozy_addons_premium_access() || ! is_woocommerce_active() ) { ?>
					<div class="cozy-block-upsell-tooltip">
						<?php
						if ( false === cozy_addons_premium_access() ) {
							esc_html_e( 'Please', 'cozy-addons' );
							?>
							<a href="https://cozythemes.com/pricing-and-plans/"><?php esc_html_e( ' upgrade to pro', 'cozy-addons' ); ?></a>
							<?php
							esc_html_e( ' to enable this block!', 'cozy-addons' );
						}
						if ( ! is_woocommerce_active() ) {
							esc_html_e( 'This block requires the WooCommerce plugin to be installed and activated.', 'cozy-addons' );
						}
						?>
					</div>
				<?php } else { ?>
					<span class="cozy-toggle-slider cozy-pro-block round"></span>
				<?php } ?>
			</label>
		</div>
	</li>
</ul>