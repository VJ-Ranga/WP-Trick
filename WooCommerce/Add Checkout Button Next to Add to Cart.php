/*
Plugin Name: Add Checkout Button Next to Add to Cart
Description: Adds a "Purchase Now" button next to the Add to Cart button on WooCommerce product pages, directly adding the product to checkout.
Version: 1.5
Author: VJRanga
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function add_checkout_button_next_to_cart() {
    global $product;
    $checkout_url = wc_get_checkout_url() . '?add-to-cart=' . $product->get_id();
    echo '<a href="' . esc_url($checkout_url) . '" class="button checkout-button">Buy Now</a>';
}
add_action('woocommerce_after_add_to_cart_button', 'add_checkout_button_next_to_cart');

// Enqueue CSS Styles
function add_checkout_button_styles() {
    echo '<style>
        .cart {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: nowrap;
        }
        .single_add_to_cart_button {
            width: 40% !important;
        }
        .checkout-button {
            background-color: var(--e-global-color-primary);
            color: white !important;
            padding: 10px 20px !important;
            border-radius: 30px;
            text-transform: uppercase;
            font-weight: bold;
            display: inline-block;
            border: none;
			text-align: center;
            font-size: 14px;
            width: 50% !important;
        }
        .checkout-button:hover, .single_add_to_cart_button:hover {
            background-color: var(--e-global-color-accent);
        }
    </style>';
}
add_action('wp_head', 'add_checkout_button_styles');
