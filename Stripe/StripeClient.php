<?php

namespace Flosch\Bundle\StripeBundle\Stripe;

use Stripe\Stripe;

class StripeClient extends Stripe
{
    public function __construct($stripeApiKey)
    {
        self::setApiKey($stripeApiKey);

        return $this;
    }
}
