<?php
class Features extends Controller
{
    private $featuresData;

    public function __construct()
    {
        // Define all feature data
        $this->featuresData = [
            'lightning-fast' => [
                'slug' => 'lightning-fast',
                'title' => 'Lightning Fast',
                'icon' => 'fa-solid fa-bolt',
                'color' => 'var(--md-sys-color-primary)',
                'bg_color' => 'var(--md-sys-color-primary-container)',
                'short_intro' => 'Experience blazing-fast performance with our optimized search and reporting system designed specifically for the DIU community.',
                'description' => 'DIU Find is built from the ground up with performance in mind. Our lightning-fast platform ensures that you can report lost items and search for found items in seconds, not minutes. Every millisecond counts when you\'re trying to recover something precious.',
                'sections' => [
                    [
                        'heading' => 'Optimized Search Engine',
                        'content' => 'Our advanced search algorithm scans through thousands of posts instantly, delivering relevant results in milliseconds. Whether you\'re looking for a lost phone, wallet, or ID card, our smart indexing system ensures you find what you need immediately.'
                    ],
                    [
                        'heading' => 'Instant Post Creation',
                        'content' => 'Report lost or found items in under 30 seconds. Our streamlined interface eliminates unnecessary steps, getting your post live on the platform instantly so the community can help you right away.'
                    ],
                    [
                        'heading' => 'Real-Time Updates',
                        'content' => 'The feed updates automatically without page refreshes. See new posts appear instantly as they\'re submitted, ensuring you never miss a potential match for your lost item.'
                    ]
                ],
                'benefits' => [
                    'Sub-second search results across entire database',
                    'Zero lag when creating or editing posts',
                    'Optimized image loading for fast page speeds',
                    'Lightweight codebase for smooth mobile experience',
                    'Instant notifications without delays'
                ]
            ],
            'secure-private' => [
                'slug' => 'secure-private',
                'title' => 'Secure & Private',
                'icon' => 'fa-solid fa-shield-alt',
                'color' => 'var(--md-sys-color-tertiary)',
                'bg_color' => 'var(--md-sys-color-tertiary-container)',
                'short_intro' => 'Your privacy and security are our top priorities. All your data is protected with industry-standard security measures.',
                'description' => 'At DIU Find, we understand that you\'re sharing sensitive information about lost and found items. That\'s why we\'ve implemented comprehensive security measures to protect your data and maintain your privacy throughout the platform.',
                'sections' => [
                    [
                        'heading' => 'Data Encryption',
                        'content' => 'All sensitive data is encrypted both in transit and at rest. Your personal information, including phone numbers and contact details, are securely stored and only shared with verified users when necessary.'
                    ],
                    [
                        'heading' => 'Privacy Controls',
                        'content' => 'You have full control over what information you share. Choose to hide your phone number, use private messaging, or limit who can contact you about found items. Your privacy settings are respected across the entire platform.'
                    ],
                    [
                        'heading' => 'Trust Score System',
                        'content' => 'Our unique trust score system helps identify reliable community members. This gamification approach encourages honest behavior while protecting users from potential scams or fraudulent claims.'
                    ]
                ],
                'benefits' => [
                    'Industry-standard password hashing and authentication',
                    'Optional phone number privacy settings',
                    'Secure session management to prevent unauthorized access',
                    'Regular security audits and updates',
                    'Community-driven trust verification system'
                ]
            ],
            'ai-powered' => [
                'slug' => 'ai-powered',
                'title' => 'AI-Powered Matching',
                'icon' => 'fa-solid fa-brain',
                'color' => 'var(--md-sys-color-secondary)',
                'bg_color' => 'var(--md-sys-color-secondary-container)',
                'short_intro' => 'Intelligent algorithms work behind the scenes to match lost items with found items automatically.',
                'description' => 'Our AI-powered matching system uses advanced algorithms to analyze item descriptions, categories, locations, and timestamps to suggest potential matches between lost and found items. This smart technology significantly increases the chances of reuniting items with their owners.',
                'sections' => [
                    [
                        'heading' => 'Smart Category Matching',
                        'content' => 'The system intelligently categorizes items and suggests matches based on item type, color, brand, and distinctive features mentioned in descriptions. Lost your blue Samsung phone? We\'ll automatically surface relevant found phone posts.'
                    ],
                    [
                        'heading' => 'Location-Based Intelligence',
                        'content' => 'Our AI considers the location and time where items were lost or found. If you lost something in the library yesterday, we\'ll prioritize found items reported from that same area around that time.'
                    ],
                    [
                        'heading' => 'Pattern Recognition',
                        'content' => 'Over time, the system learns patterns about where and when items are commonly lost on campus. This helps predict likely locations for specific item types and improves matching accuracy.'
                    ]
                ],
                'benefits' => [
                    'Automatic matching suggestions sent via notifications',
                    'Improved search relevance based on context',
                    'Smart filters that understand natural language queries',
                    'Pattern analysis to identify common loss locations',
                    'Continuous learning from successful reunifications'
                ]
            ],
            'real-time-alerts' => [
                'slug' => 'real-time-alerts',
                'title' => 'Real-Time Alerts',
                'icon' => 'fa-solid fa-bell',
                'color' => 'var(--md-sys-color-error)',
                'bg_color' => 'var(--md-sys-color-error-container)',
                'short_intro' => 'Never miss a potential match. Get instant notifications when items matching your lost item are reported.',
                'description' => 'Time is critical when recovering lost items. Our real-time notification system ensures you\'re immediately alerted when someone finds and posts an item that matches your description, giving you the best chance of recovery.',
                'sections' => [
                    [
                        'heading' => 'Instant Push Notifications',
                        'content' => 'Receive immediate alerts the moment a matching item is posted. Whether you\'re in class, at home, or anywhere on campus, you\'ll know instantly when there\'s a potential match.'
                    ],
                    [
                        'heading' => 'Smart Notification Filtering',
                        'content' => 'Our intelligent system only sends you relevant notifications. No spam, no noise—just alerts about items that genuinely match your lost item criteria based on category, location, and description.'
                    ],
                    [
                        'heading' => 'Multi-Channel Alerts',
                        'content' => 'Choose how you want to be notified: in-app notifications, email alerts, or both. Customize notification frequency and types to match your preferences without missing important updates.'
                    ]
                ],
                'benefits' => [
                    'Instant notifications for matching items',
                    'Comment and reaction alerts on your posts',
                    'Claim requests delivered in real-time',
                    'Customizable notification preferences',
                    'Email backup for critical alerts'
                ]
            ],
            'community-driven' => [
                'slug' => 'community-driven',
                'title' => 'Community Driven',
                'icon' => 'fa-solid fa-comments',
                'color' => '#1976D2',
                'bg_color' => '#E3F2FD',
                'short_intro' => 'Join a caring community of DIU students and staff dedicated to helping each other recover lost items.',
                'description' => 'DIU Find is more than just a platform—it\'s a thriving community of students, faculty, and staff who care about helping each other. Together, we\'ve created a culture of honesty and mutual support that makes our campus a better place.',
                'sections' => [
                    [
                        'heading' => 'Social Engagement Features',
                        'content' => 'Interact with posts through reactions, comments, and direct messaging. The community can share tips, ask questions, and provide additional information that might help reunite items with their owners.'
                    ],
                    [
                        'heading' => 'Heroes of DIU',
                        'content' => 'We celebrate community members who go above and beyond to help others. Our Hall of Fame recognizes top contributors who consistently help reunite lost items, fostering a culture of kindness and cooperation.'
                    ],
                    [
                        'heading' => 'Collaborative Problem Solving',
                        'content' => 'Sometimes finding an item takes a village. The community can collaborate through comments to provide leads, suggest locations to check, or share information about similar items they\'ve seen.'
                    ]
                ],
                'benefits' => [
                    'Comment system for collaborative searching',
                    'Reaction emojis to show support and empathy',
                    'Direct WhatsApp/phone contact integration',
                    'Leaderboard to recognize helpful heroes',
                    'Trust score system to build community credibility'
                ]
            ],
            'mobile-ready' => [
                'slug' => 'mobile-ready',
                'title' => 'Mobile Ready',
                'icon' => 'fa-solid fa-mobile-alt',
                'color' => '#F57C00',
                'bg_color' => '#FFF3E0',
                'short_intro' => 'Access DIU Find from anywhere, on any device. Our responsive design works perfectly on phones, tablets, and desktops.',
                'description' => 'In today\'s mobile-first world, you need to report and search for items on the go. DIU Find is fully optimized for mobile devices, providing a seamless experience whether you\'re using a smartphone, tablet, or desktop computer.',
                'sections' => [
                    [
                        'heading' => 'Responsive Design',
                        'content' => 'Every page and feature automatically adapts to your screen size. The interface is touch-friendly, with appropriately sized buttons and easy-to-read text that looks great on any device.'
                    ],
                    [
                        'heading' => 'Mobile-Optimized Features',
                        'content' => 'Special mobile features include camera integration for quick photo uploads, location detection for automatic map pins, and one-tap calling/WhatsApp buttons to contact item owners instantly.'
                    ],
                    [
                        'heading' => 'Progressive Web App',
                        'content' => 'Add DIU Find to your phone\'s home screen for an app-like experience. Fast loading, offline capabilities, and native-feeling interactions make it feel like a dedicated mobile app.'
                    ]
                ],
                'benefits' => [
                    'Fully responsive on all screen sizes',
                    'Touch-optimized interface for mobile devices',
                    'Fast loading on mobile networks',
                    'Camera integration for photo uploads',
                    'GPS location detection for map features'
                ]
            ]
        ];
    }

