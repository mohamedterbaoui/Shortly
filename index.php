<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shortly – URL Shortener</title>
  <link rel="icon" href="assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

 <div class="bg-grid"></div>
  <canvas id="particles-canvas"></canvas>

  <main class="hero">

    <div class="logo">
      <span class="logo-dot"></span>Shortly
    </div>

    <div class="hero-content">
      <div class="badge">
        <span class="badge-pulse"></span>
        links shortened every second
      </div>

      <h1 class="headline">
        Short links.<br>
        <em>Big impact.</em>
      </h1>

      <p class="subheadline">
        Paste a long URL and get a clean, shareable link in under a second.
      </p>

      <form id="urlForm" class="url-form">
        <div class="input-group">
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
              <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
            </svg>
          </span>
          <input
            type="text"
            name="long_url"
            placeholder="https://your-very-long-url-goes-here.com/..."
            required
            class="url-input"
            autocomplete="off"
          >
          <button type="submit" class="shorten-btn">
            <span class="btn-text">Shorten</span>
            <span class="btn-arrow">→</span>
          </button>
        </div>
      </form>

      <div id="result"></div>
    </div>

    <div class="stats-row">
      <div class="stat">
        <span class="stat-num">1k+</span>
        <span class="stat-label">Links shortened</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat">
        <span class="stat-num">99.9%</span>
        <span class="stat-label">Uptime</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat">
        <span class="stat-num">&lt;1s</span>
        <span class="stat-label">Processing time</span>
      </div>
    </div>

  </main>

  <script src="assets/js/app.js"></script>
  <script>
    (() => {
      const canvas = document.getElementById('particles-canvas');
      const ctx = canvas.getContext('2d');

      const COLORS = ['#e8ff47', '#633cff', '#1ec8b4', '#ffffff'];
      const COUNT  = 90;

      let W, H, particles;

      function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
      }

      function rand(min, max) { return Math.random() * (max - min) + min; }

      function createParticle() {
        const color = COLORS[Math.floor(Math.random() * COLORS.length)];
        return {
          x:       rand(0, W),
          y:       rand(0, H),
          r:       rand(0.8, 2.4),
          vx:      rand(-0.18, 0.18),
          vy:      rand(-0.22, 0.08),
          alpha:   rand(0.15, 0.55),
          dAlpha:  rand(0.001, 0.003) * (Math.random() < 0.5 ? 1 : -1),
          color,
        };
      }

      function drawConnections() {
        const MAX_DIST = 130;
        for (let i = 0; i < particles.length; i++) {
          for (let j = i + 1; j < particles.length; j++) {
            const a = particles[i], b = particles[j];
            const dx = a.x - b.x, dy = a.y - b.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < MAX_DIST) {
              const opacity = (1 - dist / MAX_DIST) * 0.12;
              ctx.beginPath();
              ctx.moveTo(a.x, a.y);
              ctx.lineTo(b.x, b.y);
              ctx.strokeStyle = `rgba(255,255,255,${opacity})`;
              ctx.lineWidth = 0.5;
              ctx.stroke();
            }
          }
        }
      }

      function tick() {
        ctx.clearRect(0, 0, W, H);

        drawConnections();

        for (const p of particles) {
          p.x += p.vx;
          p.y += p.vy;

          p.alpha += p.dAlpha;
          if (p.alpha > 0.55 || p.alpha < 0.1) p.dAlpha *= -1;

          if (p.x < -10) p.x = W + 10;
          if (p.x > W + 10) p.x = -10;
          if (p.y < -10) p.y = H + 10;
          if (p.y > H + 10) p.y = -10;

          ctx.save();
          ctx.globalAlpha = p.alpha;
          ctx.shadowColor = p.color;
          ctx.shadowBlur  = 6;
          ctx.fillStyle   = p.color;
          ctx.beginPath();
          ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
          ctx.fill();
          ctx.restore();
        }

        requestAnimationFrame(tick);
      }

      window.addEventListener('resize', resize);

      init();
      tick();

      function init() {
        resize();
        particles = Array.from({ length: COUNT }, createParticle);
      }
    })();
  </script>
</body>
</html>