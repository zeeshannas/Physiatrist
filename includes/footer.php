</main>
<footer class="site-footer">
  <div class="wrap">
    <div class="f-cta reveal">
      <div>
        <h3>🩺 Ready to start your recovery?</h3>
        <p>Book a consultation with <?= e(cfg('doctor')) ?> in <?= e(cfg('city')) ?> today. 💚</p>
      </div>
      <div class="f-cta-btns">
        <a class="btn btn-light" href="<?= e(url('book')) ?>">📅 Book Appointment</a>
        <a class="btn btn-ghost-w" href="tel:<?= e(preg_replace('/\s+/','',cfg('phone'))) ?>">📞 <?= e(cfg('phone')) ?></a>
      </div>
    </div>

    <div class="fgrid">
      <div class="f-col f-brand reveal">
        <a class="logo light" href="<?= e(url()) ?>"><span class="logo-mark"><?= icon('spine',26) ?></span><span><b><?= e(cfg('doctor')) ?></b><small>Physiatrist &middot; PM&amp;R</small></span></a>
        <p>🎓 <?= e(cfg('qualification')) ?>.<br>Evidence-based pain relief and rehabilitation in <?= e(cfg('city')) ?>.</p>
        <div class="soc">
          <?php foreach (cfg('social') as $n => $l): ?>
            <a href="<?= e($l) ?>" target="_blank" rel="noopener" aria-label="<?= e(ucfirst($n)) ?>"><?= icon($n,18) ?></a>
          <?php endforeach; ?>
          <a href="<?= e(wa_link('Hello Doctor')) ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?= icon('wa',18) ?></a>
        </div>
      </div>

      <div class="f-col reveal"><h4>🦴 Services</h4>
        <?php foreach (array_slice($SERVICES, 0, 6, true) as $slug => $s): ?>
          <a href="<?= e(url('services/'.$slug)) ?>"><?= e($s['title']) ?></a>
        <?php endforeach; ?>
      </div>

      <div class="f-col reveal"><h4>🔗 Quick Links</h4>
        <a href="<?= e(url('about')) ?>">About the Doctor</a>
        <a href="<?= e(url('services')) ?>">All Services</a>
        <a href="<?= e(url('blog')) ?>">Health Blog</a>
        <a href="<?= e(url('faq')) ?>">FAQ</a>
        <a href="<?= e(url('book')) ?>">Book Appointment</a>
        <a href="<?= e(url('contact')) ?>">Contact Us</a>
      </div>

      <div class="f-col reveal"><h4>🏥 Visit the Clinic</h4>
        <ul class="f-info">
          <li><span class="em">📍</span><span><?= e(cfg('clinic_name')) ?><br><?= e(cfg('address')) ?></span></li>
          <li><span class="em">📞</span><a href="tel:<?= e(preg_replace('/\s+/','',cfg('phone'))) ?>"><?= e(cfg('phone')) ?></a></li>
          <li><span class="em">✉️</span><a href="mailto:<?= e(cfg('email')) ?>"><?= e(cfg('email')) ?></a></li>
        </ul>
        <div class="f-hours">
          <b>🕒 Clinic Hours</b>
          <?php foreach (cfg('timings') as $d => $t): ?><div><span><?= e($d) ?></span><em><?= e($t) ?></em></div><?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="copy">
      <span>&copy; <?= date('Y') ?> <?= e(cfg('doctor')) ?>. All rights reserved. Made with 💙 in <?= e(cfg('city')) ?></span>
      <span class="disc">⚠️ Information on this site is educational and does not replace medical advice. In an emergency, go to the nearest hospital.</span>
    </div>
  </div>
</footer>

<button class="to-top" id="toTop" aria-label="Back to top"><?= icon('up',20) ?></button>

<!-- Floating actions -->
<a class="fab fab-wa" href="<?= e(wa_link('Hello Doctor, I would like to book an appointment.')) ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><?= icon('wa',28) ?></a>

<!-- Automated chat assistant -->
<button class="chat-toggle" id="chatToggle" aria-label="Open assistant"><?= icon('chat',26) ?></button>
<section class="chatbox" id="chatbox" aria-label="Virtual assistant" hidden>
  <div class="chat-h"><b>Clinic Assistant</b><small>Replies instantly &middot; 24/7</small><button id="chatClose" aria-label="Close">&times;</button></div>
  <div class="chat-b" id="chatBody"></div>
  <div class="chat-q" id="chatQuick"></div>
  <form class="chat-f" id="chatForm"><input id="chatInput" placeholder="Type your question..." autocomplete="off"><button aria-label="Send"><?= icon('send',18) ?></button></form>
</section>

<script>window.SITE={base:<?= json_encode(base_path()) ?>,csrf:<?= json_encode(csrf_token()) ?>,wa:<?= json_encode(cfg('whatsapp')) ?>};</script>
<script src="<?= e(asset('assets/js/app.js')) ?>" defer></script>
<?php if (!empty($use3d)): ?>
<script type="importmap">{"imports":{"three":"https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js"}}</script>
<script type="module" src="<?= e(asset('assets/js/hero3d.js')) ?>"></script>
<?php endif; ?>
</body>
</html>