    public function show($slug = null)
    {
        // Validate slug
        if (!$slug || !isset($this->featuresData[$slug])) {
            // Return 404 page
            die('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>404 - Feature Not Found | DIU Find</title>
                    <link rel="stylesheet" href="' . URLROOT . '/public/css/style.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                </head>
                <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif;">
                    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--md-sys-color-primary-container), var(--md-sys-color-tertiary-container)); padding: 20px;">
                        <div style="text-align: center; max-width: 500px; background: white; padding: 48px; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                            <i class="fa-solid fa-exclamation-triangle" style="font-size: 72px; color: #F57C00; margin-bottom: 24px;"></i>
                            <h1 style="font-size: 48px; margin: 0 0 16px; color: #333;">404</h1>
                            <h2 style="font-size: 24px; margin: 0 0 16px; color: #666;">Feature Not Found</h2>
                            <p style="color: #999; margin-bottom: 32px; line-height: 1.6;">The feature you\'re looking for doesn\'t exist or has been removed.</p>
                            <a href="' . URLROOT . '" style="display: inline-block; padding: 14px 32px; background: var(--md-sys-color-primary); color: white; text-decoration: none; border-radius: 12px; font-weight: 600; transition: all 0.3s;">
                                <i class="fa-solid fa-home" style="margin-right: 8px;"></i>
                                Back to Home
                            </a>
                        </div>
                    </div>
                </body>
                </html>
            ');
        }

        $feature = $this->featuresData[$slug];

        $data = [
            'title' => $feature['title'] . ' - DIU Find',
            'feature' => $feature
        ];

        $this->view('features/show', $data);
    }
}
