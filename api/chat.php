<?php
require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json; charset=utf-8');

$q = mb_strtolower(trim(strip_tags($_POST['q'] ?? '')));
$timings = [];
foreach (cfg('timings') as $d => $t) $timings[] = "$d: $t";

$rules = [
  ['/(emergency|urgent|chest pain|cannot breathe|bladder|bowel)/', 'This sounds urgent. Please go to the nearest emergency department or call your local emergency number immediately.', []],
  ['/(book|appointment|visit|slot|schedule|booking)/', 'You can book online in under a minute. Pick a date and time here: ' . abs_url('book'), ['Clinic timings','Fees','Location']],
  ['/(time|timing|open|hour|close|when)/', 'Clinic timings - ' . implode(', ', $timings) . '.', ['Book appointment','Location']],
  ['/(fee|fees|price|cost|charges|rate)/', 'Fees depend on the treatment. Please call ' . cfg('phone') . ' or WhatsApp us for the latest fee details.', ['Book appointment']],
  ['/(where|location|address|map|direction)/', 'We are at ' . cfg('clinic_name') . ', ' . cfg('address') . '. Map: ' . abs_url('contact'), ['Clinic timings','Book appointment']],
  ['/(dry needl|needle|trigger point)/', 'Dry needling is done by a certified practitioner for tight muscle knots, as part of a physiotherapy plan. See: ' . abs_url('services/dry-needling-therapy'), ['Book appointment']],
  ['/(tape|taping|k-tap|kinesio)/', 'K-taping gives flexible support to muscles and joints. See: ' . abs_url('services/k-taping-therapy'), ['Book appointment']],
  ['/(hijama|cupping)/', 'Hijama (cupping) is offered by a certified hijama therapist with single-use sterile equipment. See: ' . abs_url('services/hijama-cupping-therapy'), ['Book appointment']],
  ['/(fitness|trainer|gym|personal train|weight)/', 'We offer safe, personalised fitness programs. See: ' . abs_url('services/fitness-personal-training'), ['Book appointment']],
  ['/(back|spine|lumbar|disc|sciatica)/', 'Back pain and sciatica are among the most common problems we treat, using exercise, manual therapy and posture correction. See: ' . abs_url('services/back-pain-treatment'), ['Book appointment']],
  ['/(neck|cervical|shoulder)/', 'Neck and shoulder pain are treated with manual therapy, exercise and dry needling where suitable. See: ' . abs_url('services/neck-pain-cervical-spondylosis'), ['Book appointment']],
  ['/(stroke|paralysis|hemiplegia|brain)/', 'Early stroke rehabilitation gives the best recovery. Details: ' . abs_url('services/stroke-rehabilitation'), ['Book appointment']],
  ['/(knee|arthritis|joint)/', 'Knee pain and arthritis respond well to strengthening and guided exercise. Details: ' . abs_url('services/knee-pain-osteoarthritis'), ['Book appointment']],
  ['/(sport|injury|ligament|acl|sprain)/', 'We offer sports injury rehabilitation with safe return-to-play plans: ' . abs_url('services/sports-injury-rehabilitation'), ['Book appointment']],
  ['/(child|kid|baby|pediatric|paediatric)/', 'We offer gentle, play-based physiotherapy for children: ' . abs_url('services/pediatric-rehabilitation'), ['Book appointment']],
  ['/(physio|dpt|doctor|qualif|who)/', cfg('doctor') . ' is a Doctor of Physiotherapy (DPT), certified in dry needling, K-taping, fitness training and hijama therapy. More: ' . abs_url('about'), ['Book appointment','Services']],
  ['/(service|treat|offer)/', 'We offer physiotherapy for pain, injuries, stroke and children, plus dry needling, K-taping, hijama and fitness training: ' . abs_url('services'), ['Book appointment']],
  ['/(phone|call|number|contact|whatsapp)/', 'Call ' . cfg('phone') . ' or WhatsApp: ' . wa_link('Hello Doctor'), ['Book appointment']],
  ['/(hi|hello|salam|assalam|hey)/', 'Hello! I am the clinic assistant. How can I help you today?', ['Book appointment','Clinic timings','Services']],
];
$reply = 'I am not sure I understood. You can ask about appointments, timings, fees, location or a condition such as back pain. Or WhatsApp us: ' . wa_link('Hello Doctor');
$quick = ['Book appointment','Clinic timings','Services'];
foreach ($rules as $r) {
    if (preg_match($r[0], $q)) { $reply = $r[1]; $quick = $r[2]; break; }
}
echo json_encode(['reply'=>$reply,'quick'=>$quick], JSON_UNESCAPED_SLASHES);
