<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'og_image',
        'slug',
        'body_html',
        'body_css',
        'custom_js',
        'is_published',
        'show_in_navigation',
        'show_in_footer',
        'is_system',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_navigation' => 'boolean',
        'show_in_footer' => 'boolean',
        'is_system' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Page $page): void {
            $page->slug = Str::slug($page->slug ?: $page->title);

            if ($page->is_published && !$page->published_at) {
                $page->published_at = now();
            }

            if (!$page->is_published) {
                $page->published_at = null;
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeVisibleInNavigation(Builder $query): Builder
    {
        return $query->published()->where('show_in_navigation', true);
    }

    public function scopeVisibleInFooter(Builder $query): Builder
    {
        return $query->published()->where('show_in_footer', true);
    }

    public function getUrlAttribute(): string
    {
        if ($this->slug === 'home') {
            return url('/');
        }

        if ($this->slug === 'about') {
            return route('about');
        }

        return url('/' . $this->slug);
    }

    public static function ensureCorePagesExist(): void
    {
        static::firstOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Home',
                'body_html' => self::defaultHomeHtml(),
                'body_css' => self::defaultHomeCss(),
                'is_system' => true,
                'is_published' => true,
                'show_in_navigation' => true,
                'show_in_footer' => true,
                'published_at' => now(),
            ]
        );

        static::firstOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Us',
                'body_html' => self::defaultAboutHtml(),
                'body_css' => self::defaultAboutCss(),
                'is_system' => true,
                'is_published' => true,
                'show_in_navigation' => true,
                'show_in_footer' => true,
                'published_at' => now(),
            ]
        );
    }

    private static function defaultHomeHtml(): string
    {
        return <<<'HTML'
<div class="h-wrap">

  <!-- ── HERO ─────────────────────────────────────────── -->
  <section class="h-hero">
    <div class="h-con">
      <div class="h-hero-inner">
        <div class="h-hero-text">
          <span class="h-kicker">✦ Stories That Travel With You</span>
          <h1 class="h-hero-h1">Faith. Family.<br><span class="h-orange">Growth.</span></h1>
          <p class="h-hero-sub">Your Journey Voices is your digital home for inspiring audiobooks, children's stories, and motivational content crafted to strengthen your walk every single day.</p>
          <div class="h-cta-row">
            <a class="h-btn h-btn-orange" href="/products">Browse Library</a>
            <a class="h-btn h-btn-ghost" href="/about">Our Story</a>
          </div>
          <div class="h-stats">
            <div class="h-stat"><strong>500+</strong><span>Resources</span></div>
            <div class="h-stat-div"></div>
            <div class="h-stat"><strong>4.9★</strong><span>Rated</span></div>
            <div class="h-stat-div"></div>
            <div class="h-stat"><strong>10k+</strong><span>Listeners</span></div>
          </div>
        </div>
        <div class="h-hero-img-wrap">
          <div class="h-hero-img-frame">
            <img
              src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=700&q=80&auto=format&fit=crop"
              alt="Your Journey Voices – Audiobooks &amp; Stories"
              class="h-hero-img"
            >
            <div class="h-img-badge">
              <span class="h-img-badge-icon">🎧</span>
              <div>
                <p class="h-img-badge-top">New This Week</p>
                <p class="h-img-badge-bot">Living in Purpose Audio Series</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ── MARQUEE STRIP ──────────────────────────────────── -->
  <div class="h-strip">
    <div class="h-strip-track">
      <span>Christian Audiobooks</span><span class="h-dot">✦</span>
      <span>Children's Stories</span><span class="h-dot">✦</span>
      <span>Commuter Picks</span><span class="h-dot">✦</span>
      <span>Inspiration &amp; Health</span><span class="h-dot">✦</span>
      <span>Daily Devotionals</span><span class="h-dot">✦</span>
      <span>Faith-Based eBooks</span><span class="h-dot">✦</span>
      <span>Christian Audiobooks</span><span class="h-dot">✦</span>
      <span>Children's Stories</span><span class="h-dot">✦</span>
      <span>Commuter Picks</span><span class="h-dot">✦</span>
      <span>Inspiration &amp; Health</span><span class="h-dot">✦</span>
    </div>
  </div>

  <!-- ── CATEGORIES ─────────────────────────────────────── -->
  <section class="h-cats-section">
    <div class="h-con">
      <div class="h-section-head">
        <div>
          <p class="h-section-label">Explore By Category</p>
          <h2 class="h-section-h2">Find Content For Every Season</h2>
        </div>
        <a href="/products" class="h-link-arrow">View all →</a>
      </div>
      <div class="h-cats-grid">
        <a href="/christian-audiobooks" class="h-cat h-cat-blue">
          <div class="h-cat-icon">✝</div>
          <h3>Christian Audiobooks</h3>
          <p>Strengthen your faith with Bible-based teachings and uplifting messages for daily spiritual growth.</p>
          <span class="h-cat-cta">Explore →</span>
        </a>
        <a href="/children-audiobooks" class="h-cat h-cat-pink">
          <div class="h-cat-icon">🌟</div>
          <h3>Children's Stories</h3>
          <p>Magical stories and Bible tales that spark imagination and create precious memories with family.</p>
          <span class="h-cat-cta">Explore →</span>
        </a>
        <a href="/commuter-audiobooks" class="h-cat h-cat-green">
          <div class="h-cat-icon">🚗</div>
          <h3>Commuter Picks</h3>
          <p>Transform your commute with uplifting stories and motivational content built for your journey.</p>
          <span class="h-cat-cta">Explore →</span>
        </a>
        <a href="/inspiration-health" class="h-cat h-cat-purple">
          <div class="h-cat-icon">💡</div>
          <h3>Inspiration &amp; Health</h3>
          <p>Boost mental wellness with personal development content and healing narratives for mind and soul.</p>
          <span class="h-cat-cta">Explore →</span>
        </a>
      </div>
    </div>
  </section>

  <!-- ── HOW IT WORKS ──────────────────────────────────── -->
  <section class="h-how-section">
    <div class="h-con">
      <div class="h-section-head h-center">
        <div>
          <p class="h-section-label">Simple Process</p>
          <h2 class="h-section-h2">Start Listening in Minutes</h2>
        </div>
      </div>
      <div class="h-steps">
        <div class="h-step">
          <div class="h-step-num">01</div>
          <h4>Browse &amp; Discover</h4>
          <p>Explore hundreds of faith-based audiobooks, ebooks, and devotionals across every category.</p>
        </div>
        <div class="h-step-arrow">→</div>
        <div class="h-step">
          <div class="h-step-num">02</div>
          <h4>Select &amp; Purchase</h4>
          <p>Choose your content and complete a quick, secure checkout to unlock instant access.</p>
        </div>
        <div class="h-step-arrow">→</div>
        <div class="h-step">
          <div class="h-step-num">03</div>
          <h4>Listen &amp; Grow</h4>
          <p>Download or stream on any device. Let the stories and teachings travel with you, everywhere.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ── BLOG CTA ───────────────────────────────────────── -->
  <section class="h-blog-cta-section">
    <div class="h-con">
      <div class="h-blog-cta-inner">
        <div class="h-blog-cta-text">
          <p class="h-section-label" style="color:#fdba74">Weekly Inspiration</p>
          <h2 style="margin:8px 0 12px;font-size:clamp(26px,4vw,42px);line-height:1.1;color:#ffffff">Stay Encouraged<br>Every Week</h2>
          <p style="color:#d1d5db;line-height:1.6;max-width:500px">Practical, scripture-rooted insights delivered weekly. Read our blog for encouragement, tips, and teachings to keep your faith strong.</p>
          <a href="/blog" class="h-btn h-btn-orange" style="margin-top:24px;display:inline-block">Read the Blog →</a>
        </div>
        <div class="h-blog-cta-deco">
          <div class="h-deco-card">📘 "Walking in Purpose"</div>
          <div class="h-deco-card">🙏 "Morning Devotional"</div>
          <div class="h-deco-card">🔥 "Faith Under Fire"</div>
        </div>
      </div>
    </div>
  </section>

</div>
HTML;
    }

    private static function defaultHomeCss(): string
    {
        return <<<'CSS'
/* ── Reset & Base ─────────────────────────── */
.h-wrap{font-family:Inter,system-ui,-apple-system,sans-serif;color:#111827;background:#f9fafb}
.h-con{width:min(1200px,94%);margin:0 auto}
*{box-sizing:border-box}

/* ── Hero ─────────────────────────────────── */
.h-hero{background:#111827;padding:72px 0 80px}
.h-hero-inner{display:grid;grid-template-columns:1fr 380px;gap:48px;align-items:center}
.h-kicker{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;background:rgba(249,115,22,.15);border:1px solid rgba(249,115,22,.3);border-radius:999px;color:#fb923c;font-size:13px;font-weight:600;letter-spacing:.04em}
.h-hero-h1{margin:20px 0 16px;font-size:clamp(36px,5vw,62px);line-height:1.05;color:#fff;font-weight:800}
.h-orange{color:#f97316}
.h-hero-sub{font-size:17px;line-height:1.7;color:#9ca3af;max-width:580px}
.h-cta-row{display:flex;gap:12px;flex-wrap:wrap;margin-top:28px}
.h-btn{display:inline-flex;align-items:center;padding:13px 26px;border-radius:10px;text-decoration:none;font-weight:700;font-size:15px;transition:all .15s}
.h-btn-orange{background:#f97316;color:#fff;box-shadow:0 4px 20px rgba(249,115,22,.35)}
.h-btn-orange:hover{background:#ea580c;transform:translateY(-1px)}
.h-btn-ghost{border:1.5px solid rgba(255,255,255,.2);color:#e5e7eb}
.h-btn-ghost:hover{border-color:rgba(255,255,255,.5);background:rgba(255,255,255,.05)}
.h-stats{display:flex;align-items:center;gap:20px;margin-top:36px;padding-top:28px;border-top:1px solid rgba(255,255,255,.1)}
.h-stat strong{display:block;font-size:22px;font-weight:800;color:#fff}
.h-stat span{font-size:12px;color:#6b7280;margin-top:2px;display:block}
.h-stat-div{width:1px;height:36px;background:rgba(255,255,255,.1)}

/* Hero right image column */
.h-hero-img-wrap{display:flex;align-items:center;justify-content:center}
.h-hero-img-frame{position:relative;border-radius:20px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.6);width:100%}
.h-hero-img{width:100%;height:420px;object-fit:cover;display:block}
.h-img-badge{position:absolute;bottom:16px;left:16px;right:16px;background:rgba(17,24,39,.88);backdrop-filter:blur(10px);border:1px solid rgba(249,115,22,.35);border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:12px}
.h-img-badge-icon{font-size:24px;flex-shrink:0}
.h-img-badge-top{font-size:10px;font-weight:700;color:#f97316;text-transform:uppercase;letter-spacing:.08em;margin-bottom:3px}
.h-img-badge-bot{font-size:13px;color:#f9fafb;font-weight:600}

/* ── Strip ─────────────────────────────────── */
.h-strip{background:#f97316;padding:14px 0;overflow:hidden}
.h-strip-track{display:flex;gap:32px;white-space:nowrap;animation:strip-scroll 22s linear infinite}
.h-strip-track span{font-size:13px;font-weight:700;color:#fff;letter-spacing:.04em;text-transform:uppercase}
.h-dot{color:rgba(255,255,255,.6)}
@keyframes strip-scroll{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}

/* ── Section helpers ─────────────────────── */
.h-section-head{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:36px;flex-wrap:wrap;gap:12px}
.h-center .h-section-head{justify-content:center;text-align:center}
.h-section-label{font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#f97316;margin-bottom:6px}
.h-section-h2{font-size:clamp(24px,3.5vw,36px);font-weight:800;color:#111827;line-height:1.15}
.h-link-arrow{font-size:14px;font-weight:700;color:#f97316;text-decoration:none;white-space:nowrap}
.h-link-arrow:hover{color:#ea580c}

/* ── Categories ──────────────────────────── */
.h-cats-section{padding:72px 0}
.h-cats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.h-cat{display:flex;flex-direction:column;border-radius:20px;padding:28px 24px;text-decoration:none;transition:transform .2s,box-shadow .2s;color:#fff}
.h-cat:hover{transform:translateY(-5px);box-shadow:0 20px 40px rgba(0,0,0,.2)}
.h-cat-blue{background:linear-gradient(145deg,#1d4ed8,#1e40af)}
.h-cat-pink{background:linear-gradient(145deg,#db2777,#9333ea)}
.h-cat-green{background:linear-gradient(145deg,#16a34a,#0d9488)}
.h-cat-purple{background:linear-gradient(145deg,#7c3aed,#4f46e5)}
.h-cat-icon{font-size:36px;margin-bottom:14px}
.h-cat h3{font-size:18px;font-weight:700;margin-bottom:10px}
.h-cat p{font-size:13.5px;line-height:1.6;opacity:.85;flex:1;margin-bottom:16px}
.h-cat-cta{font-size:13px;font-weight:700;opacity:.9}

/* ── How it works ─────────────────────────── */
.h-how-section{padding:72px 0;background:#111827}
.h-how-section .h-section-label{color:#fb923c}
.h-how-section .h-section-h2{color:#fff}
.h-steps{display:flex;align-items:center;gap:0;margin-top:48px}
.h-step{flex:1;background:#1f2937;border:1px solid #374151;border-radius:18px;padding:32px 28px;text-align:center}
.h-step-num{font-size:44px;font-weight:900;color:#f97316;opacity:.7;line-height:1;margin-bottom:16px}
.h-step h4{font-size:18px;font-weight:700;color:#f9fafb;margin-bottom:10px}
.h-step p{font-size:14px;color:#9ca3af;line-height:1.65}
.h-step-arrow{font-size:28px;color:#374151;flex-shrink:0;padding:0 12px}

/* ── Blog CTA ─────────────────────────────── */
.h-blog-cta-section{padding:72px 0;background:#f9fafb}
.h-blog-cta-inner{background:#111827;border-radius:24px;padding:56px 48px;display:flex;justify-content:space-between;align-items:center;gap:40px;overflow:hidden;position:relative}
.h-blog-cta-inner::before{content:'';position:absolute;top:-60px;right:-60px;width:280px;height:280px;background:radial-gradient(circle,rgba(249,115,22,.15),transparent 70%);pointer-events:none}
.h-blog-cta-text{flex:1;min-width:0}
.h-blog-cta-deco{display:flex;flex-direction:column;gap:12px;flex-shrink:0}
.h-deco-card{background:#1f2937;border:1px solid #374151;border-radius:12px;padding:14px 20px;font-size:14px;color:#e5e7eb;white-space:nowrap;transition:border-color .15s}
.h-deco-card:hover{border-color:#f97316;color:#fff}

/* ── Responsive ──────────────────────────── */
@media(max-width:1100px){.h-cats-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){
  .h-hero-inner{grid-template-columns:1fr}
  .h-hero-img-wrap{display:none}
  .h-steps{flex-direction:column}
  .h-step-arrow{transform:rotate(90deg)}
  .h-blog-cta-inner{flex-direction:column;padding:36px 28px}
  .h-blog-cta-deco{flex-direction:row;flex-wrap:wrap}
}
@media(max-width:640px){.h-cats-grid{grid-template-columns:1fr}}
CSS;
    }

    private static function defaultAboutHtml(): string
    {
        return <<<'HTML'
<div class="ab-wrap">

  <!-- ── HERO ─────────────────────────────────────────── -->
  <section class="ab-hero">
    <div class="ab-con">
      <div class="ab-hero-inner">
        <div class="ab-hero-text">
          <span class="ab-kicker">✦ Our Story</span>
          <h1 class="ab-hero-h1">Voices That<br><span class="ab-orange">Journey</span> With You</h1>
          <p class="ab-hero-sub">Your Journey Voices was born from a simple belief — that the right story, heard at the right moment, can change everything.</p>
          <a href="/products" class="ab-btn ab-btn-orange">Explore Our Library →</a>
        </div>
        <div class="ab-hero-deco">
          <div class="ab-quote-card">
            <p class="ab-quote">"Faith comes by hearing, and hearing by the Word of God."</p>
            <span class="ab-quote-ref">Romans 10:17</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ── MISSION / VISION / VALUES ────────────────────── -->
  <section class="ab-pillars-section">
    <div class="ab-con">
      <div class="ab-section-head">
        <p class="ab-label">What Drives Us</p>
        <h2 class="ab-section-h2">Built on Purpose, Rooted in Faith</h2>
      </div>
      <div class="ab-pillars">
        <div class="ab-pillar ab-pillar-orange">
          <div class="ab-pillar-icon">🎯</div>
          <h3>Our Mission</h3>
          <p>To provide transformative digital content that strengthens faith, encourages families, and supports personal growth through every season of life.</p>
        </div>
        <div class="ab-pillar ab-pillar-dark">
          <div class="ab-pillar-icon">🔭</div>
          <h3>Our Vision</h3>
          <p>To become the most trusted faith-based digital library — a place where every listener discovers wisdom, hope, and clear direction for their journey.</p>
        </div>
        <div class="ab-pillar ab-pillar-dark">
          <div class="ab-pillar-icon">💎</div>
          <h3>What We Value</h3>
          <ul class="ab-value-list">
            <li>Faith-centered content with practical daily value</li>
            <li>Resources for every age and stage of life</li>
            <li>Excellence, consistency, and community impact</li>
            <li>Uplifting voices that travel with you everywhere</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ── STATS ──────────────────────────────────────────── -->
  <section class="ab-stats-section">
    <div class="ab-con">
      <div class="ab-stats-grid">
        <div class="ab-stat-item">
          <span class="ab-stat-num">500+</span>
          <span class="ab-stat-label">Digital Resources</span>
        </div>
        <div class="ab-stat-div"></div>
        <div class="ab-stat-item">
          <span class="ab-stat-num">10k+</span>
          <span class="ab-stat-label">Lives Inspired</span>
        </div>
        <div class="ab-stat-div"></div>
        <div class="ab-stat-item">
          <span class="ab-stat-num">4</span>
          <span class="ab-stat-label">Content Categories</span>
        </div>
        <div class="ab-stat-div"></div>
        <div class="ab-stat-item">
          <span class="ab-stat-num">4.9★</span>
          <span class="ab-stat-label">Average Rating</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ── WHAT WE OFFER ─────────────────────────────────── -->
  <section class="ab-offer-section">
    <div class="ab-con">
      <div class="ab-section-head">
        <p class="ab-label">Our Content</p>
        <h2 class="ab-section-h2">Something for Every Part of Your Journey</h2>
      </div>
      <div class="ab-offer-grid">
        <div class="ab-offer-card">
          <span class="ab-offer-emoji">✝️</span>
          <h4>Christian Audiobooks</h4>
          <p>Powerful biblical teachings, devotionals, and sermons to deepen your faith walk.</p>
        </div>
        <div class="ab-offer-card">
          <span class="ab-offer-emoji">🌙</span>
          <h4>Children's Stories</h4>
          <p>Bedtime stories and Bible adventures that inspire the next generation to love God.</p>
        </div>
        <div class="ab-offer-card">
          <span class="ab-offer-emoji">🚗</span>
          <h4>Commuter Picks</h4>
          <p>Uplifting content crafted to make your drive, commute, or walk time truly count.</p>
        </div>
        <div class="ab-offer-card">
          <span class="ab-offer-emoji">🌱</span>
          <h4>Inspiration &amp; Health</h4>
          <p>Mind, body, and spirit content to help you live well and walk in wholeness daily.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ── CTA ───────────────────────────────────────────── -->
  <section class="ab-cta-section">
    <div class="ab-con">
      <div class="ab-cta-inner">
        <div>
          <h2>Ready to Start Your Journey?</h2>
          <p>Thousands of listeners have already found their voice. Now it's your turn.</p>
        </div>
        <div class="ab-cta-btns">
          <a href="/products" class="ab-btn ab-btn-orange">Browse Library</a>
          <a href="/contact" class="ab-btn ab-btn-ghost">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

</div>
HTML;
    }

    private static function defaultAboutCss(): string
    {
        return <<<'CSS'
/* ── Base ─────────────────────────────────── */
.ab-wrap{font-family:Inter,system-ui,-apple-system,sans-serif;color:#111827;background:#f9fafb}
.ab-con{width:min(1200px,94%);margin:0 auto}
*{box-sizing:border-box}

/* ── Hero ─────────────────────────────────── */
.ab-hero{background:#111827;padding:72px 0 80px}
.ab-hero-inner{display:grid;grid-template-columns:1fr 380px;gap:48px;align-items:center}
.ab-kicker{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;background:rgba(249,115,22,.15);border:1px solid rgba(249,115,22,.3);border-radius:999px;color:#fb923c;font-size:13px;font-weight:600;letter-spacing:.04em}
.ab-hero-h1{margin:20px 0 16px;font-size:clamp(36px,5vw,58px);line-height:1.05;color:#fff;font-weight:800}
.ab-orange{color:#f97316}
.ab-hero-sub{font-size:17px;line-height:1.7;color:#9ca3af;max-width:560px;margin-bottom:28px}
.ab-btn{display:inline-flex;align-items:center;padding:13px 26px;border-radius:10px;text-decoration:none;font-weight:700;font-size:15px;transition:all .15s}
.ab-btn-orange{background:#f97316;color:#fff;box-shadow:0 4px 20px rgba(249,115,22,.35)}
.ab-btn-orange:hover{background:#ea580c;transform:translateY(-1px)}
.ab-btn-ghost{border:1.5px solid #374151;color:#e5e7eb;background:transparent}
.ab-btn-ghost:hover{border-color:#f97316;color:#fff}

.ab-hero-deco{display:flex;justify-content:center}
.ab-quote-card{background:#1f2937;border:1px solid #374151;border-left:4px solid #f97316;border-radius:16px;padding:32px 28px;position:relative}
.ab-quote{font-size:18px;font-style:italic;color:#e5e7eb;line-height:1.6;margin-bottom:14px}
.ab-quote-ref{font-size:13px;font-weight:700;color:#f97316;letter-spacing:.05em}

/* ── Pillars ──────────────────────────────── */
.ab-pillars-section{padding:72px 0;background:#f9fafb}
.ab-section-head{text-align:center;margin-bottom:40px}
.ab-label{font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#f97316;margin-bottom:8px}
.ab-section-h2{font-size:clamp(24px,3.5vw,38px);font-weight:800;color:#111827;line-height:1.15}
.ab-pillars{display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px}
.ab-pillar{border-radius:20px;padding:36px 28px}
.ab-pillar-orange{background:#f97316;color:#fff}
.ab-pillar-dark{background:#111827;color:#fff}
.ab-pillar-icon{font-size:36px;margin-bottom:16px}
.ab-pillar h3{font-size:22px;font-weight:700;margin-bottom:12px}
.ab-pillar p{font-size:15px;line-height:1.65;opacity:.85}
.ab-value-list{padding-left:18px;opacity:.85}
.ab-value-list li{font-size:14px;line-height:1.8}

/* ── Stats ────────────────────────────────── */
.ab-stats-section{background:#f97316;padding:36px 0}
.ab-stats-grid{display:flex;justify-content:center;align-items:center;gap:0;flex-wrap:wrap}
.ab-stat-item{flex:1;text-align:center;padding:12px 20px}
.ab-stat-num{display:block;font-size:clamp(28px,4vw,44px);font-weight:900;color:#fff;line-height:1}
.ab-stat-label{display:block;font-size:13px;color:rgba(255,255,255,.8);margin-top:4px;font-weight:600}
.ab-stat-div{width:1px;height:56px;background:rgba(255,255,255,.25)}

/* ── Offer ────────────────────────────────── */
.ab-offer-section{padding:72px 0;background:#111827}
.ab-offer-section .ab-label{color:#fb923c}
.ab-offer-section .ab-section-h2{color:#fff}
.ab-offer-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-top:40px}
.ab-offer-card{background:#1f2937;border:1px solid #374151;border-radius:18px;padding:28px 22px;transition:border-color .2s,transform .2s}
.ab-offer-card:hover{border-color:#f97316;transform:translateY(-4px)}
.ab-offer-emoji{font-size:32px;display:block;margin-bottom:14px}
.ab-offer-card h4{font-size:17px;font-weight:700;color:#f9fafb;margin-bottom:10px}
.ab-offer-card p{font-size:14px;color:#9ca3af;line-height:1.65}

/* ── CTA ──────────────────────────────────── */
.ab-cta-section{padding:72px 0;background:#f9fafb}
.ab-cta-inner{background:#111827;border-radius:24px;padding:56px 48px;display:flex;justify-content:space-between;align-items:center;gap:32px;position:relative;overflow:hidden}
.ab-cta-inner::before{content:'';position:absolute;top:-80px;right:-80px;width:300px;height:300px;background:radial-gradient(circle,rgba(249,115,22,.15),transparent 70%);pointer-events:none}
.ab-cta-inner h2{font-size:clamp(24px,3.5vw,36px);font-weight:800;color:#fff;margin-bottom:10px}
.ab-cta-inner p{font-size:16px;color:#9ca3af;line-height:1.6}
.ab-cta-btns{display:flex;gap:12px;flex-shrink:0;flex-wrap:wrap}

/* ── Responsive ──────────────────────────── */
@media(max-width:1000px){.ab-offer-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){
  .ab-hero-inner{grid-template-columns:1fr}
  .ab-hero-deco{display:none}
  .ab-pillars{grid-template-columns:1fr}
  .ab-stats-grid{flex-wrap:wrap}
  .ab-stat-div{display:none}
  .ab-cta-inner{flex-direction:column;align-items:flex-start;padding:36px 28px}
}
@media(max-width:640px){.ab-offer-grid{grid-template-columns:1fr}}
CSS;
    }

    public static function defaultCreatePageHtml(): string
    {
        return <<<'HTML'
<div class="pg-wrap">

  <section class="pg-hero">
    <div class="pg-con pg-hero-inner">
      <div class="pg-hero-text">
        <span class="pg-kicker">✦ Page Tagline</span>
        <h1 class="pg-hero-h1">Your Page<br><span class="pg-orange">Headline Here</span></h1>
        <p class="pg-hero-sub">Write a short description of this page — what it is about and why the visitor should keep reading.</p>
        <div class="pg-cta-row">
          <a class="pg-btn pg-btn-orange" href="#">Primary Action →</a>
          <a class="pg-btn pg-btn-ghost" href="#">Learn More</a>
        </div>
      </div>
      <div class="pg-hero-img-wrap">
        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=640&q=80&auto=format&fit=crop" alt="Page image" class="pg-hero-img">
        <div class="pg-img-badge">
          <span class="pg-img-badge-icon">📖</span>
          <div>
            <p class="pg-img-badge-top">Featured</p>
            <p class="pg-img-badge-bot">Replace this with your featured content</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="pg-intro">
    <div class="pg-con pg-intro-inner">
      <p class="pg-label">About This Page</p>
      <h2 class="pg-section-h2">Section Heading Goes Here</h2>
      <p class="pg-intro-p">This is your intro paragraph. Give visitors a quick overview of what this page is about in two to three sentences.</p>
    </div>
  </section>

  <section class="pg-features">
    <div class="pg-con pg-features-grid">
      <div class="pg-feature pg-feature-light">
        <div class="pg-feature-icon">🎯</div>
        <h3>Feature One</h3>
        <p>Describe this feature or benefit clearly in one to two short sentences.</p>
        <a href="#" class="pg-feature-link">Learn more →</a>
      </div>
      <div class="pg-feature pg-feature-dark">
        <div class="pg-feature-icon">🔥</div>
        <h3>Feature Two</h3>
        <p>Describe this feature or benefit clearly in one to two short sentences.</p>
        <a href="#" class="pg-feature-link">Learn more →</a>
      </div>
      <div class="pg-feature pg-feature-light">
        <div class="pg-feature-icon">💡</div>
        <h3>Feature Three</h3>
        <p>Describe this feature or benefit clearly in one to two short sentences.</p>
        <a href="#" class="pg-feature-link">Learn more →</a>
      </div>
    </div>
  </section>

  <section class="pg-split">
    <div class="pg-con pg-split-inner">
      <div class="pg-split-img-wrap">
        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=640&q=80&auto=format&fit=crop" alt="Section image" class="pg-split-img">
      </div>
      <div class="pg-split-text">
        <p class="pg-label">Details</p>
        <h2 class="pg-section-h2">Why This Matters to You</h2>
        <p class="pg-split-p">Add your supporting copy here. Explain the value, tell a story, or list the reasons why the visitor should take action.</p>
        <ul class="pg-checklist">
          <li><span>✓</span> First key point or benefit</li>
          <li><span>✓</span> Second key point or benefit</li>
          <li><span>✓</span> Third key point or benefit</li>
        </ul>
        <a class="pg-btn pg-btn-orange" href="#">Get Started →</a>
      </div>
    </div>
  </section>

  <section class="pg-cta-section">
    <div class="pg-con">
      <div class="pg-cta-inner">
        <div>
          <h2 class="pg-cta-h2">Ready to Take the Next Step?</h2>
          <p class="pg-cta-p">Add a short sentence here that motivates the visitor to act. Keep it direct and benefit-focused.</p>
        </div>
        <div class="pg-cta-btns">
          <a class="pg-btn pg-btn-orange" href="#">Main Action</a>
          <a class="pg-btn pg-btn-ghost" href="/contact">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

</div>
HTML;
    }

    public static function defaultCreatePageCss(): string
    {
        return <<<'CSS'
.pg-wrap{font-family:Inter,system-ui,-apple-system,sans-serif;color:#111827;background:#fff}
.pg-con{width:min(1120px,92%);margin:0 auto}
*{box-sizing:border-box}

.pg-hero{background:#111827;padding:80px 0}
.pg-hero-inner{display:grid;grid-template-columns:1fr 400px;gap:48px;align-items:center}
.pg-kicker{display:inline-block;padding:7px 14px;background:rgba(249,115,22,.18);border:1px solid rgba(249,115,22,.4);border-radius:999px;color:#fb923c;font-size:13px;font-weight:700;letter-spacing:.04em}
.pg-hero-h1{margin:20px 0 16px;font-size:clamp(36px,5vw,52px);line-height:1.05;color:#fff;font-weight:900}
.pg-orange{color:#f97316}
.pg-hero-sub{font-size:17px;line-height:1.7;color:#9ca3af;max-width:520px;margin:0 0 28px}
.pg-cta-row{display:flex;gap:12px;flex-wrap:wrap}
.pg-btn{display:inline-flex;align-items:center;padding:13px 26px;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;white-space:nowrap}
.pg-btn-orange{background:#f97316;color:#fff}
.pg-btn-ghost{border:1.5px solid rgba(255,255,255,.25);color:#e5e7eb}

.pg-hero-img-wrap{position:relative;border-radius:18px;overflow:hidden;box-shadow:0 24px 56px rgba(0,0,0,.5)}
.pg-hero-img{width:100%;height:380px;object-fit:cover;display:block}
.pg-img-badge{position:absolute;bottom:14px;left:14px;right:14px;background:rgba(17,24,39,.85);backdrop-filter:blur(8px);border:1px solid rgba(249,115,22,.3);border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:12px}
.pg-img-badge-icon{font-size:22px}
.pg-img-badge-top{font-size:10px;font-weight:700;color:#f97316;text-transform:uppercase;letter-spacing:.08em;margin:0 0 3px}
.pg-img-badge-bot{font-size:13px;color:#f9fafb;font-weight:600;margin:0}

.pg-intro{padding:72px 0;background:#fff}
.pg-intro-inner{width:min(760px,92%);text-align:center}
.pg-label{font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#f97316;margin:0 0 10px}
.pg-section-h2{font-size:clamp(28px,4vw,36px);font-weight:800;color:#111827;line-height:1.15;margin:0 0 16px}
.pg-intro-p{font-size:17px;color:#6b7280;line-height:1.75;margin:0}

.pg-features{padding:0 0 72px;background:#fff}
.pg-features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.pg-feature{border-radius:16px;padding:28px}
.pg-feature-light{background:#f9fafb;border:1px solid #e5e7eb;box-shadow:0 4px 16px rgba(0,0,0,.05)}
.pg-feature-dark{background:#111827}
.pg-feature-icon{font-size:36px;margin-bottom:14px}
.pg-feature h3{font-size:20px;font-weight:700;margin:0 0 10px}
.pg-feature-light h3{color:#111827}
.pg-feature-dark h3{color:#fff}
.pg-feature p{font-size:14px;line-height:1.65;margin:0 0 16px}
.pg-feature-light p{color:#6b7280}
.pg-feature-dark p{color:#9ca3af}
.pg-feature-link{font-size:13px;font-weight:700;color:#f97316;text-decoration:none}

.pg-split{padding:72px 0;background:#f9fafb}
.pg-split-inner{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center}
.pg-split-img-wrap{border-radius:18px;overflow:hidden;box-shadow:0 16px 48px rgba(0,0,0,.1)}
.pg-split-img{width:100%;height:380px;object-fit:cover;display:block}
.pg-split-p{font-size:16px;color:#6b7280;line-height:1.7;margin:0 0 22px}
.pg-checklist{list-style:none;padding:0;margin:0 0 28px;display:flex;flex-direction:column;gap:10px}
.pg-checklist li{display:flex;align-items:center;gap:10px;font-size:15px;color:#374151}
.pg-checklist li span{color:#f97316;font-weight:900;font-size:16px}

.pg-cta-section{padding:64px 0;background:#f9fafb}
.pg-cta-inner{background:#111827;border-radius:22px;padding:52px 48px;display:flex;justify-content:space-between;align-items:center;gap:32px;position:relative;overflow:hidden}
.pg-cta-inner::before{content:'';position:absolute;top:-80px;right:-80px;width:300px;height:300px;background:radial-gradient(circle,rgba(249,115,22,.18),transparent 70%);pointer-events:none}
.pg-cta-h2{font-size:clamp(26px,3.5vw,36px);font-weight:800;color:#fff;line-height:1.1;margin:0 0 12px}
.pg-cta-p{font-size:16px;color:#9ca3af;line-height:1.6;max-width:520px;margin:0}
.pg-cta-btns{display:flex;gap:12px;flex-shrink:0;flex-wrap:wrap}
.pg-cta-btns .pg-btn-ghost{border-color:#374151}

@media(max-width:900px){
  .pg-hero-inner,.pg-split-inner{grid-template-columns:1fr}
  .pg-features-grid{grid-template-columns:1fr}
  .pg-cta-inner{flex-direction:column;align-items:flex-start;padding:36px 28px}
}
CSS;
    }
}
