<?php
require_once __DIR__ . '/includes/functions.php';
$use3d = true;
$seo = [
  'title' => 'Best Physiotherapist in ' . cfg('city') . ' | Back Pain, Dry Needling & Rehab - ' . cfg('doctor'),
  'desc'  => cfg('doctor') . ', Doctor of Physiotherapy (DPT), at ' . cfg('clinic_name') . ', ' . cfg('city') . '. Physiotherapy for back pain, neck pain, sciatica, stroke and sports injuries with dry needling, K-taping and hijama. Book online.',
  'keywords' => 'physiotherapist in ' . cfg('city') . ', physiotherapy ' . cfg('city') . ', DPT, dry needling, K-taping, hijama, back pain treatment, stroke rehabilitation',
  'path' => '',
  'schema' => [faq_schema(array_slice($CONTENT['faqs'], 0, 6))],
];
include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <canvas id="hero3d" aria-hidden="true"></canvas>
  <div class="wrap hero-in">
    <div class="hero-txt reveal">
      <span class="pill"><?= icon('shield',16) ?> Doctor of Physiotherapy (DPT)</span>
      <h1>Move Better. <span class="grad">Live Pain-Free.</span></h1>
      <p>Expert physiotherapy for back &amp; neck pain, sciatica, stroke recovery and sports injuries, with dry needling, K-taping and personalised exercise programs by <b><?= e(cfg('doctor')) ?></b>.</p>
      <div class="cta">
        <a class="btn" href="<?= e(url('book')) ?>"><?= icon('calendar',18) ?> Book Appointment</a>
        <a class="btn btn-ghost" href="<?= e(wa_link('Hello Doctor, I need a consultation.')) ?>" target="_blank" rel="noopener"><?= icon('wa',18) ?> WhatsApp Us</a>
      </div>
      <ul class="trust">
        <li><b>DPT</b> Doctor of Physiotherapy</li>
        <li><b><?= count(cfg('credentials')) - 1 ?></b> Professional Certifications</li>
        <li><b><?= count(cfg('experience_list')) ?></b> Hospital Internships</li>
      </ul>
    </div>
    <div class="hero-card">
      <img src="<?= e(photo("hero", "hero-exam.svg")) ?>" alt="Physiotherapist assessing a patient's back at <?= e(cfg("clinic_name")) ?>, <?= e(cfg("city")) ?>" width="560" height="520" fetchpriority="high">
    </div>
  </div>
</section>

<section class="strip"><div class="wrap strip-in">
  <?php foreach ([['spine','Back & Neck Pain'],['brain','Stroke Rehab'],['sport','Sports Injury'],['nerve','Nerve Disorders'],['knee','Joint & Arthritis']] as $i): ?>
    <span><?= icon($i[0],22) ?> <?= e($i[1]) ?></span>
  <?php endforeach; ?>
</div></section>

<section class="sec"><div class="wrap two">
  <div class="reveal about-img"><img src="<?= e(photo("clinic", "clinic.svg")) ?>" alt="Modern rehabilitation clinic in <?= e(cfg('city')) ?>" loading="lazy" width="520" height="420"></div>
  <div class="reveal">
    <span class="eyebrow">About the Doctor</span>
    <h2>A Physiotherapist Who Treats the Cause, Not Just the Pain</h2>
    <p><?= e(cfg('doctor')) ?> (<?= e(cfg('qualification')) ?>) is a clinical physiotherapist at <?= e(cfg('clinic_name')) ?>, <?= e(cfg('city')) ?>, with hospital training at South Punjab Hospital, Children Hospital and Barki Advanced Physiotherapy Complex. Every plan begins with a careful assessment and is explained in simple language.</p>
    <ul class="ticks">
      <li><?= icon('check',18) ?> Careful assessment of movement, posture and strength</li>
      <li><?= icon('check',18) ?> Personalised, goal-based rehabilitation</li>
      <li><?= icon('check',18) ?> Dry needling, K-taping and hijama by a certified practitioner</li>
      <li><?= icon('check',18) ?> Honest advice, with referral to a doctor when needed</li>
    </ul>
    <a class="btn btn-outline" href="<?= e(url('about')) ?>">Read full profile <?= icon('arrow',16) ?></a>
  </div>
</div></section>

