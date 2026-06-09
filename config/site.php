<?php

// এজেন্সির সব তথ্য এখান থেকে সহজে বদলানো যাবে।
return [
    'name'     => 'Digital Boost',
    'tagline'  => 'Digital Marketing Agency',
    'address'  => '123 Gulshan Avenue, Dhaka, Bangladesh',
    'phone'    => '+880 1700-000000',
    'email'    => 'hello@digitalboost.com',

    'social' => [
        'facebook'  => 'https://facebook.com/',
        'twitter'   => 'https://twitter.com/',
        'instagram' => 'https://instagram.com/',
        'linkedin'  => 'https://linkedin.com/',
        'youtube'   => 'https://youtube.com/',
    ],

    // হোম ও সার্ভিস পেজে দেখানো সার্ভিসসমূহ
    'services' => [
        ['icon' => 'fa-chart-line',        'title' => 'SEO Optimization',       'desc' => 'Rank higher on Google with technical SEO, on-page optimization and authority-building link strategies.'],
        ['icon' => 'fa-share-alt',         'title' => 'Social Media Marketing', 'desc' => 'Grow and engage your audience on Facebook, Instagram, LinkedIn and TikTok with content that converts.'],
        ['icon' => 'fa-mouse-pointer',     'title' => 'PPC Advertising',        'desc' => 'Drive instant, qualified traffic with high-ROI Google Ads and Meta Ads campaigns managed end to end.'],
        ['icon' => 'fa-envelope-open-text','title' => 'Email Marketing',        'desc' => 'Nurture leads and boost retention with automated email funnels and data-driven newsletters.'],
        ['icon' => 'fa-laptop-code',       'title' => 'Web Design & Dev',       'desc' => 'Fast, responsive, conversion-focused websites and landing pages built to turn visitors into customers.'],
        ['icon' => 'fa-pen-nib',           'title' => 'Content & Branding',     'desc' => 'Compelling copy, creative design and brand strategy that make your business stand out and sell.'],
    ],

    // প্রজেক্ট/পোর্টফোলিও আইটেম
    'projects' => [
        ['img' => 'portfolio-1.jpg', 'category' => 'SEO',          'title' => 'E-commerce Growth'],
        ['img' => 'portfolio-2.jpg', 'category' => 'Web Design',   'title' => 'SaaS Landing Page'],
        ['img' => 'portfolio-3.jpg', 'category' => 'Social Media', 'title' => 'Brand Campaign'],
        ['img' => 'portfolio-4.jpg', 'category' => 'PPC',          'title' => 'Lead Gen Funnel'],
        ['img' => 'portfolio-5.jpg', 'category' => 'Branding',     'title' => 'Restaurant Rebrand'],
        ['img' => 'portfolio-6.jpg', 'category' => 'Email',        'title' => 'Retention Program'],
    ],
];
