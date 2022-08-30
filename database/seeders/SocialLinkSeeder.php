<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $this->makeFacebook();

        $this->makeInstagram();

        $this->makeTwitter();

        $this->makeYoutube();
    }

    private function makeFacebook(): void
    {
        if (!SocialLink::where('title', 'Facebook')->exists()) {

            SocialLink::create([
                'title'     => 'Facebook',
                'picture'   => '/icons/facebook.svg',
                'url'       => 'https://facebook.com',
                'is_active' => true,
                'priority'  => 0,
            ]);

        }
    }

    private function makeInstagram(): void
    {
        if (!SocialLink::where('title', 'Instagram')->exists()) {

            SocialLink::create([
                'title'     => 'Instagram',
                'picture'   => '/icons/instagram.svg',
                'url'       => 'https://instagram.com',
                'is_active' => true,
                'priority'  => 0,
            ]);

        }
    }

    private function makeTwitter(): void
    {
        if (!SocialLink::where('title', 'Twitter')->exists()) {

            SocialLink::create([
                'title'     => 'Twitter',
                'picture'   => '/icons/twitter.svg',
                'url'       => 'https://twitter.com',
                'is_active' => true,
                'priority'  => 0,
            ]);

        }
    }

    private function makeYoutube(): void
    {
        if (!SocialLink::where('title', 'Youtube')->exists()) {

            SocialLink::create([
                'title'     => 'Youtube',
                'picture'   => '/icons/youtube.svg',
                'url'       => 'https://youtube.com',
                'is_active' => true,
                'priority'  => 0,
            ]);

        }
    }
}