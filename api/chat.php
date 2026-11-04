<?php
require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json; charset=utf-8');

$q = mb_strtolower(trim(strip_tags($_POST['q'] ?? '')));
$rules = [
  ['/(book|appointment|visit|slot|schedule|booking)/', 'You can book online in under a minute. Pick a date and time here: ' . abs_url('book'), ['Clinic timings','Fees','Location']],
  ['/(time|timing|open|hour|close|when)/', "Clinic timings: Mon-Fri 4PM-9PM, Saturday 5PM-8PM, Sunday closed.", ['Book appointment','Location']],
  ['/(fee|fees|price|cost|charges|rate)/', 'Fees depend on the consultation and any tests or procedures. Please call ' . cfg('phone') . ' or WhatsApp us for the latest fee details.', ['Book appointment']],
  ['/(where|location|address|map|direction)/', 'We are at ' . cfg('address') . '. Map: ' . abs_url('contact'), ['Clinic timings','Book appointment']],
  ['/(back|spine|lumbar|disc|sciatica)/', 'Back pain and sciatica are our most common problems. Most improve without surgery with the right exercise, posture and, if needed, injections. See: ' . abs_url('services/back-pain-treatment'), ['Book appointment']],
  ['/(neck|cervical|shoulder)/', 'Neck and shoulder pain are treated with targeted therapy and guided injections when required. See: ' . abs_url('services/neck-pain-cervical-spondylosis'), ['Book appointment']],
  ['/(stroke|paralysis|hemiplegia|brain)/', 'Early stroke rehabilitation gives the best recovery. Details: ' . abs_url('services/stroke-rehabilitation'), ['Book appointment']],
  ['/(knee|arthritis|joint)/', 'Knee arthritis can often be managed without surgery. Details: ' . abs_url('services/knee-pain-osteoarthritis'), ['Book appointment']],
  ['/(sport|injury|ligament|acl)/', 'We offer sports injury rehabilitation with safe return-to-play plans: ' . abs_url('services/sports-injury-rehabilitation'), ['Book appointment']],
  ['/(physiatrist|what is|pm&r|rehab)/', 'A physiatrist is a Physical Medicine & Rehabilitation doctor who treats pain and disability without surgery whenever possible: ' . abs_url('faq'), ['Book appointment','Services']],
  ['/(service|treat|offer)/', 'We treat back/neck pain, stroke, sports injuries, arthritis, nerve problems and pediatric conditions: ' . abs_url('services'), ['Book appointment']],
  ['/(phone|call|number|contact|whatsapp)/', 'Call ' . cfg('phone') . ' or WhatsApp: ' . wa_link('Hello Doctor'), ['Book appointment']],
  ['/(hi|hello|salam|assalam|hey)/', 'Hello! I am the clinic assistant. How can I help you today?', ['Book appointment','Clinic timings','Services']],
  ['/(emergency|urgent|chest pain|cannot breathe|bladder|bowel)/', 'This sounds urgent. Please go to the nearest emergency department or call your local emergency number immediately.', []],
];
$reply = 'I am not sure I understood. You can ask about appointments, timings, fees, location or a condition such as back pain. Or WhatsApp us: ' . wa_link('Hello Doctor');
$quick = ['Book appointment','Clinic timings','Services'];
foreach ($rules as $r) {
    if (preg_match($r[0], $q)) { $reply = $r[1]; $quick = $r[2]; break; }
}
echo json_encode(['reply'=>$reply,'quick'=>$quick], JSON_UNESCAPED_SLASHES);
