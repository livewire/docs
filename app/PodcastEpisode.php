<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Sushi\Sushi;

class PodcastEpisode extends Model
{
    use Sushi;

    public function getRows()
    {
        return collect($this->fetchEpisodes())->map(function ($ep) {
            $idFromSharingUrl = Str::after($ep['sharing_url'], 'https://simplecast.com/s/');

            return [
                'number' => $ep['number'],
                'filename' => 'ep'.$ep['number'].'-'.Str::slug($ep['title']),
                'title' => $ep['title'],
                'duration_in_minutes' => date('i:s', $ep['duration']),
                'published' => $ep['published'],
                'description' => $ep['description'],
                'long_description' => $ep['long_description'],
                'published_on' => Str::before(Carbon::parse($ep['published_at'])->format('M d, Y'), ', 2019'),
                'sharing_url' => $ep['sharing_url'],
                'iframe_markup' => "<iframe frameborder='0' height='200px' scrolling='no' seamless src='https://embed.simplecast.com/{$idFromSharingUrl}?color=f5f5f5' width='100%'></iframe>"
            ];
        })->filter(function ($ep) {
            return $ep['published'] == true;
        })->toArray();
    }

    public function fetchEpisodes()
    {
        return Cache::remember('podcast_episodes', now()->addHour(), function () {
            return Http::withHeaders(['X-API-KEY' => env('SIMPLECAST_API_KEY')])->get('https://api.simplecast.fm/v1/podcasts/10939/episodes.json')->json();
        });
    }
}
