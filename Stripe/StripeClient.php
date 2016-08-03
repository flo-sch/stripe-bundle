<?php

namespace Flosch\Bundle\StripeBundle\Stripe;

use Stripe\Stripe,
    Stripe\Customer;

/**
 * An extension of the Stripe PHP SDK, including an API key parameter to automatically authenticate.
 *
 * This class will provide helper methods to use the Stripe SDK
 */
class StripeClient extends Stripe
{
    public function __construct($stripeApiKey)
    {
        self::setApiKey($stripeApiKey);

        return $this;
    }

    /**
     * Associate a new Customer object to an existing Plan.
     *
     * @throws HttpException:
     *     - If the planId is invalid (the plan does not exists...)
     *     - If the payment token is invalid (payment failed)
     *
     * @see https://stripe.com/docs/subscriptions/tutorial#create-subscription
     *
     * @param string $planId: The plan ID as defined in your Stripe dashboard
     * @param string $paymentToken: The payment token returned by the payment form
     * @param string $customerEmail: The customer email
     *
     * @return Customer
     */
    public function subscribeCustomerToPlan(string $planId, string $paymentToken, string $customerEmail)
    {
        return Customer::create([
            "plan" => $planId,
            "source" => $paymentToken,
            "email" => $customerEmail
        ]);
    }
}