<section class="sec alt" id="services-sec"><div class="wrap">
  <div class="sec-h wide reveal"><span class="eyebrow">Our Services</span><h2>Complete Physiotherapy &amp; Rehabilitation Care</h2>
  <p>From pain relief and injury recovery to dry needling, K-taping and fitness training, you get a complete plan under one roof.</p></div>
  <div class="slider reveal" id="svcSlider">
    <button type="button" class="sl-btn prev" aria-label="Previous services">&#8249;</button>
    <div class="sl-track">
      <?php foreach ($SERVICES as $slug => $s): ?>
      <?= str_replace(' tilt reveal', '', service_card($slug, $s)) ?>
      <?php endforeach; ?>
    </div>
    <button type="button" class="sl-btn next" aria-label="Next services">&#8250;</button>
  </div>
  <div class="sl-foot reveal">
    <div class="sl-bar" aria-hidden="true"><i id="slBar"></i></div>
    <span class="sl-count" aria-hidden="true"><b id="slNow">1</b> / <?= count($SERVICES) ?></span>
    <a class="btn btn-outline" href="<?= e(url('services')) ?>">View all services <?= icon('arrow',16) ?></a>
  </div>
</div></section>

<section class="sec"><div class="wrap">
  <div class="sec-h reveal"><span class="eyebrow">How It Works</span><h2>Your Recovery in 4 Simple Steps</h2></div>
  <div class="grid steps">
    <?php foreach ([['Book Online','Choose a date and time. Instant confirmation by email &amp; WhatsApp.'],['Assessment','Detailed physical assessment of your movement, posture and strength.'],['Personal Plan','A clear treatment plan with realistic timelines.'],['Recovery','Guided therapy, follow-ups and a prevention program.']] as $i => $st): ?>
    <div class="step reveal"><span class="num"><?= $i+1 ?></span><h3><?= $st[0] ?></h3><p><?= $st[1] ?></p></div>
    <?php endforeach; ?>
  </div>
</div></section>

<section class="sec dark"><div class="wrap">
  <div class="sec-h reveal"><span class="eyebrow">Conditions We Treat</span><h2>Find Relief From</h2></div>
  <div class="chips reveal">
    <?php foreach ($CONTENT['conditions'] as $c): ?><span><?= e($c) ?></span><?php endforeach; ?>
  </div>
</div></section>

<section class="sec"><div class="wrap">
  <div class="sec-h reveal"><span class="eyebrow">Qualifications &amp; Training</span><h2>Trained, Certified and Hospital-Experienced</h2></div>
  <div class="grid cred">
    <div class="cred-box reveal"><h3><?= icon('shield',22) ?> Qualifications &amp; Certifications</h3>
      <ul class="ticks"><?php foreach (cfg('credentials') as $x): ?><li><?= icon('check',18) ?> <?= e($x) ?></li><?php endforeach; ?></ul></div>
    <div class="cred-box reveal"><h3><?= icon('pin',22) ?> Hospital Experience</h3>
      <ul class="ticks"><?php foreach (cfg('experience_list') as $x): ?><li><?= icon('check',18) ?> <?= e($x) ?></li><?php endforeach; ?></ul></div>
  </div>
</div></section>

<section class="sec alt"><div class="wrap two">
  <div class="reveal">
    <span class="eyebrow">Latest Articles</span><h2>Health Tips from Your Physiotherapist</h2>
    <p>Practical, evidence-based guidance you can use today.</p>
    <a class="btn btn-outline" href="<?= e(url('blog')) ?>">All articles <?= icon('arrow',16) ?></a>
  </div>
  <div class="reveal list">
    <?php foreach (array_slice($CONTENT['articles'], 0, 3, true) as $slug => $a): ?>
      <a class="li" href="<?= e(url('blog/'.$slug)) ?>"><span class="card-ico sm"><?= icon($a['icon'],22) ?></span><span><b><?= e($a['title']) ?></b><small><?= e(date('M j, Y', strtotime($a['date']))) ?> &middot; <?= (int)$a['read'] ?> min read</small></span></a>
    <?php endforeach; ?>
  </div>
</div></section>

<section class="sec"><div class="wrap narrow">
  <div class="sec-h reveal"><span class="eyebrow">FAQ</span><h2>Frequently Asked Questions</h2></div>
  <?php foreach (array_slice($CONTENT['faqs'], 0, 5) as $f): ?>
  <details class="faq reveal"><summary><?= e($f[0]) ?></summary><p><?= e($f[1]) ?></p></details>
  <?php endforeach; ?>
</div></section>

<section class="cta-band"><div class="wrap reveal">
  <h2>Don't let pain limit your life</h2>
  <p>Book your consultation today and take the first step toward recovery.</p>
  <a class="btn btn-light" href="<?= e(url('book')) ?>">Book Appointment Now</a>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
