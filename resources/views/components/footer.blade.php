<footer class="bg-neutral-900 text-neutral-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Company Information -->
            <div class="lg:col-span-1">
                <div class="mb-6">
                    <x-logo class="h-24 w-auto" variant="light" />
                </div>
                @if(setting('footer_company_description') || true)
                    <p class="text-white text-sm leading-relaxed mb-4">
                        {{ setting('footer_company_description') ?: 'Elite Car Export specializes in connecting European automotive excellence with international markets. We provide comprehensive export services for premium vehicles worldwide.' }}
                    </p>
                @endif
                @if(setting('company_registration') || true)
                    <p class="text-neutral-200 text-xs">
                        {{ setting('company_registration') ?: 'Elite Car Export GmbH, HRB 12345 Berlin, VAT: DE123456789' }}
                    </p>
                @endif
            </div>

            <!-- Quick Links -->
            <div class="lg:col-span-1">
                <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-4">{{ __('Quick Links') }}</h3>
                <nav class="space-y-3">
                    <a href="{{ route('home') }}" class="block text-neutral-200 hover:text-blue-400 text-sm transition-colors duration-200">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('cars.index') }}" class="block text-neutral-200 hover:text-blue-400 text-sm transition-colors duration-200">
                        {{ __('Cars') }}
                    </a>
                    <a href="{{ route('contact') }}" class="block text-neutral-200 hover:text-blue-400 text-sm transition-colors duration-200">
                        {{ __('Contact') }}
                    </a>
                    <a href="#how-to-export" class="block text-neutral-200 hover:text-blue-400 text-sm transition-colors duration-200">
                        {{ __('How to Export') }}
                    </a>
                </nav>
            </div>

            <!-- Contact Information -->
            <div class="lg:col-span-1">
                <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-4">{{ __('Contact Info') }}</h3>
                <div class="space-y-3">
                    @if(setting('contact_email') || true)
                        <div class="flex items-start">
                            <x-keys::icon name="heroicon-o-envelope" size="sm" class="text-blue-400 mt-0.5 mr-3 flex-shrink-0" />
                            <a href="mailto:{{ setting('contact_email') ?: 'info@elitecarexport.com' }}" class="text-neutral-200 hover:text-blue-400 text-sm transition-colors duration-200">
                                {{ setting('contact_email') ?: 'info@elitecarexport.com' }}
                            </a>
                        </div>
                    @endif

                    @if(setting('contact_phone') || true)
                        <div class="flex items-start">
                            <x-keys::icon name="heroicon-o-phone" size="sm" class="text-blue-400 mt-0.5 mr-3 flex-shrink-0" />
                            <a href="tel:{{ setting('contact_phone') ?: '+49 123 456 7890' }}" class="text-neutral-200 hover:text-blue-400 text-sm transition-colors duration-200">
                                {{ setting('contact_phone') ?: '+49 123 456 7890' }}
                            </a>
                        </div>
                    @endif

                    @if(setting('whatsapp_number') || true)
                        <div class="flex items-start">
                            <x-keys::icon name="heroicon-o-chat-bubble-left-ellipsis" size="sm" class="text-green-400 mt-0.5 mr-3 flex-shrink-0" />
                            <a href="https://wa.me/{{ str_replace([' ', '-', '(', ')'], '', setting('whatsapp_number') ?: '+4912345678') }}" target="_blank" class="text-neutral-200 hover:text-green-400 text-sm transition-colors duration-200">
                                {{ setting('whatsapp_number') ?: '+49 123 456 7890' }}
                            </a>
                        </div>
                    @endif

                    @if(setting('contact_address') || true)
                        <div class="flex items-start">
                            <x-keys::icon name="heroicon-o-map-pin" size="sm" class="text-blue-400 mt-0.5 mr-3 flex-shrink-0" />
                            <span class="text-neutral-200 text-sm">{{ setting('contact_address') ?: "Elite Car Export GmbH\nMusterstraße 123\n12345 Berlin, Germany" }}</span>
                        </div>
                    @endif

                    @if(setting('business_hours') || true)
                        <div class="flex items-start">
                            <x-keys::icon name="heroicon-o-clock" size="sm" class="text-blue-400 mt-0.5 mr-3 flex-shrink-0" />
                            <span class="text-neutral-200 text-sm whitespace-pre-line">{{ setting('business_hours') ?: "Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 10:00 AM - 4:00 PM\nSunday: Closed" }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Social Media -->
            <div class="lg:col-span-1">
                <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-4">{{ __('Follow Us') }}</h3>
                <div class="flex space-x-4">
                    @if(setting('facebook_url') || true)
                        <a href="{{ setting('facebook_url') ?: 'https://facebook.com/elitecarexport' }}" target="_blank" class="text-neutral-200 hover:text-blue-500 transition-colors duration-200">
                            <span class="sr-only">{{ __('Facebook') }}</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clipRule="evenodd"></path>
                            </svg>
                        </a>
                    @endif

                    @if(setting('instagram_url') || true)
                        <a href="{{ setting('instagram_url') ?: 'https://instagram.com/elitecarexport' }}" target="_blank" class="text-neutral-200 hover:text-pink-500 transition-colors duration-200">
                            <span class="sr-only">{{ __('Instagram') }}</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.596-3.185-1.537-.737-.94-1.297-2.448-1.297-4.018s.56-3.078 1.297-4.018c.737-.94 1.888-1.537 3.185-1.537s2.448.596 3.185 1.537c.737.94 1.297 2.448 1.297 4.018s-.56 3.078-1.297 4.018c-.737.941-1.888 1.537-3.185 1.537zm7.718-1.537c-.737.94-1.888 1.537-3.185 1.537s-2.448-.596-3.185-1.537c-.737-.94-1.297-2.448-1.297-4.018s.56-3.078 1.297-4.018c.737-.94 1.888-1.537 3.185-1.537s2.448.596 3.185 1.537c.737.94 1.297 2.448 1.297 4.018s-.56 3.078-1.297 4.018z"/>
                            </svg>
                        </a>
                    @endif

                    @if(setting('linkedin_url') || true)
                        <a href="{{ setting('linkedin_url') ?: 'https://linkedin.com/company/elitecarexport' }}" target="_blank" class="text-neutral-200 hover:text-blue-600 transition-colors duration-200">
                            <span class="sr-only">{{ __('LinkedIn') }}</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clipRule="evenodd"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics and Car Makes Section -->
        <div class="border-t border-neutral-800 pt-8 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Statistics -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-6">{{ __('Our Numbers') }}</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="text-left">
                            <div class="text-2xl font-bold text-white mb-1">{{ \App\Models\Car::count() }}+</div>
                            <div class="text-neutral-300 text-xs">{{ __('Cars Available') }}</div>
                        </div>
                        <div class="text-left">
                            <div class="text-2xl font-bold text-white mb-1">{{ \App\Models\Review::count() }}+</div>
                            <div class="text-neutral-300 text-xs">{{ __('Happy Clients') }}</div>
                        </div>
                        <div class="text-left">
                            <div class="text-2xl font-bold text-white mb-1">5+</div>
                            <div class="text-neutral-300 text-xs">{{ __('Years Experience') }}</div>
                        </div>
                        <div class="text-left">
                            <div class="text-2xl font-bold text-white mb-1">25+</div>
                            <div class="text-neutral-300 text-xs">{{ __('Countries Served') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Car Makes -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-6">{{ __('Premium Brands') }}</h3>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                        @php
                            $makes = \App\Models\Make::active()
                                ->ordered()
                                ->limit(8)
                                ->get();
                        @endphp
                        @foreach($makes as $make)
                            <a href="{{ route('cars.index', ['make' => $make->slug]) }}"
                               class="bg-neutral-800 hover:bg-neutral-700 rounded-lg p-3 text-center transition-all duration-200 block group">
                                @if($make->hasLogo())
                                    <img src="{{ $make->getLogoUrl() }}"
                                         alt="{{ $make->name }}"
                                         class="h-6 w-auto mx-auto object-contain partner-logo-filter group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="text-neutral-200 text-xs font-medium group-hover:text-brand-400 transition-colors">{{ $make->name }}</div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Border -->
        <div class="border-t border-neutral-800 mt-12 pt-8">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <div class="text-neutral-400 text-sm">
                    @if(setting('footer_display_year'))
                        &copy; {{ date('Y') }} {{ setting('site_name', 'Elite Car Export') }}.
                    @else
                        &copy; {{ setting('site_name', 'Elite Car Export') }}.
                    @endif
                    {{ setting('footer_copyright_text', 'All rights reserved.') }}
                </div>

                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-6 mt-4 sm:mt-0 items-center">
                    <div class="flex space-x-6">
                        <a href="{{ route('legal.show', 'privacy-policy') }}" class="text-neutral-400 hover:text-white text-sm transition-colors duration-200">{{ __('Privacy Policy') }}</a>
                        <a href="{{ route('legal.show', 'terms-of-service') }}" class="text-neutral-400 hover:text-white text-sm transition-colors duration-200">{{ __('Terms of Service') }}</a>
                        <a href="{{ route('legal.show', 'cookie-policy') }}" class="text-neutral-400 hover:text-white text-sm transition-colors duration-200">{{ __('Cookie Policy') }}</a>
                    </div>

                    <div class="text-neutral-400 text-xs">
                        {{ __('Rosa Media Powered by Stratos') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
