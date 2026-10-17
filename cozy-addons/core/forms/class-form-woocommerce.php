<?php
/**
 * WooCommerce product details for product enquiry forms (Pro).
 *
 * @package CozyAddons
 */

namespace CozyAddons\Core\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Finds the current product and reads trusted product details. Product details always come
 * from the database, never from the visitor, so enquiries cannot be forged for another product.
 */
final class Form_WooCommerce {

	/**
	 * Whether WooCommerce is available. Checked at call time, as it may load after this plugin.
	 *
	 * @return bool
	 */
	public static function active() {
		return class_exists( 'WooCommerce' ) && function_exists( 'wc_get_product' );
	}

	/**
	 * The product shown on the current page, if any.
	 *
	 * @return \WC_Product|null
	 */
	public static function current_product() {
		if ( ! self::active() ) {
			return null;
		}
		global $product;
		if ( $product instanceof \WC_Product ) {
			return $product;
		}
		$post_id = get_the_ID();
		if ( $post_id && 'product' === get_post_type( $post_id ) ) {
			$found = wc_get_product( $post_id );
			return $found instanceof \WC_Product ? $found : null;
		}

		return null;
	}

	/**
	 * Trusted product details.
	 *
	 * @param int $product_id   Product ID from the signed form config.
	 * @param int $variation_id Variation ID chosen on the page, validated here.
	 * @return array|null Details, or null when the product is not available.
	 */
	public static function resolve( $product_id, $variation_id = 0 ) {
		if ( ! self::active() ) {
			return null;
		}
		$product = wc_get_product( (int) $product_id );
		if ( ! $product instanceof \WC_Product || 'publish' !== get_post_status( $product->get_id() ) ) {
			return null;
		}

		$source = $product;
		if ( $variation_id > 0 ) {
			$variation = wc_get_product( (int) $variation_id );
			if ( $variation instanceof \WC_Product_Variation && (int) $variation->get_parent_id() === (int) $product->get_id() ) {
				$source = $variation;
			}
		}

		return array(
			'id'      => (int) $product->get_id(),
			'name'    => wp_strip_all_tags( $product->get_name() ),
			'sku'     => (string) $source->get_sku(),
			'price'   => trim( html_entity_decode( wp_strip_all_tags( $source->get_price_html() ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ),
			'url'     => get_permalink( $product->get_id() ),
			'variant' => $source->get_id() !== $product->get_id() ? (int) $source->get_id() : 0,
		);
	}

	/**
	 * The "your enquiry is about" card shown above the form.
	 *
	 * @param \WC_Product $product Product.
	 * @return string Escaped HTML.
	 */
	public static function card( $product ) {
		$image = $product->get_image( 'thumbnail' );
		$sku   = (string) $product->get_sku();
		$html  = '<div class="cozy-form__product">';
		if ( $image ) {
			$html .= '<span class="cozy-form__product-media">' . wp_kses_post( $image ) . '</span>';
		}
		$html .= '<span class="cozy-form__product-body">';
		$html .= '<span class="cozy-form__product-label">' . esc_html__( 'Your enquiry is about', 'cozy-addons' ) . '</span>';
		$html .= '<strong class="cozy-form__product-name">' . esc_html( wp_strip_all_tags( $product->get_name() ) ) . '</strong>';
		$meta  = array();
		if ( '' !== $sku ) {
			/* translators: %s: product SKU */
			$meta[] = esc_html( sprintf( __( 'SKU: %s', 'cozy-addons' ), $sku ) );
		}
		$price = trim( html_entity_decode( wp_strip_all_tags( $product->get_price_html() ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
		if ( '' !== $price ) {
			$meta[] = esc_html( $price );
		}
		if ( $meta ) {
			$html .= '<span class="cozy-form__product-meta">' . implode( ' · ', $meta ) . '</span>';
		}
		$html .= '<span class="cozy-form__product-options" aria-live="polite"></span>';
		$html .= '</span></div>';

		return $html;
	}
}
