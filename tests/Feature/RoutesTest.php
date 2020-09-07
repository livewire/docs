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

        collect((new DocumentationPages())->rows)->each(function ($items, $version) {
            collect($items)->filter(function ($page) {
                return is_string($page);
            })->each(function ($page) use ($version) {
                $this->get("/docs/{$version}.x/{$page}")->assertSuccessful();
            });

            collect($items)->filter(function ($pages) {
                return is_array($pages);
            })->each(function ($pages) use ($version) {
                collect($pages)->each(function ($page) use ($version) {
                    $this->get("/docs/{$version}.x/{$page}")->assertSuccessful();
                });
            });
        });

        collect((new DocumentationPages())->rows)->filter(function ($version) {
            return $version === (new DocumentationPages())->newestVersion();
        })->each(function ($items, $version) {
            collect($items)->filter(function ($page) {
                return is_string($page);
            })->each(function ($page) use ($version) {
                $this->get("/docs/{$page}")->assertRedirect("/docs/{$version}.x/{$page}");
            });

            collect($items)->filter(function ($pages) {
                return is_array($pages);
            })->each(function ($pages) use ($version) {
                collect($pages)->each(function ($page) use ($version) {
                    $this->get("/docs/{$page}")->assertRedirect("/docs/{$version}.x/{$page}");
                });
            });
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
