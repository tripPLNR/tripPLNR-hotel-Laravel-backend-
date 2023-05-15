<?php

namespace App\Library;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Stripe;
use Exception;

class StripeGateway
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(config('mail.stripe.secret_key'));
    }

    public static function setStripeApiKey()
    {
        \Stripe\Stripe::setApiKey(config('mail.stripe.secret_key'));
    }

    public static function createToken($card = NULL)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['message'] = "";
        try {
            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );
            $tokenObj = $stripe->tokens->create([
                'card' => [
                    'number' => $card['card_number'],
                    'exp_month' => $card['card_expiry_month'],
                    'exp_year' => $card['card_expiry_year'],
                    'cvc' => $card['card_cvv'],
                ],
            ]);

            if ($tokenObj) {
                $response['token'] = $tokenObj->id;
                $response['success'] = TRUE;
            }
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;

            return $response;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
    }

    public static function createCustomer($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $customerObj = \Stripe\Customer::create(array(
                'email' => $data['email'],
                'source'  => $data['token']
            ));
            $response['success'] = TRUE;
            $response['data'] = $customerObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
    }

    public static function createChargeOld($orderData = [])
    {
        $response = [];
        $response['success'] = FALSE;

        $orderAmount = $orderData['amount'] * 100;
        $adminAmount = $orderAmount * (env('ADMIN_AMOUNT_PERCENTAGE') / 100);
        $restaurantAmount = $orderAmount - $adminAmount;

        $adminAmount = round($adminAmount);
        $restaurantAmount = round($restaurantAmount);

        if (isset($orderData['stripe_connected_account_id']) && !empty($orderData['stripe_connected_account_id'])) {
            $stripeData = [
                'customer' => $orderData['stripe_customer_id'],
                'amount' => $adminAmount,
                'currency' => 'usd',
                'source' => $orderData['source'],
                'transfer_data' => [
                    "amount" => $restaurantAmount,
                    "destination" => $orderData['stripe_connected_account_id'],
                ]
            ];
        } else {
            $stripeData = [
                'customer' => $orderData['stripe_customer_id'],
                'amount' => $orderAmount,
                'currency' => 'usd',
                'source' => $orderData['source'],
            ];
        }

        try {
            self::setStripeApiKey();

            $chargeObj = \Stripe\Charge::create($stripeData);

            $response['data'] = $chargeObj;
            $response['success'] = TRUE;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        print_pre($response);
        return $response;
    }

    public static function createCharge($paymentData = [])
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            self::setStripeApiKey();

            \Stripe\Stripe::setApiKey(config('mail.stripe.secret_key'));

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $amount = $paymentData['amount'] * 100;

            $ssss = $stripe->charges->create([
                'amount' => $amount,
                'currency' => 'usd',
                'customer' => $paymentData['stripe_customer_id'],
                'card' => $paymentData['source'],
            ]);

            $response['data'] = $ssss;
            $response['success'] = TRUE;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function createCard($card = NULL)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            self::setStripeApiKey();

            $token = $card['token'];
            $customer = \Stripe\Customer::retrieve($card['stripe_customer_id']);
            if ($customer->sources) {
                $card = $customer->sources->create(array("source" => $token));
            } else {
                $stripe = new \Stripe\StripeClient(
                    config('mail.stripe.secret_key')
                );
                $card = $stripe->customers->createSource(
                    $card['stripe_customer_id'],
                    ['source' => $token]
                );
            }
            $response['success'] = TRUE;
            $response['card'] = $card;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
    }

    public static function deleteCard($card = NULL)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $result = $stripe->customers->deleteSource(
                $card['stripe_customer_id'],
                $card['stripe_card_id'],
                []
            );

            if ($result->deleted) {
                $response['success'] = TRUE;
            }
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        return $response;
        return FALSE;
    }

    public static function createAccount($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);
            if ($data['country'] == 'US') {
                $countryData = [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ];
                $termCondition = [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time(),
                ];
                $currency = 'USD';
            } else {
                $countryData = [
                    'transfers' => ['requested' => true],
                ];
                $termCondition = [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time(),
                    'service_agreement' => 'recipient',
                ];
                $currency = 'CAD';
            }

            //=============================================
            $accountObj = $stripe->accounts->create([
                'type' => 'custom',
                'country' => $data['country'],
                'email' => $data['email'],
                'capabilities' => $countryData,
                'business_type' => 'individual',
                'individual' => [
                    'first_name' =>  $data['first_name'],
                    'last_name' => $data['last_name'],
                    'dob' => [
                        'day' => '',
                        'month' => '',
                        'year' => '',
                    ],
                    'address' => [
                        'line1' => '',
                        'postal_code' => '',
                        'city' => '',
                        'state' => '',
                    ],
                    'email' => $data['email'],
                    'phone' => '',
                    'id_number' => ''
                ],
                'tos_acceptance' => [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time()
                ],
                'external_account' => [
                    'country' => $data['country'],
                    'currency' => $currency,
                    'account_number' => $data['account_number'],
                    'account_holder_name' => $data['account_holder_name'],
                    'object' => 'bank_account',
                    'account_holder_type' => 'individual',
                    'routing_number' => $data['routing_number'],
                ]
            ]);

            print_r($accountObj);
            //=============================================

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function createExternalAccount($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);
            if ($data['country'] == 'US') {
                $countryData = [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ];
                $termCondition = [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time(),
                ];
            } else {
                $countryData = [
                    'transfers' => ['requested' => true],
                ];
                $termCondition = [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time(),
                    'service_agreement' => 'recipient',
                ];
            }
            $accountObj = $stripe->accounts->create([
                'type' => 'custom',
                'country' => $data['country'],
                'email' => $data['email'],
                'capabilities' => $countryData,
                'tos_acceptance' => $termCondition,
            ]);

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function getStripeCustomer($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);

            $accountObj = $stripe->accounts->retrieve(
                $data['stripe_connected_account_id'],
                []
            );

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function updateAccount($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);
            error_log(print_r($data, true));

            $individual = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],

                'dob' => [
                    'day' => $data['dob']['day'],
                    'month' => $data['dob']['month'],
                    'year' => $data['dob']['year'],
                ],
                'address' => [
                    'line1' => $data['address']['line1'],
                    'postal_code' => $data['address']['postal_code'],
                    'city' => $data['address']['city'],
                    'state' => $data['address']['state'],
                ],
                'email' => $data['email'],
                'phone' => $data['mobile']

            ];
            if (!empty($data['ssn_last_4'])) {
                $individual['ssn_last_4'] = $data['ssn_last_4'];
            }
            if ($data['country'] == 'US') {
                $termCondition = [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time(),
                ];
            } else {
                $termCondition = [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time(),
                    'service_agreement' => 'recipient',
                ];
            }
            $accountObj = $stripe->accounts->update(
                $data['stripe_account_id'],
                [
                    'business_type' => 'individual',
                    'business_profile' => [
                        'mcc' => 1520,
                        'product_description' => 'Property owner.'
                    ],
                    'individual' => $individual,
                    'tos_acceptance' => $termCondition,

                ]
            );

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }
    public static function getAccountById($accountId)
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $accountObj = $stripe->accounts->retrieve(
                $accountId,
                []
            );

            $response['success'] = TRUE;
            $response['data'] = $accountObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function createBank($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );
            if ($data['country'] == 'US') {
                $currencyObj = "USD";
            } else {
                $currencyObj = 'CAD';
            }

            $bankObj = $stripe->accounts->createExternalAccount(
                $data['stripe_connected_account_id'],
                [
                    'external_account' => [
                        'country' => $data['country'] ?? 'CA', // change this based on user country
                        'currency' => $currencyObj ?? 'CAD', // change this based on user country
                        'account_number' => $data['account_number'] ?? '000123456789', // change this based on app requirement
                        'account_holder_name' => $data['account_holder_name'], // change this based on app requirement
                        'object' => 'bank_account',
                        'account_holder_type' => 'individual',
                        'routing_number' => $data['routing_number'] ?? '11000-000', // formate should be TransitNumber-InstitutionNumber
                    ]
                ]
            );

            $response['success'] = TRUE;
            $response['data'] = $bankObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        print_pre($response);
        return $response;
    }

    public static function deleteBank($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );

            $bankObj = $stripe->accounts->deleteExternalAccount(
                $data['stripe_connected_account_id'],
                $data['stripe_bank_id'],
                []
            );

            $response['success'] = TRUE;
            $response['data'] = $bankObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    public static function transfer($data = [])
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient(
                config('mail.stripe.secret_key')
            );
            error_log(print_r($data, true));

            $adminCommission = $data['amount'] * (10 / 100);
            $finalAmount = $data['amount'] - $adminCommission;
            $transferObj = $stripe->transfers->create([
                'amount' => $finalAmount * 100,
                'currency' => 'usd',
                'destination' => $data['stripe_connected_account_id'],
                "source_transaction" => $data['chargeId'],
            ]);

            $response['success'] = TRUE;
            $response['data'] = $transferObj;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    /**
     * @param array $data
     * @return array
     * @throws Exception
     */
    public static function createConnectAccount(array $data = []): array
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);
            error_log(print_r($data, true));

            $payload = [
                'type' => 'custom',
                'email' => $data['email'],
                'business_type' => 'individual',
                'business_profile' => [
                    'mcc' => 1520,
                    'product_description' => 'Property owner.'
                ],
                'individual' => [
                    'first_name' => $data['name'] ?? "Property",
                    'last_name' => $data['last_name'] ?? "Owner" . @$data['id'],
                    'dob' => [
                        'day' => date("d", strtotime($data['dob'])) ?? "01",
                        'month' => date("m", strtotime($data['dob'])) ?? "01",
                        'year' => date("Y", strtotime($data['dob'])) ?? "1995",
                    ],
                    'email' => $data['email'] ?? 'dhanu@wyzewaze.com',
                    'phone' => $data['mobile'] ?? '2145477814',
                    'id_number' => $data['ssn_last_4'] ?? '000000000'
                ],
                'tos_acceptance' => [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'date' => time(),
                    'service_agreement' => "recipient"
                ]
            ];

            if ($data['country'] == 'US') {
                $payload['country'] = 'US';
                $payload['tos_acceptance']['service_agreement'] = '';
                $payload['individual']['id_number'] = $data['ssn_last_4'] ?? '000000000';
            } else {
                $payload['country'] = 'CA';
                $payload['tos_acceptance']['service_agreement'] = '';
                $payload['individual']['id_number'] = '';
            }

            $payload['capabilities'] = [
                'transfers' => ['requested' => true],
                'card_payments' => ['requested' => true],
            ];
            $payload['individual']['address'] = [
                'line1' => $data['address_line1'] ?? '3555 Don Mills Rd',
                'postal_code' => $data['postal_code'] ?? 'M2H 3N3',
                'city' => $data['city'] ?? 'Toronto',
                'state' => $data['state'] ?? 'Ontario',
                'country' => $data['country'] ?? 'CA',
            ];
            error_log(print_r($payload, true));

            $account = $stripe->accounts->create($payload);
            Log::debug($account);

            $response['success'] = TRUE;
            $response['data'] = $account;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }

    /**
     * @param array $data
     * @return array
     * @throws Exception
     */
    public static function updateConnectBankAccount(array $data = []): array
    {
        $response = [];
        $response['success'] = FALSE;
        try {
            self::setStripeApiKey();

            $stripe = new \Stripe\StripeClient([
                "api_key" => config('mail.stripe.secret_key'),
                "stripe_version" => "2020-08-27"
            ]);
            $payload = [
                'external_account' => [
                    'country' => $data['country'],
                    'currency' => $data['currency'],
                    'account_number' => $data['account_number'],
                    'account_holder_name' => $data['account_holder_name'],
                    'object' => 'bank_account',
                    'account_holder_type' => 'individual',
                    'routing_number' => $data['routing_number'], // format should be TransitNumber-InstitutionNumber
                ]
            ];
            $account = $stripe->accounts->update($data['stripe_connected_account_id'], $payload);
            Log::debug($account);
            $response['success'] = TRUE;
            $response['data'] = $account;
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getError()->message;
            $response['code'] = $e->getError()->code;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = "";
        }
        //print_pre($response);
        return $response;
    }
}
