/**
 * Load third-party scripts only after analytics consent.
 * Listen for: window 'cookie-consent-updated' or call loadAnalyticsIfConsented() on init.
 */
const CONSENT_KEY = 'yjv_cookie_consent_v1';

export function getCookieConsent() {
    try {
        const raw = localStorage.getItem(CONSENT_KEY);
        return raw ? JSON.parse(raw) : null;
    } catch {
        return null;
    }
}

export function hasAnalyticsConsent() {
    return getCookieConsent()?.analytics === true;
}

export function loadAnalyticsIfConsented() {
    if (!hasAnalyticsConsent()) {
        return;
    }

    // Example: enable Google Analytics when you add a measurement ID
    // if (!window.gtag && import.meta.env.VITE_GA_MEASUREMENT_ID) { ... }
}

window.addEventListener('cookie-consent-updated', (event) => {
    if (event.detail?.analytics) {
        loadAnalyticsIfConsented();
    }
});

document.addEventListener('DOMContentLoaded', loadAnalyticsIfConsented);
