<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', setting('site_name', 'Elite Car Export'))</title>

    <style>
        /* Reset styles for email clients */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        /* Brand Colors - Consistent with website */
        :root {
            --brand-600: #b45309;
            --brand-700: #92400e;
            --neutral-50: #fafafa;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d4d4d4;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
        }

        /* Typography - Helvetica family like website */
        body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Helvetica', 'Helvetica Neue', Arial, sans-serif !important;
            font-size: 16px;
            line-height: 1.6;
            color: #262626;
            background-color: #fafafa;
        }

        /* Main container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        /* Header styles */
        .email-header {
            background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
            padding: 30px 40px;
            text-align: center;
        }

        .email-header .logo {
            height: 48px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .email-header .site-name {
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            text-decoration: none;
            font-family: 'Helvetica', 'Helvetica Neue', Arial, sans-serif;
        }

        .email-header .tagline {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin: 8px 0 0 0;
            font-weight: 300;
        }

        /* Content area */
        .email-content {
            padding: 40px;
            background-color: #ffffff;
        }

        .email-title {
            color: #171717;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 24px 0;
            font-family: 'Helvetica', 'Helvetica Neue', Arial, sans-serif;
        }

        .email-subtitle {
            color: #525252;
            font-size: 16px;
            margin: 0 0 32px 0;
            line-height: 1.5;
        }

        /* Card-like sections */
        .content-section {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 24px;
            margin: 24px 0;
            border-left: 4px solid #b45309;
        }

        .content-section h3 {
            color: #171717;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 16px 0;
            font-family: 'Helvetica', 'Helvetica Neue', Arial, sans-serif;
        }

        /* Field styling */
        .field {
            margin-bottom: 20px;
        }

        .field-label {
            font-weight: 600;
            color: #404040;
            font-size: 14px;
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field-value {
            background-color: #ffffff;
            padding: 12px 16px;
            border-radius: 6px;
            border: 1px solid #e5e5e5;
            color: #262626;
            font-size: 15px;
            line-height: 1.5;
        }

        .field-value.large {
            min-height: 80px;
            white-space: pre-wrap;
        }

        /* Links */
        .email-link {
            color: #b45309;
            text-decoration: none;
            font-weight: 500;
        }

        .email-link:hover {
            color: #92400e;
            text-decoration: underline;
        }

        /* Buttons */
        .email-button {
            display: inline-block;
            background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
            color: #ffffff !important;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            margin: 8px 8px 8px 0;
            transition: all 0.3s ease;
            text-align: center;
        }

        .email-button:hover {
            background: #92400e;
            transform: translateY(-1px);
        }

        .email-button.secondary {
            background: #525252;
        }

        .email-button.secondary:hover {
            background: #404040;
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            background-color: #b45309;
            color: #ffffff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.success {
            background-color: #16a34a;
        }

        .status-badge.info {
            background-color: #0ea5e9;
        }

        /* Footer */
        .email-footer {
            background-color: #f5f5f5;
            padding: 32px 40px;
            text-align: center;
            border-top: 1px solid #e5e5e5;
        }

        .email-footer p {
            color: #525252;
            font-size: 14px;
            margin: 8px 0;
            line-height: 1.5;
        }

        .email-footer .company-info {
            color: #404040;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .email-footer .meta-info {
            color: #737373;
            font-size: 13px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #d4d4d4;
        }

        /* Price styling */
        .price {
            font-size: 28px;
            font-weight: 700;
            color: #16a34a;
            margin: 8px 0;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }

            .email-header,
            .email-content,
            .email-footer {
                padding: 24px !important;
            }

            .email-title {
                font-size: 20px !important;
            }

            .content-section {
                padding: 20px !important;
                margin: 16px 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            @php
                $logoUrl = setting_file('site_logo');
                $siteName = setting('site_name', 'Elite Car Export');
            @endphp

            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="logo">
            @else
                <h1 class="site-name">{{ $siteName }}</h1>
            @endif

            @if(trim($__env->yieldContent('headerTagline')))
                <p class="tagline">@yield('headerTagline')</p>
            @endif
        </div>

        <!-- Content -->
        <div class="email-content">
            @if(trim($__env->yieldContent('emailTitle')))
                <h1 class="email-title">@yield('emailTitle')</h1>
            @endif

            @if(trim($__env->yieldContent('emailSubtitle')))
                <p class="email-subtitle">@yield('emailSubtitle')</p>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p class="company-info">{{ setting('site_name', 'Elite Car Export') }}</p>

            @if(setting('contact_address'))
                <p>{{ setting('contact_address') }}</p>
            @endif

            @if(setting('contact_phone') || setting('contact_email'))
                <p>
                    @if(setting('contact_phone'))
                        Phone: {{ setting('contact_phone') }}
                    @endif
                    @if(setting('contact_phone') && setting('contact_email'))
                        |
                    @endif
                    @if(setting('contact_email'))
                        Email: {{ setting('contact_email') }}
                    @endif
                </p>
            @endif

            @if(trim($__env->yieldContent('footerMeta')))
                <div class="meta-info">
                    @yield('footerMeta')
                </div>
            @endif
        </div>
    </div>
</body>
</html>