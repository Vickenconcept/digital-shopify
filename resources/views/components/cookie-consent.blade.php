<div
    x-data="cookieConsent()"
    x-cloak
    x-show="visible"
    class="fixed inset-x-0 bottom-0 z-[100] p-4 sm:p-6 pointer-events-none"
    role="dialog"
    aria-label="Cookie consent"
>
    <div class="pointer-events-auto mx-auto max-w-4xl rounded-xl border border-gray-200 bg-white shadow-2xl overflow-hidden">
        <template x-if="!showPreferences">
            <div class="p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex-1">
                        <h2 class="text-base font-semibold text-gray-900">We value your privacy</h2>
                        <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                            We use essential cookies to run this site. With your permission, we may also use analytics cookies to understand how visitors use our store.
                            <a href="{{ url('/privacy-policy') }}" class="text-orange-600 hover:text-orange-700 underline">Privacy policy</a>
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 shrink-0">
                        <button type="button" @click="openPreferences()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Manage preferences
                        </button>
                        <button type="button" @click="acceptEssentialOnly()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200">
                            Essential only
                        </button>
                        <button type="button" @click="acceptAll()"
                            class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700">
                            Accept all
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="showPreferences">
            <div class="p-5 sm:p-6">
                <h2 class="text-base font-semibold text-gray-900">Cookie preferences</h2>
                <p class="mt-1 text-sm text-gray-600">Choose which cookies we may use. You can change this anytime by clearing site data or revisiting this banner after we add a footer link.</p>

                <div class="mt-4 space-y-3">
                    <div class="flex items-start justify-between gap-4 p-3 rounded-lg bg-gray-50 border border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Essential</p>
                            <p class="text-xs text-gray-500 mt-0.5">Required for login, cart, and security. Always enabled.</p>
                        </div>
                        <span class="text-xs font-medium text-gray-500 uppercase shrink-0">Always on</span>
                    </div>
                    <label class="flex items-start justify-between gap-4 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Analytics</p>
                            <p class="text-xs text-gray-500 mt-0.5">Helps us improve the site (e.g. page views). Not used until you allow.</p>
                        </div>
                        <input type="checkbox" x-model="preferences.analytics"
                            class="mt-1 h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                    </label>
                </div>

                <div class="mt-5 flex flex-col sm:flex-row gap-2 justify-end">
                    <button type="button" @click="showPreferences = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Back
                    </button>
                    <button type="button" @click="savePreferences()"
                        class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700">
                        Save preferences
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    function cookieConsent() {
        const STORAGE_KEY = 'yjv_cookie_consent_v1';

        return {
            visible: false,
            showPreferences: false,
            preferences: { essential: true, analytics: false },

            init() {
                const stored = this.readStored();
                if (stored) {
                    this.preferences = { essential: true, analytics: !!stored.analytics };
                    window.dispatchEvent(new CustomEvent('cookie-consent-updated', { detail: stored }));
                    return;
                }
                this.visible = true;
            },

            readStored() {
                try {
                    const raw = localStorage.getItem(STORAGE_KEY);
                    return raw ? JSON.parse(raw) : null;
                } catch {
                    return null;
                }
            },

            persist() {
                const payload = {
                    essential: true,
                    analytics: this.preferences.analytics,
                    decided_at: new Date().toISOString(),
                };
                localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
                window.dispatchEvent(new CustomEvent('cookie-consent-updated', { detail: payload }));
                this.visible = false;
                this.showPreferences = false;
            },

            acceptAll() {
                this.preferences.analytics = true;
                this.persist();
            },

            acceptEssentialOnly() {
                this.preferences.analytics = false;
                this.persist();
            },

            openPreferences() {
                this.showPreferences = true;
            },

            savePreferences() {
                this.persist();
            },
        };
    }
</script>
