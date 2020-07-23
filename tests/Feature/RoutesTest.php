<?php

namespace Tests\Feature;

use App\DocumentationPages;
use App\PodcastEpisode;
use App\Screencast;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /** @test */
    function hit_pages_and_make_sure_nothing_breaks()
    {
        // Home Page
        $this->get('/')->assertSuccessful();

        // Screencasts
        $this->followingRedirects()->get('/screencasts')->assertSuccessful();
        Screencast::all()->each(function ($screencast) {
            $this->get('/screencasts/'.$screencast->slug)->assertSuccessful();
        });

        // Docs
        $this->withoutExceptionHandling()->followingRedirects()->get('/docs')->assertSuccessful();

        collect((new DocumentationPages(''))->all())->flatten()->each(function ($slug) {
            $this->get('/docs/'.$slug)->assertSuccessful();
        });

        if (env('SIMPLECAST_API_KEY')) {
            // Podcasts
            $this->get('/podcast')->assertSuccessful();
            PodcastEpisode::all()->each(function ($podcast) {
                $this->get('/podcasts/'.$podcast->filename)->assertSuccessful();
            });
        }
    }
}
