# <div align="center">⚡ PipraPay — Direct Payment Automation & Verification Tool</div>

<p align="center">
  <strong>Self-Hosted Direct Payment Automation • Zero Fund Custody • Instant Verification</strong><br>
  <em>Modernized Checkout UI • Peer-to-Peer & Direct Accounts • 100% Direct to Seller</em>
</p>

<p align="center">
  <a href="#-important-disclaimer--what-piprapay-is-and-is-not"><img src="https://img.shields.io/badge/Architecture-Direct_to_Seller_(Non--Custodial)-10b981?style=for-the-badge&logo=shield&logoColor=white" alt="Non-Custodial"></a>
  <a href="#-developer-documentation--api-reference"><img src="https://img.shields.io/badge/Docs_Portal-Interactive_Guides-8b5cf6?style=for-the-badge&logo=googledocs&logoColor=white" alt="Documentation"></a>
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

## 📚 Developer Documentation & API Reference

All REST API specifications, checkout creation endpoints, payload parameters, multi-language code snippets (cURL, PHP, Node.js, Python), and webhook IPN guides are documented in the built-in documentation portal:

* **Interactive Docs Portal**: Open `http://localhost/payments/docs/` (or [docs/index.html](docs/index.html)) in your browser.
* **Included in `/docs/`**:
  * Complete REST API endpoint reference (`/api/checkout/redirect`, `/api/verify-payment`, `/api/refund-payment`)
  * Full parameter definitions, requirement badges, and headers
  * Copy-paste ready code examples (cURL, PHP, Node.js, Python)
  * Instant search and keyboard shortcuts (`Ctrl+K` / `Cmd+K`)
  * Android Companion SMS sync & mobile communication protocols

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
