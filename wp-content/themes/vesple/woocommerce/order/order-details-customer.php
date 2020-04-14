<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="width-400 margin-auto">
  <p class="font-12 type-bold caps m-b-20">Billing info</p>
  <ul class="border-bottom p-b-10">
    <?php if ( $order->get_billing_first_name() ) : ?>
      <li class="row no-gutters justify-content-between font-15 subtitle m-b-20">
  		<div>
        Name
      </div>
      <div>
        <?php echo $order->get_billing_first_name(); ?>
        <?php if ( $order->get_billing_last_name() ):
          echo ' ' . $order->get_billing_last_name();
        endif; ?>
      </div>
    </li>
  	<?php endif; ?>

    <?php if ( $order->get_billing_address_1() ) : ?>
      <li class="row no-gutters justify-content-between font-15 subtitle m-b-20">
      <div>
        Address
      </div>
      <div>
        <?php echo $order->get_billing_address_1(); ?>
        <?php if ( $order->get_billing_address_2() ):
          echo ', ' . $order->get_billing_address_2();
        endif; ?>
      </div>
    </li>
    <?php endif; ?>

    <?php if ( $order->get_billing_postcode() ) : ?>
      <li class="row no-gutters justify-content-between font-15 subtitle m-b-20">
      <div>
        Postal Code
      </div>
      <div>
        <?php echo $order->get_billing_postcode(); ?>
      </div>
    </li>
    <?php endif; ?>

    <?php if ( $order->get_billing_phone() ) : ?>
      <li class="row no-gutters justify-content-between font-15 subtitle m-b-20">
      <div>
        Phone
      </div>
      <div>
        <?php echo $order->get_billing_phone(); ?>
      </div>
    </li>
    <?php endif; ?>
  </ul>

</div>
