<?php
/**
 * SITE CONFIG - yahan details change karein.
 * Details doctor ke visiting card se li gayi hain.
 */
return [
    'site_name'   => 'Dr. Benish Abdul Sattar | Clinical Physiotherapist in Multan',
    'doctor'      => 'Dr. Benish Abdul Sattar',
    'title_short' => 'Clinical Physiotherapist (DPT)',
    'qualification' => 'Doctor of Physiotherapy (DPT)',
    // About page par "Qualifications & Certifications" mein dikhenge
    'credentials' => [
        'Doctor of Physiotherapy (DPT)',
        'Certified K-Taping Practitioner',
        'Certified Dry Needling Practitioner',
        'Certified Fitness & Personal Trainer',
        'Certified Hijama Therapist',
    ],
    'experience_list' => [
        'Ex-Intern, South Punjab Hospital, Multan',
        'Ex-Intern, Children Hospital, Multan',
        'Ex-Intern, Barki Advanced Physiotherapy Complex',
    ],
    'phone'       => '+92 307 6054492',
    'whatsapp'    => '923076054492',           
    'country_code'=> '92',                      
    'clinic_name' => 'Haleema Hospital Complex',
    'address'     => 'Nishtar Road, Al Raheem Colony, Multan',
    'city'        => 'Multan',
    'country'     => 'PK',
    'geo'         => ['lat' => 30.1700, 'lng' => 71.4400],
    'map_embed'   => 'https://www.google.com/maps?q=Haleema+Hospital+Complex+Nishtar+Road+Multan&output=embed',
    'timings'     => [
        'Monday - Saturday' => '11:00 AM - 4:00 PM',
        'Sunday'            => 'Closed',
    ],
    'opening_hours' => ['Mo-Sa 11:00-16:00'],
    'social' => [
        'facebook'  => '#',
        'instagram' => '#',
        'youtube'   => '#',
        'linkedin'  => '#',
    ],
    'admin_password' => 'ChangeMe@123',
    'site_url'    => '',
    'timezone'    => 'Asia/Karachi',
    // Slots (24h) jo online booking mein dikhenge (11AM - 4PM)
    'slots'       => ['11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30'],
    'closed_days' => [0], // 0 = Sunday
];
