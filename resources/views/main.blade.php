<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page['brand'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main/main.js'])
</head>
<body class="rn-body text-white">
    <nav class="navbar navbar-expand-lg fixed-top rn-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#hero">
                <span class="rn-logo">R</span>
                <div>
                    <div class="rn-brand">{{ $page['brand'] }}</div>
                    <small class="rn-brand-sub">review automation platform</small>
                </div>
            </a>

            <div class="navbar-collapse d-flex align-items-center justify-content-end" id="rnNav">
                <ul class="navbar-nav mx-auto gap-lg-3 flex-row flex-wrap justify-content-center">
                    <li class="nav-item"><a class="nav-link rn-nav-link" href="#why">Miért kevés az értékelés?</a></li>
                    <li class="nav-item"><a class="nav-link rn-nav-link" href="#how">Hogyan működik?</a></li>
                    <li class="nav-item"><a class="nav-link rn-nav-link" href="#features">Funkciók</a></li>
                    <li class="nav-item"><a class="nav-link rn-nav-link" href="#testimonials">Referenciák</a></li>
                    <li class="nav-item"><a class="nav-link rn-nav-link" href="#pricing">Árajánlat</a></li>
                </ul>
                <a href="#contact" class="btn rn-btn rn-btn-primary">Kapcsolat</a>
            </div>
        </div>
    </nav>

    <main>
        <section id="hero" class="rn-section rn-hero">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7 reveal">
                        <span class="rn-chip">ÚJ GENERÁCIÓS REVIEW MENEDZSMENT</span>
                        <h1 class="rn-title mt-3 mb-3">{{ $page['title'] }}</h1>
                        <p class="rn-subtitle mb-4">{{ $page['subtitle'] }}</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#how" class="btn rn-btn rn-btn-primary">{{ $page['cta_primary'] }}</a>
                            <a href="#features" class="btn rn-btn rn-btn-ghost">{{ $page['cta_secondary'] }}</a>
                        </div>
                    </div>

                    <div class="col-lg-5 reveal">
                        <div class="rn-panel">
                            <h2 class="h5 mb-3">Live Review Pulse</h2>
                            <div class="d-grid gap-3">
                                @foreach ($page['stats'] as $stat)
                                    <div class="rn-stat-card">
                                        <small class="text-secondary d-block">{{ $stat['label'] }}</small>
                                        <strong class="js-counter rn-counter" data-target="{{ preg_replace('/[^0-9]/', '', $stat['value']) ?: 0 }}">{{ $stat['value'] }}</strong>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="why" class="rn-section">
            <div class="container">
                <div class="text-center reveal mb-5">
                    <h2 class="rn-section-title">Miért kevés a friss értékelés?</h2>
                    <p class="rn-section-text">A legtöbb cég passzívan várja a véleményeket. A ReviewNinja aktívan tereli az ügyfelet értékelésre, majd a negatív visszajelzéseket belső csatornára irányítja.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4 reveal">
                        <article class="rn-card">
                            <div class="rn-icon">📉</div>
                            <h3>Inkonzisztens gyűjtés</h3>
                            <p>Nem automatikus a kérés, ezért kiszámíthatatlanul érkeznek új vélemények.</p>
                        </article>
                    </div>
                    <div class="col-md-4 reveal">
                        <article class="rn-card">
                            <div class="rn-icon">🕒</div>
                            <h3>Késői reakciók</h3>
                            <p>Az értékelésekre adott válasz késik, így csökken a bizalom és a konverzió.</p>
                        </article>
                    </div>
                    <div class="col-md-4 reveal">
                        <article class="rn-card">
                            <div class="rn-icon">🧩</div>
                            <h3>Széttagolt adatok</h3>
                            <p>Több felületen dolgozol párhuzamosan, így nincs egységes döntéstámogatás.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="how" class="rn-section rn-section-muted">
            <div class="container">
                <div class="text-center reveal mb-5">
                    <h2 class="rn-section-title">Hogyan működik?</h2>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4 reveal">
                        <div class="rn-step-card">
                            <span class="rn-step">01</span>
                            <h3>Kapcsolódás</h3>
                            <p>Google, Facebook és további csatornák bekötése percek alatt.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 reveal">
                        <div class="rn-step-card">
                            <span class="rn-step">02</span>
                            <h3>Automatizálás</h3>
                            <p>Okos review-kérések, szegmentált üzenetek, időzített utánkövetés.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 reveal">
                        <div class="rn-step-card">
                            <span class="rn-step">03</span>
                            <h3>Növekedés</h3>
                            <p>Gyors válasz, jobb reputáció, több kattintás és több vásárló.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="rn-section">
            <div class="container">
                <div class="text-center reveal mb-5">
                    <h2 class="rn-section-title">Funkciók, amik tényleg dolgoznak helyetted</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 reveal"><div class="rn-feature"><span>⚡</span><div><h4>Smart Request Flow</h4><p>Dinamikus sablonok és automatizált review-kérés több csatornán.</p></div></div></div>
                    <div class="col-md-6 reveal"><div class="rn-feature"><span>💬</span><div><h4>Válasz asszisztens</h4><p>Gyors, márkahű válaszajánlatok pozitív és negatív értékelésekhez.</p></div></div></div>
                    <div class="col-md-6 reveal"><div class="rn-feature"><span>📊</span><div><h4>Reputációs dashboard</h4><p>Trendek, score változás, csatorna szerinti bontás valós időben.</p></div></div></div>
                    <div class="col-md-6 reveal"><div class="rn-feature"><span>🔗</span><div><h4>Integrációk</h4><p>12+ platform és webhook/API támogatás enterprise workflow-hoz.</p></div></div></div>
                </div>
            </div>
        </section>

        <section id="testimonials" class="rn-section rn-section-muted">
            <div class="container">
                <div class="text-center reveal mb-5">
                    <h2 class="rn-section-title">Mit mondanak az ügyfelek?</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4 reveal"><blockquote class="rn-quote"><p>„90 nap alatt látványosan nőtt a Google profilunk aktivitása.”</p><footer>— Vendéglátás</footer></blockquote></div>
                    <div class="col-md-4 reveal"><blockquote class="rn-quote"><p>„A csapat napi ideje felszabadult, mégis gyorsabban válaszolunk.”</p><footer>— E-kereskedelem</footer></blockquote></div>
                    <div class="col-md-4 reveal"><blockquote class="rn-quote"><p>„Átláthatóbb lett a reputációnk, és nőtt a bizalom az ügyfelekben.”</p><footer>— Szolgáltató szektor</footer></blockquote></div>
                </div>
            </div>
        </section>

        <section id="pricing" class="rn-section">
            <div class="container">
                <div class="text-center reveal mb-5">
                    <h2 class="rn-section-title">Árazás</h2>
                </div>
                <div class="row g-4 align-items-stretch">
                    <div class="col-md-4 reveal">
                        <div class="rn-price-card">
                            <h3>Starter</h3>
                            <p class="rn-price">29 €<small>/hó</small></p>
                            <ul>
                                <li>2 csatorna</li>
                                <li>250 kérés / hó</li>
                                <li>Alap dashboard</li>
                            </ul>
                            <a href="#contact" class="btn rn-btn rn-btn-ghost w-100">Kezdés</a>
                        </div>
                    </div>
                    <div class="col-md-4 reveal">
                        <div class="rn-price-card rn-price-card-featured">
                            <span class="rn-badge">LEGNÉPSZERŰBB</span>
                            <h3>Growth</h3>
                            <p class="rn-price">79 €<small>/hó</small></p>
                            <ul>
                                <li>8 csatorna</li>
                                <li>Korlátlan kérés</li>
                                <li>AI válasz asszisztens</li>
                            </ul>
                            <a href="#contact" class="btn rn-btn rn-btn-primary w-100">Próba indítása</a>
                        </div>
                    </div>
                    <div class="col-md-4 reveal">
                        <div class="rn-price-card">
                            <h3>Scale</h3>
                            <p class="rn-price">Egyedi<small>/hó</small></p>
                            <ul>
                                <li>Korlatlan csatorna</li>
                                <li>Multi-location</li>
                                <li>API + dedikált support</li>
                            </ul>
                            <a href="#contact" class="btn rn-btn rn-btn-ghost w-100">Kérj ajánlatot</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="rn-section rn-contact">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6 reveal">
                        <h2 class="rn-section-title">Kezdjük el a növekedést</h2>
                        <p class="rn-section-text">30 perces demo során megmutatjuk, hogyan skálázd a reputációdat biztonságosan és mérhetően.</p>
                    </div>
                    <div class="col-lg-6 reveal">
                        <form class="rn-form" action="#" method="post" onsubmit="return false;">
                            <input class="form-control" type="text" placeholder="Név">
                            <input class="form-control" type="email" placeholder="Email">
                            <textarea class="form-control" rows="4" placeholder="Miben segíthetünk?"></textarea>
                            <button class="btn rn-btn rn-btn-primary w-100" type="submit">Demo kérése</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="rn-footer">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <small>© 2026 {{ $page['brand'] }}. Minden jog fenntartva.</small>
            <small>Built for modern reputation teams.</small>
        </div>
    </footer>
</body>
</html>
