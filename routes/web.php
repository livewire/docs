<?php

use App\User;
use App\Screencast;
use App\PodcastEpisode;
use Michelf\MarkdownExtra;
use App\DocumentationPages;
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
    \Illuminate\Support\Facades\Cache::forget('sponsors');
    $gitHubUser = Socialite::driver('github')->user();

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

// Documentation.
Route::redirect('/docs', '/docs/quickstart');
Route::get('/docs/{page}', function ($slug) {
    if (! file_exists($path = resource_path('views/docs/'.$slug.'.blade.php'))) {
        abort(404);
    }

    $pages = new DocumentationPages($slug);
    $content = MarkdownExtra::defaultTransform(
        View::file($path)->render()
    );

    return view('docs', [
        'title' => $pages->title(),
        'slug' => $slug,
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
    $screencast = Screencast::whereSlug($slug)->first();

    return view('show-screencast', [
        'title' => $screencast->title . ' | Livewire Screencasts',
        'screencasts' => Screencast::all(),
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
