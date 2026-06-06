{{--
    Shared GrapesJS styles + init script.
    Included by both create.blade.php and edit.blade.php.

    Required JS variables that the including template must define
    BEFORE this partial is included:
        window.PB_INITIAL_HTML  – string
        window.PB_INITIAL_CSS   – string
        window.PB_UPLOAD_URL    – string
        window.PB_CSRF          – string
--}}

{{-- ── GrapesJS dark theme CSS ───────────────────────────── --}}
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; overflow: hidden; }
    body { font-family: system-ui, -apple-system, sans-serif; background: #0f0f0f; }

    /* ── Topbar ──────────────────────────────────────────── */
    #pb-topbar {
        position: fixed; top: 0; left: 0; right: 0; height: 52px;
        background: #111827; border-bottom: 1px solid #1f2937;
        display: flex; align-items: center; gap: 10px; padding: 0 14px;
        z-index: 9999; overflow: hidden;
    }
    .pb-back { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; background: #1f2937; color: #d1d5db; border-radius: 7px; text-decoration: none; font-size: 12px; white-space: nowrap; flex-shrink: 0; transition: background .15s; }
    .pb-back:hover { background: #374151; color: #fff; }
    .pb-divider { width: 1px; height: 26px; background: #374151; flex-shrink: 0; }
    #pb-title-input { background: #1f2937; border: 1px solid #374151; border-radius: 7px; color: #f9fafb; font-size: 13px; font-weight: 600; padding: 5px 10px; width: 200px; outline: none; flex-shrink: 0; transition: border-color .15s; }
    #pb-title-input:focus { border-color: #f97316; }
    #pb-slug-input { background: #1f2937; border: 1px solid #374151; border-radius: 7px; color: #6b7280; font-size: 12px; padding: 5px 10px; width: 140px; outline: none; flex-shrink: 0; transition: border-color .15s; }
    #pb-slug-input:focus { border-color: #f97316; color: #e5e7eb; }
    #pb-slug-input[readonly] { opacity: .45; cursor: default; }
    .pb-toggles { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
    .pb-toggle-label { display: flex; align-items: center; gap: 5px; cursor: pointer; user-select: none; }
    .pb-toggle-label input[type="checkbox"] { width: 13px; height: 13px; accent-color: #f97316; cursor: pointer; }
    .pb-toggle-label span { font-size: 11px; color: #9ca3af; }
    .pb-spacer { flex: 1 1 auto; min-width: 8px; }
    .pb-status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 999px; font-size: 11px; font-weight: 600; flex-shrink: 0; white-space: nowrap; }
    .pb-status-badge.published { background: #022c22; color: #4ade80; }
    .pb-status-badge.draft { background: #422006; color: #fb923c; }
    .pb-view-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #1f2937; color: #d1d5db; border-radius: 7px; text-decoration: none; font-size: 12px; white-space: nowrap; flex-shrink: 0; border: 1px solid #374151; transition: background .15s; }
    .pb-view-btn:hover { background: #374151; color: #fff; }
    .pb-save-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 16px; background: #f97316; color: #fff; border-radius: 7px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; white-space: nowrap; flex-shrink: 0; transition: background .15s; }
    .pb-save-btn:hover { background: #ea580c; }

    /* ── Editor fills remaining height ────────────────────── */
    #gjs { position: fixed; top: 52px; left: 0; right: 0; bottom: 0; }
    .gjs-editor-cont, .gjs-editor { height: 100% !important; }

    /* ── GrapesJS dark chrome ─────────────────────────────── */
    .gjs-pn-panel { background: #111827 !important; border-color: #1f2937 !important; }
    .gjs-pn-views { background: #111827 !important; border-bottom: 1px solid #1f2937 !important; }
    .gjs-pn-views-container { background: #111827 !important; border-left: 1px solid #1f2937 !important; }
    .gjs-block-categories, .gjs-blocks-c { background: #111827 !important; }
    .gjs-block-category .gjs-title { background: #1a2233 !important; color: #9ca3af !important; border-color: #1f2937 !important; }
    .gjs-block { background: #1a2233 !important; border: 1px solid #374151 !important; color: #e5e7eb !important; border-radius: 8px !important; transition: border-color .15s !important; }
    .gjs-block:hover { border-color: #f97316 !important; background: #1f2937 !important; }
    .gjs-block .gjs-block-label { color: #d1d5db !important; font-size: 11px !important; }
    .gjs-block svg { color: #9ca3af !important; }
    .gjs-sm-sector-title { background: #1a2233 !important; color: #9ca3af !important; border-color: #1f2937 !important; }
    .gjs-sm-field input, .gjs-sm-field select { background: #1f2937 !important; color: #f9fafb !important; border-color: #374151 !important; border-radius: 5px !important; }
    .gjs-sm-label { color: #9ca3af !important; }
    .gjs-layers { background: #111827 !important; }
    .gjs-layer { background: #1a2233 !important; color: #e5e7eb !important; border-color: #1f2937 !important; }
    .gjs-layer:hover { background: #1f2937 !important; }
    .gjs-layer.gjs-selected { background: rgba(249,115,22,.15) !important; border-left: 2px solid #f97316 !important; }
    .gjs-pn-btn { color: #6b7280 !important; border-radius: 5px !important; }
    .gjs-pn-btn:hover { color: #f97316 !important; background: rgba(249,115,22,.1) !important; }
    .gjs-pn-btn.gjs-pn-active { color: #f97316 !important; }
    .gjs-cv-canvas { background: #e5e7eb !important; }
    .gjs-toolbar { background: #111827 !important; border-color: #374151 !important; border-radius: 6px !important; }
    .gjs-toolbar-item { color: #e5e7eb !important; }
    .gjs-toolbar-item:hover { color: #f97316 !important; }
    .gjs-rte-toolbar { background: #111827 !important; border-color: #374151 !important; border-radius: 6px !important; }
    .gjs-rte-action { color: #e5e7eb !important; }
    .gjs-rte-action:hover, .gjs-rte-action.gjs-rte-active { color: #f97316 !important; }

    /* ── Flash ────────────────────────────────────────────── */
    #pb-flash { position: fixed; top: 64px; left: 50%; transform: translateX(-50%); background: #022c22; color: #4ade80; padding: 9px 18px; border-radius: 8px; font-size: 12px; font-weight: 600; z-index: 99999; border: 1px solid #166534; display: none; pointer-events: none; }
    #pb-flash.error { background: #450a0a; color: #f87171; border-color: #7f1d1d; }
</style>

{{-- ── GrapesJS scripts ──────────────────────────────────── --}}
<script src="https://unpkg.com/grapesjs"></script>
<script src="https://unpkg.com/grapesjs-preset-webpage"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* Canvas base CSS — injected into the iframe, never saved */
    const CANVAS_BASE_CSS = `
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif !important; color: #111827; margin: 0; background: #fff; }
        h1,h2,h3,h4,h5,h6 { line-height: 1.15; }
        a { text-decoration: none; }
        img { max-width: 100%; display: block; }
        /* Editor preview: show final state (scroll animations run on live site only) */
        .yjv-reveal, .yjv-hero-part { opacity: 1 !important; transform: none !important; }
    `;

    /* ── Init editor ──────────────────────────────────────── */
    const editor = grapesjs.init({
        container: '#gjs',
        height: '100%',
        width: 'auto',
        fromElement: false,
        storageManager: false,
        canvasCss: CANVAS_BASE_CSS,
        plugins: ['gjs-preset-webpage'],
        pluginsOpts: {
            'gjs-preset-webpage': {
                blocksBasicOpts: { flexGrid: true },
                navbarOpts:    false,
                countdownOpts: false,
                formsOpts:     false,
            }
        },
        assetManager: {
            upload:      window.PB_UPLOAD_URL,
            uploadName:  'files',
            multiUpload: true,
            headers: { 'X-CSRF-TOKEN': window.PB_CSRF },
            assets: [],
        }
    });

    /* ── Load content ─────────────────────────────────────── */
    editor.setComponents(window.PB_INITIAL_HTML || `
        <section style="padding:100px 40px;text-align:center;background:#f8fafc">
            <h1 style="font-size:40px;color:#111827;margin-bottom:16px">Start designing your page</h1>
            <p style="color:#6b7280;font-size:18px">Drag a block from the right panel onto the canvas.</p>
        </section>`);
    editor.setStyle(window.PB_INITIAL_CSS || '');

    /* ── Custom YJV blocks ────────────────────────────────── */
    const bm = editor.BlockManager;
    const icon = (e) => `<div style="font-size:26px;line-height:1;margin-bottom:5px">${e}</div>`;

    /* ─ YJV Sections ─ */
    bm.add('yjv-hero', {
        label: icon('🦸') + 'Hero Section',
        category: 'YJV Sections',
        content: `
<section style="background:#111827;padding:72px 0;font-family:'Inter',sans-serif">
    <div style="width:min(1120px,92%);margin:0 auto;display:grid;grid-template-columns:1fr 420px;gap:48px;align-items:center">
    <div class="yjv-hero-part">
      <span style="display:inline-block;padding:7px 14px;background:rgba(249,115,22,.18);border:1px solid rgba(249,115,22,.4);border-radius:999px;color:#fb923c;font-size:13px;font-weight:700;letter-spacing:.04em">✦ Your Tagline Here</span>
      <h1 style="margin:20px 0 16px;font-size:52px;line-height:1.05;color:#ffffff;font-weight:900">Your Bold<br><span style="color:#f97316">Headline Here</span></h1>
      <p style="font-size:17px;line-height:1.7;color:#9ca3af;max-width:520px;margin-bottom:28px">Write a compelling sub-headline that explains your value to the visitor in one or two sentences.</p>
      <div style="display:flex;gap:12px;flex-wrap:wrap">
        <a href="/products" style="display:inline-flex;align-items:center;padding:13px 26px;background:#f97316;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none">Primary Action</a>
        <a href="/about" style="display:inline-flex;align-items:center;padding:13px 26px;border:1.5px solid rgba(255,255,255,.25);color:#e5e7eb;border-radius:10px;font-weight:600;font-size:15px;text-decoration:none">Secondary Action</a>
      </div>
    </div>
    <div class="yjv-hero-part" style="position:relative;border-radius:18px;overflow:hidden;box-shadow:0 24px 56px rgba(0,0,0,.5)">
      <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=640&q=80&auto=format&fit=crop" alt="Hero image" style="width:100%;height:400px;object-fit:cover;display:block">
      <div style="position:absolute;bottom:14px;left:14px;right:14px;background:rgba(17,24,39,.85);backdrop-filter:blur(8px);border:1px solid rgba(249,115,22,.3);border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:12px">
        <span style="font-size:22px">🎧</span>
        <div>
          <p style="font-size:10px;font-weight:700;color:#f97316;text-transform:uppercase;letter-spacing:.08em;margin:0 0 3px">Featured Content</p>
          <p style="font-size:13px;color:#f9fafb;font-weight:600;margin:0">Your Featured Audio Title Here</p>
        </div>
      </div>
    </div>
  </div>
</section>`,
    });

    bm.add('yjv-feature-cards', {
        label: icon('🃏') + 'Feature Cards',
        category: 'YJV Sections',
        content: `
<section style="padding:64px 0;background:#f9fafb;font-family:'Inter',sans-serif">
  <div style="width:min(1120px,92%);margin:0 auto">
    <div style="text-align:center;margin-bottom:40px">
      <p style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#f97316;margin-bottom:8px">What We Offer</p>
      <h2 style="font-size:36px;font-weight:800;color:#111827">Section Heading Goes Here</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px" class="yjv-stagger-grid">
      <div class="yjv-reveal" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;box-shadow:0 4px 16px rgba(0,0,0,.06)">
        <div style="font-size:36px;margin-bottom:14px">🎯</div>
        <h3 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:10px">Card Title One</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.65;margin-bottom:16px">Describe the feature or benefit in a short, clear sentence.</p>
        <a href="#" style="font-size:13px;font-weight:700;color:#f97316;text-decoration:none">Learn more →</a>
      </div>
      <div class="yjv-reveal" style="background:#111827;border-radius:16px;padding:28px">
        <div style="font-size:36px;margin-bottom:14px">🔥</div>
        <h3 style="font-size:20px;font-weight:700;color:#fff;margin-bottom:10px">Card Title Two</h3>
        <p style="font-size:14px;color:#9ca3af;line-height:1.65;margin-bottom:16px">Describe the feature or benefit in a short, clear sentence.</p>
        <a href="#" style="font-size:13px;font-weight:700;color:#f97316;text-decoration:none">Learn more →</a>
      </div>
      <div class="yjv-reveal" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;box-shadow:0 4px 16px rgba(0,0,0,.06)">
        <div style="font-size:36px;margin-bottom:14px">💡</div>
        <h3 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:10px">Card Title Three</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.65;margin-bottom:16px">Describe the feature or benefit in a short, clear sentence.</p>
        <a href="#" style="font-size:13px;font-weight:700;color:#f97316;text-decoration:none">Learn more →</a>
      </div>
    </div>
  </div>
</section>`,
    });

    bm.add('yjv-image-text', {
        label: icon('🖼️') + 'Image + Text',
        category: 'YJV Sections',
        content: `
<section style="padding:72px 0;background:#fff;font-family:'Inter',sans-serif">
  <div style="width:min(1120px,92%);margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center">
    <div style="border-radius:18px;overflow:hidden;box-shadow:0 16px 48px rgba(0,0,0,.12)">
      <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=640&q=80&auto=format&fit=crop" alt="Section image" style="width:100%;height:400px;object-fit:cover;display:block">
    </div>
    <div>
      <p style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#f97316;margin-bottom:10px">Section Label</p>
      <h2 style="font-size:38px;font-weight:800;color:#111827;line-height:1.1;margin-bottom:16px">Your Heading<br>Goes Right Here</h2>
      <p style="font-size:16px;color:#6b7280;line-height:1.7;margin-bottom:24px">Write supporting copy here. Explain your value, your story, or what makes this section important.</p>
      <ul style="list-style:none;padding:0;margin:0 0 28px;display:flex;flex-direction:column;gap:10px">
        <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:#374151"><span style="color:#f97316;font-weight:900">✓</span> Key benefit or feature point</li>
        <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:#374151"><span style="color:#f97316;font-weight:900">✓</span> Another important point here</li>
        <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:#374151"><span style="color:#f97316;font-weight:900">✓</span> Third compelling reason</li>
      </ul>
      <a href="#" style="display:inline-flex;align-items:center;padding:13px 26px;background:#f97316;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none">Get Started →</a>
    </div>
  </div>
</section>`,
    });

    bm.add('yjv-cta-banner', {
        label: icon('📢') + 'CTA Banner',
        category: 'YJV Sections',
        content: `
<section style="padding:64px 0;background:#f9fafb;font-family:'Inter',sans-serif">
  <div style="width:min(1120px,92%);margin:0 auto">
    <div style="background:#111827;border-radius:22px;padding:52px 48px;display:flex;justify-content:space-between;align-items:center;gap:32px;position:relative;overflow:hidden">
      <div style="position:absolute;top:-80px;right:-80px;width:300px;height:300px;background:radial-gradient(circle,rgba(249,115,22,.18),transparent 70%);pointer-events:none"></div>
      <div>
        <h2 style="font-size:38px;font-weight:800;color:#fff;line-height:1.1;margin:0 0 12px">Ready to Take the Next Step?</h2>
        <p style="font-size:16px;color:#9ca3af;line-height:1.6;max-width:520px;margin:0">Short persuasive text that motivates the visitor to click the action button.</p>
      </div>
      <div style="display:flex;gap:12px;flex-shrink:0;flex-wrap:wrap">
        <a href="/products" style="display:inline-flex;align-items:center;padding:13px 26px;background:#f97316;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;white-space:nowrap">Browse Library</a>
        <a href="/contact" style="display:inline-flex;align-items:center;padding:13px 26px;border:1.5px solid #374151;color:#e5e7eb;border-radius:10px;font-weight:600;font-size:15px;text-decoration:none;white-space:nowrap">Contact Us</a>
      </div>
    </div>
  </div>
</section>`,
    });

    bm.add('yjv-stats', {
        label: icon('📊') + 'Stats Row',
        category: 'YJV Sections',
        content: `
<section style="background:#f97316;padding:36px 0;font-family:'Inter',sans-serif">
  <div style="width:min(1120px,92%);margin:0 auto;display:flex;justify-content:center;align-items:center;flex-wrap:wrap">
    <div style="flex:1;text-align:center;padding:12px 24px;min-width:140px"><span style="display:block;font-size:42px;font-weight:900;color:#fff;line-height:1">500+</span><span style="display:block;font-size:13px;color:rgba(255,255,255,.8);margin-top:4px;font-weight:600">Digital Resources</span></div>
    <div style="width:1px;height:56px;background:rgba(255,255,255,.25)"></div>
    <div style="flex:1;text-align:center;padding:12px 24px;min-width:140px"><span style="display:block;font-size:42px;font-weight:900;color:#fff;line-height:1">10k+</span><span style="display:block;font-size:13px;color:rgba(255,255,255,.8);margin-top:4px;font-weight:600">Lives Inspired</span></div>
    <div style="width:1px;height:56px;background:rgba(255,255,255,.25)"></div>
    <div style="flex:1;text-align:center;padding:12px 24px;min-width:140px"><span style="display:block;font-size:42px;font-weight:900;color:#fff;line-height:1">4.9★</span><span style="display:block;font-size:13px;color:rgba(255,255,255,.8);margin-top:4px;font-weight:600">Average Rating</span></div>
    <div style="width:1px;height:56px;background:rgba(255,255,255,.25)"></div>
    <div style="flex:1;text-align:center;padding:12px 24px;min-width:140px"><span style="display:block;font-size:42px;font-weight:900;color:#fff;line-height:1">100%</span><span style="display:block;font-size:13px;color:rgba(255,255,255,.8);margin-top:4px;font-weight:600">Faith-Centered</span></div>
  </div>
</section>`,
    });

    bm.add('yjv-text-block', {
        label: icon('📝') + 'Text Block',
        category: 'YJV Sections',
        content: `
<section style="padding:64px 0;background:#fff;font-family:'Inter',sans-serif">
  <div style="width:min(760px,92%);margin:0 auto;text-align:center">
    <p style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#f97316;margin-bottom:10px">Label / Tag</p>
    <h2 style="font-size:38px;font-weight:800;color:#111827;line-height:1.15;margin-bottom:16px">Your Section Heading Here</h2>
    <p style="font-size:17px;color:#6b7280;line-height:1.75;margin-bottom:28px">Write your body copy here. This block is great for introductions, about text, or any standalone text section on your page.</p>
    <a href="#" style="display:inline-flex;align-items:center;padding:12px 24px;background:#f97316;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none">Call to Action</a>
  </div>
</section>`,
    });

    bm.add('yjv-quote', {
        label: icon('💬') + 'Quote / Testimonial',
        category: 'YJV Sections',
        content: `
<section style="padding:64px 0;background:#f9fafb;font-family:'Inter',sans-serif">
  <div style="width:min(800px,92%);margin:0 auto">
    <div style="background:#111827;border-left:4px solid #f97316;border-radius:16px;padding:40px">
      <p style="font-size:22px;font-style:italic;color:#e5e7eb;line-height:1.65;margin:0 0 24px">"This is where a powerful testimonial or inspirational quote goes. Make it personal and impactful."</p>
      <div style="display:flex;align-items:center;gap:14px">
        <div style="width:44px;height:44px;border-radius:50%;background:#1f2937;border:2px solid #f97316;display:flex;align-items:center;justify-content:center;font-size:18px">👤</div>
        <div>
          <p style="font-size:15px;font-weight:700;color:#fff;margin:0">Person Name</p>
          <p style="font-size:13px;color:#6b7280;margin:2px 0 0">Title, Organization</p>
        </div>
      </div>
    </div>
  </div>
</section>`,
    });

    /* ─ YJV Layout ─ */
    bm.add('yjv-2col', {
        label: icon('⬜⬜') + '2 Columns',
        category: 'YJV Layout',
        content: `
<section style="padding:48px 0;background:#fff;font-family:'Inter',sans-serif">
  <div style="width:min(1120px,92%);margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:32px">
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:14px;padding:32px;min-height:160px">
      <h3 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 10px">Column One</h3>
      <p style="font-size:14px;color:#6b7280;line-height:1.65;margin:0">Add your content here.</p>
    </div>
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:14px;padding:32px;min-height:160px">
      <h3 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 10px">Column Two</h3>
      <p style="font-size:14px;color:#6b7280;line-height:1.65;margin:0">Add your content here.</p>
    </div>
  </div>
</section>`,
    });

    bm.add('yjv-3col', {
        label: icon('▪▪▪') + '3 Columns',
        category: 'YJV Layout',
        content: `
<section style="padding:48px 0;background:#fff;font-family:'Inter',sans-serif">
  <div style="width:min(1120px,92%);margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:14px;padding:28px;min-height:140px"><h3 style="font-size:18px;font-weight:700;color:#111827;margin:0 0 8px">Column One</h3><p style="font-size:14px;color:#6b7280;line-height:1.65;margin:0">Content goes here.</p></div>
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:14px;padding:28px;min-height:140px"><h3 style="font-size:18px;font-weight:700;color:#111827;margin:0 0 8px">Column Two</h3><p style="font-size:14px;color:#6b7280;line-height:1.65;margin:0">Content goes here.</p></div>
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:14px;padding:28px;min-height:140px"><h3 style="font-size:18px;font-weight:700;color:#111827;margin:0 0 8px">Column Three</h3><p style="font-size:14px;color:#6b7280;line-height:1.65;margin:0">Content goes here.</p></div>
  </div>
</section>`,
    });

    bm.add('yjv-4col', {
        label: icon('||||') + '4 Columns',
        category: 'YJV Layout',
        content: `
<section style="padding:48px 0;background:#fff;font-family:'Inter',sans-serif">
  <div style="width:min(1120px,92%);margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:20px">
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:24px;min-height:120px"><h3 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 8px">Col 1</h3><p style="font-size:13px;color:#6b7280;line-height:1.6;margin:0">Content.</p></div>
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:24px;min-height:120px"><h3 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 8px">Col 2</h3><p style="font-size:13px;color:#6b7280;line-height:1.6;margin:0">Content.</p></div>
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:24px;min-height:120px"><h3 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 8px">Col 3</h3><p style="font-size:13px;color:#6b7280;line-height:1.6;margin:0">Content.</p></div>
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:24px;min-height:120px"><h3 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 8px">Col 4</h3><p style="font-size:13px;color:#6b7280;line-height:1.6;margin:0">Content.</p></div>
  </div>
</section>`,
    });

    /* ─ YJV Elements ─ */
    bm.add('yjv-btn-orange', {
        label: icon('🟠') + 'Orange Button',
        category: 'YJV Elements',
        content: `<a href="#" style="display:inline-flex;align-items:center;padding:13px 26px;background:#f97316;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;font-family:'Inter',sans-serif;box-shadow:0 4px 16px rgba(249,115,22,.35)">Button Text →</a>`,
    });
    bm.add('yjv-btn-outline', {
        label: icon('⬜') + 'Outline Button',
        category: 'YJV Elements',
        content: `<a href="#" style="display:inline-flex;align-items:center;padding:12px 24px;border:2px solid #111827;color:#111827;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;font-family:'Inter',sans-serif">Button Text</a>`,
    });
    bm.add('yjv-divider', {
        label: icon('—') + 'Divider',
        category: 'YJV Elements',
        content: `<div style="width:min(1120px,92%);margin:0 auto;padding:24px 0"><hr style="border:none;border-top:1px solid #e5e7eb;margin:0"></div>`,
    });
    bm.add('yjv-divider-label', {
        label: icon('✦') + 'Divider + Label',
        category: 'YJV Elements',
        content: `<div style="width:min(1120px,92%);margin:0 auto;padding:32px 0;display:flex;align-items:center;gap:16px"><div style="flex:1;height:1px;background:#e5e7eb"></div><span style="font-size:13px;font-weight:700;color:#f97316;letter-spacing:.1em;text-transform:uppercase;white-space:nowrap">Section Label</span><div style="flex:1;height:1px;background:#e5e7eb"></div></div>`,
    });
    bm.add('yjv-spacer-sm', {
        label: icon('↕') + 'Spacer Small',
        category: 'YJV Elements',
        content: `<div style="height:40px"></div>`,
    });
    bm.add('yjv-spacer-lg', {
        label: icon('⬆⬇') + 'Spacer Large',
        category: 'YJV Elements',
        content: `<div style="height:80px"></div>`,
    });
    bm.add('yjv-badge', {
        label: icon('🏷️') + 'Orange Badge',
        category: 'YJV Elements',
        content: `<span style="display:inline-block;padding:6px 14px;background:rgba(249,115,22,.15);border:1px solid rgba(249,115,22,.4);border-radius:999px;color:#ea580c;font-size:13px;font-weight:700;letter-spacing:.04em;font-family:'Inter',sans-serif">Label Text</span>`,
    });
    bm.add('yjv-image', {
        label: icon('🖼') + 'Image',
        category: 'YJV Elements',
        content: `<figure style="margin:0;border-radius:16px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.1)"><img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800&q=80&auto=format&fit=crop" alt="Replace this image" style="width:100%;height:320px;object-fit:cover;display:block"></figure>`,
    });
    bm.add('yjv-card', {
        label: icon('📄') + 'Card',
        category: 'YJV Elements',
        content: `
<div class="yjv-reveal yjv-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;box-shadow:0 4px 16px rgba(0,0,0,.06);font-family:'Inter',sans-serif;max-width:360px">
  <div style="font-size:32px;margin-bottom:14px">⭐</div>
  <h3 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 10px">Card Title</h3>
  <p style="font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 18px">Card description goes here. Keep it short and compelling.</p>
  <a href="#" style="font-size:13px;font-weight:700;color:#f97316;text-decoration:none">Read more →</a>
</div>`,
    });

    /* ── Title → slug ─────────────────────────────────────── */
    const titleInput = document.getElementById('pb-title-input');
    const slugInput  = document.getElementById('pb-slug-input');
    if (titleInput && slugInput && !slugInput.readOnly) {
        titleInput.addEventListener('input', () => {
            if (slugInput.dataset.edited === '1') return;
            slugInput.value = titleInput.value.toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        });
        slugInput.addEventListener('input', () => { slugInput.dataset.edited = '1'; });
    }

    /* ── Save ─────────────────────────────────────────────── */
    document.getElementById('pb-form').addEventListener('submit', function () {
        document.getElementById('body_html').value = editor.getHtml();
        document.getElementById('body_css').value  = editor.getCss();
    });

    /* ── Published badge sync (edit page only) ────────────── */
    const cbPublished   = document.getElementById('cb-published');
    const statusDisplay = document.getElementById('pb-status-display');
    const statusText    = document.getElementById('pb-status-text');
    if (cbPublished && statusDisplay) {
        cbPublished.addEventListener('change', () => {
            statusDisplay.className = cbPublished.checked
                ? 'pb-status-badge published'
                : 'pb-status-badge draft';
            statusText.textContent = cbPublished.checked ? 'Published' : 'Draft';
        });
    }

    /* ── Flash on save ────────────────────────────────────── */
    if (window.PB_FLASH_MSG) {
        const el = document.getElementById('pb-flash');
        el.textContent = window.PB_FLASH_MSG;
        el.style.display = 'block';
        setTimeout(() => { el.style.display = 'none'; }, 3500);
    }
});
</script>
