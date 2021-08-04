<?php
/*
 * Plugin Name: Netzspitze Minimum Order Value
 * Description: Dieses Plugin zeigt den Betrag an, welcher noch benötigt wird, um in deinem WooCommerce E-Commerce Shop kostenlosen Versand zu erhalten.
 * Author: Fabian Keßler
 * Author URI: https://fabiankessler.de
 * Version: 1.0.0
 */
// Direkten Aufruf verhindern
if ( ! defined( 'WPINC' ) ) {
  die;
}
add_action( 'woocommerce_checkout_process', 'fke_shipping_order_amount' );
add_action( 'woocommerce_before_cart' , 'fke_shipping_order_amount' );

function fke_shipping_order_amount() {
  // Set this variable to specify a minimum order value
  $total = WC()->cart->total;
  $free_shipping_settings = get_option( 'woocommerce_free_shipping_settings' );
  if(WC()->customer->get_shipping_country() == "DE"){
      $minimum = 20; //change this to your free shipping threshold
  }
  else{
      $minimum = 40; //change this to your free shipping threshold
  }
  $open = $minimum - $total;

  if ( WC()->cart->total < $minimum ) {
      if( is_cart() ) {
          wc_print_notice( 
              sprintf( 'Ihr aktueller Bestellwert liegt bei %s — Jetzt noch %s hinzufügen und versandkostenfrei bestellen.' , 
                  wc_price( WC()->cart->total ), 
                  wc_price( $open)
              ), 'error' 
          );
      } else {
          wc_print_notice( 
              sprintf( 'Ihr aktueller Bestellwert liegt bei %s — Dadurch bestellen sie heute versandkostenfrei.' , 
                  wc_price( WC()->cart->total ), 
                  wc_price( $minimum )
              ), 'error' 
          );
      }
    }
}
?>
