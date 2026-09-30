<div align="center">

# `PIPRAPAY`
### Direct Payment Automation & Instant Verification Engine

[![License: AGPL-3.0](https://img.shields.io/badge/License-AGPL--3.0-3b82f6.svg?style=for-the-badge&logo=gnu&logoColor=white)](LICENSE)
[![Model: Non-Custodial](https://img.shields.io/badge/Model-Non--Custodial_Direct_P2P-10b981?style=for-the-badge&logo=shield&logoColor=white)](#01-non-custodial-architecture--disclaimer)
[![Docs: Interactive Portal](https://img.shields.io/badge/Docs-Interactive_Portal-8b5cf6?style=for-the-badge&logo=googledocs&logoColor=white)](#05-developer-documentation--api-reference)
[![Checkout UI: Enhanced](https://img.shields.io/badge/Checkout_UI-Modern_Glassmorphism-06b6d4?style=for-the-badge&logo=sparkles&logoColor=white)](#02-uiux-transformation--flow-overview)
[![Automation: SMS Sync](https://img.shields.io/badge/Automation-Instant_SMS_Verification-f59e0b?style=for-the-badge&logo=android&logoColor=white)](#04-installation--deployment)

<br>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.0_|_8.1_|_8.2-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP Support">
  <img src="https://img.shields.io/badge/Database-MySQL_5.7+_|_MariaDB-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="Database Support">
  <img src="https://img.shields.io/badge/Web_Server-Apache_|_Nginx-009639?style=flat-square&logo=nginx&logoColor=white" alt="Web Server">
  <img src="https://img.shields.io/badge/Companion_App-Android_SMS_Sync-3DDC84?style=flat-square&logo=android&logoColor=white" alt="Android Sync">
  <img src="https://img.shields.io/badge/API-RESTful_v1-ec4899?style=flat-square&logo=postman&logoColor=white" alt="REST API">
  <img src="https://img.shields.io/badge/Architecture-Self--Hosted-64748b?style=flat-square&logo=serverfault&logoColor=white" alt="Self Hosted">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Fund_Custody-Zero_(100%25_Direct)-10b981?style=flat-square&logo=cashapp&logoColor=white" alt="Zero Custody">
  <img src="https://img.shields.io/badge/Middleman_Fees-0%25-blue?style=flat-square&logo=counterstrike&logoColor=white" alt="0% Fees">
  <img src="https://img.shields.io/badge/Security-AES--256_Encrypted-slate?style=flat-square&logo=lock&logoColor=white" alt="AES 256">
  <img src="https://img.shields.io/badge/Status-Production_Ready-brightgreen?style=flat-square&logo=checkmarx&logoColor=white" alt="Production Ready">
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

<div align="center">

![Non-Custodial](https://img.shields.io/badge/Custody-NON--CUSTODIAL-10b981?style=for-the-badge&logo=shield&logoColor=white)
![Direct Payment](https://img.shields.io/badge/Routing-DIRECT_TO_SELLER-blue?style=for-the-badge&logo=arrow-right&logoColor=white)
![Verification Engine](https://img.shields.io/badge/Function-AUTOMATION_&_VERIFY-8b5cf6?style=for-the-badge&logo=check-circle&logoColor=white)

</div>

---

## 02. UI/UX Transformation & Flow Overview

This repository features a comprehensive design overhaul of customer-facing touchpoints while preserving all core backend logic and security validations.

| Flow / Component | View Type | Status | Key Features |
| :--- | :---: | :---: | :--- |
| **Checkout Interface** | `Customer View` | ![Enhanced](https://img.shields.io/badge/Status-Enhanced-06b6d4?style=flat-square) | Modern dark glassmorphism styling, step-by-step guidance, one-click copy, and countdown timers. |
| **Success Receipt UI** | `Status View` | ![Active](https://img.shields.io/badge/Status-Redesigned-10b981?style=flat-square) | High-clarity digital receipt containing transaction ID, timestamp, channel badge, and redirection handler. |
| **Error & Cancellation UI** | `Status View` | ![Active](https://img.shields.io/badge/Status-Redesigned-f43f5e?style=flat-square) | Clear feedback detailing rejection/timeout reasons with retry mechanisms and merchant tracking identifiers. |
| **Developer Portal** | `/docs/` | ![Bundled](https://img.shields.io/badge/Portal-Local_Interactive-8b5cf6?style=flat-square) | Self-hosted interactive documentation with cURL, PHP, JS, and Python snippets. |

---

## 03. Supported Direct Channels & Connectors

PipraPay automates verification across direct seller accounts and standard merchant APIs:

<details open>
<summary><b>Mobile Financial Services (MFS) & Direct Accounts</b></summary>

<br>

| Channel Badge | Supported Account Types | Verification Workflow | Automation Mode |
| :--- | :--- | :--- | :---: |
| ![bKash](https://img.shields.io/badge/bKash-Personal%20%7C%20Merchant%20%7C%20Agent-E2136E?style=flat-square&logoColor=white) | Personal, Merchant, Agent | Customer transfers directly to seller &rarr; Companion app reads SMS &rarr; Auto-verifies order | ![Auto-SMS](https://img.shields.io/badge/Auto-SMS_Sync-10b981?style=flat-square) |
| ![Nagad](https://img.shields.io/badge/Nagad-Personal%20%7C%20Merchant%20%7C%20Agent-F7941E?style=flat-square&logoColor=white) | Personal, Merchant, Agent | Customer transfers directly to seller &rarr; Companion app reads SMS &rarr; Auto-verifies order | ![Auto-SMS](https://img.shields.io/badge/Auto-SMS_Sync-10b981?style=flat-square) |
| ![Rocket](https://img.shields.io/badge/Rocket-Personal%20%7C%20Merchant%20%7C%20Agent-8C3494?style=flat-square&logoColor=white) | Personal, Merchant, Agent | Direct P2P transfer &rarr; Automated SMS alert capture & TxnID matching | ![Auto-SMS](https://img.shields.io/badge/Auto-SMS_Sync-10b981?style=flat-square) |
| ![Upay](https://img.shields.io/badge/Upay-Personal%20%7C%20Merchant%20%7C%20Agent-0066B3?style=flat-square&logoColor=white) | Personal, Merchant, Agent | Direct P2P transfer &rarr; Automated SMS alert capture & TxnID matching | ![Auto-SMS](https://img.shields.io/badge/Auto-SMS_Sync-10b981?style=flat-square) |
| ![Cellfin](https://img.shields.io/badge/Cellfin-Account%20%7C%20Card-1E824C?style=flat-square&logoColor=white) | Personal, Virtual Card | Direct transfer &rarr; Instant transaction reference code validation | ![Instant](https://img.shields.io/badge/Auto-Direct-06b6d4?style=flat-square) |
| ![OK Wallet](https://img.shields.io/badge/OK_Wallet-Personal%20%7C%20Merchant-E31B23?style=flat-square&logoColor=white) | Personal, Merchant, Agent | Direct P2P transfer &rarr; Automated SMS alert capture & TxnID matching | ![Auto-SMS](https://img.shields.io/badge/Auto-SMS_Sync-10b981?style=flat-square) |
| ![Tap](https://img.shields.io/badge/Tap%20--%20TeleCash-Personal%20%7C%20Agent-F37021?style=flat-square&logoColor=white) | Personal, Merchant, Agent | Direct P2P transfer &rarr; Automated SMS alert capture & TxnID matching | ![Auto-SMS](https://img.shields.io/badge/Auto-SMS_Sync-10b981?style=flat-square) |

</details>

<details>
<summary><b>Direct Merchant Gateways & Transfer Connectors</b></summary>

<br>

| Connector Badge | Type | Integration Mode | Verification Type |
| :--- | :--- | :--- | :---: |
| ![Stripe](https://img.shields.io/badge/Stripe-Credit%20%2F%20Debit%20Cards-635BFF?style=flat-square&logo=stripe&logoColor=white) | Direct Merchant Account | Instant Webhooks & 3D-Secure Processing | ![Webhook](https://img.shields.io/badge/Mode-Webhook-6366f1?style=flat-square) |
| ![PayPal](https://img.shields.io/badge/PayPal-Wallet%20%2F%20Cards-00457C?style=flat-square&logo=paypal&logoColor=white) | Direct Merchant Account | Instant Payment Notification (IPN) & Callbacks | ![IPN](https://img.shields.io/badge/Mode-IPN-3b82f6?style=flat-square) |
| ![SSLCommerz](https://img.shields.io/badge/SSLCommerz-Hosted%20Gateway-005B94?style=flat-square&logoColor=white) | Direct Merchant Account | Hosted Checkout & IPN Handlers | ![Direct](https://img.shields.io/badge/Mode-Direct-06b6d4?style=flat-square) |
| ![Shurjopay](https://img.shields.io/badge/Shurjopay-Merchant%20API-2ECC71?style=flat-square&logoColor=white) | Direct Merchant Account | Instant Verification API Callback | ![API](https://img.shields.io/badge/Mode-API-8b5cf6?style=flat-square) |
| ![Crypto](https://img.shields.io/badge/Crypto-NOWPayments%20%7C%20OxaPay-F7931A?style=flat-square&logo=bitcoin&logoColor=white) | Direct Merchant Wallet | Automated Multi-Crypto On-Chain / API Confirmations | ![Blockchain](https://img.shields.io/badge/Mode-Crypto-f59e0b?style=flat-square) |
| ![Wise](https://img.shields.io/badge/International-Wise%20%7C%20Payoneer%20%7C%20Payeer-00B9FF?style=flat-square&logo=wise&logoColor=white) | Direct Seller Account | Manual / Automated Transaction Reference Matching | ![Sync](https://img.shields.io/badge/Mode-Sync-64748b?style=flat-square) |

</details>

---

## 04. Installation & Deployment

### System Requirements & Compatibility

<p>
  <img src="https://img.shields.io/badge/PHP-8.0_--_8.2-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/MariaDB-10.3+-C0765A?style=flat-square&logo=mariadb&logoColor=white" alt="MariaDB">
  <img src="https://img.shields.io/badge/Apache-mod__rewrite-D22128?style=flat-square&logo=apache&logoColor=white" alt="Apache">
  <img src="https://img.shields.io/badge/Nginx-Compatible-009639?style=flat-square&logo=nginx&logoColor=white" alt="Nginx">
  <img src="https://img.shields.io/badge/Extensions-curl_|_pdo_|_openssl_|_mbstring-slate?style=flat-square" alt="Extensions">
</p>

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

<div align="center">

[![Download Android Companion APK](https://img.shields.io/badge/Download_APK-Latest_Release-3DDC84?style=for-the-badge&logo=android&logoColor=white)](https://github.com/jisan789/piprapay/releases/latest)
[![Release Notes](https://img.shields.io/badge/Releases-Changelog_&_Assets-blue?style=for-the-badge&logo=github&logoColor=white)](https://github.com/jisan789/piprapay/releases)

</div>

```text
[Step 1] Download and install the PipraPay Companion APK from GitHub Releases.
[Step 2] Navigate to Admin Panel -> Settings -> Companion App.
[Step 3] Generate and copy the one-time authentication token.
[Step 4] Authenticate the mobile companion app to initiate automated background sync.
```

---

## 05. Developer Documentation & API Reference

Comprehensive documentation for all endpoints, payload schemas, and webhook integrations is bundled directly inside the repository:

<div align="center">

[![Explore Docs](https://img.shields.io/badge/Open_Documentation-Local_Portal-8b5cf6?style=for-the-badge&logo=read-the-docs&logoColor=white)](docs/index.html)

</div>

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

<p align="center">
  <img src="https://img.shields.io/badge/SQLi_Protection-PDO_Prepared_Statements-10b981?style=flat-square&logo=securityscorecard&logoColor=white" alt="SQLi Protection">
  <img src="https://img.shields.io/badge/Webhooks-Cryptographically_Signed-blue?style=flat-square&logo=json-web-tokens&logoColor=white" alt="Signed Webhooks">
  <img src="https://img.shields.io/badge/API_Keys-Encrypted_At_Rest-8b5cf6?style=flat-square&logo=letsencrypt&logoColor=white" alt="Encrypted Keys">
  <img src="https://img.shields.io/badge/Core_Logic-Original_PipraPay_Verified-06b6d4?style=flat-square&logo=checkmarx&logoColor=white" alt="Verified Logic">
</p>

---

## 07. Licensing & Attribution

* **Original Platform**: Created and conceptualized by the [PipraPay](https://piprapay.com) Community.
* **License**: Released under the **GNU Affero General Public License v3.0 (AGPL-3.0)**.
* **Scope of Modifications**: User-facing UI overhaul, responsive checkout flow redesign, modern success and error interfaces, and bundled interactive developer documentation. Core payment logic and security standards remain 100% compliant with upstream PipraPay.

<div align="center">
  <sub>PipraPay Direct Payment Automation • Open Source AGPL-3.0</sub>
</div>
