<?php

namespace Database\Seeders;

use App\Models\HomepageSlider;
use App\Models\HomepageSection;
use App\Models\HomepageFeature;
use App\Models\HomepageFaq;
use App\Models\SessionTime;
use App\Models\Breadcrumb;
use App\Models\AboutPageContent;
use App\Models\TeamMember;
use App\Models\HistoryTimeline;
use App\Models\ContactInformation;
use Illuminate\Database\Seeder;

class WebsiteContentSeeder extends Seeder
{
    public function run(): void
    {
        // Homepage Slider
        HomepageSlider::firstOrCreate(
            ['text' => 'We Prepare Your Child For Life'],
            [
                'image' => 'assets/img/hero/hero-1-1.jpg',
                'text' => 'We Prepare Your Child For Life',
                'description' => 'Montessori Is A Nurturing And Holistic Approach To Learning',
                'button_text' => 'Apply Today',
                'button_link' => '/contact',
                'order' => 1,
                'is_visible' => true,
            ]
        );
        HomepageSlider::firstOrCreate(
            ['text' => 'Special Child Session For Brain Growth'],
            [
                'image' => 'assets/img/hero/hero-1-2.jpg',
                'text' => 'Special Child Session For Brain Growth',
                'description' => 'Montessori Is A Nurturing And Holistic Approach To Learning',
                'button_text' => 'Apply Today',
                'button_link' => '/contact',
                'order' => 2,
                'is_visible' => true,
            ]
        );
        HomepageSlider::firstOrCreate(
            ['text' => 'Best Children Study And Furture Care'],
            [
                'image' => 'assets/img/hero/hero-1-3.jpg',
                'text' => 'Best Children Study And Furture Care',
                'description' => 'Montessori Is A Nurturing And Holistic Approach To Learning',
                'button_text' => 'Apply Today',
                'button_link' => '/contact',
                'order' => 3,
                'is_visible' => true,
            ]
        );

        // About Section
        HomepageSection::firstOrCreate(
            ['section_type' => 'about'],
            [
                'section_type' => 'about',
                'title' => 'Part of the family since 2001',
                'heading' => 'Your Child Will Take The Lead Learning',
                'paragraph' => 'We are constantly expanding the range of services offered, taking care of children of all ages. Our goal is to carefully educate and develop children in a fun way. We strive to turn the learning process into a bright event so that children study with pleasure.',
                'button_text' => 'Learn More',
                'button_link' => '/about',
                'background_image' => null,
                'icon' => null,
                'images' => json_encode([
                    'image_1' => 'website/sections/ab-1-1.jpg',
                    'image_2' => 'website/sections/ab-1-2.jpg',
                    'image_3' => 'website/sections/ab-1-3.jpg',
                    'image_4' => 'website/sections/ab-1-4.jpg',
                ]),
                'content' => null,
                'is_visible' => true,
            ]
        );

        // Features Section
        $features = [
            [
                'section_title' => 'Our Features',
                'section_heading' => 'Why Choose Us',
                'content' => null,
                'image' => null,
                'icon' => 'book-open',
                'title' => 'Active Learning',
                'paragraph' => 'Engaging and interactive learning experiences that inspire curiosity.',
                'order' => 1,
                'is_visible' => true,
            ],
            [
                'section_title' => 'Our Features',
                'section_heading' => 'Why Choose Us',
                'content' => null,
                'image' => null,
                'icon' => 'heart',
                'title' => 'Child Care',
                'paragraph' => 'Comprehensive care and support for every child\'s wellbeing.',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'section_title' => 'Our Features',
                'section_heading' => 'Why Choose Us',
                'content' => null,
                'image' => null,
                'icon' => 'apple',
                'title' => 'Healthy Meals',
                'paragraph' => 'Nutritious and balanced meals prepared with care.',
                'order' => 3,
                'is_visible' => true,
            ],
            [
                'section_title' => 'Our Features',
                'section_heading' => 'Why Choose Us',
                'content' => null,
                'image' => null,
                'icon' => 'shield-check',
                'title' => 'Secure Environment',
                'paragraph' => 'Safe and secure learning environment for peace of mind.',
                'order' => 4,
                'is_visible' => true,
            ],
        ];

        foreach ($features as $feature) {
            HomepageFeature::firstOrCreate(
                ['title' => $feature['title']],
                $feature
            );
        }

        // Programs Section
        HomepageSection::firstOrCreate(
            ['section_type' => 'programs'],
            [
                'section_type' => 'programs',
                'title' => 'Choose Your Own Grade Level',
                'heading' => 'Smarty Programs',
                'paragraph' => null,
                'button_text' => null,
                'button_link' => null,
                'background_image' => null,
                'icon' => null,
                'images' => null,
                'content' => null,
                'is_visible' => true,
            ]
        );

        // Session Times
        $sessionTimes = [
            [
                'background_image' => 'assets/img/bg/table-bg-1-1.jpg',
                'title' => 'Session Times',
                'icon' => 'fal fa-alarm-clock',
                'paragraph' => 'We provide full day care from 8.30am to 3.30pm for children aged 18 months to 5 years,',
                'label' => 'Early Drop Off',
                'time_range' => '8.00am – 10.00am',
                'order' => 1,
                'is_visible' => true,
            ],
            [
                'background_image' => null,
                'title' => null,
                'icon' => null,
                'paragraph' => null,
                'label' => 'Morning',
                'time_range' => '10.30am – 12.00am',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'background_image' => null,
                'title' => null,
                'icon' => null,
                'paragraph' => null,
                'label' => 'Lunch',
                'time_range' => '12noon – 1.00pm',
                'order' => 3,
                'is_visible' => true,
            ],
            [
                'background_image' => null,
                'title' => null,
                'icon' => null,
                'paragraph' => null,
                'label' => 'Afternoon',
                'time_range' => '2.00am – 4.00am',
                'order' => 4,
                'is_visible' => true,
            ],
        ];

        foreach ($sessionTimes as $sessionTime) {
            SessionTime::firstOrCreate(
                ['label' => $sessionTime['label']],
                $sessionTime
            );
        }

        // Day Care Section
        HomepageSection::firstOrCreate(
            ['section_type' => 'day_care'],
            [
                'section_type' => 'day_care',
                'title' => 'Day Care Services',
                'heading' => 'Professional Day Care',
                'paragraph' => 'Quality day care services for your little ones.',
                'button_text' => 'Apply Now',
                'button_link' => '/contact',
                'background_image' => null,
                'icon' => null,
                'images' => null,
                'content' => null,
                'is_visible' => true,
            ]
        );

        // FAQs
        $faqs = [
            [
                'title' => 'Choose your own grade level',
                'heading' => 'Guide to Preschool',
                'question' => 'First Little Readers (Levels A-C)',
                'answer' => 'Enrolment Events are like open days or open weeks at Busy Bees. It\'s a chance for you to visit your local nursery, take a look around, and see some of exciting activities in action.',
                'order' => 1,
                'is_visible' => true,
            ],
            [
                'title' => null,
                'heading' => null,
                'question' => 'What Age Do Kids Start Preschool?',
                'answer' => 'Enrolment Events are like open days or open weeks at Busy Bees. It\'s a chance for you to visit your local nursery, take a look around, and see some of exciting activities in action.',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'title' => null,
                'heading' => null,
                'question' => 'Is My Child Ready for Preschool?',
                'answer' => 'Enrolment Events are like open days or open weeks at Busy Bees. It\'s a chance for you to visit your local nursery, take a look around, and see some of exciting activities in action.',
                'order' => 3,
                'is_visible' => true,
            ],
            [
                'title' => null,
                'heading' => null,
                'question' => 'Can your child separate from you?',
                'answer' => 'Enrolment Events are like open days or open weeks at Busy Bees. It\'s a chance for you to visit your local nursery, take a look around, and see some of exciting activities in action.',
                'order' => 4,
                'is_visible' => true,
            ],
            [
                'title' => null,
                'heading' => null,
                'question' => 'Can your child play with others?',
                'answer' => 'Enrolment Events are like open days or open weeks at Busy Bees. It\'s a chance for you to visit your local nursery, take a look around, and see some of exciting activities in action.',
                'order' => 5,
                'is_visible' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            HomepageFaq::firstOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }

        // Breadcrumbs
        $breadcrumbs = [
            ['page_key' => 'about', 'title' => 'About Us', 'paragraph' => 'Montessori Is A Nurturing And Holistic Approach To Learning', 'background_image' => 'assets/img/breadcumb/breadcumb-bg.jpg'],
            ['page_key' => 'classes', 'title' => 'Our Classes', 'paragraph' => 'Montessori Is A Nurturing And Holistic Approach To Learning', 'background_image' => 'assets/img/breadcumb/breadcumb-bg.jpg'],
            ['page_key' => 'gallery', 'title' => 'Gallery', 'paragraph' => 'Montessori Is A Nurturing And Holistic Approach To Learning', 'background_image' => 'assets/img/breadcumb/breadcumb-bg.jpg'],
            ['page_key' => 'contact', 'title' => 'Contact Us', 'paragraph' => 'Montessori Is A Nurturing And Holistic Approach To Learning', 'background_image' => 'assets/img/breadcumb/breadcumb-bg.jpg'],
            ['page_key' => 'enroll', 'title' => 'Enroll Now', 'paragraph' => 'Montessori Is A Nurturing And Holistic Approach To Learning', 'background_image' => 'assets/img/breadcumb/breadcumb-bg.jpg'],
        ];

        foreach ($breadcrumbs as $breadcrumb) {
            Breadcrumb::firstOrCreate(
                ['page_key' => $breadcrumb['page_key']],
                $breadcrumb
            );
        }

        // About Page Content (About the School)
        AboutPageContent::firstOrCreate(
            ['section_type' => 'about_school'],
            [
                'section_type' => 'about_school',
                'image' => 'assets/img/about/ab-2-1.jpg',
                'title' => 'Your child\'s best start in life',
                'paragraph' => 'We are constantly expanding the range of services offered, taking children of all ages. Our goal is to carefully educate and develop a fun way. We strive to turn the learning process.',
                'name' => null,
                'description' => null,
                'order' => 1,
                'is_visible' => true,
            ]
        );

        // Our Team
        TeamMember::firstOrCreate(
            ['name' => 'Katie Willmore'],
            [
                'image' => 'assets/img/team/t-1-1.jpg',
                'name' => 'Katie Willmore',
                'position' => 'Principal and Manager',
                'bio' => 'Katie is the principal and manager, dedicated to fostering a nurturing learning environment.',
                'order' => 1,
                'is_visible' => true,
            ]
        );
        TeamMember::firstOrCreate(
            ['name' => 'Jessica Levis'],
            [
                'image' => 'assets/img/team/t-1-2.jpg',
                'name' => 'Jessica Levis',
                'position' => 'Senior Teacher',
                'bio' => 'Jessica is a passionate and experienced senior teacher committed to student success.',
                'order' => 2,
                'is_visible' => true,
            ]
        );
        TeamMember::firstOrCreate(
            ['name' => 'Nomina Leione'],
            [
                'image' => 'assets/img/team/t-1-3.jpg',
                'name' => 'Nomina Leione',
                'position' => 'Admissions Officer',
                'bio' => 'Nomina handles all admissions, guiding families through the enrollment process.',
                'order' => 3,
                'is_visible' => true,
            ]
        );

        // Clubs
        AboutPageContent::firstOrCreate(
            ['section_type' => 'club', 'name' => 'Early Club'],
            [
                'section_type' => 'club',
                'image' => 'assets/img/feature/fe-1-1.jpg',
                'title' => 'Early Club',
                'paragraph' => null,
                'name' => 'Early Club',
                'description' => 'Help parents get to work on time, Near the station, Children settled and ready to work',
                'order' => 1,
                'is_visible' => true,
            ]
        );
        AboutPageContent::firstOrCreate(
            ['section_type' => 'club', 'name' => 'Lunch Club'],
            [
                'section_type' => 'club',
                'image' => 'assets/img/feature/fe-1-2.jpg',
                'title' => 'Lunch Club',
                'paragraph' => null,
                'name' => 'Lunch Club',
                'description' => 'Help parents get to work on time, Near the station, Children settled and ready to work',
                'order' => 2,
                'is_visible' => true,
            ]
        );
        AboutPageContent::firstOrCreate(
            ['section_type' => 'club', 'name' => 'Afternoon Club'],
            [
                'section_type' => 'club',
                'image' => 'assets/img/feature/fe-1-3.jpg',
                'title' => 'Afternoon Club',
                'paragraph' => null,
                'name' => 'Afternoon Club',
                'description' => 'Help parents get to work on time, Near the station, Children settled and ready to work',
                'order' => 3,
                'is_visible' => true,
            ]
        );
        AboutPageContent::firstOrCreate(
            ['section_type' => 'club', 'name' => 'Music Club'],
            [
                'section_type' => 'club',
                'image' => 'assets/img/feature/fe-1-4.jpg',
                'title' => 'Music Club',
                'paragraph' => null,
                'name' => 'Music Club',
                'description' => 'Help parents get to work on time, Near the station, Children settled and ready to work',
                'order' => 4,
                'is_visible' => true,
            ]
        );

        // History Timeline
        $timeline = [
            [
                'year' => 1994,
                'title' => 'Opened its doors',
                'feature_label' => 'Foundation',
                'description' => 'Sir Isaac Newton School opened its doors, beginning a journey of educational excellence.',
                'order' => 1,
                'is_visible' => true,
            ],
            [
                'year' => 2001,
                'title' => 'High school physics',
                'feature_label' => 'Expansion',
                'description' => 'Introduced advanced physics curriculum for high school students.',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'year' => 2008,
                'title' => 'Get ready for 6th grade',
                'feature_label' => 'Growth',
                'description' => 'Expanded primary education program to include comprehensive 6th grade preparation.',
                'order' => 3,
                'is_visible' => true,
            ],
            [
                'year' => 2014,
                'title' => 'Internet safety',
                'feature_label' => 'Innovation',
                'description' => 'Launched internet safety program to protect and educate students in the digital age.',
                'order' => 4,
                'is_visible' => true,
            ],
        ];

        foreach ($timeline as $item) {
            HistoryTimeline::firstOrCreate(
                ['year' => $item['year'], 'title' => $item['title']],
                $item
            );
        }

        // Contact Information
        ContactInformation::firstOrCreate(
            ['id' => 1],
            [
                'address' => 'First Floor, 10A Chandos Street London New Town W1G 9LE',
                'phone' => '+44 (0) 207 689 7888',
                'email' => 'user@domainname.com',
                'google_map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d461913.0572571096!2d8.516164543417332!3d50.24088825844987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47bd121b354b47fd%3A0x422435029b0c610!2sOffenbach%2C%20Germany!5e0!3m2!1sen!2sbd!4v1693456840610!5m2!1sen!2sbd',
            ]
        );

        $this->command->info('Website content seeded successfully!');
    }
}
