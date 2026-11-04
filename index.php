<?php
require_once __DIR__ . '/includes/functions.php';
$use3d = true;
$seo = [
  'title' => 'Best Physiatrist in ' . cfg('city') . ' | Back Pain, Stroke & Sports Rehab - ' . cfg('doctor'),
  'desc'  => cfg('doctor') . ' is a trusted physiatrist (PM&R specialist) in ' . cfg('city') . ' treating back pain, neck pain, sciatica, stroke, sports injuries and nerve pain without surgery. Book online today.',
  'keywords' => 'physiatrist in ' . cfg('city') . ', physical medicine and rehabilitation, back pain specialist, stroke rehabilitation, pain management doctor',
  'path' => '',
  'schema' => [faq_schema(array_slice($CONTENT['faqs'], 0, 6))],
];
include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <canvas id="hero3d" aria-hidden="true"></canvas>
  <div class="wrap hero-in">
    <div class="hero-txt reveal">
      <span class="pill"><?= icon('shield',16) ?> Board-Certified PM&amp;R Specialist</span>
      <h1>Move Better. <span class="grad">Live Pain-Free.</span><br>Expert Physiatrist in <?= e(cfg('city')) ?></h1>
      <p>Advanced non-surgical treatment for back &amp; neck pain, sciatica, stroke recovery, sports injuries and nerve disorders by <b><?= e(cfg('doctor')) ?></b>.</p>
      <div class="cta">
        <a class="btn" href="<?= e(url('book')) ?>"><?= icon('calendar',18) ?> Book Appointment</a>
        <a class="btn btn-ghost" href="<?= e(wa_link('Hello Doctor, I need a consultation.')) ?>" target="_blank" rel="noopener"><?= icon('wa',18) ?> WhatsApp Us</a>
      </div>
      <ul class="trust">
        <li><b><?= (int)cfg('experience') ?>+</b> Years Experience</li>
        <li><b><?= e(cfg('patients')) ?></b> Patients Treated</li>
        <li><b>4.9</b> <?= icon('star',14) ?> Patient Rating</li>
      </ul>
    </div>
    <div class="hero-card">
      <img src="<?= e(photo("hero", "hero-exam.svg")) ?>" alt="<?= e(cfg("doctor")) ?> examining a patient's spine" width="560" height="520" fetchpriority="high">
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
    <h2>A Physiatrist Who Treats the Cause, Not Just the Pain</h2>
    <p><?= e(cfg('doctor')) ?> (<?= e(cfg('qualification')) ?>) has helped more than <?= e(cfg('patients')) ?> patients regain movement and return to the life they love. Every plan begins with an accurate diagnosis and is explained in simple language.</p>
    <ul class="ticks">
      <li><?= icon('check',18) ?> Detailed diagnosis with ultrasound &amp; EMG/NCV</li>
      <li><?= icon('check',18) ?> Personalised, goal-based rehabilitation</li>
      <li><?= icon('check',18) ?> Minimal medication, maximum function</li>
      <li><?= icon('check',18) ?> Clear costs and honest advice on surgery</li>
    </ul>
    <a class="btn btn-outline" href="<?= e(url('about')) ?>">Read full profile <?= icon('arrow',16) ?></a>
  </div>
</div></section>

<section class="sec alt"><div class="wrap">
  <div class="sec-h reveal"><span class="eyebrow">Our Services</span><h2>Comprehensive Physical Medicine &amp; Rehabilitation</h2>
  <p>From acute injuries to long-term neurological recovery, you get a complete plan under one roof.</p></div>
  <div class="grid cards">
    <?php foreach ($SERVICES as $slug => $s): ?>
    <a class="card tilt reveal" href="<?= e(url('services/'.$slug)) ?>">
      <span class="card-ico"><?= icon($s['icon'],30) ?></span>
      <h3><?= e($s['title']) ?></h3>
      <p><?= e($s['short']) ?></p>
      <span class="more">Learn more <?= icon('arrow',16) ?></span>
    </a>
    <?php endforeach; ?>
  </div>
</div></section>

<section class="sec"><div class="wrap">
  <div class="sec-h reveal"><span class="eyebrow">How It Works</span><h2>Your Recovery in 4 Simple Steps</h2></div>
  <div class="grid steps">
    <?php foreach ([['Book Online','Choose a date and time. Instant confirmation by email &amp; WhatsApp.'],['Assessment','Detailed examination and, only if needed, targeted tests.'],['Personal Plan','A clear treatment plan with realistic timelines.'],['Recovery','Guided therapy, follow-ups and a prevention program.']] as $i => $st): ?>
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
  <div class="sec-h reveal"><span class="eyebrow">Patient Stories</span><h2>Trusted by Patients Across <?= e(cfg('city')) ?></h2></div>
  <div class="grid t3">
    <?php foreach ($CONTENT['testimonials'] as $t): ?>
    <figure class="testi tilt reveal">
      <div class="stars"><?= str_repeat(icon('star',16), 5) ?></div>
      <blockquote>&ldquo;<?= e($t[2]) ?>&rdquo;</blockquote>
      <figcaption><b><?= e($t[0]) ?></b><small><?= e($t[1]) ?></small></figcaption>
    </figure>
    <?php endforeach; ?>
  </div>
</div></section>

<section class="sec alt"><div class="wrap two">
  <div class="reveal">
    <span class="eyebrow">Latest Articles</span><h2>Health Tips from Your Physiatrist</h2>
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
