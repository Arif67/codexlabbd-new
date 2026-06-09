<?php

// কোম্পানির সব তথ্য এখান থেকে সহজে বদলানো যাবে (প্রথম সিডের ডিফল্ট মান)।
// লাইভ সাইটে এগুলো DB থেকে আসে — Admin > Site Settings থেকে বদলান।
return [
    'name'     => 'CodexLab',
    'tagline'  => 'Custom Software Solutions & Digital Marketing',
    'address'  => '123 Gulshan Avenue, Dhaka, Bangladesh',
    'phone'    => '+880 1700-000000',
    'email'    => 'hello@codexlab.com',

    'social' => [
        'facebook'  => 'https://facebook.com/',
        'twitter'   => 'https://twitter.com/',
        'instagram' => 'https://instagram.com/',
        'linkedin'  => 'https://linkedin.com/',
        'youtube'   => 'https://youtube.com/',
    ],

    // হোম ও সার্ভিস পেজে দেখানো সার্ভিসসমূহ (সফটওয়্যার আগে, মার্কেটিং পরে)
    'services' => [
        // ---- Custom Software Solutions (core business) ----
        ['icon' => 'fa-code',          'title' => 'Custom Software Development', 'desc' => 'Tailored software built around your exact workflow — from internal business tools to full enterprise platforms.'],
        ['icon' => 'fa-laptop-code',   'title' => 'Web Application Development', 'desc' => 'Fast, secure and scalable web apps, dashboards and SaaS products using modern stacks like Laravel, React and Node.'],
        ['icon' => 'fa-mobile-alt',    'title' => 'Mobile App Development',      'desc' => 'Native and cross-platform iOS & Android apps that are smooth, reliable and built to grow with your users.'],
        ['icon' => 'fa-pen-nib',       'title' => 'UI/UX Design',               'desc' => 'User-centered interface and experience design that makes your product intuitive, modern and easy to use.'],
        ['icon' => 'fa-plug',          'title' => 'API & System Integration',   'desc' => 'Connect your tools, automate processes and integrate third-party services, payment gateways and ERPs.'],
        ['icon' => 'fa-cloud',         'title' => 'Cloud & DevOps',             'desc' => 'Cloud deployment, CI/CD pipelines and dependable hosting that scales safely as your business grows.'],

        // ---- Digital Marketing (alongside) ----
        ['icon' => 'fa-chart-line',    'title' => 'SEO Optimization',           'desc' => 'Rank higher on Google with technical SEO, on-page optimization and authority-building link strategies.'],
        ['icon' => 'fa-share-alt',     'title' => 'Social Media Marketing',     'desc' => 'Grow and engage your audience on Facebook, Instagram and LinkedIn with content that converts.'],
        ['icon' => 'fa-mouse-pointer', 'title' => 'PPC Advertising',            'desc' => 'Drive instant, qualified traffic with high-ROI Google Ads and Meta Ads campaigns managed end to end.'],
    ],

    // প্রজেক্ট/পোর্টফোলিও আইটেম
    'projects' => [
        ['img' => 'portfolio-1.jpg', 'category' => 'Software',          'title' => 'ERP Management System'],
        ['img' => 'portfolio-2.jpg', 'category' => 'Web Application',   'title' => 'SaaS Business Platform'],
        ['img' => 'portfolio-3.jpg', 'category' => 'Mobile App',        'title' => 'Food Delivery App'],
        ['img' => 'portfolio-4.jpg', 'category' => 'Software',          'title' => 'School Management System'],
        ['img' => 'portfolio-5.jpg', 'category' => 'Web Application',   'title' => 'POS & Inventory System'],
        ['img' => 'portfolio-6.jpg', 'category' => 'Digital Marketing', 'title' => 'SEO Growth Campaign'],
    ],
];
