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
            ['text' => 'Creating World Changers'],
            [
                'image' => null, // Will be uploaded via admin
                'text' => 'Creating World Changers',
                'button_text' => 'Learn More',
                'button_link' => '/about',
                'order' => 1,
                'is_visible' => true,
            ]
        );

        // About Section
        HomepageSection::firstOrCreate(
            ['section_type' => 'about'],
            [
                'section_type' => 'about',
                'title' => 'About Our School',
                'heading' => 'Creating World Changers',
                'paragraph' => 'We nurture children through quality education and holistic development.',
                'button_text' => 'Read More',
                'button_link' => '/about',
                'background_image' => null,
                'icon' => null,
                'images' => null, // 4 images to be uploaded via admin
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
                'background_image' => null,
                'title' => 'Our Schedule',
                'icon' => 'clock',
                'paragraph' => 'Flexible session times to accommodate your needs.',
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
                'time_range' => '10.30am – 12.00pm',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'background_image' => null,
                'title' => null,
                'icon' => null,
                'paragraph' => null,
                'label' => 'Lunch',
                'time_range' => '12.00pm – 1.00pm',
                'order' => 3,
                'is_visible' => true,
            ],
            [
                'background_image' => null,
                'title' => null,
                'icon' => null,
                'paragraph' => null,
                'label' => 'Afternoon',
                'time_range' => '2.00pm – 4.00pm',
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
                'title' => 'Guide to Preschool',
                'heading' => 'Frequently Asked Questions',
                'question' => 'What age groups do you accept?',
                'answer' => 'We accept children from Daycare through Grade 6, including PP1 and PP2.',
                'order' => 1,
                'is_visible' => true,
            ],
            [
                'title' => null,
                'heading' => null,
                'question' => 'What are your operating hours?',
                'answer' => 'We offer flexible session times: Early Drop Off (8.00am – 10.00am), Morning (10.30am – 12.00pm), Lunch (12.00pm – 1.00pm), and Afternoon (2.00pm – 4.00pm).',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'title' => null,
                'heading' => null,
                'question' => 'Do you provide meals?',
                'answer' => 'Yes, we provide healthy and nutritious meals prepared with care for all our students.',
                'order' => 3,
                'is_visible' => true,
            ],
            [
                'title' => null,
                'heading' => null,
                'question' => 'What safety measures are in place?',
                'answer' => 'We maintain a secure environment with comprehensive safety protocols and trained staff.',
                'order' => 4,
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
            ['page_key' => 'about', 'title' => 'About Us', 'paragraph' => 'Learn more about our school'],
            ['page_key' => 'classes', 'title' => 'Our Classes', 'paragraph' => 'Explore our grade levels'],
            ['page_key' => 'gallery', 'title' => 'Gallery', 'paragraph' => 'View our school activities'],
            ['page_key' => 'contact', 'title' => 'Contact Us', 'paragraph' => 'Get in touch with us'],
        ];

        foreach ($breadcrumbs as $breadcrumb) {
            Breadcrumb::firstOrCreate(
                ['page_key' => $breadcrumb['page_key']],
                array_merge($breadcrumb, ['background_image' => null])
            );
        }

        // About Page Content
        AboutPageContent::firstOrCreate(
            ['section_type' => 'about_school'],
            [
                'section_type' => 'about_school',
                'image' => null,
                'title' => 'About Sir Isaac Newton School',
                'paragraph' => 'We are committed to providing quality education and holistic development for every child.',
                'name' => null,
                'description' => null,
                'order' => 0,
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
                'address' => null, // To be filled via admin
                'phone' => null, // To be filled via admin
                'email' => null, // To be filled via admin
                'google_map_embed_url' => null, // To be filled via admin
            ]
        );

        $this->command->info('Website content seeded successfully!');
    }
}
