import * as THREE from 'three';

/* 3D hero: a rotating, glowing spine (vertebrae + discs) surrounded by floating particles.
   Mouse parallax + scroll-aware. Falls back silently if WebGL is unavailable. */
const canvas = document.getElementById('hero3d');
if (canvas && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
  try {
    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
    camera.position.set(0, 0, 14);

    scene.add(new THREE.AmbientLight(0xffffff, 0.9));
    const key = new THREE.PointLight(0x12a4b0, 60, 40); key.position.set(6, 6, 8); scene.add(key);
    const fill = new THREE.PointLight(0x2f80ed, 40, 40); fill.position.set(-8, -4, 6); scene.add(fill);

    const spine = new THREE.Group();
    const bone = new THREE.MeshStandardMaterial({ color: 0xe9fbfc, roughness: .35, metalness: .15, emissive: 0x0e7c86, emissiveIntensity: .25 });
    const disc = new THREE.MeshStandardMaterial({ color: 0x12a4b0, roughness: .5, transparent: true, opacity: .85 });
    const N = 16;
    for (let i = 0; i < N; i++) {
      const t = i / (N - 1), y = (t - .5) * 11;
      const x = Math.sin(t * Math.PI * 2) * 0.9;         // natural S-curve
      const s = 0.7 + Math.sin(t * Math.PI) * 0.5;
      const v = new THREE.Mesh(new THREE.CylinderGeometry(s * .9, s, .55, 28), bone);
      v.position.set(x, y, 0); v.rotation.z = Math.cos(t * Math.PI * 2) * .12; spine.add(v);
      const p = new THREE.Mesh(new THREE.SphereGeometry(.28, 16, 16), bone); p.position.set(x, y, -s * .9); spine.add(p);   // spinous process
      for (const sd of [-1, 1]) { const tp = new THREE.Mesh(new THREE.CapsuleGeometry(.12, s * 1.1, 4, 8), bone); tp.position.set(x + sd * s * 1.1, y, 0); tp.rotation.z = Math.PI / 2; spine.add(tp); }
      if (i < N - 1) { const d = new THREE.Mesh(new THREE.CylinderGeometry(s * .85, s * .85, .22, 24), disc); d.position.set(x, y - .38, 0); spine.add(d); }
    }
    spine.position.x = 4.2; spine.scale.setScalar(.95);
    scene.add(spine);

    // floating particles
    const pc = 450, pos = new Float32Array(pc * 3);
    for (let i = 0; i < pc; i++) { pos[i * 3] = (Math.random() - .5) * 34; pos[i * 3 + 1] = (Math.random() - .5) * 20; pos[i * 3 + 2] = (Math.random() - .5) * 14; }
    const pg = new THREE.BufferGeometry(); pg.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    const pts = new THREE.Points(pg, new THREE.PointsMaterial({ color: 0x12a4b0, size: .07, transparent: true, opacity: .7 }));
    scene.add(pts);

    // DNA-like rings
    const ring = new THREE.Mesh(new THREE.TorusGeometry(4.6, .02, 8, 120), new THREE.MeshBasicMaterial({ color: 0x2f80ed, transparent: true, opacity: .35 }));
    ring.position.x = 4.2; ring.rotation.x = 1.2; scene.add(ring);

    let mx = 0, my = 0, w = 0, h = 0, vis = true;
    const resize = () => {
      const r = canvas.parentElement.getBoundingClientRect(); w = r.width; h = r.height;
      renderer.setSize(w, h, false); camera.aspect = w / h;
      const narrow = w < 900; spine.position.x = narrow ? 0 : 4.2; ring.position.x = spine.position.x;
      spine.scale.setScalar(narrow ? .5 : .75); camera.updateProjectionMatrix();
    };
    resize(); addEventListener('resize', resize);
    addEventListener('mousemove', e => { mx = e.clientX / innerWidth - .5; my = e.clientY / innerHeight - .5; });
    new IntersectionObserver(es => { vis = es[0].isIntersecting; }).observe(canvas);

    const clock = new THREE.Clock();
    (function loop() {
      requestAnimationFrame(loop); if (!vis) return;
      const t = clock.getElapsedTime();
      spine.rotation.y = t * .15 + mx * .3; spine.rotation.x = my * .25;
      spine.position.y = Math.sin(t) * .1;
      ring.rotation.z = t * .2; pts.rotation.y = t * .02;
      camera.position.x += (mx * 1.2 - camera.position.x) * .04; camera.position.y += (-my * .8 - camera.position.y) * .04; camera.lookAt(0, 0, 0);
      renderer.render(scene, camera);
    })();
  } catch (e) { canvas.remove(); }
}
