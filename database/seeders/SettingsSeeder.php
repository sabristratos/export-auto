<?php

namespace Database\Seeders;

use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Site Information
            'site_name' => 'Elite Car Export',
            'site_description' => 'Professional car export services connecting Europe with worldwide markets. We specialize in high-quality European vehicles for international buyers.',
            'site_keywords' => 'car export, european cars, luxury vehicles, international shipping, BMW export, Mercedes export, Audi export',

            // Contact Information
            'contact_email' => 'info@elitecarexport.com',
            'contact_phone' => '+49 123 456 7890',
            'whatsapp_number' => '+49 123 456 7890',
            'contact_address' => "Elite Car Export GmbH\nMusterstraße 123\n12345 Berlin, Germany",
            'business_hours' => "Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 10:00 AM - 4:00 PM\nSunday: Closed",
            'company_registration' => 'HRB 12345 Berlin, VAT: DE123456789',

            // Social Media
            'facebook_url' => 'https://facebook.com/elitecarexport',
            'instagram_url' => 'https://instagram.com/elitecarexport',
            'linkedin_url' => 'https://linkedin.com/company/elitecarexport',

            // SEO Settings
            'meta_title' => 'Elite Car Export - Premium European Vehicles Worldwide',
            'meta_description' => 'Export premium European vehicles worldwide. Specializing in BMW, Mercedes, Audi and luxury cars with professional shipping and documentation services.',

            // Email Settings
            'from_name' => 'Elite Car Export',
            'from_email' => 'noreply@elitecarexport.com',
            'reply_to_email' => 'info@elitecarexport.com',

            // Footer Settings
            'footer_company_description' => 'Elite Car Export specializes in connecting European automotive excellence with international markets. We provide comprehensive export services for premium vehicles worldwide.',
            'footer_copyright_text' => 'All rights reserved.',
            'footer_display_year' => true,

            // Theme Settings
            'primary_color' => '#1e40af',
            'secondary_color' => '#64748b',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $this->getSettingType($key),
                    'is_public' => $this->isPublicSetting($key),
                ]
            );
        }

        $this->command->info('✅ Settings seeded successfully!');
    }

    private function getSettingType(string $key): SettingType
    {
        return match ($key) {
            'contact_email', 'from_email', 'reply_to_email' => SettingType::Email,
            'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url' => SettingType::Url,
            'primary_color', 'secondary_color' => SettingType::Color,
            'footer_display_year' => SettingType::Boolean,
            'contact_address', 'business_hours', 'site_description', 'meta_description', 'footer_company_description' => SettingType::Textarea,
            default => SettingType::Text,
        };
    }

    private function isPublicSetting(string $key): bool
    {
        $privateSetting = [
            'from_name',
            'from_email',
            'reply_to_email',
            'google_analytics_id',
            'google_tag_manager_id',
        ];

        return !in_array($key, $privateSetting);
    }
}