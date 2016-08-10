<?php

namespace Flosch\Bundle\StripeBundle\Stripe;

use Stripe\Stripe,
    Stripe\Customer,
    Stripe\Charge;

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
     * @param string $paymentToken: The payment token returned by the payment form (Stripe.js)
     * @param string $customerEmail: The customer email
     *
     * @return Customer
     */
    public function subscribeCustomerToPlan(string $planId, string $paymentToken, string $customerEmail)
    {
        return Customer::create([
            'plan'      => $planId,
            'source'    => $paymentToken,
            'email'     => $customerEmail
        ]);
    }

    /**
     * Create a new Charge from a payment token, to a connected stripe account.
     *
     * @throws HttpException:
     *     - If the planId is invalid (the plan does not exists...)
     *     - If the payment token is invalid (payment failed)
     *
     * @see https://stripe.com/docs/subscriptions/tutorial#create-subscription
     *
     * @param int    $chargeAmount: The charge amount in cents
     * @param string $chargeCurrency: The charge currency to use
     * @param string $stripeAccountId: The connected stripe account ID
     * @param string $paymentToken: The payment token returned by the payment form (Stripe.js)
     * @param int    $applicationFee: The fee taken by the platform will take, in cents
     * @param string $description: An optional charge description
     *
     * @return Customer
     */
    public function createCharge(int $chargeAmount, string $chargeCurrency, string $paymentToken, string $stripeAccountId, int $applicationFee = 0, string $chargeDescription = '')
    {
        return Charge::create([
            'amount'            => $chargeAmount,
            'currency'          => $chargeCurrency,
            'source'            => $paymentToken,
            'application_fee'   => $applicationFee,
            'description'       => $description
        ], [
            'stripe_account'    => $stripeAccountId
        ]);
    }
}
