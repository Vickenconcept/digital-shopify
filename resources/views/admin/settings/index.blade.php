<x-admin-layout>
<div class="space-y-6">

    {{-- ── Header ──────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Contact details, social links, and other global site information.</p>
        </div>
        <button type="submit" form="settings-form"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition-colors shadow-sm shadow-orange-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Save Settings
        </button>
    </div>

    {{-- ── Flash messages ──────────────────────────────────────── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start gap-3 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <svg class="w-4 h-4 shrink-0 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $socials = [
            'facebook'  => ['label' => 'Facebook',  'icon' => 'bxl-facebook',  'bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'border' => 'border-blue-100',    'placeholder' => 'https://facebook.com/yourpage'],
            'twitter'   => ['label' => 'Twitter / X', 'icon' => 'bxl-twitter',   'bg' => 'bg-sky-50',     'text' => 'text-sky-600',     'border' => 'border-sky-100',     'placeholder' => 'https://x.com/yourhandle'],
            'instagram' => ['label' => 'Instagram', 'icon' => 'bxl-instagram', 'bg' => 'bg-pink-50',    'text' => 'text-pink-600',    'border' => 'border-pink-100',    'placeholder' => 'https://instagram.com/yourhandle'],
            'youtube'   => ['label' => 'YouTube',   'icon' => 'bxl-youtube',   'bg' => 'bg-red-50',     'text' => 'text-red-600',     'border' => 'border-red-100',     'placeholder' => 'https://youtube.com/@yourchannel'],
            'tiktok'    => ['label' => 'TikTok',    'icon' => 'bxl-tiktok',    'bg' => 'bg-gray-100',   'text' => 'text-gray-800',    'border' => 'border-gray-200',    'placeholder' => 'https://tiktok.com/@yourhandle'],
        ];
        $configured = collect($socials)->filter(fn ($_, $key) => filled($settings->{$key . '_link'}))->count();
        $missing    = count($socials) - $configured;
    @endphp

    {{-- ── Stats ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Platforms</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ count($socials) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Configured</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $configured }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4 col-span-2 sm:col-span-1">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Not Set</p>
            <p class="text-3xl font-bold text-orange-500 mt-1">{{ $missing }}</p>
        </div>
    </div>

    <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- ── Contact information ───────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Contact Information</h2>
                        <p class="text-sm text-gray-500">Shown on the public Contact page. Leave blank to hide a field.</p>
                    </div>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Public contact email</label>
                    <input type="email" id="contact_email" name="contact_email"
                           value="{{ old('contact_email', $settings->contact_email) }}"
                           placeholder="support@yourjourneyvoices.com"
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                    <p class="mt-1.5 text-xs text-gray-500">Displayed on the contact page. Form submissions still go to <code class="text-gray-600">MAIL_CONTACT_RECIPIENT</code> in .env.</p>
                </div>
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" id="contact_phone" name="contact_phone"
                           value="{{ old('contact_phone', $settings->contact_phone) }}"
                           placeholder="+1 (555) 123-4567"
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea id="contact_address" name="contact_address" rows="3"
                              placeholder="123 Main Street&#10;City, State ZIP"
                              class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500 resize-y">{{ old('contact_address', $settings->contact_address) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── Store, notifications & audit ─────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Store &amp; notifications</h2>
                <p class="text-sm text-gray-500 mt-1">Tax rate for receipts, admin email alerts, and audit log retention.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="max-w-xs">
                    <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-1">Tax rate (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="tax_rate" id="tax_rate"
                           value="{{ old('tax_rate', $settings->tax_rate ?? 0) }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                </div>
                <div class="max-w-xs">
                    <label for="audit_log_retention_days" class="block text-sm font-medium text-gray-700 mb-1">Audit log retention (days)</label>
                    <input type="number" min="0" max="3650" name="audit_log_retention_days" id="audit_log_retention_days"
                           value="{{ old('audit_log_retention_days', $settings->audit_log_retention_days ?? 90) }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500">
                    <p class="mt-1 text-xs text-gray-500">0 = never auto-prune. Schedule <code class="text-xs bg-gray-100 px-1 rounded">activity-logs:prune</code> daily.</p>
                </div>
                <div class="space-y-3">
                    <p class="text-sm font-medium text-gray-700">Admin email notifications</p>
                    @foreach([
                        'notify_admin_new_order' => 'New paid orders',
                        'notify_admin_new_user' => 'New customer registrations',
                        'notify_admin_contact' => 'Contact form submissions',
                    ] as $field => $label)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="{{ $field }}" value="0">
                            <input type="checkbox" name="{{ $field }}" value="1"
                                   @checked(old($field, $settings->{$field} ?? true))
                                   class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Social links card ──────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Social Media Links</h2>
                        <p class="text-sm text-gray-500">Shown in the site footer. Leave blank to hide a platform.</p>
                    </div>
                </div>
                <span class="text-sm text-gray-400 shrink-0">{{ $configured }} of {{ count($socials) }} active</span>
            </div>

            <div class="divide-y divide-gray-50">
                @foreach($socials as $key => $social)
                    @php
                        $field = $key . '_link';
                        $value = old($field, $settings->{$field});
                        $isSet = filled($value);
                    @endphp
                    <div class="px-6 py-5 hover:bg-gray-50/60 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                            {{-- Platform identity --}}
                            <div class="flex items-center gap-3 lg:w-52 shrink-0">
                                <div class="w-10 h-10 rounded-lg {{ $social['bg'] }} border {{ $social['border'] }} flex items-center justify-center shrink-0">
                                    <i class="bx {{ $social['icon'] }} text-xl {{ $social['text'] }}"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $social['label'] }}</p>
                                    @if($isSet)
                                        <span class="inline-flex items-center gap-1 mt-0.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 mt-0.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-50 text-gray-500 border border-gray-200">
                                            Not set
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- URL input --}}
                            <div class="flex-1 min-w-0">
                                <label for="{{ $field }}" class="sr-only">{{ $social['label'] }} URL</label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                    <input
                                        id="{{ $field }}"
                                        name="{{ $field }}"
                                        type="url"
                                        value="{{ $value }}"
                                        placeholder="{{ $social['placeholder'] }}"
                                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-orange-500 @error($field) border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                    >
                                </div>
                                @error($field)
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Preview link --}}
                            <div class="lg:w-28 shrink-0 flex lg:justify-end">
                                @if($isSet)
                                    <a href="{{ $value }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Open
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs text-gray-300 bg-gray-50 rounded-lg border border-gray-100 cursor-default select-none">
                                        —
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Footer bar --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-xs text-gray-500">
                    Tip: Use full URLs including <code class="px-1 py-0.5 bg-white rounded border border-gray-200 text-gray-600">https://</code>
                </p>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition-colors shadow-sm shadow-orange-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Settings
                </button>
            </div>
        </div>
    </form>

    {{-- ── Help card ───────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm px-6 py-5">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Looking for page content?</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Homepage, About, and other page designs are managed in the
                    <a href="{{ route('admin.pages.index') }}" class="text-orange-600 font-medium hover:text-orange-700 hover:underline">Pages</a>
                    section with the visual page builder.
                </p>
            </div>
        </div>
    </div>

</div>
</x-admin-layout>
