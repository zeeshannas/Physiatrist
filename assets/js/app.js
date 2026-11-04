(function () {
  'use strict';
  var B = (window.SITE && SITE.base) || '';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* header: shadow on scroll + mobile menu */
  var hdr = $('#hdr');
  addEventListener('scroll', function () { hdr && hdr.classList.toggle('sc', scrollY > 10); }, { passive: true });
  var burger = $('#burger'), nav = $('#nav');
  if (burger) burger.addEventListener('click', function () {
    var o = nav.classList.toggle('open'); burger.setAttribute('aria-expanded', o);
  });

  /* scroll reveal animation */
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: .12 });
    $$('.reveal').forEach(function (el, i) { el.style.transitionDelay = (i % 4) * 80 + 'ms'; io.observe(el); });
  } else { $$('.reveal').forEach(function (el) { el.classList.add('in'); }); }

  /* 3D card tilt (mouse devices only) */
  if (matchMedia('(hover:hover) and (pointer:fine)').matches && !matchMedia('(prefers-reduced-motion:reduce)').matches) {
    $$('.tilt').forEach(function (el) {
      el.addEventListener('mousemove', function (e) {
        var r = el.getBoundingClientRect(), x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
        el.style.transform = 'perspective(900px) rotateY(' + (x * 4) + 'deg) rotateX(' + (-y * 4) + 'deg)';
      });
      el.addEventListener('mouseleave', function () { el.style.transform = ''; });
    });
  }

  /* ---------- Booking form (automation) ---------- */
  var form = $('#bookForm');
  if (form) {
    var dateEl = $('#bdate'), timeEl = $('#btime'), msg = $('#bmsg'), btn = $('#bbtn');
    dateEl.addEventListener('change', function () {
      timeEl.innerHTML = '<option value="">Loading...</option>';
      fetch(B + '/api/slots.php?date=' + encodeURIComponent(dateEl.value)).then(function (r) { return r.json(); }).then(function (d) {
        if (!d.slots.length) { timeEl.innerHTML = '<option value="">' + (d.closed ? 'Clinic closed on this day' : 'No slots left today') + '</option>'; return; }
        timeEl.innerHTML = '<option value="">Select time</option>' + d.slots.map(function (s) {
          return '<option value="' + s.time + '"' + (s.free ? '' : ' disabled') + '>' + s.label + (s.free ? '' : ' (booked)') + '</option>';
        }).join('');
      }).catch(function () { timeEl.innerHTML = '<option value="">Could not load slots</option>'; });
    });
    form.addEventListener('submit', function (ev) {
      ev.preventDefault(); msg.className = 'form-msg'; msg.textContent = '';
      if (!form.checkValidity()) { form.reportValidity(); return; }
      btn.disabled = true; btn.style.opacity = .7;
      fetch(B + '/api/book.php', { method: 'POST', body: new FormData(form) })
        .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
        .then(function (x) {
          if (!x.ok || !x.j.ok) throw new Error(x.j.error || 'Something went wrong');
          var d = x.j, box = document.createElement('div'); box.className = 'success';
          box.innerHTML = '<h3>Appointment Confirmed!</h3><p>Booking ID: <b></b><br>' + '<span></span></p>' +
            '<a class="btn" target="_blank" rel="noopener" href="' + d.wa + '">Send confirmation on WhatsApp</a>' +
            '<a class="btn btn-outline" href="' + B + '/">Back to home</a>';
          box.querySelector('b').textContent = d.id; box.querySelector('span').textContent = d.when;
          form.replaceWith(box); scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(function (e) { msg.className = 'form-msg err'; msg.textContent = e.message; btn.disabled = false; btn.style.opacity = 1; });
    });
    if (dateEl.value) dateEl.dispatchEvent(new Event('change'));
  }

  /* ---------- Chat assistant (automation) ---------- */
  var cb = $('#chatbox'), body = $('#chatBody'), quick = $('#chatQuick'), cf = $('#chatForm'), ci = $('#chatInput');
  function esc(s) { return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }
  function add(t, who) {
    var d = document.createElement('div'); d.className = 'msg ' + who;
    d.innerHTML = esc(t).replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" rel="noopener">$1</a>').replace(/\n/g, '<br>');
    body.appendChild(d); body.scrollTop = body.scrollHeight;
  }
  function setQuick(a) {
    quick.innerHTML = '';
    (a || []).forEach(function (q) {
      var b = document.createElement('button'); b.type = 'button'; b.textContent = q;
      b.onclick = function () { ask(q); }; quick.appendChild(b);
    });
  }
  function ask(q) {
    add(q, 'me'); setQuick([]);
    var fd = new FormData(); fd.append('q', q);
    fetch(B + '/api/chat.php', { method: 'POST', body: fd }).then(function (r) { return r.json(); })
      .then(function (d) { setTimeout(function () { add(d.reply, 'bot'); setQuick(d.quick); }, 350); })
      .catch(function () { add('Sorry, please try again or use WhatsApp.', 'bot'); });
  }
  if (cb) {
    $('#chatToggle').addEventListener('click', function () {
      cb.hidden = !cb.hidden;
      if (!cb.hidden && !body.children.length) { add('Assalam o Alaikum! I am the clinic assistant. Ask me about appointments, timings, fees or your condition.', 'bot'); setQuick(['Book appointment', 'Clinic timings', 'Services', 'Location']); }
    });
    $('#chatClose').addEventListener('click', function () { cb.hidden = true; });
    cf.addEventListener('submit', function (e) { e.preventDefault(); var v = ci.value.trim(); if (v) { ci.value = ''; ask(v); } });
  }
})();

