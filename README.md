# <div align="center">⚡ PipraPay — Direct Payment Automation & Verification Tool</div>

<p align="center">
  <strong>Self-Hosted Direct Payment Automation • Zero Fund Custody • Instant Verification</strong><br>
  <em>Modernized Checkout UI • Peer-to-Peer & Direct Accounts • 100% Direct to Seller</em>
</p>

<p align="center">
  <a href="#-important-disclaimer--what-piprapay-is-and-is-not"><img src="https://img.shields.io/badge/Architecture-Direct_to_Seller_(Non--Custodial)-10b981?style=for-the-badge&logo=shield&logoColor=white" alt="Non-Custodial"></a>
  <a href="#-how-to-create-orders-checkout-api-guide"><img src="https://img.shields.io/badge/Checkout_API-Quick_Integration-8b5cf6?style=for-the-badge&logo=fastapi&logoColor=white" alt="Checkout API"></a>
  <a href="#-uiux-transformation-showcase"><img src="https://img.shields.io/badge/UI_Edition-Modern_Glassmorphism-06b6d4?style=for-the-badge&logo=sparkles&logoColor=white" alt="UI Edition"></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-AGPL--3.0-3b82f6.svg?style=for-the-badge&logo=gnu&logoColor=white" alt="AGPL-3.0 License"></a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.0%20|%208.1%20|%208.2-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8">
  <img src="https://img.shields.io/badge/Database-MySQL_5.7+_%7C_MariaDB-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Model-Direct_P2P_Automation-emerald?style=flat-square&logo=cashapp&logoColor=white" alt="Direct P2P">
  <img src="https://img.shields.io/badge/Companion_App-Android_SMS_Sync-3DDC84?style=flat-square&logo=android&logoColor=white" alt="Android Companion">
  <img src="https://img.shields.io/badge/API-RESTful_v1-ec4899?style=flat-square&logo=postman&logoColor=white" alt="REST API">
</p>

---

> [!IMPORTANT]
> ### 🚫 Critical Notice: Non-Custodial Direct Payment Automation Tool
> **PipraPay is NOT a payment aggregator, payment gateway, escrow service, or financial middleman.**
>
> * **Zero Fund Custody**: PipraPay **never** receives, collects, pools, holds, or distributes customer money.
> * **100% Direct to Seller**: All payments are sent **directly from the customer to the seller's/merchant's own personal or business accounts** (bKash, Nagad, Rocket, Upay, Bank, etc.).
> * **Pure Automation & Verification**: PipraPay functions strictly as an **automotive payment verification tool**. It reads incoming payment alerts (via the self-hosted Android SMS companion or direct callbacks), matches the transaction data against initiated orders, and automatically marks the order as paid on the merchant's backend.

---

## ⚡ Overview & What's New

