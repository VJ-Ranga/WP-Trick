<?php
/*
Plugin Name: Add Checkout Button Next to Add to Cart
Description: Adds a "Purchase Now" button next to the Add to Cart button on WooCommerce single product pages only, directly adding the product to checkout. Adjusts layout for mobile.
Version: 1.8
Author: VJRanga
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function add_checkout_button_next_to_cart() {
    if (!is_product()) {
        return;
    }
    global $product;
    $checkout_url = wc_get_checkout_url() . '?add-to-cart=' . $product->get_id();
    echo '<a href="' . esc_url($checkout_url) . '" class="button checkout-button">Buy Now</a>';
}
add_action('woocommerce_after_add_to_cart_button', 'add_checkout_button_next_to_cart');

// Enqueue CSS Styles only on single product pages
function add_checkout_button_styles() {
    if (!is_product()) {
        return;
    }
    echo '<style>
        .cart {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: nowrap;
        }
        .single_add_to_cart_button {
            width: 50% !important;
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
            width: 40% !important;
        }
        .checkout-button:hover {
            background-color: var(--e-global-color-accent);
        }
        @media (max-width: 768px) {
            .cart {
                flex-direction: column;
                gap: 5px;
            }
            .single_add_to_cart_button, .checkout-button {
                width: 100% !important;
            }
        }
    </style>';
}
add_action('wp_head', 'add_checkout_button_styles');

