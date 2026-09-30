# 🐜 PipraPay (Enhanced UI & Checkout Edition)

<p align="center">
  <img src="https://img.shields.io/badge/Edition-UI%20Updated%20Fork-6366f1?style=for-the-badge&logo=sparkles&logoColor=white" alt="UI Updated Edition">
  <img src="https://img.shields.io/badge/Security-Original%20PipraPay%20Core-emerald?style=for-the-badge&logo=shield" alt="Core Security Untouched">
  <img src="https://img.shields.io/badge/Payment-Automatic%20Verification-blue?style=for-the-badge&logo=check-circle" alt="Automatic Payment Verification">
  <img src="https://img.shields.io/badge/License-AGPL--3.0-blue.svg?style=for-the-badge&logo=gnu&logoColor=white" alt="AGPL-3.0 License">
</p>

---

## 🌟 About This Edition

This repository is a **Modern UI/UX Enhanced Version** of the open-source **[PipraPay](https://piprapay.com)** payment automation engine. 

> **Important Note on System Integrity & Security:**  
> **No changes have been made to the core business logic, verification security mechanisms, or database schemas.** All fundamental security validations, encryption routines, API authentications, and transaction pipelines remain completely intact and aligned with the original PipraPay standard.

### ✨ Key Enhancements in this Version:
* **Modernized User-Side Payment UI**: A streamlined, mobile-first, and highly intuitive checkout interface for customers.
* **Redesigned Success & Error Screens**: Beautifully styled status pages providing clear transaction summaries, reference tokens, and actionable feedback.
* **Automatic Payment Verification**: Smooth end-to-end verification workflows connecting customer inputs, SMS automation, and merchant webhooks.
* **Interactive API Documentation**: Polished in-repo REST API & Android Companion sync documentation available directly via `/docs/`.

---

## ⚡ Core Features

- **Automated Payment Verification**: Converts SMS payment alerts into instant, verifiable webhook and callback events.
- **Unified Multi-Gateway Interface**: Accept payments across Mobile Financial Services (bKash, Nagad, Rocket, Upay, etc.), Bank transfers, and Card gateways.
- **Android Companion App Support**: Synchronizes incoming device payment SMS notifications securely with the backend.
- **Instant Webhooks & IPN**: Delivers instant JSON notifications to merchant endpoints upon payment completion.
- **Self-Hosted & Private**: Retain 100% control and privacy of your transaction records and customer payment data.

---

## 🖥️ User Experience & UI Highlights

| Flow / Page | Description |
| :--- | :--- |
| **Checkout & Payment Selection** | Redesigned modern interface with tabbed payment options, step-by-step instructions, and dynamic timers. |
| **Success Receipt (`success.php`)** | Crisp, professional confirmation screen with transaction ID, amount, date, and redirect triggers. |
| **Error & Cancellation (`error.php`)** | Clean, user-friendly error state reporting with retry triggers and support identifiers. |
| **API Documentation (`/docs/`)** | Interactive developer portal featuring code snippets (cURL, PHP, Node.js, Python), payload schemas, and copy shortcuts. |

---

## 🚀 Getting Started & Installation

### Requirements
- **PHP**: 8.0, 8.1, or 8.2 (with `curl`, `json`, `mbstring`, `pdo_mysql`, `openssl` extensions enabled)
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Web Server**: Apache (`mod_rewrite` enabled) or Nginx

### Installation Steps

1. **Clone or Download the Repository**:
   ```bash
   git clone https://github.com/your-username/piprapay-ui-updated.git
   ```
2. **Move to Web Server Directory**:
   Place the files inside your web server document root (e.g., `c:/xampp/htdocs/payments` or `/var/www/html/payments`).

3. **Run Web Installer**:
   Open your browser and navigate to the installation wizard:
   ```text
   http://localhost/payments/pp-content/pp-install/
   ```

4. **Complete Setup**:
   Follow the on-screen installer instructions to configure your database credentials, system URL, and admin account.

---

## 📱 Android Companion App

For automated SMS transaction reading and matching:
1. Download the **PipraPay Companion** app on your payment receiver Android device.
2. In your PipraPay Admin Panel, navigate to **Settings > Companion App** to generate your one-time sync OTP.
3. Login via the Android app to begin automated background transaction synchronization.

---

## 📚 API Reference & Documentation

Explore the built-in developer documentation:
- **Local Interactive Docs**: Open `http://localhost/payments/docs/` in your browser.
- **Official Documentation**: [https://help.piprapay.com/](https://help.piprapay.com/)
- **API Reference**: [https://piprapay.readme.io](https://piprapay.readme.io)

---

## 🛡️ Upstream Attribution & License

- **Original Project**: [PipraPay](https://piprapay.com)
- **License**: [AGPL-3.0 License](LICENSE)
- **Modifications**: Front-end user experience, checkout views, success/failure UI redesign, and interactive developer docs. Core transaction security and payment logic remain 100% compliant with upstream PipraPay.