This repository is a **Modernized UI/UX Edition** of the open-source **[PipraPay](https://piprapay.com)** automated payment ecosystem.

```text
┌────────────────────────────────────────────────────────────────────────────────────────┐
│  ✨ SPECIAL EDITION HIGHLIGHTS                                                         │
│                                                                                        │
│  ✔ Modern Dark/Glassmorphism Checkout Interface                                       │
│  ✔ Revamped Customer-Facing Flow (Selection ➔ Account Info ➔ Verification ➔ Receipt)  │
│  ✔ Automated SMS-Based Direct Payment Verification Pipeline                            │
│  ✔ Modern Success & Failure Screens with Instant Copying & Live Redirection            │
│  ✔ 100% Untouched Core Security, Encryption & Database Schemas                        │
└────────────────────────────────────────────────────────────────────────────────────────┘
```

---

## 🎨 UI/UX Transformation Showcase

| Screen / Flow | Experience | Description |
| :--- | :---: | :--- |
| **💳 Modern Checkout** | `Payment Selection` | Sleek dark-mode container with dynamic timer counters, instant account number copying, and step-by-step guidance. |
| **✅ Success State UI** | `Payment Approved` | High-clarity digital receipt displaying transaction ID, amount, payment channel badge, and animated redirection. |
| **⚠️ Error & Cancel State UI** | `Payment Failed` | Informative state screen detailing error reasons, retry mechanisms, and merchant support identifiers. |
| **📚 Developer Portal** | `/docs/` | Interactive developer playground featuring cURL, PHP, JS snippets, copy-paste shortcuts, and payload inspectors. |

---

## 🌐 Supported Direct Payment Channels & Methods

PipraPay automates payment verification across a wide range of direct seller accounts:

<details open>
<summary><b>📱 Mobile Financial Services (MFS) & Direct Accounts</b></summary>

<br>

| Channel | Supported Account Types | Verification Method |
| :--- | :--- | :--- |
| **bKash** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching / API |
| **Nagad** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching / API |
| **Rocket** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching |
| **Upay** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching |
| **Cellfin** | Personal, Virtual Card | Direct to Seller + Instant Verification |
| **OK Wallet** | Personal, Merchant, Agent | Direct to Seller + Automated Verification |
| **Tap / TeleCash** | Personal, Merchant, Agent | Direct to Seller + Automated Verification |

</details>

<details>
<summary><b>💳 Direct Gateway & Transfer Connectors</b></summary>

<br>

| Channel / Connector | Type | Automation Feature |
| :--- | :--- | :--- |
| **Stripe** | Direct Merchant Account | Instant Webhook & 3D-Secure |
| **PayPal** | Direct Merchant Account | IPN & Instant Callback |
| **SSLCommerz** | Direct Merchant Account | Hosted Checkout & IPN |
| **Shurjopay** | Direct Merchant Account | Instant Verification |
| **NOWPayments & OxaPay** | Direct Merchant Wallet | Auto Crypto Confirmations (BTC, USDT, etc.) |
| **Wise / Payoneer / Payeer**| Direct Seller Account | Manual / Automated Matching |

</details>

---

## 🚀 Quick Setup & Installation

### 1. Requirements
* **PHP**: `8.0`, `8.1`, or `8.2`
* **PHP Extensions**: `curl`, `pdo_mysql`, `mbstring`, `openssl`, `json`, `gd`
* **Database**: MySQL `5.7+` or MariaDB `10.3+`
* **Web Server**: Apache (`mod_rewrite` enabled) or Nginx

### 2. Fast Installation

```bash
# 1. Clone the repository into your web root
git clone https://github.com/jisan789/piprapay.git /var/www/html/payments

# 2. Set directory permissions
cd /var/www/html/payments
chmod -R 755 .
chmod -R 777 pp-content/pp-upload pp-media/storage

# 3. Open the web installer in your browser:
# http://localhost/payments/pp-content/pp-install/
```

### 3. Setup Android Companion (For Direct SMS Payment Verification)

```text
Step 1 ➔ Install PipraPay Companion APK on the Android phone that receives your payment SMS alerts.
Step 2 ➔ In PipraPay Admin: Go to "Settings" > "Companion App".
Step 3 ➔ Copy the one-time authentication token.
Step 4 ➔ Enter the token in the Android app and tap "Start Syncing".
```

---

## 📖 How to Create Orders (Checkout API Guide)

Integrating PipraPay direct payment automation into your application or eCommerce store is simple. Follow the step-by-step guide below to initialize payments, redirect customers, and receive automated verification notifications.

---

### 1️⃣ Authentication & Endpoint

* **Endpoint**: `POST https://yourdomain.com/api/checkout/redirect`
* **Headers**:
  ```http
  MHS-PIPRAPAY-API-KEY: YOUR_MERCHANT_API_KEY
  Content-Type: application/json
  ```

---

### 2️⃣ Request Parameters

| Parameter | Type | Required | Description |
| :--- | :---: | :---: | :--- |
| `full_name` | `string` | **Yes** | Full customer name (e.g. `John Doe`). |
| `email_address` | `string` | **Yes** | Customer email address for transaction invoices and records. |
| `mobile_number` | `string` | **Yes** | Customer mobile number (e.g. `01700000000`). |
| `amount` | `number` | **Yes** | Order payable amount (must be positive, e.g. `500.00`). |
| `currency` | `string` | **Yes** | Active brand currency code (e.g. `BDT`, `USD`, `INR`). |
| `return_url` | `string` | *Optional* | URL to redirect customer after payment completion. |
| `webhook_url` | `string` | *Optional* | Server webhook URL to receive instant asynchronous POST notifications. |
| `metadata` | `object` | *Optional* | Custom merchant data object (e.g. `{"order_id": "ORD-9021", "user_id": "42"}`). |

---

### 3️⃣ Code Implementation Examples

<details open>
<summary><b>🐘 PHP (cURL Implementation)</b></summary>

```php
<?php
$apiKey   = "YOUR_MERCHANT_API_KEY";
$endpoint = "https://yourdomain.com/api/checkout/redirect";

$orderData = [
    "full_name"     => "John Doe",
    "email_address" => "john@example.com",
    "mobile_number" => "01700000000",
    "amount"        => 500.00,
    "currency"      => "BDT",
    "return_url"    => "https://merchant-store.com/payment/callback",
    "webhook_url"   => "https://merchant-store.com/payment/webhook",
    "metadata"      => [
        "order_id"    => "INV-10029",
        "customer_id" => "CUST-8812"
    ]
];

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "MHS-PIPRAPAY-API-KEY: " . $apiKey,
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (!empty($result['pp_url'])) {
    // Redirect customer to the PipraPay checkout page
    header("Location: " . $result['pp_url']);
    exit;
} else {
    echo "Payment initialization failed: " . ($result['error']['message'] ?? 'Unknown error');
}
```
</details>

<details>
<summary><b>🟢 Node.js (Axios Implementation)</b></summary>

```javascript
const axios = require('axios');

async function createPipraPayOrder() {
  const apiKey = 'YOUR_MERCHANT_API_KEY';
  const endpoint = 'https://yourdomain.com/api/checkout/redirect';

  const orderData = {
    full_name: 'John Doe',
    email_address: 'john@example.com',
    mobile_number: '01700000000',
    amount: 500.00,
    currency: 'BDT',
    return_url: 'https://merchant-store.com/payment/callback',
    webhook_url: 'https://merchant-store.com/payment/webhook',
    metadata: {
      order_id: 'INV-10029',
      customer_id: 'CUST-8812'
    }
  };

  try {
    const { data } = await axios.post(endpoint, orderData, {
      headers: {
        'MHS-PIPRAPAY-API-KEY': apiKey,
        'Content-Type': 'application/json'
      }
    });

    console.log('Payment ID:', data.pp_id);
    console.log('Redirect User to:', data.pp_url);
    // Express response redirect: res.redirect(data.pp_url);
  } catch (error) {
    console.error('Order creation error:', error.response?.data || error.message);
  }
}

createPipraPayOrder();
```
</details>

<details>
<summary><b>🐍 Python (Requests Implementation)</b></summary>

```python
import requests

api_key = "YOUR_MERCHANT_API_KEY"
endpoint = "https://yourdomain.com/api/checkout/redirect"

payload = {
    "full_name": "John Doe",
    "email_address": "john@example.com",
    "mobile_number": "01700000000",
    "amount": 500.00,
    "currency": "BDT",
    "return_url": "https://merchant-store.com/payment/callback",
    "webhook_url": "https://merchant-store.com/payment/webhook",
    "metadata": {
        "order_id": "INV-10029"
    }
}

headers = {
    "MHS-PIPRAPAY-API-KEY": api_key,
    "Content-Type": "application/json"
}

response = requests.post(endpoint, json=payload, headers=headers)
data = response.json()

if "pp_url" in data:
    print("Redirect customer to:", data["pp_url"])
else:
    print("Failed to initialize:", data.get("error", {}).get("message"))
```
</details>

<details>
<summary><b>💻 cURL Command</b></summary>

```bash
curl -X POST https://yourdomain.com/api/checkout/redirect \
  -H "MHS-PIPRAPAY-API-KEY: YOUR_MERCHANT_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "John Doe",
    "email_address": "john@example.com",
    "mobile_number": "01700000000",
    "amount": 500.00,
    "currency": "BDT",
    "return_url": "https://merchant-store.com/payment/callback",
    "webhook_url": "https://merchant-store.com/payment/webhook",
    "metadata": {
      "order_id": "INV-10029"
    }
  }'
```
</details>

---

### 4️⃣ Success Response (HTTP 200 OK)

When an order is created successfully, PipraPay returns a 27-character payment reference identifier (`pp_id`) and the hosted checkout payment URL (`pp_url`):

```json
{
  "pp_id": "9A8B7C6D5E4F3G2H1I0J1K2L3M4",
  "pp_url": "https://yourdomain.com/payment/9A8B7C6D5E4F3G2H1I0J1K2L3M4"
}
```

---

### 5️⃣ Handling Webhooks & Verification

#### A. Webhook Notification (Instant Server-to-Server IPN)
When direct payment is approved (either automatically via SMS matching or connector callback), PipraPay sends a `POST` request to your `webhook_url`:

```json
{
  "event": "payment.completed",
  "pp_id": "9A8B7C6D5E4F3G2H1I0J1K2L3M4",
  "status": "completed",
  "amount": "500.00",
  "currency": "BDT",
  "transaction_id": "BKX78942918",
  "gateway": "bkash-personal",
  "metadata": {
    "order_id": "INV-10029",
    "customer_id": "CUST-8812"
  }
}
```

#### B. Manual Payment Verification API
You can also verify any transaction status server-side at any time:

* **Endpoint**: `POST https://yourdomain.com/api/verify-payment`
* **Request**:
  ```json
  {
    "pp_id": "9A8B7C6D5E4F3G2H1I0J1K2L3M4"
  }
  ```
* **Response**:
  ```json
  {
    "status": "completed",
    "pp_id": "9A8B7C6D5E4F3G2H1I0J1K2L3M4",
    "amount": "500.00",
    "currency": "BDT",
    "transaction_id": "BKX78942918",
    "verified_at": "2026-10-01 00:15:30"
  }
  ```

---

## 🔒 Security & Verification Guarantee

```text
  🛡️ SECURE SYSTEM INTEGRITY
  ────────────────────────────────────────────────────────────────
  [✓] All payment calculations are processed server-side.
  [✓] Transaction IDs are cryptographically hashed & uniqueness-checked.
  [✓] SQL injection protection via PDO Prepared Statements.
  [✓] Webhook notifications are cryptographically signed.
  [✓] Sensitive API keys are encrypted at rest.
  [✓] Non-custodial direct peer-to-peer payment model.
```

---

## 📄 License & Credits

- **Original Engine**: Designed & conceptualized by the [PipraPay](https://piprapay.com) Community.
- **License**: Released under the **GNU Affero General Public License v3.0 (AGPL-3.0)**.
- **Modifications**: Front-end user experience, modernized checkout views, success/failure UI redesign, and interactive developer docs. Core transaction security and direct payment logic remain 100% compliant with upstream PipraPay.

<div align="center">
  <sub>Crafted for modern fintech workflows • Non-Custodial Direct Payment Automation</sub>
</div>
