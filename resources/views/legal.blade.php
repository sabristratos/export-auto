@php
    $pageSlug = request()->route('page');
    $pageData = collect([
        'privacy-policy' => [
            'title_key' => 'privacy_policy_title',
            'content_key' => 'privacy_policy_content',
            'default_title' => 'Privacy Policy',
        ],
        'terms-of-service' => [
            'title_key' => 'terms_of_service_title',
            'content_key' => 'terms_of_service_content',
            'default_title' => 'Terms of Service',
        ],
        'cookie-policy' => [
            'title_key' => 'cookie_policy_title',
            'content_key' => 'cookie_policy_content',
            'default_title' => 'Cookie Policy',
        ],
        'refund-policy' => [
            'title_key' => 'refund_policy_title',
            'content_key' => 'refund_policy_content',
            'default_title' => 'Refund Policy',
        ],
        'shipping-policy' => [
            'title_key' => 'shipping_policy_title',
            'content_key' => 'shipping_policy_content',
            'default_title' => 'Shipping Policy',
        ],
    ])->get($pageSlug);

    if (!$pageData) {
        abort(404);
    }

    // Get the title using regular setting helper (handles translations automatically)
    $pageTitle = setting($pageData['title_key'], $pageData['default_title']);

    // Get the content using getTranslation for current locale
    $contentSetting = \App\Models\Setting::where('key', $pageData['content_key'])->first();
    $pageContent = $contentSetting ? $contentSetting->getTranslation('value', app()->getLocale()) : '';
@endphp

<x-layouts.app :title="$pageTitle" :header-variant="'standard'">
    <div class="min-h-screen bg-neutral-50">
        <!-- Page Header -->
        <div class="py-16">
            <div class="container-public">
                <!-- Breadcrumb -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <ol class="flex items-center justify-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="text-neutral-600 hover:text-neutral-900 transition-colors duration-200">
                                {{ __('Home') }}
                            </a>
                        </li>
                        <li class="text-neutral-400">
                            <x-keys::icon name="heroicon-s-chevron-right" size="sm" />
                        </li>
                        <li class="text-neutral-900" aria-current="page">
                            {{ $pageTitle }}
                        </li>
                    </ol>
                </nav>

                <!-- Decorated Heading -->
                <x-decorated-heading
                    :overline="__('Legal Documentation')"
                    :heading="$pageTitle"
                    :description="__('Last updated: :date', ['date' => now()->format('F j, Y')])"
                    alignment="center"
                    class="mb-16" />
            </div>
        </div>

        <!-- Content -->
        <div class="py-16">
            <div class="container-public">
                <div class="max-w-4xl mx-auto">
                    @if($pageContent)
                        <div class="legal-content {{ app()->getLocale() === 'ar' ? 'legal-content-rtl' : '' }}">
                            {!! $pageContent !!}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-neutral-100 rounded-full flex items-center justify-center mb-6">
                                <x-keys::icon name="heroicon-o-document-text" size="lg" class="text-neutral-400" />
                            </div>
                            <h2 class="text-2xl font-semibold text-neutral-900 mb-4">
                                {{ __('Content Coming Soon') }}
                            </h2>
                            <p class="text-neutral-600 max-w-md mx-auto mb-8">
                                {{ __('This page is currently being prepared. Please check back soon for the latest :title.', ['title' => strtolower($pageTitle)]) }}
                            </p>
                            <x-keys::button href="{{ route('contact') }}" variant="brand">
                                {{ __('Contact Us') }}
                            </x-keys::button>
                        </div>
                    @endif

                    <!-- Contact Information -->
                    @if($pageContent)
                        <div class="mt-16 pt-8 border-t border-neutral-200">
                            <div class="bg-neutral-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-neutral-900 mb-4">
                                    {{ __('Questions about this policy?') }}
                                </h3>
                                <p class="text-neutral-600 mb-4">
                                    {{ __('If you have any questions or concerns about this :title, please contact us.', ['title' => strtolower($pageTitle)]) }}
                                </p>
                                <div class="flex flex-col sm:flex-row gap-4">
                                    @if(setting('contact_email'))
                                        <x-keys::button
                                            href="mailto:{{ setting('contact_email') }}"
                                            variant="outline"
                                            icon="heroicon-o-envelope">
                                            {{ setting('contact_email') }}
                                        </x-keys::button>
                                    @endif
                                    @if(setting('contact_phone'))
                                        <x-keys::button
                                            href="tel:{{ setting('contact_phone') }}"
                                            variant="outline"
                                            icon="heroicon-o-phone">
                                            {{ setting('contact_phone') }}
                                        </x-keys::button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>