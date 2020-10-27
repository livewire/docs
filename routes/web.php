<?php

use App\User;
use App\Series;
use App\Screencast;
use App\PodcastEpisode;
use Michelf\MarkdownExtra;
use App\DocumentationPages;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// Algolia Docsearch API Details.
View::share('docsearchApiKey', env('DOCSEARCH_API_KEY'));
View::share('docsearchIndexName', env('DOCSEARCH_INDEX'));

// Home Page.
Route::get('/', function () {
    return view('home', [
        'title' => 'Livewire',
    ]);
});

Route::get('login/github', function () {
    session()->put('before-github-redirect', url()->previous());

    return Socialite::driver('github')->redirect();
});

Route::get('login/github/callback', function () {
    $gitHubUser = Socialite::driver('github')->stateless()->user();

    $user = User::firstOrCreate([
        'github_id' => $gitHubUser->id,
    ], [
        'github_username' => $gitHubUser->nickname,
        'name' => $gitHubUser->name,
        'email' => $gitHubUser->email,
        'avatar' => $gitHubUser->avatar,
    ]);

    auth()->login($user);

    return redirect()->to(session('before-github-redirect', '/screencasts/installation'));
});

Route::post('/sponsors/refresh', function () {
    \Illuminate\Support\Facades\Cache::forget('sponsors');

    return response(200);
});

// Documentation.
Route::redirect('/docs', '/docs/quickstart');
Route::get('/docs/{pageSlug}', function ($pageSlug) {
    $newestVersion = (new DocumentationPages())->newestVersion();

    if (! file_exists($path = resource_path("views/docs/{$newestVersion}/{$pageSlug}.blade.php"))) {
        return redirect("/docs/{$newestVersion}.x/quickstart");
    }

    return redirect("/docs/{$newestVersion}.x/{$pageSlug}");
});
Route::get('/docs/{versionSlug}/{pageSlug}', function ($versionSlug, $pageSlug) {
    $version = Str::before($versionSlug, '.');

    if (! file_exists($path = resource_path("views/docs/{$version}/{$pageSlug}.blade.php"))) {
        return redirect("/docs/{$versionSlug}/quickstart");
    }

    $pages = new DocumentationPages($pageSlug, $version);
    $content = MarkdownExtra::defaultTransform(
        View::file($path)->render()
    );

    return view('docs', [
        // Temoporary V2 twitter card to celebrate V2.
        'social_size' => ($versionSlug === '2.x' && $pageSlug === 'upgrading') ? 'summary_large_image' : 'summary',
        'social_image' => ($versionSlug === '2.x' && $pageSlug === 'upgrading') ? 'https://laravel-livewire.com/img/twitter-card2.jpg' : 'https://laravel-livewire.com/img/twitter.png',
        'title' => $pages->title(),
        'slug' => $pageSlug,
        'versionSlug' => $versionSlug,
        'pages' => $pages,
        'content' => $content,
    ]);
});

// Screencast Index.
Route::get('/screencasts', function () {
    return redirect()->to('/screencasts/'.Screencast::first()->slug);
});

// Show Screencast.
Route::get('/screencasts/{slug}', function ($slug) {
    $screencast = Screencast::whereSlug($slug)->firstOrFail();

    $progresses = auth()->check() ? auth()->user()->screencastProgresses()
        ->toBase()
        ->select(['screencast_id', 'last_known_timestamp_in_seconds', 'completed_at'])
        ->get()
        : collect();

    $series = Series::with('screencasts')->get()->map(function ($series) use ($progresses) {
        $series->screencasts = $series->screencasts->map(function ($screencast) use ($progresses) {
            if ($progress = $progresses->firstWhere('screencast_id', $screencast->id)) {
                $screencast->completed_at = $progress->completed_at;
                $screencast->last_known_timestamp_in_seconds = $progress->last_known_timestamp_in_seconds;
                $screencast->percent_complete = $screencast->last_known_timestamp_in_seconds / $screencast->duration_in_seconds * 100;
            }

            return $screencast;
        });
        return $series;
    });

    return view('show-screencast', [
        'title' => $screencast->title . ' | Livewire Screencasts',
        'series' => $series,
        'screencast' => $screencast,
        'social_image' => 'https://laravel-livewire.com/img/screencast-head.png',
    ]);
});

// Podcast Index.
Route::get('/podcast', function () {
    return view('podcast', [
        'title' => 'Building Livewire Podcast',
        'social_image' => 'https://laravel-livewire.com/img/podcast-artwork.png',
        'description' => 'Follow along on the Livewire journey. We\'ll talk about where the project came from, where it\'s going, and all the fun problems to solve along the way!',
        'podcasts' => PodcastEpisode::all(),
    ]);
});

// Show Podcast Show.
Route::get('/podcasts/{slug}', function ($slug) {
    $podcast = PodcastEpisode::whereFilename($slug)->first();

    return view('show-podcast', [
        'title' => $podcast->title . ' | Building Livewire Podcast',
        'social_image' => 'https://laravel-livewire.com/img/podcast-artwork.png',
        'description' => 'Follow along on the Livewire journey. We\'ll talk about where the project came from, where it\'s going, and all the fun problems to solve along the way!',
        'podcast' => $podcast,
    ]);
});
