<?php
    if (!defined('PipraPay_INIT')) {
        http_response_code(403);
        exit('Direct access not allowed');
    }

    if(isset($_GET['lang'])){
        if($_GET['lang'] !== ""){
            pp_set_lang($_GET['lang']);
?>
            <script>
                location.href = '?lang=';
            </script>
<?php
            exit();
        }
    }

    if(isset($_GET['cancel'])){
        pp_set_transaction_status($data['transaction']['ref'], 'canceled');
?>
        <script>
            location.href = '<?php echo pp_checkout_address();?>';
        </script>
<?php
        exit();
    }

    $pp_gateways_mfs = pp_gateways('mfs', $data);
    $pp_gateways_bank = pp_gateways('bank', $data);
    $pp_gateways_global = pp_gateways('global', $data);

    $primaryColor = !empty($data['options']['primary_color']) ? $data['options']['primary_color'] : '#5f38f9';
    $textColor    = !empty($data['options']['text_color']) ? $data['options']['text_color'] : '#FFFFFF';
    $watermark    = !empty($data['options']['watermark_text']) ? $data['options']['watermark_text'] : '';
    $brandName    = !empty($data['brand']['name']) && $data['brand']['name'] !== '--' ? $data['brand']['name'] : ($data['brand']['identifyName'] ?? 'PipraPay');
    $brandLogo    = !empty($data['brand']['logo']) && $data['brand']['logo'] !== '--' ? $data['brand']['logo'] : (!empty($data['brand']['favicon']) && $data['brand']['favicon'] !== '--' ? $data['brand']['favicon'] : '');

    $seoTitle = trim($data['options']['seo_title'] ?? '');
    $seoDesc  = trim($data['options']['seo_description'] ?? '');
    $seoKey   = trim($data['options']['seo_keywords'] ?? '');
    $analyticsCode = trim($data['options']['analytics_code'] ?? '');

    $bgStyle = 'background: linear-gradient(135deg, #f6f8fc 0%, #edf2f9 100%);';
    if (!empty($data['options']['enable_bg_image']) && $data['options']['enable_bg_image'] === 'enabled' && !empty($data['options']['background_image'])) {
        $bgImage = $data['options']['background_image'];
        $bgStyle = "background-image: url('{$bgImage}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;";
    }
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($data['brand']['locale']['language'] ?? ($_SESSION['ui_language'] ?? 'bn')); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $data['lang']['checkout'] ?? 'Checkout'?> - <?php echo htmlspecialchars($brandName); ?></title>
    <link rel="shortcut icon" href="<?php echo $data['brand']['favicon'];?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php echo pp_assets('head'); ?>

    <?php
        if ($seoTitle !== '' && $seoTitle !== '--') {
            echo '<title>' . htmlspecialchars($seoTitle) . '</title>' . PHP_EOL;
            echo '<meta name="title" content="' . htmlspecialchars($seoTitle) . '">' . PHP_EOL;
            echo '<meta property="og:title" content="' . htmlspecialchars($seoTitle) . '">' . PHP_EOL;
        }
        if ($seoDesc !== '' && $seoDesc !== '--') {
            echo '<meta name="description" content="' . htmlspecialchars($seoDesc) . '">' . PHP_EOL;
            echo '<meta property="og:description" content="' . htmlspecialchars($seoDesc) . '">' . PHP_EOL;
        }
        if ($seoKey !== '' && $seoKey !== '--') {
            echo '<meta name="keywords" content="' . htmlspecialchars($seoKey) . '">' . PHP_EOL;
        }
        if ($analyticsCode !== '' && $analyticsCode !== '--') {
            echo $analyticsCode;
        }
    ?>

    <style>
        :root {
            --pp-primary: <?php echo $primaryColor; ?>;
            --pp-primary-rgb: <?php 
                $hex = ltrim($primaryColor, '#');
                if(strlen($hex) == 3) {
                    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                } else {
                    $r = hexdec(substr($hex,0,2));
                    $g = hexdec(substr($hex,2,2));
                    $b = hexdec(substr($hex,4,2));
                }
                echo "$r, $g, $b";
            ?>;
            --pp-text-color: <?php echo $textColor; ?>;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 40px 16px 50px 16px;
            color: #1e293b;
            position: relative;
            overflow-x: hidden;
            <?= $bgStyle ?>
        }

        /* Ambient background glow */
        .ambient-glow-1 {
            position: fixed;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            top: -160px;
            left: 50%;
            transform: translateX(-50%);
            background: radial-gradient(circle, rgba(var(--pp-primary-rgb), 0.14) 0%, rgba(var(--pp-primary-rgb), 0) 70%);
            z-index: 0;
            pointer-events: none;
        }
        .ambient-glow-2 {
            position: fixed;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            bottom: -120px;
            right: 8%;
            background: radial-gradient(circle, rgba(var(--pp-primary-rgb), 0.09) 0%, rgba(var(--pp-primary-rgb), 0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        .checkout-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 540px;
            margin: auto;
            animation: fadeInCard 0.45s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInCard {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Main Checkout Card */
        .checkout-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.02);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .checkout-card:hover {
            box-shadow: 0 25px 55px -12px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(15, 23, 42, 0.03);
        }

        /* Top Action Bar */
        .checkout-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }

        .nav-btn-circle {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .nav-btn-circle:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #ef4444;
            transform: scale(1.05);
        }

        .nav-btn-circle svg {
            width: 18px;
            height: 18px;
        }

        .action-btns-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-pill-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-pill-btn:hover {
            background: rgba(var(--pp-primary-rgb), 0.08);
            border-color: rgba(var(--pp-primary-rgb), 0.3);
            color: var(--pp-primary);
            transform: translateY(-1px);
        }

        .action-pill-btn.active {
            background: var(--pp-primary) !important;
            border-color: var(--pp-primary) !important;
            color: var(--pp-text-color) !important;
            box-shadow: 0 4px 12px rgba(var(--pp-primary-rgb), 0.35);
        }

        .action-pill-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Hero Brand Section */
        .checkout-hero {
            padding: 24px 24px 20px 24px;
            text-align: center;
            background: linear-gradient(180deg, rgba(var(--pp-primary-rgb), 0.05) 0%, rgba(255, 255, 255, 0) 100%);
        }

        .brand-avatar-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.85);
            margin-bottom: 12px;
            max-width: 200px;
            max-height: 60px;
        }

        .brand-avatar-img {
            max-height: 44px;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .brand-avatar-fallback {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(var(--pp-primary-rgb), 0.16) 0%, rgba(var(--pp-primary-rgb), 0.05) 100%);
            color: var(--pp-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            border: 1px solid rgba(var(--pp-primary-rgb), 0.2);
        }

        .brand-avatar-fallback svg {
            width: 24px;
            height: 24px;
        }

        .checkout-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px 0;
            letter-spacing: -0.02em;
        }

        .checkout-subtitle {
            font-size: 13.5px;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        /* Body container */
        .checkout-body {
            padding: 0 24px 24px 24px;
        }

        /* Category Segmented Tabs */
        .category-tab-container {
            display: flex;
            background: #f1f5f9;
            padding: 5px;
            border-radius: 14px;
            margin-bottom: 20px;
            gap: 4px;
        }

        .category-tab-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: #64748b;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
            user-select: none;
        }

        .category-tab-btn svg {
            width: 17px;
            height: 17px;
        }

        .category-tab-btn:hover {
            color: #1e293b;
            background: rgba(255, 255, 255, 0.6);
        }

        .category-tab-btn.active {
            background: #ffffff;
            color: var(--pp-primary);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.8);
        }

        /* Gateway Cards Grid */
        .gateway-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        @media (min-width: 480px) {
            .gateway-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .gateway-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 108px;
        }

        .gateway-card:hover {
            border-color: var(--pp-primary);
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -6px rgba(var(--pp-primary-rgb), 0.18), 0 0 0 1px var(--pp-primary);
            background: #ffffff;
        }

        .gateway-card:active {
            transform: translateY(0);
        }

        .gateway-logo-wrap {
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            width: 100%;
        }

        .gateway-logo-img {
            max-width: 100px;
            max-height: 40px;
            object-fit: contain;
            display: block;
            transition: transform 0.2s ease;
        }

        .gateway-card:hover .gateway-logo-img {
            transform: scale(1.05);
        }

        .gateway-name {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin: 0;
            letter-spacing: -0.01em;
        }

        /* Total Amount Banner */
        .total-amount-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, rgba(var(--pp-primary-rgb), 0.08) 0%, rgba(var(--pp-primary-rgb), 0.03) 100%);
            border: 1px solid rgba(var(--pp-primary-rgb), 0.18);
            border-radius: 14px;
            padding: 14px 18px;
            margin-top: 20px;
        }

        .total-amount-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .total-amount-label svg {
            width: 18px;
            height: 18px;
            color: var(--pp-primary);
        }

        .total-amount-value {
            font-size: 17px;
            font-weight: 800;
            color: var(--pp-primary);
            letter-spacing: -0.02em;
        }

        /* Details Tab List */
        .details-list {
            list-style: none;
            padding: 0;
            margin: 0;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            background: #ffffff;
        }

        .details-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px;
            color: #64748b;
        }

        .details-row:last-child {
            border-bottom: none;
            background: #f8fafc;
            font-weight: 700;
            color: #0f172a;
        }

        .details-val {
            font-weight: 600;
            color: #1e293b;
        }

        /* Support Tab Grid */
        .support-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .support-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
            text-align: center;
            text-decoration: none;
            color: #334155;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .support-card:hover {
            border-color: var(--pp-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -4px rgba(0,0,0,0.06);
            color: var(--pp-primary);
        }

        .support-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            color: var(--pp-primary);
        }

        .support-icon svg {
            width: 20px;
            height: 20px;
        }

        .support-label {
            font-size: 12.5px;
            font-weight: 600;
        }

        /* FAQ Tab */
        .faq-accordion .accordion-item {
            border: 1px solid #e2e8f0;
            border-radius: 12px !important;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .faq-accordion .accordion-button {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            background: #ffffff;
            padding: 14px 18px;
            box-shadow: none !important;
        }

        .faq-accordion .accordion-button:not(.collapsed) {
            color: var(--pp-primary);
            background: rgba(var(--pp-primary-rgb), 0.04);
        }

        .faq-accordion .accordion-body {
            font-size: 13.5px;
            color: #475569;
            line-height: 1.6;
            padding: 14px 18px;
        }

        /* Trust Footer */
        .trust-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px dashed #e2e8f0;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .trust-item svg {
            width: 15px;
            height: 15px;
            color: #10b981;
        }

        .watermark-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12.5px;
            color: #94a3b8;
            font-weight: 500;
        }

        .watermark-footer a {
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .watermark-footer a:hover {
            color: var(--pp-primary);
        }

        /* Modal styling */
        .modal-content {
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 18px 24px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid #f1f5f9;
            padding: 14px 24px;
        }
    </style>
</head>
<body loading="lazy">
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="checkout-wrapper">
        <!-- Main Card -->
        <div class="checkout-card">
            <!-- Nav Header -->
            <div class="checkout-nav-bar">
                <a href="<?php echo pp_checkout_address();?>?cancel" class="nav-btn-circle" title="Cancel Payment">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </a>

                <div class="action-btns-group">
                    <div class="action-pill-btn" data-tab="support" title="Support">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 15a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2l0 -3" />
                            <path d="M15 15a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2l0 -3" />
                            <path d="M4 15v-3a8 8 0 0 1 16 0v3" />
                        </svg>
                    </div>

                    <div class="action-pill-btn" data-tab="details" title="Order Details">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M12 9h.01" />
                            <path d="M11 12h1v4h1" />
                        </svg>
                    </div>

                    <div class="action-pill-btn" data-tab="faq" title="FAQ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033" />
                            <path d="M12 16v.01" />
                            <path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                        </svg>
                    </div>

                    <?php if (!empty($data['supported_languages']) && count($data['supported_languages']) > 1): ?>
                        <div class="action-pill-btn" data-bs-target="#modal-language" data-bs-toggle="modal" title="Language">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 5h7" /><path d="M9 3v2c0 4.418 -2.239 8 -5 8" /><path d="M5 9c0 2.144 2.952 3.908 6.7 4" /><path d="M12 20l4 -9l4 9" /><path d="M19.1 18h-6.2" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Hero Merchant Info -->
            <div class="checkout-hero">
                <?php if (!empty($brandLogo)): ?>
                    <div class="brand-avatar-box">
                        <img src="<?php echo htmlspecialchars($brandLogo); ?>" alt="<?php echo htmlspecialchars($brandName); ?>" class="brand-avatar-img" onerror="this.parentElement.style.display='none'; document.getElementById('hero-fallback-icon').style.display='inline-flex';">
                    </div>
                <?php endif; ?>

                <div id="hero-fallback-icon" class="brand-avatar-fallback" style="<?php echo !empty($brandLogo) ? 'display:none;' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 21l18 0" /><path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" /><path d="M5 21v-10.15" /><path d="M19 21v-10.15" /><path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                    </svg>
                </div>

                <h2 class="checkout-title"><?php echo htmlspecialchars($brandName); ?></h2>
                <p class="checkout-subtitle"><?php echo $data['lang']['select_payment_method'] ?? 'Choose your payment method'; ?></p>
            </div>

            <!-- Checkout Body -->
            <div class="checkout-body">
                <!-- Category Tabs -->
                <div class="category-tab-container">
                    <?php if ($pp_gateways_mfs['status'] === true && !empty($pp_gateways_mfs['gateway'])): ?>
                        <button type="button" class="category-tab-btn btn-mfs" data-tab="mfs">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14" />
                                <path d="M11 4h2" /><path d="M12 17v.01" />
                            </svg>
                            <span><?php echo $data['lang']['mobile_banking'] ?? 'Mobile Banking'?></span>
                        </button>
                    <?php endif; ?>

                    <?php if ($pp_gateways_bank['status'] === true && !empty($pp_gateways_bank['gateway'])): ?>
                        <button type="button" class="category-tab-btn btn-net-banking" data-tab="bank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 21l18 0" /><path d="M3 10l18 0" /><path d="M5 6l7 -3l7 3" /><path d="M4 10l0 11" /><path d="M20 10l0 11" /><path d="M8 14l0 3" /><path d="M12 14l0 3" /><path d="M16 14l0 3" />
                            </svg>
                            <span><?php echo $data['lang']['net_banking'] ?? 'Net Banking'?></span>
                        </button>
                    <?php endif; ?>

                    <?php if ($pp_gateways_global['status'] === true && !empty($pp_gateways_global['gateway'])): ?>
                        <button type="button" class="category-tab-btn btn-global" data-tab="global">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M3.6 9h16.8" /><path d="M3.6 15h16.8" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a17 17 0 0 1 0 18" />
                            </svg>
                            <span><?php echo $data['lang']['global'] ?? 'Global Cards'?></span>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- MFS Gateways -->
                <div id="gateways-mfs" class="gateway-grid" style="display: none;">
                    <?php
                        if ($pp_gateways_mfs['status'] === true && !empty($pp_gateways_mfs['gateway'])) {
                            foreach($pp_gateways_mfs['gateway'] as $row){
                    ?>
                                <div class="gateway-card" onclick="location.href='<?php echo pp_checkout_address()?>?gateway=<?php echo $row['gateway_id']?>'">
                                    <div class="gateway-logo-wrap">
                                        <img src="<?php echo $row['logo']?>" alt="<?php echo htmlspecialchars($row['display'])?>" class="gateway-logo-img">
                                    </div>
                                    <div class="gateway-name"><?php echo htmlspecialchars($row['display'])?></div>
                                </div>
                    <?php
                            }
                        }
                    ?>
                </div>

                <!-- Net Banking Gateways -->
                <div id="gateways-bank" class="gateway-grid" style="display: none;">
                    <?php
                        if ($pp_gateways_bank['status'] === true && !empty($pp_gateways_bank['gateway'])) {
                            foreach($pp_gateways_bank['gateway'] as $row){
                    ?>
                                <div class="gateway-card" onclick="location.href='<?php echo pp_checkout_address()?>?gateway=<?php echo $row['gateway_id']?>'">
                                    <div class="gateway-logo-wrap">
                                        <img src="<?php echo $row['logo']?>" alt="<?php echo htmlspecialchars($row['display'])?>" class="gateway-logo-img">
                                    </div>
                                    <div class="gateway-name"><?php echo htmlspecialchars($row['display'])?></div>
                                </div>
                    <?php
                            }
                        }
                    ?>
                </div>

                <!-- Global Gateways -->
                <div id="gateways-global" class="gateway-grid" style="display: none;">
                    <?php
                        if ($pp_gateways_global['status'] === true && !empty($pp_gateways_global['gateway'])) {
                            foreach($pp_gateways_global['gateway'] as $row){
                    ?>
                                <div class="gateway-card" onclick="location.href='<?php echo pp_checkout_address()?>?gateway=<?php echo $row['gateway_id']?>'">
                                    <div class="gateway-logo-wrap">
                                        <img src="<?php echo $row['logo']?>" alt="<?php echo htmlspecialchars($row['display'])?>" class="gateway-logo-img">
                                    </div>
                                    <div class="gateway-name"><?php echo htmlspecialchars($row['display'])?></div>
                                </div>
                    <?php
                            }
                        }
                    ?>
                </div>

                <!-- Support View -->
                <?php $support = $data['brand']['support'] ?? []; ?>
                <div id="gateways-support" class="support-grid" style="display: none;">
                    <?php if(!empty($support['email']) && $support['email'] != '--'): ?>
                        <a href="mailto:<?php echo $support['email']?>" target="_blank" class="support-card">
                            <div class="support-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>
                            </div>
                            <span class="support-label"><?php echo $data['lang']['contact_email'] ?? 'Email Support'?></span>
                        </a>
                    <?php endif; ?>

                    <?php if(!empty($support['phone']) && $support['phone'] != '--'): ?>
                        <a href="tel:<?php echo $support['phone']?>" target="_blank" class="support-card">
                            <div class="support-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /><path d="M15 7l0 .01" /><path d="M18 7l0 .01" /><path d="M21 7l0 .01" /></svg>
                            </div>
                            <span class="support-label"><?php echo $data['lang']['contact_phone'] ?? 'Phone Support'?></span>
                        </a>
                    <?php endif; ?>

                    <?php if(!empty($support['whatsapp']) && $support['whatsapp'] != '--'): ?>
                        <a href="https://wa.me/<?php echo $support['whatsapp']?>" target="_blank" class="support-card">
                            <div class="support-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" /><path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" /></svg>
                            </div>
                            <span class="support-label"><?php echo $data['lang']['contact_whatsapp'] ?? 'WhatsApp'?></span>
                        </a>
                    <?php endif; ?>

                    <?php if(!empty($support['telegram']) && $support['telegram'] != '--'): ?>
                        <a href="<?php echo $support['telegram']?>" target="_blank" class="support-card">
                            <div class="support-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" /></svg>
                            </div>
                            <span class="support-label"><?php echo $data['lang']['contact_telegram'] ?? 'Telegram'?></span>
                        </a>
                    <?php endif; ?>

                    <?php if(!empty($support['website']) && $support['website'] != '--'): ?>
                        <a href="<?php echo $support['website']?>" target="_blank" class="support-card">
                            <div class="support-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 7a9 9 0 0 0 -7.5 -4a8.991 8.991 0 0 0 -7.484 4" /><path d="M11.5 3a16.989 16.989 0 0 0 -1.826 4" /><path d="M12.5 3a16.989 16.989 0 0 1 1.828 4" /><path d="M19.5 17a9 9 0 0 1 -7.5 4a8.991 8.991 0 0 1 -7.484 -4" /><path d="M11.5 21a16.989 16.989 0 0 1 -1.826 -4" /><path d="M12.5 21a16.989 16.989 0 0 0 1.828 -4" /><path d="M2 10l1 4l1.5 -4l1.5 4l1 -4" /><path d="M17 10l1 4l1.5 -4l1.5 4l1 -4" /><path d="M9.5 10l1 4l1.5 -4l1.5 4l1 -4" /></svg>
                            </div>
                            <span class="support-label"><?php echo $data['lang']['contact_website'] ?? 'Website'?></span>
                        </a>
                    <?php endif; ?>

                    <?php if(!empty($support['messenger']) && $support['messenger'] != '--'): ?>
                        <a href="<?php echo $support['messenger']?>" target="_blank" class="support-card">
                            <div class="support-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" /><path d="M8 13l3 -2l2 2l3 -2" /></svg>
                            </div>
                            <span class="support-label"><?php echo $data['lang']['contact_messenger'] ?? 'Messenger'?></span>
                        </a>
                    <?php endif; ?>

                    <?php if(!empty($support['fb_page']) && $support['fb_page'] != '--'): ?>
                        <a href="<?php echo $support['fb_page']?>" target="_blank" class="support-card">
                            <div class="support-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                            </div>
                            <span class="support-label"><?php echo $data['lang']['contact_fb_page'] ?? 'Facebook'?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Order Details View -->
                <div id="gateways-details" style="display: none;">
                    <ul class="details-list">
                        <li class="details-row">
                            <span><?php echo $data['lang']['currency'] ?? 'Currency'?></span>
                            <span class="details-val"><?php echo htmlspecialchars($data['transaction']['currency']); ?></span>
                        </li>
                        <li class="details-row">
                            <span><?php echo $data['lang']['subtotal'] ?? 'Subtotal'?></span>
                            <span class="details-val"><?php echo money_round(($data['transaction']['amount'] ?? 0) - ($data['transaction']['discount_amount'] ?? 0), 2).' '.$data['transaction']['currency']; ?></span>
                        </li>
                        <li class="details-row">
                            <span><?php echo $data['lang']['discount'] ?? 'Discount'?></span>
                            <span class="details-val"><?php echo money_round($data['transaction']['discount_amount'] ?? 0, 2).' '.$data['transaction']['currency']; ?></span>
                        </li>
                        <li class="details-row">
                            <span><?php echo $data['lang']['total'] ?? 'Total'?></span>
                            <span class="details-val" style="color: var(--pp-primary);"><?php echo money_round($data['transaction']['amount'], 2).' '.$data['transaction']['currency']; ?></span>
                        </li>
                    </ul>
                </div>

                <!-- FAQ View -->
                <div id="gateways-faq" style="display: none;">
                    <div class="accordion faq-accordion" id="accordion-default">
                        <?php
                            $count = 0;
                            foreach($data['faqs'] ?? [] as $faq){
                                $count = $count+1;
                        ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button <?php echo ($count > 1) ? 'collapsed' : ''?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $count?>-default">
                                            <?php echo htmlspecialchars($faq['title'])?>
                                        </button>
                                    </h2>
                                    <div id="collapse-<?php echo $count?>-default" class="accordion-collapse collapse <?php echo ($count == 1) ? 'show' : ''?>" data-bs-parent="#accordion-default">
                                        <div class="accordion-body">
                                            <?php echo $faq['description']?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>

                <!-- Total Payable Banner -->
                <div class="total-amount-box">
                    <span class="total-amount-label">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                            <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                        </svg>
                        <?php echo $data['lang']['total_payable'] ?? ($data['lang']['total'] ?? 'Total Payable')?>
                    </span>
                    <span class="total-amount-value"><?php echo money_round($data['transaction']['amount'], 2).' '.$data['transaction']['currency'];?></span>
                </div>

                <!-- Trust Footer -->
                <div class="trust-footer">
                    <div class="trust-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                            <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                        </svg>
                        <span><?php echo $data['lang']['ssl_secure'] ?? '256-Bit SSL'; ?></span>
                    </div>
                    <span>•</span>
                    <div class="trust-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.414 0l-4.293 4.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l5 -5l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                        </svg>
                        <span><?php echo $data['lang']['encrypted_safe'] ?? 'Encrypted & Safe'; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($watermark)): ?>
            <div class="watermark-footer">
                <?php echo $watermark; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Language Modal -->
    <div class="modal fade" id="modal-language" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollableLabel"><?php echo $data['lang']['select_language'] ?? 'Select Language'?></h5> 
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <div class="form-group mt-1">
                        <label for="" class="form-label"><?php echo $data['lang']['language'] ?? 'Language'?> <span class="text-danger">*</span></label>
                        <div class="form-control-wrap">
                            <select class="form-select" id="model-languages" onchange="hitLanguage()">
                                <option value="" selected><?php echo $data['lang']['select_a_language'] ?? 'Select a language'?></option>
                                <?php foreach ($data['supported_languages'] ?? [] as $code => $language): ?>
                                    <option value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($language) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal"><?php echo $data['lang']['close'] ?? 'Close'?></button>
                </div>
            </div>
        </div>
    </div>

    <?php echo pp_assets('footer'); ?>

    <script data-cfasync="false">
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-tab-container .category-tab-btn');
            const actionButtons = document.querySelectorAll('.action-btns-group .action-pill-btn[data-tab]');
            const allTabs = document.querySelectorAll('[data-tab]');

            const panels = {
                mfs: document.getElementById('gateways-mfs'),
                bank: document.getElementById('gateways-bank'),
                global: document.getElementById('gateways-global'),
                support: document.getElementById('gateways-support'),
                details: document.getElementById('gateways-details'),
                faq: document.getElementById('gateways-faq')
            };

            function activateTab(tabKey, clickedElement) {
                // Hide all panels
                Object.values(panels).forEach(p => {
                    if (p) p.style.display = 'none';
                });

                // Reset active states
                categoryButtons.forEach(b => b.classList.remove('active'));
                actionButtons.forEach(b => b.classList.remove('active'));

                // Set active class
                if (clickedElement) {
                    clickedElement.classList.add('active');
                }

                // Show target panel
                if (panels[tabKey]) {
                    const isGrid = panels[tabKey].classList.contains('gateway-grid') || panels[tabKey].classList.contains('support-grid');
                    panels[tabKey].style.display = isGrid ? 'grid' : 'block';
                }
            }

            // Category Tab Clicks
            categoryButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    activateTab(this.dataset.tab, this);
                });
            });

            // Action Pill Clicks (Support, Details, FAQ)
            actionButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabKey = this.dataset.tab;
                    if (this.classList.contains('active')) {
                        // Toggle back to first category
                        if (categoryButtons.length > 0) {
                            activateTab(categoryButtons[0].dataset.tab, categoryButtons[0]);
                        }
                    } else {
                        activateTab(tabKey, this);
                    }
                });
            });

            // Auto-activate first available category tab on load
            if (categoryButtons.length > 0) {
                activateTab(categoryButtons[0].dataset.tab, categoryButtons[0]);
            }
        });

        function hitLanguage(){
            var language = document.querySelector("#model-languages").value;
            if(language !== ""){
                location.href = '?lang='+language;
            }
        }
    </script>
</body>
</html>
