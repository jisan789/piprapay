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

    $primaryColor = !empty($data['options']['primary_color']) ? $data['options']['primary_color'] : '#5f38f9';
    $textColor    = !empty($data['options']['text_color']) ? $data['options']['text_color'] : '#FFFFFF';
    $watermark    = !empty($data['options']['watermark_text']) ? $data['options']['watermark_text'] : '';
    $currency     = $data['paymentLink']['currency'] ?? 'BDT';
    $brandName    = !empty($data['brand']['name']) && $data['brand']['name'] !== '--' ? $data['brand']['name'] : ($data['brand']['identifyName'] ?? 'PipraPay');
    $brandLogo    = !empty($data['brand']['logo']) && $data['brand']['logo'] !== '--' ? $data['brand']['logo'] : '';

    $seoTitle = trim($data['options']['seo_title'] ?? '');
    $seoDesc  = trim($data['options']['seo_description'] ?? '');
    $seoKey   = trim($data['options']['seo_keywords'] ?? '');
    $analyticsCode = trim($data['options']['analytics_code'] ?? '');

    $bgStyle = 'background: linear-gradient(135deg, #f5f7fb 0%, #eef2f9 100%);';
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
    <title><?php echo $data['lang']['payment_link'] ?? 'Payment'?> - <?php echo htmlspecialchars($brandName); ?></title>
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

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 40px 16px 50px 16px;
            box-sizing: border-box;
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

        .payment-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
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

        /* Main Payment Card */
        .payment-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.02);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .payment-card:hover {
            box-shadow: 0 25px 55px -12px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(15, 23, 42, 0.03);
        }

        /* Hero Banner inside card */
        .payment-card-hero {
            background: linear-gradient(180deg, rgba(var(--pp-primary-rgb), 0.07) 0%, rgba(255, 255, 255, 0) 100%);
            padding: 30px 24px 20px 24px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
            position: relative;
        }

        .brand-hero-logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.85);
            margin-bottom: 14px;
            max-width: 220px;
            max-height: 64px;
            transition: transform 0.25s ease;
        }

        .brand-hero-logo-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.09), 0 0 0 1px rgba(var(--pp-primary-rgb), 0.25);
        }

        .brand-hero-logo {
            max-height: 48px;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .hero-badge-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(var(--pp-primary-rgb), 0.16) 0%, rgba(var(--pp-primary-rgb), 0.04) 100%);
            color: var(--pp-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 10px 20px -5px rgba(var(--pp-primary-rgb), 0.25);
            border: 1px solid rgba(var(--pp-primary-rgb), 0.2);
            transition: transform 0.3s ease;
        }

        .hero-badge-icon:hover {
            transform: scale(1.06) rotate(2deg);
        }

        .hero-badge-icon svg {
            width: 30px;
            height: 30px;
        }

        .payment-card-hero h1 {
            font-size: 21px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px 0;
            letter-spacing: -0.02em;
        }

        .payment-card-hero p {
            font-size: 13.5px;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #ecfdf5;
            color: #059669;
            padding: 4px 11px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            margin-top: 12px;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            border: 1px solid #d1fae5;
        }

        .verified-badge svg {
            width: 13px;
            height: 13px;
        }

        /* Form Area */
        .payment-card-body {
            padding: 28px 26px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-control, .input-group-text {
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            padding: 12px 14px;
            height: auto;
            color: #0f172a;
            background-color: #f8fafc;
            font-weight: 500;
        }

        .form-control::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .form-control:hover {
            border-color: #cbd5e1;
            background-color: #ffffff;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--pp-primary) !important;
            box-shadow: 0 0 0 4px rgba(var(--pp-primary-rgb), 0.12) !important;
            outline: none;
        }

        /* Amount Input Group */
        .input-group {
            position: relative;
            display: flex;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .input-group .input-group-text {
            background: linear-gradient(135deg, rgba(var(--pp-primary-rgb), 0.12) 0%, rgba(var(--pp-primary-rgb), 0.04) 100%);
            border: 1.5px solid #e2e8f0;
            border-right: none;
            color: var(--pp-primary);
            font-weight: 700;
            font-size: 14.5px;
            padding: 12px 18px;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            letter-spacing: 0.03em;
        }

        .input-group .form-control {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--pp-primary);
        }

        /* Pay Button */
        .btn-pay-now {
            width: 100%;
            padding: 14px 20px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
            cursor: pointer;
            margin-top: 24px;
            color: var(--pp-text-color) !important;
            background: var(--pp-primary);
            box-shadow: 0 10px 24px -6px rgba(var(--pp-primary-rgb), 0.45);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-pay-now::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 100%);
            pointer-events: none;
        }

        .btn-pay-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px -6px rgba(var(--pp-primary-rgb), 0.55);
            filter: brightness(1.04);
        }

        .btn-pay-now:active {
            transform: translateY(0);
            box-shadow: 0 6px 14px -4px rgba(var(--pp-primary-rgb), 0.4);
        }

        .btn-pay-now svg {
            width: 20px;
            height: 20px;
        }

        /* Trust Footer Badges */
        .trust-badge-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 22px;
            padding-top: 18px;
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
            margin-top: 22px;
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
<body>
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="payment-wrapper">
        <?php if (!empty($data['supported_languages']) && count($data['supported_languages']) > 1): ?>
            <div class="top-lang-bar">
                <a href="javascript:void(0)" class="lang-switch-btn" data-bs-target="#modal-language" data-bs-toggle="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5h7" /><path d="M9 3v2c0 4.418 -2.239 8 -5 8" /><path d="M5 9c0 2.144 2.952 3.908 6.7 4" /><path d="M12 20l4 -9l4 9" /><path d="M19.1 18h-6.2" /></svg>
                    <span>Language</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- Payment Card -->
        <div class="payment-card">
            <!-- Hero banner -->
            <div class="payment-card-hero">
                <?php if (!empty($brandLogo)): ?>
                    <div class="brand-hero-logo-box">
                        <img src="<?php echo htmlspecialchars($brandLogo); ?>" alt="<?php echo htmlspecialchars($brandName); ?>" class="brand-hero-logo">
                    </div>
                <?php else: ?>
                    <div class="hero-badge-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                            <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                        </svg>
                    </div>
                <?php endif; ?>

                <h1><?php echo $data['lang']['payment_link'] ?? 'Payment Checkout'; ?></h1>
                <p>
                    <?php if (!empty($brandName) && $brandName !== 'PipraPay'): ?>
                        Pay securely to <strong><?php echo htmlspecialchars($brandName); ?></strong>
                    <?php else: ?>
                        Complete your payment information securely
                    <?php endif; ?>
                </p>
                <div>
                    <span class="verified-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.414 0l-4.293 4.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l5 -5l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                        </svg>
                        Official Payment Link
                    </span>
                </div>
            </div>

            <!-- Form -->
            <div class="payment-card-body">
                <form action="" method="POST" id="form" enctype="multipart/form-data">
                    <?php pp_renderFormFields('payment-link-default', $data); ?>

                    <button type="submit" id="payButton" class="btn-pay-now">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -8" />
                            <path d="M3 10l18 0" />
                            <path d="M7 15l.01 0" />
                            <path d="M11 15l2 0" />
                        </svg>
                        <span><?php echo $data['lang']['pay_now'] ?? 'Proceed to Pay'?></span>
                    </button>
                </form>

                <!-- Trust Badges -->
                <div class="trust-badge-row">
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        <span>Encrypted & Safe</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer watermark -->
        <?php if(!empty($watermark) && $watermark !== '--'): ?>
            <div class="watermark-footer">
                <?php echo htmlspecialchars($watermark); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Language Switcher Modal -->
    <div class="modal fade" id="modal-language" data-bs-keyboard="false" tabindex="-1" aria-labelledby="langModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="langModalLabel"><?php echo $data['lang']['select_language'] ?? 'Select Language'?></h5> 
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <div class="form-group">
                        <label for="model-languages" class="form-label"><?php echo $data['lang']['language'] ?? 'Language'?> <span class="text-danger">*</span></label>
                        <div class="form-control-wrap">
                            <select class="form-select" id="model-languages" onchange="hitLanguage()">
                                <option value="" selected><?php echo $data['lang']['select_a_language'] ?? 'Choose Language'?></option>
                                <?php foreach ($data['supported_languages'] ?? [] as $code => $language): ?>
                                    <option value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($language) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal"><?php echo $data['lang']['close'] ?? 'Close'?></button>
                </div>
            </div>
        </div>
    </div>

    <?php echo pp_assets('footer'); ?>

    <script data-cfasync="false">
        function hitLanguage(){
            var language = document.querySelector("#model-languages").value;
            if(language !== ""){
                location.href = '?lang=' + encodeURIComponent(language);
            }
        }
        
        $(document).ready(function() {
            $('#form').on('submit', function(e) {
                e.preventDefault(); 

                var $amtInput = $('input[name="amount"]');
                if ($amtInput.length > 0) {
                    var amtVal = parseFloat($amtInput.val());
                    if (isNaN(amtVal) || amtVal <= 0) {
                        createToast({
                            title: 'Invalid Amount',
                            description: 'Please enter a valid amount greater than 0.',
                            svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                            timeout: 5000
                        });
                        $amtInput.focus();
                        return false;
                    }
                }

                var $btn = $("#payButton");
                var originalHtml = $btn.html();
                var formData = $(this).serialize(); 

                $btn.prop('disabled', true).html('<div class="spinner-border spinner-border-sm text-light" role="status" style="width: 1.2rem; height: 1.2rem;"><span class="visually-hidden">Loading...</span></div> <span>Processing...</span>');

                $.ajax({
                    url: '<?php echo pp_site_address(); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: formData, 
                    success: function(data) {
                        $btn.prop('disabled', false).html(originalHtml);

                        if (data.status == "true") {
                            location.href = data.redirect;
                        } else {
                            createToast({
                                title: data.title || 'Payment Error',
                                description: data.message || 'Please check your information and try again.',
                                svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                                timeout: 6000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $btn.prop('disabled', false).html(originalHtml);

                        createToast({
                            title: '<?php echo addslashes($data['lang']['something_wrong'] ?? 'Something went wrong')?>',
                            description: '<?php echo addslashes($data['lang']['support_contact_text'] ?? 'Please try again or contact support.')?>',
                            svg: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d63939" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>`,
                            timeout: 6000
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
