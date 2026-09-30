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
                location.href = '<?php echo pp_checkout_address().'?gateway='.$_GET['gateway'];?>';
            </script>
<?php
            exit();
        }
    }

    if(isset($_GET['gateway'])){
        $gateway_info = pp_gateway_info($_GET['gateway'], $data);

        if($gateway_info['status'] == false){
            http_response_code(403);
            exit('Direct access not allowed');
        }
    }else{
        http_response_code(403);
        exit('Direct access not allowed');
    }

    $gwPrimary = !empty($gateway_info['gateway']['primary_color']) ? $gateway_info['gateway']['primary_color'] : '#D12053';
    $gwText    = !empty($gateway_info['gateway']['text_color']) ? $gateway_info['gateway']['text_color'] : '#FFFFFF';
    $gwBtn     = !empty($gateway_info['gateway']['btn_color']) ? $gateway_info['gateway']['btn_color'] : $gwPrimary;
    $gwBtnText = !empty($gateway_info['gateway']['btn_text_color']) ? $gateway_info['gateway']['btn_text_color'] : '#FFFFFF';
    $gwLogo    = $gateway_info['gateway']['logo'] ?? '';
    $gwName    = $gateway_info['gateway']['display'] ?? ($gateway_info['gateway']['name'] ?? 'Payment');

    $brandName = !empty($data['brand']['name']) && $data['brand']['name'] !== '--' ? $data['brand']['name'] : ($data['brand']['identifyName'] ?? 'PipraPay');
    $watermark = !empty($data['options']['watermark_text']) ? $data['options']['watermark_text'] : '';

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
    <title><?php echo htmlspecialchars($gwName); ?> - <?php echo htmlspecialchars($brandName); ?></title>
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
            --gw-primary: <?php echo $gwPrimary; ?>;
            --gw-primary-rgb: <?php 
                $hex = ltrim($gwPrimary, '#');
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
            --gw-text: <?php echo $gwText; ?>;
            --gw-btn: <?php echo $gwBtn; ?>;
            --gw-btn-text: <?php echo $gwBtnText; ?>;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            margin: 0;
            padding: 20px 12px 30px 12px;
            box-sizing: border-box;
            color: #1e293b;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
            <?= $bgStyle ?>
        }

        /* Ambient background glow */
        .ambient-glow-1 {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            top: -160px;
            left: 50%;
            transform: translateX(-50%);
            background: radial-gradient(circle, rgba(var(--gw-primary-rgb), 0.14) 0%, rgba(var(--gw-primary-rgb), 0) 70%);
            z-index: 0;
            pointer-events: none;
        }
        .ambient-glow-2 {
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            bottom: -120px;
            right: 5%;
            background: radial-gradient(circle, rgba(var(--gw-primary-rgb), 0.08) 0%, rgba(var(--gw-primary-rgb), 0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        .gateway-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            margin: auto;
            animation: fadeInCard 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInCard {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Main Gateway Card */
        .gateway-card-main {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 16px 40px -12px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.02);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
            width: 100%;
        }

        .gateway-card-main:hover {
            box-shadow: 0 22px 50px -12px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(15, 23, 42, 0.03);
        }

        /* Top Action Bar */
        .gateway-nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }

        .nav-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-back-btn:hover {
            background: rgba(var(--gw-primary-rgb), 0.08);
            border-color: rgba(var(--gw-primary-rgb), 0.3);
            color: var(--gw-primary);
            transform: translateX(-2px);
        }

        .nav-back-btn svg {
            width: 15px;
            height: 15px;
        }

        .nav-lang-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-lang-btn:hover {
            background: rgba(var(--gw-primary-rgb), 0.08);
            border-color: rgba(var(--gw-primary-rgb), 0.3);
            color: var(--gw-primary);
        }

        .nav-lang-btn svg {
            width: 15px;
            height: 15px;
        }

        /* Hero Gateway Header */
        .gateway-hero {
            padding: 22px 18px 18px 18px;
            text-align: center;
            background: linear-gradient(180deg, rgba(var(--gw-primary-rgb), 0.06) 0%, rgba(255, 255, 255, 0) 100%);
            border-bottom: 1px solid #f1f5f9;
        }

        .gateway-logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.85);
            margin-bottom: 10px;
            max-width: 160px;
            max-height: 54px;
            transition: transform 0.2s ease;
        }

        .gateway-logo-box:hover {
            transform: translateY(-2px);
        }

        .gateway-logo-box img {
            max-height: 38px;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .gateway-title {
            font-size: clamp(17px, 4.5vw, 20px);
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px 0;
            letter-spacing: -0.02em;
        }

        .gateway-subtitle {
            font-size: 13px;
            color: #64748b;
            margin: 0 0 10px 0;
            font-weight: 500;
        }

        .gateway-amount-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 9999px;
            background: rgba(var(--gw-primary-rgb), 0.1);
            border: 1px solid rgba(var(--gw-primary-rgb), 0.25);
            color: var(--gw-primary);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: -0.01em;
            max-width: 100%;
        }

        .gateway-amount-pill svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }

        /* Card Body */
        .gateway-body {
            padding: 20px 18px;
        }

        /* Rich Instructions Box */
        .payment-instructions {
            background: linear-gradient(145deg, var(--gw-primary) 0%, rgba(var(--gw-primary-rgb), 0.92) 100%) !important;
            color: var(--gw-text) !important;
            border-radius: 18px !important;
            padding: 10px 16px !important;
            margin: 0 0 18px 0 !important;
            list-style: none !important;
            counter-reset: custom-step;
            box-shadow: 0 10px 24px -6px rgba(var(--gw-primary-rgb), 0.35);
            border: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .payment-instructions::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }

        .payment-instructions li {
            counter-increment: custom-step;
            display: flex !important;
            align-items: flex-start !important;
            gap: 10px !important;
            padding: 11px 0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
            font-size: 13px;
            line-height: 1.5;
            font-weight: 500;
            position: relative;
            z-index: 1;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .payment-instructions li:last-child {
            border-bottom: none !important;
        }

        .payment-instructions li .dot {
            min-width: 20px;
            width: 20px;
            height: 20px;
            border-radius: 50% !important;
            background: rgba(255, 255, 255, 0.22) !important;
            color: #ffffff;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            margin-top: 1px;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .payment-instructions li .dot::after {
            content: counter(custom-step);
        }

        .payment-instructions li p {
            margin: 0 !important;
            flex: 1;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .payment-instructions li .dynamic-value {
            display: inline-block;
            background: rgba(255, 255, 255, 0.22);
            padding: 2px 7px;
            border-radius: 6px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.02em;
            margin: 2px 2px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            word-break: break-all;
        }

        .payment-instructions li .button-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 3px 9px !important;
            margin: 2px 0 2px 5px !important;
            background: #ffffff !important;
            color: var(--gw-primary) !important;
            border-radius: 7px !important;
            cursor: pointer;
            font-size: 11.5px;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            vertical-align: middle;
            user-select: none;
            white-space: nowrap;
        }

        .payment-instructions li .button-icon:hover {
            transform: translateY(-1px) scale(1.04);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.22);
            filter: brightness(1.03);
        }

        .payment-instructions li .button-icon svg {
            width: 13px;
            height: 13px;
        }

        /* Form Inputs & Button */
        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            height: 46px;
            padding: 9px 14px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            font-size: 14px;
            font-family: inherit;
            color: #0f172a;
            background: #ffffff;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--gw-primary) !important;
            box-shadow: 0 0 0 3.5px rgba(var(--gw-primary-rgb), 0.14) !important;
            outline: none;
        }

        .form-control::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .btn-primary, .payment-form-btn {
            width: 100%;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 12px;
            font-size: 14.5px;
            font-weight: 700;
            color: var(--gw-btn-text) !important;
            background: var(--gw-btn) !important;
            border: none !important;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 8px 20px -5px rgba(var(--gw-primary-rgb), 0.42);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            margin-top: 14px;
        }

        .btn-primary:hover, .payment-form-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -6px rgba(var(--gw-primary-rgb), 0.55);
            filter: brightness(1.04);
        }

        .btn-primary:active, .payment-form-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px -3px rgba(var(--gw-primary-rgb), 0.35);
        }

        /* QR Image Modal */
        .pp-modal, .bp-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 14px;
        }

        .pp-modal-content, .bp-modal-content {
            position: relative;
            background: #ffffff;
            border-radius: 18px;
            padding: 16px;
            max-width: 320px;
            width: 100%;
            box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.25);
            animation: modalZoom 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
        }

        @keyframes modalZoom {
            from {
                transform: scale(0.92);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        #pp-modal-image, #bp-modal-image {
            display: block;
            width: 100%;
            max-width: 250px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .pp-close, .bp-close {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 30px;
            height: 30px;
            background: #ef4444;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(239, 68, 68, 0.4);
            transition: all 0.2s ease;
            line-height: 1;
        }

        .pp-close:hover, .bp-close:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        /* Trust Badges & Footer */
        .trust-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 18px;
            padding-top: 14px;
            border-top: 1px dashed #e2e8f0;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 500;
            flex-wrap: wrap;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .trust-item svg {
            width: 14px;
            height: 14px;
            color: #10b981;
        }

        .watermark-footer {
            text-align: center;
            margin-top: 16px;
            font-size: 12px;
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
            color: var(--gw-primary);
        }

        /* Bootstrap Modal */
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

        /* Responsive Breakpoints */
        @media (max-width: 480px) {
            body {
                padding: 16px 10px 24px 10px;
            }

            .gateway-card-main {
                border-radius: 16px;
            }

            .gateway-hero {
                padding: 18px 14px 14px 14px;
            }

            .gateway-body {
                padding: 14px 12px;
            }

            .payment-instructions {
                padding: 8px 12px !important;
                border-radius: 14px !important;
            }

            .payment-instructions li {
                font-size: 12.5px;
                gap: 8px !important;
            }
        }
    </style>
</head>
<body loading="lazy">
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="gateway-wrapper">
        <!-- Main Card -->
        <div class="gateway-card-main">
            <!-- Top Nav -->
            <div class="gateway-nav-bar">
                <a href="<?php echo pp_checkout_address();?>" class="nav-back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" />
                    </svg>
                    <span><?php echo $data['lang']['back'] ?? 'Back'; ?></span>
                </a>

                <?php if (!empty($gateway_info['supported_languages']) && count($gateway_info['supported_languages']) > 1): ?>
                    <a href="javascript:void(0)" class="nav-lang-btn" data-bs-target="#modal-language" data-bs-toggle="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 5h7" /><path d="M9 3v2c0 4.418 -2.239 8 -5 8" /><path d="M5 9c0 2.144 2.952 3.908 6.7 4" /><path d="M12 20l4 -9l4 9" /><path d="M19.1 18h-6.2" />
                        </svg>
                        <span><?php echo $data['lang']['language'] ?? 'Language'; ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Hero Section -->
            <div class="gateway-hero">
                <?php if (!empty($gwLogo)): ?>
                    <div class="gateway-logo-box">
                        <img src="<?php echo htmlspecialchars($gwLogo); ?>" alt="<?php echo htmlspecialchars($gwName); ?>" class="company-logo">
                    </div>
                <?php endif; ?>

                <h1 class="gateway-title"><?php echo htmlspecialchars($gwName); ?></h1>
                <p class="gateway-subtitle"><?php echo $data['lang']['gateway_instruction_subtitle'] ?? 'Follow the instructions to complete your payment'; ?></p>

                <div class="gateway-amount-pill">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                        <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                    </svg>
                    <span><?php echo ($data['lang']['pay_amount'] ?? 'Pay').' '.money_round($data['transaction']['amount'] ?? 0, 2).' '.($data['transaction']['currency'] ?? 'BDT'); ?></span>
                </div>
            </div>

            <!-- Body Section -->
            <div class="gateway-body">
                <?php
                    pp_gateway_render($_GET['gateway'] ?? '', $data);
                ?>

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
                                <?php
                                    foreach ($gateway_info['supported_languages'] ?? [] as $code => $language) {
                                ?>
                                        <option value="<?= htmlspecialchars($code) ?>">
                                            <?= htmlspecialchars($language) ?>
                                        </option>
                                <?php
                                    }
                                ?>
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
        var ppLang = {
            copied:        '<?php echo addslashes($data['lang']['copied_successfully'] ?? 'Copied!')?>',
            copiedDesc:    '<?php echo addslashes($data['lang']['copy_content_copied'] ?? 'Number copied to clipboard')?>',
            copyFailed:    '<?php echo addslashes($data['lang']['copy_failed'] ?? 'Copy Failed')?>',
            copyFailedDesc:'<?php echo addslashes($data['lang']['copy_failed_text'] ?? 'Unable to copy to clipboard')?>',
            noContent:     '<?php echo addslashes($data['lang']['copy_no_content'] ?? 'No content to copy')?>',
            somethingWrong:'<?php echo addslashes($data['lang']['something_wrong'] ?? 'Something went wrong')?>',
            supportText:   '<?php echo addslashes($data['lang']['support_contact_text'] ?? 'Please contact support')?>',
        };

        function copy_value(content){
            if (!content) {
                createToast({
                    title: ppLang.somethingWrong,
                    description: ppLang.noContent,
                    svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                    timeout: 4000
                });
                return;
            }

            navigator.clipboard.writeText(content).then(() => {
                createToast({
                    title: ppLang.copied,
                    description: ppLang.copiedDesc,
                    svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>`,
                    timeout: 3000
                });
            }).catch((err) => {
                createToast({
                    title: ppLang.copyFailed,
                    description: ppLang.copyFailedDesc,
                    svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                    timeout: 4000
                });
            });
        }

        function failed(title, message){
            createToast({
                title: title || 'Verification Failed',
                description: message || 'Please verify your transaction ID and try again.',
                svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                timeout: 6000
            });
        }

        function success(){
            location.href = "<?php echo pp_checkout_address();?>";
        }

        function hitLanguage(){
            var language = document.querySelector("#model-languages").value;
            if(language !== ""){
                location.href = '<?php echo pp_checkout_address().'?gateway='.$_GET['gateway'];?>&lang='+encodeURIComponent(language);
            }
        }
    </script>
</body>
</html>
