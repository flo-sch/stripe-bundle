# stripe-bundle
A symfony 3 integration for the Stripe PHP SDK

This bundle allow you to manipulate the stripe SDK as a Symfony service,
Plus some helpers to use different Stripe API notions such as Stripe Connect or the Subscriptions API.

### Installation
To install this bundle, run the command below and you will get the latest version from [Packagist][3].

``` bash
composer require flosch/stripe-bundle
```

Load required bundles in AppKernel.php:

``` php
// app/AppKernel.php
public function registerBundles()
{
  $bundles = array(
    // [...]
    new Flosch\Bundle\StripeBundle\FloschStripeBundle()
  );
}
```

And set-up the required configuration

``` yaml
# app/config/config.yml
flosch_stripe:
    stripe_api_key: "%stripe_api_key%" # The Stripe API key can be added as a symfony parameter
```

### Usage

Then, it is possible to use this service from inside a controller

``` php
$stripeClient = $this->get('flosch.stripe.client');
```

The StripeClient php class extends the default Stripe PHP SDK class, allowing you to do anything that this SDK can do.
Plus, it will automatically be authenticated with your Stripe API Key, which you do not have to worry about at all.

### Helpers

The StripeClient currently offers four helper methods :

###### Retrieve a Coupon by its ID

``` php
/**
 * $planId (string)         : The existing Coupon ID (the one you define in the Stripe dashboard)
 */
$stripeClient->retrieveCoupon($planId);
```

###### Retrieve a Plan by its ID

``` php
/**
 * $planId (string)         : The existing Plan ID (the one you define in the Stripe dashboard)
 */
$stripeClient->retrievePlan($planId);
```

###### Subscribe customer to an existing plan

``` php
/**
 * $planId (string)         : The existing Plan ID (the one you define in the Stripe dashboard)
 * $paymentToken (string)   : The payment token obtained using the Stripe.js library
 * $customerEmail (string)  : The customer e-mail address
 * $couponId (string|null)  : An optional coupon ID
 */
$stripeClient->subscribeCustomerToPlan($planId, $paymentToken, $customerEmail, $couponId);
```

###### Charge a connected Stripe account

``` php
/**
 * $chargeAmount (int)          : The charge amount in cents, for instance 1000 for 10.00 (of the currency)
 * $chargeCurrency (string)     : The charge currency (for instance, "eur")
 * $paymentToken (string)       : The payment token obtained using the Stripe.js library
 * $stripeAccountId (string)    : The connected string account ID
 * $applicationFee (int)        : The amount of the application fee (in cents), default to 0
 * $chargeDescription (string)  : An optional charge description
 */
$stripeClient->createCharge($chargeAmount, $chargeCurrency, $paymentToken, $stripeAccountId, $applicationFee, $chargeDescription);
```
