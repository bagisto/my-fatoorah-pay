# Webkul Bagisto MyFatoorah Payment Gateway

### 1. Introduction

MyFatoorah Payment Gateway integrates **MyFatoorah's V3 Hosted Payment Page** with Bagisto as a payment method.

Customers are redirected to MyFatoorah's hosted payment page to complete their payments. The payment page displays the payment methods enabled on the merchant's MyFatoorah account, such as Visa, Mastercard, Mada, Apple Pay, Google Pay, KNET, and other supported methods.

The integration supports both **Sandbox** and **Production** environments.

**MyFatoorah Documentation:**

https://docs.myfatoorah.com/

---

### 2. Requirements

* **Bagisto:** 2.5.0
---

### 3. Installation

The MyFatoorah package is already registered in this repository. For a fresh installation, follow these steps.

**Step 1: Register the package**

Add the following entry under `autoload.psr-4` in `composer.json`:

```json
"Webkul\\Myfatoorah\\": "packages/Webkul/Myfatoorah/src"
```

**Step 2: Register the service provider**

Add the following entry to `bootstrap/providers.php`:

```php
Webkul\Myfatoorah\Providers\MyfatoorahServiceProvider::class,
```

**Step 3: Run the following commands**

```bash
composer dump-autoload

php artisan myfatoorah:install
```


The MyFatoorah Payment Gateway package is now registered.

---

### 4. Admin Configuration

Go to:

**Admin → Configure → Sales → Payment Methods → MyFatoorah**

Configure the following fields:

| Field                  | Description                                                                                                             |
| ---------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| **Status**             | Enable or disable the MyFatoorah payment method.                                                                        |
| **Description**        | Payment method description displayed at checkout.                                                                       |
| **Logo**               | Optional logo displayed for the payment method.                                                                         |
| **API Key**            | API token obtained from MyFatoorah Integration Settings.                                                                |
| **Test Mode**          | Enable to use the Sandbox environment; disable to use Production.                                                       |
| **Country ISO**        | Merchant account's country code, such as KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY. Determines the Production API host. |
| **Enable Webhook**     | Enable server-to-server payment notifications.                                                                          |
| **Webhook Secret Key** | Secret key used to verify webhook signatures. Required when webhooks are enabled.                                       |

**Note:** Use the credentials corresponding to the selected environment. The Country ISO setting determines the Production API host, while Sandbox uses the shared Sandbox host.

---

### 5. Webhook Setup

Register the following webhook URL in the MyFatoorah dashboard:

```text
https://<your-domain>/myfatoorah/webhook
```

Configure the webhook for **Payment Status Changed** events.

After registering the webhook:

1. Copy the webhook secret key provided by MyFatoorah.
2. Open **Admin → Configure → Sales → Payment Methods → MyFatoorah**.
3. Enable the webhook.
4. Enter the secret key in the **Webhook Secret Key** field.
5. Save the configuration.

The integration verifies the webhook signature using HMAC-SHA256 before processing the notification.

The webhook provides a server-to-server payment confirmation mechanism. The browser callback and webhook use the same settlement logic, preventing duplicate order creation when both notifications arrive.

**Important:** The webhook URL must be publicly accessible over HTTPS.

---

### 7. Sandbox Testing

For testing, enable **Test Mode** in the MyFatoorah payment configuration and use the API token from your Sandbox account.

1. Configure the Sandbox API key.
2. Enable the MyFatoorah payment method.
3. Configure the webhook if you want to test server-to-server notifications.
4. Place a test order and complete the payment using the payment options and test credentials provided by MyFatoorah for your Sandbox account.
5. Verify the payment status and order creation in Bagisto.

Refer to MyFatoorah's documentation for the latest country-specific Sandbox testing instructions.

---

