<x-main-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-orange-50 to-orange-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Get in Touch</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Questions about audiobooks, orders, or your account? Send us a message and we will get back to you soon.
            </p>
        </div>
    </div>

    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Information -->
                <div class="space-y-8">
                <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            Let's Connect
                    </h2>
                        <p class="text-lg text-gray-600">
                            We are here to help with orders, downloads, and general questions about Your Journey Voices.
                        </p>
                    </div>

                    @php
                        $displayEmail = $siteSettings->contact_email ?? null;
                        $displayPhone = $siteSettings->contact_phone ?? null;
                        $displayAddress = $siteSettings->contact_address ?? null;
                        $hasContactInfo = filled($displayEmail) || filled($displayPhone) || filled($displayAddress);
                    @endphp

                    @if($hasContactInfo)
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900">Contact Information</h3>

                        @if(filled($displayEmail))
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Email</p>
                                <a href="mailto:{{ $displayEmail }}" class="text-sm text-orange-600 hover:text-orange-700">{{ $displayEmail }}</a>
                            </div>
                        </div>
                        @endif

                        @if(filled($displayPhone))
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Phone</p>
                                @php $phoneHref = preg_replace('/[^\d+]/', '', $displayPhone); @endphp
                                <a href="tel:{{ $phoneHref }}" class="text-sm text-orange-600 hover:text-orange-700">{{ $displayPhone }}</a>
                            </div>
                        </div>
                        @endif

                        @if(filled($displayAddress))
                        <div class="flex items-start space-x-4 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Address</p>
                                <p class="text-sm text-gray-600 whitespace-pre-line">{{ $displayAddress }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="rounded-lg border border-dashed border-gray-300 bg-white p-6 text-center">
                        <p class="text-sm text-gray-500">Contact details will appear here once configured in Site Settings.</p>
                    </div>
                    @endif

                    @if(isset($siteSettings) && ($siteSettings->facebook_link || $siteSettings->twitter_link || $siteSettings->instagram_link || $siteSettings->youtube_link || $siteSettings->tiktok_link))
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900">Follow Us</h3>
                        <p class="text-sm text-gray-600">Connect with us on social media. Links are managed in Admin → Site Settings.</p>
                        <div class="flex flex-wrap gap-3">
                            @if($siteSettings->facebook_link)
                                <a href="{{ $siteSettings->facebook_link }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-orange-500 hover:border-orange-300 transition-colors duration-200">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                                </a>
                            @endif
                            @if($siteSettings->youtube_link)
                                <a href="{{ $siteSettings->youtube_link }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-orange-500 hover:border-orange-300 transition-colors duration-200">
                                    <span class="sr-only">YouTube</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"/></svg>
                                </a>
                            @endif
                            @if($siteSettings->instagram_link)
                                <a href="{{ $siteSettings->instagram_link }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-orange-500 hover:border-orange-300 transition-colors duration-200">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.281H7.721v8.562h8.558V7.707z" clip-rule="evenodd"/></svg>
                                </a>
                            @endif
                            @if($siteSettings->twitter_link)
                                <a href="{{ $siteSettings->twitter_link }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-orange-500 hover:border-orange-300 transition-colors duration-200">
                                    <span class="sr-only">Twitter / X</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                            @if($siteSettings->tiktok_link)
                                <a href="{{ $siteSettings->tiktok_link }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-orange-500 hover:border-orange-300 transition-colors duration-200">
                                    <span class="sr-only">TikTok</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white">
                            Send Us a Message
                        </h3>
                        </div>
                        <p class="text-orange-100 mt-2">
                            We'll get back to you within 24 hours
                        </p>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Honeypot Field (Hidden from users) -->
                            <div style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;" aria-hidden="true">
                                <label for="website">Website</label>
                                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                            </div>
                            
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Full Name</span>
                                    </div>
                                </label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200"
                                    placeholder="Enter your full name">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Email Address</span>
                                    </div>
                                </label>
                                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200"
                                    placeholder="Enter your email address">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subject Field -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span>Subject</span>
                                    </div>
                                </label>
                                <input type="text" name="subject" id="subject" required value="{{ old('subject') }}"
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200"
                                    placeholder="What's this about?">
                                @error('subject')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Message Field -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span>Message</span>
                                    </div>
                                </label>
                                <textarea name="message" id="message" rows="5" required
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200 resize-none"
                                    placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            x-init="setTimeout(() => show = false, 5000)"
            class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg border border-green-400 max-w-sm">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="flex-shrink-0 text-green-200 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</x-main-layout>