/* back-to-top button */
(function(){var t=document.getElementById('toTop');if(!t)return;
addEventListener('scroll',function(){t.classList.toggle('show',scrollY>500)},{passive:true});
t.addEventListener('click',function(){scrollTo({top:0,behavior:'smooth'})});})();

/* ---------- Services slider ---------- */
(function () {
  var root = document.getElementById('svcSlider'); if (!root) return;
  var track = root.querySelector('.sl-track'), prev = root.querySelector('.prev'), next = root.querySelector('.next');
  function step() { var c = track.querySelector('.scard'); return c ? c.getBoundingClientRect().width + 24 : 300; }
  function update() {
    prev.disabled = track.scrollLeft < 8;
    next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 8;
    var bar = document.getElementById("slBar"), now = document.getElementById("slNow");
    var max = track.scrollWidth - track.clientWidth, ratio = track.clientWidth / track.scrollWidth, p = max > 0 ? track.scrollLeft / max : 0;
    if (bar) { bar.style.width = (ratio * 100) + "%"; bar.style.marginLeft = (p * (1 - ratio) * 100) + "%"; }
    var cards = track.querySelectorAll(".scard").length, per = Math.max(1, Math.round(track.clientWidth / step()));
    if (now) now.textContent = Math.min(cards, Math.round(p * (cards - per)) + per);
  }
  prev.addEventListener('click', function () { track.scrollBy({ left: -step(), behavior: 'smooth' }); });
  next.addEventListener('click', function () { track.scrollBy({ left: step(), behavior: 'smooth' }); });
  track.addEventListener('scroll', update, { passive: true }); addEventListener('resize', update); update();
  // gentle autoplay (pauses on hover/touch, off if user prefers reduced motion)
  if (matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  var paused = false, vis = true;
  ['touchstart'].forEach(function (e) { root.addEventListener(e, function () { paused = true; }, { passive: true }); });
  ['touchend'].forEach(function (e) { root.addEventListener(e, function () { paused = false; }, { passive: true }); });
  if ('IntersectionObserver' in window) new IntersectionObserver(function (es) { vis = es[0].isIntersecting; }).observe(root);
  setInterval(function () {
    if (paused || !vis) return;
    if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 8) track.scrollTo({ left: 0, behavior: 'smooth' });
    else track.scrollBy({ left: step(), behavior: 'smooth' });
  }, 3000);
})();
