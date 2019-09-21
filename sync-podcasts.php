<?php

require './vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


$episodes = collect($simplecast->podcastEpisodes([
    'podcast_id' => 10939, // Id for "Building Livewire".
]))->sortBy('number');

$episodes->each(function ($episode) {
    $path = __DIR__ . '/source/_podcasts'
    \Illuminate\Support\Facades\File::put($path, $contents);
    dd($episode);
});
