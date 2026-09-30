<?php
    if (!defined('PipraPay_INIT')) {
        http_response_code(403);
        exit('Direct access not allowed');
    }

    if(isset($_GET['receipt'])){
        pp_downloadReceiptPDF($data);
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

    $primaryColor = !empty($data['options']['primary_color']) ? $data['options']['primary_color'] : '#5f38f9';
    $textColor    = !empty($data['options']['text_color']) ? $data['options']['text_color'] : '#FFFFFF';
    $watermark    = !empty($data['options']['watermark_text']) ? $data['options']['watermark_text'] : '';
    $brandName    = !empty($data['brand']['name']) && $data['brand']['name'] !== '--' ? $data['brand']['name'] : ($data['brand']['identifyName'] ?? 'PipraPay');
    $brandLogo    = !empty($data['brand']['logo']) && $data['brand']['logo'] !== '--' ? $data['brand']['logo'] : (!empty($data['brand']['favicon']) && $data['brand']['favicon'] !== '--' ? $data['brand']['favicon'] : '');

    $status = strtolower($data['transaction']['status'] ?? 'pending');

    $seoTitle = trim($data['options']['seo_title'] ?? '');
    $seoDesc  = trim($data['options']['seo_description'] ?? '');
    $seoKey   = trim($data['options']['seo_keywords'] ?? '');
    $analyticsCode = trim($data['options']['analytics_code'] ?? '');

    $bgStyle = 'background: linear-gradient(135deg, #f6f8fc 0%, #edf2f9 100%);';
    if (!empty($data['options']['enable_bg_image']) && $data['options']['enable_bg_image'] === 'enabled' && !empty($data['options']['background_image'])) {
        $bgImage = $data['options']['background_image'];
        $bgStyle = "background-image: url('{$bgImage}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;";
    }

    $statusConfig = [
        'completed' => [
            'title' => $data['lang']['payment_successful'] ?? 'Payment Successful',
            'desc'  => $data['lang']['change_status_completed'] ?? 'Your payment has been successfully completed.',
            'color' => '#10b981',
            'color_rgb' => '16, 185, 129',
            'badge' => 'COMPLETED',
            'icon'  => 'check'
        ],
        'pending' => [
            'title' => $data['lang']['payment_pending'] ?? 'Payment Pending',
            'desc'  => $data['lang']['change_status_pending'] ?? 'Your payment is currently pending confirmation.',
            'color' => '#f59e0b',
            'color_rgb' => '245, 158, 11',
            'badge' => 'PENDING',
            'icon'  => 'hourglass'
        ],
        'refunded' => [
            'title' => $data['lang']['payment_refunded'] ?? 'Payment Refunded',
            'desc'  => $data['lang']['change_status_refunded'] ?? 'This transaction has been refunded.',
            'color' => '#3b82f6',
            'color_rgb' => '59, 130, 246',
            'badge' => 'REFUNDED',
            'icon'  => 'refund'
        ],
        'canceled' => [
            'title' => $data['lang']['payment_canceled'] ?? 'Payment Canceled',
            'desc'  => $data['lang']['change_status_cancled'] ?? 'The payment process was canceled by the user.',
            'color' => '#ef4444',
            'color_rgb' => '239, 68, 68',
            'badge' => 'CANCELED',
            'icon'  => 'x'
        ]
    ];

    $cur = $statusConfig[$status] ?? $statusConfig['pending'];
    $hasReturnUrl = !empty($data['transaction']['return_url']) && $data['transaction']['return_url'] !== '--';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($data['brand']['locale']['language'] ?? ($_SESSION['ui_language'] ?? 'bn')); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($cur['title']); ?> - <?php echo htmlspecialchars($brandName); ?></title>
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
            --status-color: <?php echo $cur['color']; ?>;
            --status-rgb: <?php echo $cur['color_rgb']; ?>;
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
            background: radial-gradient(circle, rgba(var(--status-rgb), 0.12) 0%, rgba(var(--status-rgb), 0) 70%);
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
            background: radial-gradient(circle, rgba(var(--pp-primary-rgb), 0.08) 0%, rgba(var(--pp-primary-rgb), 0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        .status-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 490px;
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

        .top-lang-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
            padding: 0 4px;
        }

        .lang-switch-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 13px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: #475569;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .lang-switch-btn:hover {
            color: var(--pp-primary);
            background: #ffffff;
            border-color: rgba(var(--pp-primary-rgb), 0.35);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .lang-switch-btn svg {
            width: 15px;
            height: 15px;
        }

        /* Status Card */
        .status-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.02);
            overflow: hidden;
            text-align: center;
        }

        /* Hero Header */
        .status-hero {
            padding: 36px 24px 24px 24px;
            background: linear-gradient(180deg, rgba(var(--status-rgb), 0.08) 0%, rgba(255, 255, 255, 0) 100%);
            border-bottom: 1px solid #f1f5f9;
        }

        .status-icon-badge {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(var(--status-rgb), 0.18) 0%, rgba(var(--status-rgb), 0.06) 100%);
            color: var(--status-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            box-shadow: 0 12px 24px -6px rgba(var(--status-rgb), 0.3);
            border: 1px solid rgba(var(--status-rgb), 0.25);
            animation: pulseIcon 2s infinite ease-in-out;
        }

        @keyframes pulseIcon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.04); }
        }

        .status-icon-badge svg {
            width: 38px;
            height: 38px;
        }

        .status-title {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 8px 0;
            letter-spacing: -0.02em;
        }

        .status-desc {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 14px 0;
            line-height: 1.5;
            padding: 0 12px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.04em;
            background: rgba(var(--status-rgb), 0.12);
            color: var(--status-color);
            border: 1px solid rgba(var(--status-rgb), 0.2);
        }

        .status-pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--status-color);
        }

        /* Card Content */
        .status-content {
            padding: 24px;
        }

        /* Summary List */
        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0 0 24px 0;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            text-align: left;
        }

        .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 18px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px;
            color: #64748b;
        }

        .summary-row:last-child {
            border-bottom: none;
            background: #f8fafc;
            font-weight: 700;
            color: #0f172a;
        }

        .summary-val {
            font-weight: 600;
            color: #1e293b;
        }

        /* Actions Button Group */
        .btn-action-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-status-primary {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 20px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            color: var(--pp-text-color) !important;
            background: var(--pp-primary);
            border: none;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 10px 20px -5px rgba(var(--pp-primary-rgb), 0.4);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-status-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px -6px rgba(var(--pp-primary-rgb), 0.55);
            filter: brightness(1.04);
            color: var(--pp-text-color) !important;
        }

        .btn-status-primary svg {
            width: 18px;
            height: 18px;
        }

        .btn-status-receipt {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 20px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            color: #065f46 !important;
            background: #ecfdf5;
            border: 1.5px solid #a7f3d0;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-status-receipt:hover {
            background: #d1fae5;
            border-color: #6ee7b7;
            transform: translateY(-1px);
        }

        .btn-status-receipt svg {
            width: 18px;
            height: 18px;
            color: #10b981;
        }

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

    <div class="status-wrapper">
        <?php if (!empty($data['supported_languages']) && count($data['supported_languages']) > 1): ?>
            <div class="top-lang-bar">
                <a href="javascript:void(0)" class="lang-switch-btn" data-bs-target="#modal-language" data-bs-toggle="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5h7" /><path d="M9 3v2c0 4.418 -2.239 8 -5 8" /><path d="M5 9c0 2.144 2.952 3.908 6.7 4" /><path d="M12 20l4 -9l4 9" /><path d="M19.1 18h-6.2" /></svg>
                    <span>Language</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- Card Container -->
        <div class="status-card">
            <!-- Hero Section -->
            <div class="status-hero">
                <div class="status-icon-badge">
                    <?php if ($cur['icon'] === 'check'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l5 5l10 -10" />
                        </svg>
                    <?php elseif ($cur['icon'] === 'x'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    <?php elseif ($cur['icon'] === 'hourglass'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M6.5 7h11" /><path d="M6.5 17h11" /><path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" /><path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" />
                        </svg>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 14l-4 -4l4 -4" /><path d="M5 10h11a4 4 0 1 1 0 8h-1" />
                        </svg>
                    <?php endif; ?>
                </div>

                <h1 class="status-title"><?php echo htmlspecialchars($cur['title']); ?></h1>
                <p class="status-desc"><?php echo htmlspecialchars($cur['desc']); ?></p>

                <div>
                    <span class="status-pill">
                        <span class="status-pill-dot"></span>
                        <?php echo htmlspecialchars($cur['badge']); ?>
                    </span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="status-content">
                <?php if ($status !== 'canceled'): ?>
                    <ul class="summary-list">
                        <?php if (!empty($data['transaction']['payment_method'])): ?>
                            <li class="summary-row">
                                <span><?php echo $data['lang']['payment_method'] ?? 'Payment Method'; ?></span>
                                <span class="summary-val"><?php echo htmlspecialchars($data['transaction']['payment_method']); ?></span>
                            </li>
                        <?php endif; ?>

                        <li class="summary-row">
                            <span><?php echo $data['lang']['amount'] ?? 'Amount'; ?></span>
                            <span class="summary-val"><?php echo money_round($data['transaction']['amount'] ?? 0, 2).' '.($data['transaction']['currency'] ?? 'BDT'); ?></span>
                        </li>

                        <?php if (!empty($data['transaction']['discount_amount']) && $data['transaction']['discount_amount'] > 0): ?>
                            <li class="summary-row">
                                <span><?php echo $data['lang']['discount'] ?? 'Discount'; ?></span>
                                <span class="summary-val"><?php echo money_round($data['transaction']['discount_amount'], 2).' '.($data['transaction']['currency'] ?? 'BDT'); ?></span>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($data['transaction']['processing_fee']) && $data['transaction']['processing_fee'] > 0): ?>
                            <li class="summary-row">
                                <span><?php echo $data['lang']['processing_fee'] ?? 'Processing Fee'; ?></span>
                                <span class="summary-val"><?php echo money_round($data['transaction']['processing_fee'], 2).' '.($data['transaction']['currency'] ?? 'BDT'); ?></span>
                            </li>
                        <?php endif; ?>

                        <li class="summary-row">
                            <span><?php echo $data['lang']['net_amount'] ?? 'Net Amount'; ?></span>
                            <span class="summary-val" style="color: var(--status-color);"><?php echo money_round(($data['transaction']['amount'] ?? 0) - ($data['transaction']['discount_amount'] ?? 0) + ($data['transaction']['processing_fee'] ?? 0), 2).' '.($data['transaction']['currency'] ?? 'BDT'); ?></span>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="summary-list">
                        <li class="summary-row">
                            <span>Transaction Reference</span>
                            <span class="summary-val"><?php echo htmlspecialchars($data['transaction']['ref'] ?? 'N/A'); ?></span>
                        </li>
                        <li class="summary-row">
                            <span>Order Amount</span>
                            <span class="summary-val"><?php echo money_round($data['transaction']['amount'] ?? 0, 2).' '.($data['transaction']['currency'] ?? 'BDT'); ?></span>
                        </li>
                        <li class="summary-row">
                            <span>Status</span>
                            <span class="summary-val" style="color: var(--status-color);">Canceled</span>
                        </li>
                    </ul>
                <?php endif; ?>

                <!-- Buttons -->
                <div class="btn-action-group">
                    <?php if ($hasReturnUrl): ?>
                        <a href="<?php echo htmlspecialchars($data['transaction']['return_url']); ?>" class="btn-status-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" />
                            </svg>
                            <span><?php echo $data['lang']['go_to_site'] ?? 'Return to Merchant Site'; ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if (in_array($status, ['completed', 'pending', 'refunded'])): ?>
                        <a href="<?php echo pp_checkout_address(); ?>?receipt" class="btn-status-receipt">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" />
                            </svg>
                            <span><?php echo $data['lang']['download_receipt'] ?? 'Download Receipt (PDF)'; ?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Trust Badges -->
                <div class="trust-footer">
                    <div class="trust-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                            <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                        </svg>
                        <span>256-Bit SSL</span>
                    </div>
                    <span>•</span>
                    <div class="trust-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.414 0l-4.293 4.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l5 -5l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                        </svg>
                        <span>Verified & Safe</span>
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
        function hitLanguage(){
            var language = document.querySelector("#model-languages").value;
            if(language !== ""){
                location.href = '?lang=' + language;
            }
        }
    </script>
</body>
</html>
