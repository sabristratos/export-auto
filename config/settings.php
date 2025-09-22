<?php

use App\Enums\SettingType;

return [
    /*
    |--------------------------------------------------------------------------
    | Settings Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the site settings system.
    | Define all available settings here with their types, default values,
    | validation rules, and organization.
    |
    */

    'cache' => [
        'enabled' => env('SETTINGS_CACHE_ENABLED', true),
        'ttl' => env('SETTINGS_CACHE_TTL', 3600), // 1 hour
        'key' => env('SETTINGS_CACHE_KEY', 'site_settings'),
    ],

    'settings' => [
        // Site Information
        'site' => [
            'site_name' => [
                'type' => SettingType::Text,
                'default' => 'My Website',
                'is_public' => true,
                'description' => 'The name of your website',
                'validation' => ['required', 'string', 'max:255'],
                'order' => 1,
            ],
            'site_description' => [
                'type' => SettingType::Textarea,
                'default' => 'A professional website built with Laravel',
                'is_public' => true,
                'description' => 'A brief description of your website',
                'validation' => ['nullable', 'string', 'max:1000'],
                'order' => 2,
            ],
            'site_keywords' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => true,
                'description' => 'SEO keywords for your website (comma separated)',
                'validation' => ['nullable', 'string', 'max:500'],
                'order' => 3,
            ],
            'site_logo' => [
                'type' => SettingType::Image,
                'default' => null,
                'is_public' => true,
                'description' => 'Your website logo',
                'validation' => ['nullable', 'image', 'max:2048'],
                'order' => 4,
            ],
            'site_favicon' => [
                'type' => SettingType::Image,
                'default' => null,
                'is_public' => true,
                'description' => 'Website favicon (recommended: 32x32 px)',
                'validation' => ['nullable', 'image', 'max:512'],
                'order' => 5,
            ],
        ],

        // Contact Information
        'contact' => [
            'contact_email' => [
                'type' => SettingType::Email,
                'default' => '',
                'is_public' => true,
                'description' => 'Primary contact email address',
                'validation' => ['nullable', 'email'],
                'order' => 1,
            ],
            'contact_phone' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => true,
                'description' => 'Primary contact phone number',
                'validation' => ['nullable', 'string', 'max:50'],
                'order' => 2,
            ],
            'whatsapp_number' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => true,
                'description' => 'WhatsApp contact number',
                'validation' => ['nullable', 'string', 'max:50'],
                'order' => 3,
            ],
            'contact_address' => [
                'type' => SettingType::Textarea,
                'default' => '',
                'is_public' => true,
                'description' => 'Business address',
                'validation' => ['nullable', 'string', 'max:500'],
                'order' => 4,
            ],
            'business_hours' => [
                'type' => SettingType::Textarea,
                'default' => '',
                'is_public' => true,
                'description' => 'Business operating hours',
                'validation' => ['nullable', 'string', 'max:500'],
                'order' => 5,
            ],
            'company_registration' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => true,
                'description' => 'Company registration details',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 6,
            ],
        ],

        // Social Media
        'social' => [
            'facebook_url' => [
                'type' => SettingType::Url,
                'default' => '',
                'is_public' => true,
                'description' => 'Facebook page URL',
                'validation' => ['nullable', 'url'],
                'order' => 1,
            ],
            'twitter_url' => [
                'type' => SettingType::Url,
                'default' => '',
                'is_public' => true,
                'description' => 'Twitter profile URL',
                'validation' => ['nullable', 'url'],
                'order' => 2,
            ],
            'linkedin_url' => [
                'type' => SettingType::Url,
                'default' => '',
                'is_public' => true,
                'description' => 'LinkedIn profile URL',
                'validation' => ['nullable', 'url'],
                'order' => 3,
            ],
            'instagram_url' => [
                'type' => SettingType::Url,
                'default' => '',
                'is_public' => true,
                'description' => 'Instagram profile URL',
                'validation' => ['nullable', 'url'],
                'order' => 4,
            ],
        ],

        // SEO Settings
        'seo' => [
            'meta_title' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => true,
                'description' => 'Default meta title for pages',
                'validation' => ['nullable', 'string', 'max:60'],
                'order' => 1,
            ],
            'meta_description' => [
                'type' => SettingType::Textarea,
                'default' => '',
                'is_public' => true,
                'description' => 'Default meta description for pages',
                'validation' => ['nullable', 'string', 'max:160'],
                'order' => 2,
            ],
            'google_analytics_id' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => false,
                'description' => 'Google Analytics tracking ID',
                'validation' => ['nullable', 'string', 'max:50'],
                'order' => 3,
            ],
            'google_tag_manager_id' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => false,
                'description' => 'Google Tag Manager container ID',
                'validation' => ['nullable', 'string', 'max:50'],
                'order' => 4,
            ],
        ],

        // Email Settings
        'email' => [
            'from_name' => [
                'type' => SettingType::Text,
                'default' => '',
                'is_public' => false,
                'description' => 'Default sender name for emails',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 1,
            ],
            'from_email' => [
                'type' => SettingType::Email,
                'default' => '',
                'is_public' => false,
                'description' => 'Default sender email address',
                'validation' => ['nullable', 'email'],
                'order' => 2,
            ],
            'reply_to_email' => [
                'type' => SettingType::Email,
                'default' => '',
                'is_public' => false,
                'description' => 'Reply-to email address',
                'validation' => ['nullable', 'email'],
                'order' => 3,
            ],
        ],

        // Maintenance
        'maintenance' => [
            'maintenance_mode' => [
                'type' => SettingType::Boolean,
                'default' => false,
                'is_public' => false,
                'description' => 'Enable maintenance mode',
                'validation' => ['boolean'],
                'order' => 1,
            ],
            'maintenance_message' => [
                'type' => SettingType::Textarea,
                'default' => 'We are currently performing scheduled maintenance. Please check back soon.',
                'is_public' => true,
                'description' => 'Message to display during maintenance',
                'validation' => ['nullable', 'string', 'max:1000'],
                'order' => 2,
            ],
        ],

        // Theme Settings
        'theme' => [
            'primary_color' => [
                'type' => SettingType::Color,
                'default' => '#3b82f6',
                'is_public' => true,
                'description' => 'Primary brand color',
                'validation' => ['nullable', 'string', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
                'order' => 1,
            ],
            'secondary_color' => [
                'type' => SettingType::Color,
                'default' => '#64748b',
                'is_public' => true,
                'description' => 'Secondary brand color',
                'validation' => ['nullable', 'string', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
                'order' => 2,
            ],
            'dark_mode_enabled' => [
                'type' => SettingType::Boolean,
                'default' => false,
                'is_public' => true,
                'description' => 'Enable dark mode support',
                'validation' => ['boolean'],
                'order' => 3,
            ],
        ],

        // Footer Settings
        'footer' => [
            'footer_company_description' => [
                'type' => SettingType::Textarea,
                'default' => 'Professional car export services connecting Europe with worldwide markets.',
                'is_public' => true,
                'description' => 'Brief company description for footer',
                'validation' => ['nullable', 'string', 'max:500'],
                'order' => 1,
            ],
            'footer_copyright_text' => [
                'type' => SettingType::Text,
                'default' => 'All rights reserved.',
                'is_public' => true,
                'description' => 'Copyright notice text',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 2,
            ],
            'footer_display_year' => [
                'type' => SettingType::Boolean,
                'default' => true,
                'is_public' => true,
                'description' => 'Display current year in copyright',
                'validation' => ['boolean'],
                'order' => 3,
            ],
        ],

        // Legal Pages Content
        'legal' => [
            'privacy_policy_title' => [
                'type' => SettingType::Text,
                'default' => 'Privacy Policy',
                'is_public' => true,
                'description' => 'Privacy policy page title',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 1,
            ],
            'privacy_policy_content' => [
                'type' => SettingType::Json,
                'default' => '',
                'is_public' => true,
                'description' => 'Privacy policy content (supports multilingual)',
                'validation' => ['nullable', 'string'],
                'order' => 2,
            ],
            'terms_of_service_title' => [
                'type' => SettingType::Text,
                'default' => 'Terms of Service',
                'is_public' => true,
                'description' => 'Terms of service page title',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 3,
            ],
            'terms_of_service_content' => [
                'type' => SettingType::Json,
                'default' => '',
                'is_public' => true,
                'description' => 'Terms of service content (supports multilingual)',
                'validation' => ['nullable', 'string'],
                'order' => 4,
            ],
            'cookie_policy_title' => [
                'type' => SettingType::Text,
                'default' => 'Cookie Policy',
                'is_public' => true,
                'description' => 'Cookie policy page title',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 5,
            ],
            'cookie_policy_content' => [
                'type' => SettingType::Json,
                'default' => '',
                'is_public' => true,
                'description' => 'Cookie policy content (supports multilingual)',
                'validation' => ['nullable', 'string'],
                'order' => 6,
            ],
            'refund_policy_title' => [
                'type' => SettingType::Text,
                'default' => 'Refund Policy',
                'is_public' => true,
                'description' => 'Refund policy page title',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 7,
            ],
            'refund_policy_content' => [
                'type' => SettingType::Json,
                'default' => '',
                'is_public' => true,
                'description' => 'Refund policy content (supports multilingual)',
                'validation' => ['nullable', 'string'],
                'order' => 8,
            ],
            'shipping_policy_title' => [
                'type' => SettingType::Text,
                'default' => 'Shipping Policy',
                'is_public' => true,
                'description' => 'Shipping policy page title',
                'validation' => ['nullable', 'string', 'max:255'],
                'order' => 9,
            ],
            'shipping_policy_content' => [
                'type' => SettingType::Json,
                'default' => '',
                'is_public' => true,
                'description' => 'Shipping policy content (supports multilingual)',
                'validation' => ['nullable', 'string'],
                'order' => 10,
            ],
        ],
    ],
];