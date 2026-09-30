<div align="center">

# `PIPRAPAY`
### Direct Payment Automation & Instant Verification Engine

[![License: AGPL-3.0](https://img.shields.io/badge/License-AGPL--3.0-3b82f6.svg?style=for-the-badge&logo=gnu&logoColor=white)](LICENSE)
[![Model: Non-Custodial](https://img.shields.io/badge/Model-Non--Custodial_Direct_P2P-10b981?style=for-the-badge&logo=shield&logoColor=white)](#01-non-custodial-architecture--disclaimer)
[![Docs: Interactive Portal](https://img.shields.io/badge/Docs-Interactive_Portal-8b5cf6?style=for-the-badge&logo=googledocs&logoColor=white)](#05-developer-documentation--api-reference)
[![Checkout UI: Enhanced](https://img.shields.io/badge/Checkout_UI-Modern_Glassmorphism-06b6d4?style=for-the-badge&logo=sparkles&logoColor=white)](#02-uiux-transformation--flow-overview)

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.0_|_8.1_|_8.2-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP Support">
  <img src="https://img.shields.io/badge/Database-MySQL_5.7+_|_MariaDB-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="Database Support">
  <img src="https://img.shields.io/badge/Companion_App-Android_SMS_Sync-3DDC84?style=flat-square&logo=android&logoColor=white" alt="Android Sync">
  <img src="https://img.shields.io/badge/API-RESTful_v1-ec4899?style=flat-square&logo=postman&logoColor=white" alt="REST API">
  <img src="https://img.shields.io/badge/Architecture-Self--Hosted-64748b?style=flat-square&logo=serverfault&logoColor=white" alt="Self Hosted">
</p>

---

**Self-Hosted Direct Payment Automation • Zero Fund Custody • Instant SMS Verification**  
*Direct Peer-to-Peer Transactions • Automated Reconciliation • Untouched Core Security*

</div>

---

## 01. Non-Custodial Architecture & Disclaimer

> [!IMPORTANT]
> **CRITICAL ARCHITECTURAL NOTICE:**  
> **PipraPay is NOT a payment aggregator, payment gateway, escrow service, or financial middleman.**

```text
┌────────────────────────────────────────────────────────────────────────────────────────┐
│ DIRECT PAYMENT AUTOMATION PRINCIPLES                                                   │
├────────────────────────────────────────────────────────────────────────────────────────┤
│ [1] ZERO FUND CUSTODY:                                                                 │
│     The software never collects, pools, holds, or distributes customer money.          │
│                                                                                        │
│ [2] 100% DIRECT TO SELLER:                                                             │
│     Customers send funds directly to the seller's/merchant's personal or business      │
│     accounts (bKash, Nagad, Rocket, Upay, Bank, etc.).                                 │
│                                                                                        │
│ [3] AUTOMATED VERIFICATION ONLY:                                                       │
│     PipraPay operates purely as an automation system that captures incoming payment    │
│     notifications (via Android SMS companion or direct callbacks) and automatically    │
│     marks the merchant's orders as verified.                                           │
└────────────────────────────────────────────────────────────────────────────────────────┘
```

---

## 02. UI/UX Transformation & Flow Overview

This repository features a comprehensive design overhaul of customer-facing touchpoints while preserving all core backend logic and security validations.

| Flow / Component | View Type | Key Features |
| :--- | :---: | :--- |
| **Checkout Interface** | Customer View | Modern dark glassmorphism styling, step-by-step guidance, one-click copy, and countdown timers. |
| **Success Receipt UI** | Status View | High-clarity digital receipt containing transaction ID, timestamp, channel badge, and redirection handler. |
| **Error & Cancellation UI** | Status View | Clear feedback detailing rejection/timeout reasons with retry mechanisms and merchant tracking identifiers. |
| **Developer Portal** | `/docs/` | Self-hosted interactive documentation with cURL, PHP, JS, and Python snippets. |

---

## 03. Supported Direct Channels & Connectors

PipraPay automates verification across direct seller accounts and standard merchant APIs:

<details open>
<summary><b>Mobile Financial Services (MFS) & Direct Accounts</b></summary>

<br>

| Channel | Supported Account Types | Verification Workflow |
| :--- | :--- | :--- |
| **bKash** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching / Merchant API |
| **Nagad** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching / Merchant API |
| **Rocket** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching |
| **Upay** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching |
| **Cellfin** | Personal, Virtual Card | Direct to Seller + Instant Reconciliation |
| **OK Wallet** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching |
| **Tap / TeleCash** | Personal, Merchant, Agent | Direct to Seller + Automated SMS Matching |

</details>

<details>
<summary><b>Direct Merchant Gateways & Transfer Connectors</b></summary>

<br>

| Connector | Type | Integration Mode |
| :--- | :--- | :--- |
| **Stripe** | Direct Merchant Account | Instant Webhooks & 3D-Secure Processing |
| **PayPal** | Direct Merchant Account | Instant Payment Notification (IPN) & Callbacks |
| **SSLCommerz** | Direct Merchant Account | Hosted Checkout & IPN Handlers |
| **Shurjopay** | Direct Merchant Account | Instant Verification API |
| **NOWPayments & OxaPay** | Direct Merchant Wallet | Automated Multi-Crypto Confirmations |
| **Wise / Payoneer / Payeer**| Direct Seller Account | Manual / Automated Transaction Reference Matching |

</details>

---

## 04. Installation & Deployment

### System Requirements
* **PHP**: `8.0`, `8.1`, or `8.2`
* **Extensions**: `curl`, `pdo_mysql`, `mbstring`, `openssl`, `json`, `gd`
* **Database**: MySQL `5.7+` or MariaDB `10.3+`
* **Web Server**: Apache (`mod_rewrite` enabled) or Nginx

### Quickstart Setup

```bash
# 1. Clone repository into web root
git clone https://github.com/jisan789/piprapay.git /var/www/html/payments

# 2. Configure directory permissions
cd /var/www/html/payments
chmod -R 755 .
chmod -R 777 pp-content/pp-upload pp-media/storage

# 3. Complete web installer via browser
# http://localhost/payments/pp-content/pp-install/
```

### Android SMS Companion Setup

```text
[Step 1] Install PipraPay Companion APK on the device receiving transaction SMS.
[Step 2] Navigate to Admin Panel -> Settings -> Companion App.
[Step 3] Generate and copy the one-time authentication token.
[Step 4] Authenticate the mobile companion app to initiate automated background sync.
```

---

## 05. Developer Documentation & API Reference

Comprehensive documentation for all endpoints, payload schemas, and webhook integrations is bundled directly inside the repository:

* **Interactive Documentation Portal**: Open `http://localhost/payments/docs/` (or [`docs/index.html`](docs/index.html))
* **Capabilities Covered**:
  * Complete REST API endpoint reference (`/api/checkout/redirect`, `/api/verify-payment`, `/api/refund-payment`)
  * Full parameter specifications, validation constraints, and authentication headers
  * Copy-ready integration code in **cURL**, **PHP**, **Node.js**, and **Python**
  * Instant search and keyboard shortcuts (`Ctrl+K` / `Cmd+K`)
  * Android Companion SMS sync and communication specifications

---

## 06. Security & System Integrity Guarantee

```text
SYSTEM INTEGRITY SPECIFICATION
--------------------------------------------------------------------------------
[PASSED] Server-side payment validation & amount tolerance checks
[PASSED] Cryptographic token generation & transaction uniqueness constraints
[PASSED] SQL injection protection via PDO Prepared Statements
[PASSED] Cryptographically signed Webhook / IPN dispatching
[PASSED] Encrypted credential storage at rest
[PASSED] 100% Non-custodial direct peer-to-peer payment flow
```

---

## 07. Licensing & Attribution

* **Original Platform**: Created and conceptualized by the [PipraPay](https://piprapay.com) Community.
* **License**: Released under the **GNU Affero General Public License v3.0 (AGPL-3.0)**.
* **Scope of Modifications**: User-facing UI overhaul, responsive checkout flow redesign, modern success and error interfaces, and bundled interactive developer documentation. Core payment logic and security standards remain 100% compliant with upstream PipraPay.

<div align="center">
  <sub>PipraPay Direct Payment Automation • Open Source AGPL-3.0</sub>
</div>
