<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class Sponsor extends Model
{
    use Sushi;

    protected $keyType = 'string';

    public function user()
    {
         return $this->hasOne(User::class, 'github_username', 'username');
    }

    public function getRows()
    {
        return Cache::remember('sponsors', now()->addHour(), function () {
            return collect($this->fetchRawSponsors())
                ->filter(function ($sponsor) {
                    return !! $sponsor['sponsor'];
                })
                ->map(function ($sponsor) {
                    return [
                        'id' => $sponsor['sponsor']['id'],
                        'tier_id' => $sponsor['tier']['id'],
                        'tier_name' => $sponsor['tier']['name'],
                        'tier_description' => $sponsor['tier']['descriptionHTML'],
                        'tier_price' => $sponsor['tier']['monthlyPriceInDollars'],
                        'tier_price_in_cents' => $sponsor['tier']['monthlyPriceInCents'],
                        'username' => $sponsor['sponsor']['login'],
                        'name' => $sponsor['sponsor']['name'],
                        'email' => $sponsor['sponsor']['email'],
                        'avatar' => $sponsor['sponsor']['avatarUrl'],
                        'location' => $sponsor['sponsor']['location'],
                        'website' => $sponsor['sponsor']['websiteUrl'],
                        'created_at' => $sponsor['createdAt'],
                        'url' => $sponsor['sponsor']['url'],
                    ];
                })
                ->toArray();
        });
    }

    public function fetchRawSponsors($runningSponsors = [], $afterCursor = null) {
        $afterCursor = json_encode($afterCursor);
        $response = Http::withToken(
            env('GITHUB_TOKEN')
        )->post('https://api.github.com/graphql', [
            'query' => <<<EOT
            {
                viewer {
                  sponsorshipsAsMaintainer(after: {$afterCursor}, first: 50, includePrivate: true) {
                    nodes {
                      id
                      tier {
                        id
                        descriptionHTML
                        monthlyPriceInDollars
                        monthlyPriceInCents
                        name
                      }
                      sponsorEntity {
                        ... on Organization {
                            avatarUrl
                            email
                            id
                            login
                            name
                            url
                            location
                            websiteUrl
                        }
                        ... on User {
                            avatarUrl
                            email
                            id
                            login
                            name
                            url
                            location
                            websiteUrl
                        }
                      }
                      createdAt
                    }
                    totalCount
                    pageInfo {
                      hasNextPage
                      endCursor
                    }
                  }
                }
              }
    EOT,
        ]);

        $sponsors = $response['data']['viewer']['sponsorshipsAsMaintainer']['nodes'];
        $hasNextPage = $response['data']['viewer']['sponsorshipsAsMaintainer']['pageInfo']['hasNextPage'];
        $endCursor = $response['data']['viewer']['sponsorshipsAsMaintainer']['pageInfo']['endCursor'];

        $allSponsors = array_merge($runningSponsors, $sponsors);

        if (! $hasNextPage) {
            return $allSponsors;
        }

        return $this->fetchRawSponsors($allSponsors, $endCursor);
    }
}
