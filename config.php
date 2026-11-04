<?php
/**
 * SITE CONFIG - yahan apni details change karein.
 */
return [
    'site_name'   => 'Dr. Ahmed Khan | Physiatrist',
    'doctor'      => 'Dr. Ahmed Khan',
    'title_short' => 'Physiatrist & Rehabilitation Specialist',
    'qualification' => 'MBBS, FCPS (PM&R), Fellowship in Interventional Pain Medicine',
    'experience'  => 12,
    'patients'    => '15,000+',
    'phone'       => '+92 300 0000000',
    'whatsapp'    => '923000000000',            // country code ke sath, + ke baghair
    'country_code'=> '92',                      // local numbers (03xx) ko WhatsApp format mein badalne ke liye
    'email'       => 'info@example.com',        // appointment notifications yahan aayengi
    'clinic_name' => 'Advanced Rehab & Pain Clinic',
    'address'     => 'Nishtar Road, Multan, Punjab, Pakistan',
    'city'        => 'Multan',
    'country'     => 'PK',
    'geo'         => ['lat' => 30.1575, 'lng' => 71.5249],
    'map_embed'   => 'https://www.google.com/maps?q=Nishtar+Road+Multan&output=embed',
    'timings'     => [
        'Monday - Friday' => '4:00 PM - 9:00 PM',
        'Saturday'        => '5:00 PM - 8:00 PM',
        'Sunday'          => 'Closed',
    ],
    // schema.org openingHours ke liye
    'opening_hours' => ['Mo-Fr 16:00-21:00', 'Sa 17:00-20:00'],
    'social' => [
        'facebook'  => '#',
        'instagram' => '#',
        'youtube'   => '#',
        'linkedin'  => '#',
    ],
    // Admin panel password (zaroor change karein!)
    'admin_password' => 'ChangeMe@123',
    // Site ka full URL (SEO canonical/sitemap). Khali chorein to auto-detect hoga.
    'site_url'    => '',
    'timezone'    => 'Asia/Karachi',
    // Slots (24h) jo online booking mein dikhenge
    'slots'       => ['16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30'],
    'closed_days' => [0], // 0 = Sunday
];
