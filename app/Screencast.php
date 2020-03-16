<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Screencast extends Model
{
    use Sushi;

    public function getNextAttribute()
    {
        return static::find($this->id + 1);
    }

    public function getPrevAttribute()
    {
        return static::find($this->id - 1);
    }

    protected $rows = [
        [
            'title' => 'Installation',
            'slug' => 'installation',
            'description' => <<<EOT
                Installing Livewire is so simple, this 2.5 minute video feels like overkill. Composer require, and two little lines added to your layout file, and you are fully set up and ready to rumble!
            EOT,
            'url' => 'https://player.vimeo.com/video/396617270',
            'duration_in_minutes' => '2:32',
        ],
        [
            'title' => 'Data Binding',
            'slug' => 'data-binding',
            'description' => <<<EOT
                The first and most important concept to understand when using Livewire is "data binding". It's the backbone of page reactivity in Livewire, and it'll be your first introduction into how Livewire works under the hood. Mandatory viewing.
            EOT,
            'url' => 'https://player.vimeo.com/video/398003880',
            'duration_in_minutes' => '9:11',
        ],
        [
            'title' => 'Actions',
            'slug' => 'actions',
            'description' => <<<EOT
                Building off the data-binding concept, "actions" in Livewire (the word we use for component methods) is the final piece of the "reactivity" puzzle. Easily trigger back-end code from front-end actions. No endpoints, no controllers, just plain PHP methods.
            EOT,
            'url' => 'https://player.vimeo.com/video/396766334',
            'duration_in_minutes' => '4:17',
        ],
        [
            'title' => 'Lifecycle Hooks',
            'slug' => 'hooks',
            'description' => <<<EOT
                When you interact with a Livewire component, a request undergoes a "lifecycle". Understanding the available lifecycle "hooks" allows you to attach behavior conventiently to different phases of an interaction.
            EOT,
            'url' => 'https://player.vimeo.com/video/396767157',
            'duration_in_minutes' => '4:43',
        ],
        [
            'title' => 'Nesting',
            'slug' => 'nesting',
            'description' => <<<EOT
                Like any good "component-based" framework, Livewire components are nestable. However, there are a few important caveats to understand about seperating components into "parents" and "children". We'll cover all the ins and outs in this video.
            EOT,
            'url' => 'https://player.vimeo.com/video/396767274',
            'duration_in_minutes' => '11:28',
        ],
        [
            'title' => 'Events',
            'slug' => 'events',
            'description' => <<<EOT
                When it comes to "inter-component" communication, Livewire offers a singular, simple, but powerful pattern: Events. You will learn how to use them to make two or more components talk to each other, or even how they can talk to third-party javascript code.
            EOT,
            'url' => 'https://player.vimeo.com/video/396766827',
            'duration_in_minutes' => '9:44',
        ],
    ];
}
