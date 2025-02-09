/*
Name: Add Checkout Button Next to Add to Cart
Description: Adds a "Purchase Now" button next to the Add to Cart button on WooCommerce product pages, directly adding the product to checkout.
Version: 1.2
Author: VJRanga
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function add_checkout_button_next_to_cart() {
    global $product;
    $checkout_url = wc_get_checkout_url() . '?add-to-cart=' . $product->get_id();
    echo '<a href="' . esc_url($checkout_url) . '" class="button checkout-button">Purchase Now</a>';
}
add_action('woocommerce_after_add_to_cart_button', 'add_checkout_button_next_to_cart');

// Enqueue CSS Styles
function add_checkout_button_styles() {
    echo '<style>
        .checkout-button {
            background-color: var(--e-global-color-primary);
            color: white !important;
            padding: 10px 15px;
            border-radius: 30px;
            text-transform: uppercase;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
            border: none;
        }
        .checkout-button:hover {
            background-color: var(--e-global-color-accent);
        }
    </style>';
}
add_action('wp_head', 'add_checkout_button_styles');
