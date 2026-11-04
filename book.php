<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'Book Appointment Online | ' . cfg('doctor') . ', Physiotherapist in ' . cfg('city'),
  'desc'  => 'Book your physiotherapy appointment online in under a minute. Instant confirmation by email and WhatsApp.',
  'path'  => 'book',
  'schema'=> [breadcrumb_schema(['Home'=>'','Book Appointment'=>'book'])],
];
$pre = preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['service'] ?? ''));
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / Book Appointment</nav><h1>Book Your Appointment</h1><p>Instant confirmation &middot; Automatic reminder</p></div></section>
<section class="sec"><div class="wrap two">
  <form id="bookForm" class="form tilt-soft" novalidate>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
    <div class="row">
      <label>Full name *<input name="name" required maxlength="80" autocomplete="name"></label>
      <label>Phone / WhatsApp *<input name="phone" required maxlength="20" inputmode="tel" autocomplete="tel" placeholder="03xx xxxxxxx"></label>
    </div>
    <div class="row">
      <label>Email<input type="email" name="email" maxlength="120" autocomplete="email"></label>
      <label>Service
        <select name="service">
          <option value="General consultation">General consultation</option>
          <?php foreach ($SERVICES as $slug => $s): ?><option <?= $pre === $slug ? 'selected' : '' ?>><?= e($s['title']) ?></option><?php endforeach; ?>
        </select>
      </label>
    </div>
    <div class="row">
      <label>Date *<input type="date" name="date" id="bdate" required min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+60 days')) ?>"></label>
      <label>Time slot *<select name="time" id="btime" required><option value="">Select date first</option></select></label>
    </div>
    <label>Describe your problem (optional)<textarea name="message" rows="3" maxlength="500"></textarea></label>
    <button class="btn" type="submit" id="bbtn"><?= icon('calendar',18) ?> Confirm Appointment</button>
    <p class="form-msg" id="bmsg" role="status"></p>
  </form>
  <aside class="side">
    <div class="side-box"><h3>What happens next?</h3>
      <ul class="ticks"><li><?= icon('check',18) ?> Instant confirmation on screen</li><li><?= icon('check',18) ?> Email confirmation (if provided)</li><li><?= icon('check',18) ?> WhatsApp confirmation link</li><li><?= icon('check',18) ?> Reminder the day before</li></ul></div>
    <div class="side-box"><h3>Prefer to talk?</h3><p>Call <b><?= e(cfg('phone')) ?></b></p><a class="btn btn-outline" href="<?= e(wa_link('Hello Doctor, I need an appointment.')) ?>" target="_blank" rel="noopener">WhatsApp us</a></div>
  </aside>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
