<?php
use CouponURLs\Original\Environment\Env;
?>
<?php foreach($self->data->couponsToBeAdded->coupons()->asCollection() as $coupon): ?>
<tr class="<?php echo esc_attr(Env::getWithPrefix('to-be-applied')); ?>">
    <th><?php echo esc_html(__('Coupon to be applied*:', 'coupon-urls-international')) ?></th>
    <td class="<?php echo esc_attr(Env::getWithPrefix('to-be-applied-code')); ?>"><?php echo esc_html($coupon->code()->get()) ?></td>
</tr>
<?php endforeach; ?>