<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Screencast extends Model
{
    use Sushi;

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

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
            'code_url' => null,
            'duration_in_minutes' => '2:32',
            'series_id' => 1,
            'is_paid' => false,
        ],
        [
            'title' => 'Data Binding',
            'slug' => 'data-binding',
            'description' => <<<EOT
                The first and most important concept to understand when using Livewire is "data binding". It's the backbone of page reactivity in Livewire, and it'll be your first introduction into how Livewire works under the hood. Mandatory viewing.
            EOT,
            'url' => 'https://player.vimeo.com/video/398003880',
            'code_url' => null,
            'duration_in_minutes' => '9:11',
            'series_id' => 1,
            'is_paid' => false,
        ],
        [
            'title' => 'Actions',
            'slug' => 'actions',
            'description' => <<<EOT
                Building off the data-binding concept, "actions" in Livewire (the word we use for component methods) is the final piece of the "reactivity" puzzle. Easily trigger back-end code from front-end actions. No endpoints, no controllers, just plain PHP methods.
            EOT,
            'url' => 'https://player.vimeo.com/video/396766334',
            'code_url' => null,
            'duration_in_minutes' => '4:17',
            'series_id' => 1,
            'is_paid' => false,
        ],
        [
            'title' => 'Lifecycle Hooks',
            'slug' => 'hooks',
            'description' => <<<EOT
                When you interact with a Livewire component, a request undergoes a "lifecycle". Understanding the available lifecycle "hooks" allows you to attach behavior conventiently to different phases of an interaction.
            EOT,
            'url' => 'https://player.vimeo.com/video/396767157',
            'code_url' => null,
            'duration_in_minutes' => '4:43',
            'series_id' => 1,
            'is_paid' => false,
        ],
        [
            'title' => 'Nesting',
            'slug' => 'nesting',
            'description' => <<<EOT
                Like any good "component-based" framework, Livewire components are nestable. However, there are a few important caveats to understand about seperating components into "parents" and "children". We'll cover all the ins and outs in this video.
            EOT,
            'url' => 'https://player.vimeo.com/video/396767274',
            'code_url' => null,
            'duration_in_minutes' => '11:28',
            'series_id' => 1,
            'is_paid' => false,
        ],
        [
            'title' => 'Events',
            'slug' => 'events',
            'description' => <<<EOT
                When it comes to "inter-component" communication, Livewire offers a singular, simple, but powerful pattern: Events. You will learn how to use them to make two or more components talk to each other, or even how they can talk to third-party javascript code.
            EOT,
            'url' => 'https://player.vimeo.com/video/396766827',
            'code_url' => null,
            'duration_in_minutes' => '9:44',
            'series_id' => 1,
            'is_paid' => false,
        ],
        [
            'title' => 'Introduction',
            'slug' => 's1-introduction',
            'description' => <<<EOT
                In this video, we get a glimpse of where we're headed in the series and what it will look like.
            EOT,
            'url' => 'https://player.vimeo.com/video/408128508',
            'code_url' => null,
            'duration_in_minutes' => '1:47',
            'series_id' => 2,
            'is_paid' => false,
        ],
        [
            'title' => 'Setting Up The Component',
            'slug' => 's1-setting-up-the-component',
            'description' => <<<EOT
                In this video, we'll set up our first real Livewire component in "Surge", and learn a few handy tricks along the way to reduce boilerplate and manipulate components more efficiently.
            EOT,
            'url' => 'https://player.vimeo.com/video/408118751',
            'code_url' => 'https://github.com/livewire/surge/commit/7a05a339439586143b1c16d89589b4124b64c236',
            'duration_in_minutes' => '6:43',
            'series_id' => 2,
            'is_paid' => false,
        ],
        [
            'title' => 'Setting Up The Form',
            'slug' => 's1-setting-up-the-form',
            'description' => <<<EOT
                In this video, we scaffold out the HTML for the "Registration Form" and give it it's most basic behavior: Creating a user.
            EOT,
            'url' => 'https://player.vimeo.com/video/408118829',
            'code_url' => 'https://github.com/livewire/surge/commit/d57eac13b8f2a5e2127cb6cdf02255a7f26818be',
            'duration_in_minutes' => '8:47',
            'series_id' => 2,
            'is_paid' => true,
        ],
        [
            'title' => 'Adding Validation',
            'slug' => 's1-adding-validation',
            'description' => <<<EOT
                In this video, we finish out the basic feature with form validation. We'll protect against creating multiple users with the same email address and see what validation looks like inside a Livewire component.
            EOT,
            'url' => 'https://player.vimeo.com/video/408118925',
            'code_url' => 'https://github.com/livewire/surge/commit/c7eab961021796b4722161777255b62b14efbad8',
            'duration_in_minutes' => '7:18',
            'series_id' => 2,
            'is_paid' => true,
        ],
        [
            'title' => 'Writing Tests',
            'slug' => 's1-writing-tests',
            'description' => <<<EOT
                Now that we have the basic behavior nailed down, we'll write automated tests against it. This way, going forward, we can run a test suite quickly and easily and be confident everything works!
            EOT,
            'url' => 'https://player.vimeo.com/video/408119012',
            'code_url' => 'https://github.com/livewire/surge/commit/995c2d462f1e0beff6c99f96bbf3d09917f764d3',
            'duration_in_minutes' => '14:51',
            'series_id' => 2,
            'is_paid' => true,
        ],
        [
            'title' => 'Real-Time Validation (TDD)',
            'slug' => 's1-real-time-validation',
            'description' => <<<EOT
                Thus far, we haven't really seen the full advantages of writing a form like this in Livewire. In this video, we'll look at how easy it is to add dynamic behavior like real-time validation to a component. The work is already done for us!
            EOT,
            'url' => 'https://player.vimeo.com/video/408119216',
            'code_url' => 'https://github.com/livewire/surge/commit/5078b3f8057b48c1398dfd574793ddef01b3aa9a',
            'duration_in_minutes' => '7:02',
            'series_id' => 2,
            'is_paid' => true,
        ],
        [
            'title' => 'Styling With Tailwind UI',
            'slug' => 's1-styling',
            'description' => <<<EOT
                Now that we're happy with the way our component WORKS, let's make it LOOK good. We'll use Tailwind & Tailwind UI to make a fantastic looking interface and review some other stylistic things along the way.
            EOT,
            'url' => 'https://player.vimeo.com/video/408118568',
            'code_url' => 'https://github.com/livewire/surge/commit/64d0007a56e9ad90d0718124a3f2b35dd8537139',
            'duration_in_minutes' => '13:19',
            'series_id' => 2,
            'is_paid' => true,
        ],
        /**
         * Profile Page
         */
        [
            'title' => 'Introduction',
            'slug' => 's2-intro',
            'description' => <<<EOT
                My face talking about all the fun and exciting things we’re going to build in this course. My beard is growing long.
            EOT,
            'url' => 'https://player.vimeo.com/video/413629785',
            'code_url' => '',
            'duration_in_minutes' => '1:01',
            'series_id' => 3,
            'is_paid' => false,
        ],
        [
            'title' => 'TDDing A Profile Form',
            'slug' => 's2-tdding-the-profile-page',
            'description' => <<<EOT
                We’ll kick off the course by TDDing out the Livewire component for the profile page form in the backend. It’s way more fun than it sounds.
            EOT,
            'url' => 'https://player.vimeo.com/video/413628748',
            'code_url' => 'https://github.com/livewire/surge/commit/76873cb17e3b4c9691a8da6912513cf5754be485',
            'duration_in_minutes' => '16:21',
            'series_id' => 3,
            'is_paid' => true,
        ],
        [
            'title' => 'Building The Frontend w/ Tailwind UI',
            'slug' => 's2-building-the-frontend-w-tailwind-ui',
            'description' => <<<EOT
                Now we can take our hard work from the TDD video and bring it to life in the browser using Tailwind UI.
            EOT,
            'url' => 'https://player.vimeo.com/video/413628917',
            'code_url' => 'https://github.com/livewire/surge/commit/dc8e729b731008719ffbae0663f1fce6dce7814e',
            'duration_in_minutes' => '10:16',
            'series_id' => 3,
            'is_paid' => true,
        ],
        [
            'title' => 'Alert Message On Save',
            'slug' => 's2-alert-message',
            'description' => <<<EOT
                We’ll add a Livewire-only “saved” alert that will display when the user clicks the “Save” button. This is a clean, reliable, and simple way to get the job done.
            EOT,
            'url' => 'https://player.vimeo.com/video/413629060',
            'code_url' => 'https://github.com/livewire/surge/commit/dc8e729b731008719ffbae0663f1fce6dce7814e',
            'duration_in_minutes' => '12:04',
            'series_id' => 3,
            'is_paid' => true,
        ],
        [
            'title' => 'Toaster Notification On Save W/ AlpineJS',
            'slug' => 's2-toaster-notifications',
            'description' => <<<EOT
                This is our first encounter with the JavaScript framework “AlpineJS”. We’ll use it to build a toaster notification system that we can use throughout the entire app and trigger from any Livewire component. Fantastic stuff.
            EOT,
            'url' => 'https://player.vimeo.com/video/413629233',
            'code_url' => 'https://github.com/livewire/surge/commit/3bbb942c9eeff5ac1146e6241ac7b16715df69aa',
            'duration_in_minutes' => '17:07',
            'series_id' => 3,
            'is_paid' => true,
        ],
        [
            'title' => 'Inline Message On Save W/ AlpineJS',
            'slug' => 's2-inline-message',
            'description' => <<<EOT
                If a toaster notification is too intrusive for you, in this video, we’ll create a subtle but pretty inline “Saved” message that will fade out after 2.5 seconds. This will be our most hardcore usage of Livewire and Alpine together. Buckle up.
            EOT,
            'url' => 'https://player.vimeo.com/video/413629507',
            'code_url' => 'https://github.com/livewire/surge/commit/67909ffe8055fad15d8764e848739a43ef9041e1',
            'duration_in_minutes' => '19:19',
            'series_id' => 3,
            'is_paid' => true,
        ],
        /**
         * Custom Form Inputs
         */
        [
            'title' => 'Introduction',
            'slug' => 's4-intro',
            'description' => <<<EOT
                This series is all about custom form inputs. Weather you're building them yourself or pulling in a third-party JS lib, you'll have all the tools you need to accomplish this pattern in your own project.
            EOT,
            'url' => 'https://player.vimeo.com/video/419922006',
            'code_url' => '',
            'duration_in_minutes' => '1:01',
            'series_id' => 4,
            'is_paid' => false,
        ],
        [
            'title' => 'Extracting Reusable Blade Components',
            'slug' => 's4-extracting-blade-components',
            'description' => <<<EOT
                Rather than copy and pasting HTML from Tailwind UI everywhere, we're going to extract this shared markup to Blade components. We'll talk all about Blade components and land on a pretty good abstraction we'll be using in the rest of the app.
            EOT,
            'url' => 'https://player.vimeo.com/video/419904257',
            'code_url' => 'https://github.com/livewire/surge/commit/97754b6c6d909de2d84a81c2848bc48ccec74261',
            'duration_in_minutes' => '24:09',
            'series_id' => 4,
            'is_paid' => true,
        ],
        [
            'title' => 'Playing Nice With JavaScript Using wire:ignore',
            'slug' => 's4-wire-ignore',
            'description' => <<<EOT
                Livewire gets confused when foreign JavaScript manipulates the page without letting Livewire know. In general, 90% of problems can be fixed by a simple attribute called "wire:ignore".
            EOT,
            'url' => 'https://player.vimeo.com/video/419904619',
            'code_url' => 'https://github.com/livewire/surge/commit/c0381278cbaf28cb1d8f7582bcc739e8b4e2683b',
            'duration_in_minutes' => '07:20',
            'series_id' => 4,
            'is_paid' => true,
        ],
        [
            'title' => 'Diggin Deep Into wire:model',
            'slug' => 's4-wire-model',
            'description' => <<<EOT
                "wire:model" is one of the most useful directives in Livewire. In this video we are going to open it up and understand how it works so that we can use it and abuse it ourselves.
            EOT,
            'url' => 'https://player.vimeo.com/video/419904727',
            'code_url' => '',
            'duration_in_minutes' => '08:52',
            'series_id' => 4,
            'is_paid' => true,
        ],
        [
            'title' => 'Using A Date-Picker: Pikaday',
            'slug' => 's4-date-picker',
            'description' => <<<EOT
                Date-pickers are one of the most common custom-input types needed in a project. This episode is all about how to integrate with them, particularly Pikaday.
            EOT,
            'url' => 'https://player.vimeo.com/video/419904844',
            'code_url' => 'https://github.com/livewire/surge/commit/636d7b2927352326f1c7a58e5b6116d464d76b78',
            'duration_in_minutes' => '22:21',
            'series_id' => 4,
            'is_paid' => true,
        ],
        [
            'title' => 'Using A Rich-Text Editor: Trix',
            'slug' => 's4-rich-text',
            'description' => <<<EOT
                This video is all about integrating with the popular rich-text editor Trix. The same principles apply to other libraries as well.
            EOT,
            'url' => 'https://player.vimeo.com/video/419905177',
            'code_url' => 'https://github.com/livewire/surge/commit/ce6cf4e313b80edca551649e1584fed9187f9cca',
            'duration_in_minutes' => '13:49',
            'series_id' => 4,
            'is_paid' => true,
        ],
        /**
         * File Uploads
         */
        [
            'title' => 'Introduction',
            'slug' => 's5-intro',
            'description' => <<<EOT
                This series is ALL about file uploads. Handling file uploads well is a notoriously tedius process. Livewire makes it MUCH easier.
            EOT,
            'url' => 'https://player.vimeo.com/video/427511470',
            'code_url' => '',
            'duration_in_minutes' => '1:47',
            'series_id' => 5,
            'is_paid' => false,
        ],
        [
            'title' => 'Setting Up Gravatar',
            'slug' => 's5-gravatar',
            'description' => <<<EOT
                Before we add the ability to upload avatars, we should start with implementing sensible default avatars with a handy service called "Gravatar".
            EOT,
            'url' => 'https://player.vimeo.com/video/427510271',
            'code_url' => 'https://github.com/livewire/surge/commit/9c9903f63c69a9e5bbfa5f1fea2d9518053dc536',
            'duration_in_minutes' => '4:11',
            'series_id' => 5,
            'is_paid' => false,
        ],
        [
            'title' => 'Configuring Filesystem Disks',
            'slug' => 's5-filesystem-disks',
            'description' => <<<EOT
                Lets talk about what we're going to do with the uploaded files users submit. Where will we store them? What will we put in the database field? And other important questions.
            EOT,
            'url' => 'https://player.vimeo.com/video/427510314',
            'code_url' => 'https://github.com/livewire/surge/commit/56fe685dc87d728cac2c6291733ee699c67f4a1f',
            'duration_in_minutes' => '11:32',
            'series_id' => 5,
            'is_paid' => false,
        ],
        [
            'title' => 'A Basic Avatar Upload',
            'slug' => 's5-avatar-upload',
            'description' => <<<EOT
                Let's look at the simplest possible user avatar upload feature in Livewire. While we're at it, we'll go over what's happening under the hood so we have a foundation for understanding future concerns.
            EOT,
            'url' => 'https://player.vimeo.com/video/427510465',
            'code_url' => 'https://github.com/livewire/surge/commit/7b8772f24d67cb215e6de3c2ec4eb17de44480f7',
            'duration_in_minutes' => '14:44',
            'series_id' => 5,
            'is_paid' => true,
        ],
        [
            'title' => 'Testing File Uploads',
            'slug' => 's5-testing-uploads',
            'description' => <<<EOT
                Laravel makes testing file uplaods easy. Livewire builds on Laravel's existing techniques and makes the experience natural and easy.
            EOT,
            'url' => 'https://player.vimeo.com/video/427510643',
            'code_url' => 'https://github.com/livewire/surge/commit/06e8381d69ce08b43847d0951d2a427c2f2a6d48',
            'duration_in_minutes' => '5:12',
            'series_id' => 5,
            'is_paid' => true,
        ],
        [
            'title' => 'Showing Upload Previews',
            'slug' => 's5-upload-previews',
            'description' => <<<EOT
                It's helpful to show users a preview of a file that has just been selected before it is "saved" with a form submission. Livewire offers simple tools for exposing public-facing, secure URLs to your users to preview their upload.
            EOT,
            'url' => 'https://player.vimeo.com/video/427510769',
            'code_url' => 'https://github.com/livewire/surge/commit/0cc2024ae6aacb04afb6f1253d7e7820f909071d',
            'duration_in_minutes' => '5:08',
            'series_id' => 5,
            'is_paid' => true,
        ],
        [
            'title' => 'Uploading Directly To S3',
            'slug' => 's5-s3-uploads',
            'description' => <<<EOT
                Livewire offers the ability to use an S3-based filesystem to store it's temporary uploads. Let's look at what it takes to enable S3 uploads and upload files without ever touching your actual Laravel server.
            EOT,
            'url' => 'https://player.vimeo.com/video/427510841',
            'code_url' => 'https://github.com/livewire/surge/commit/0cc2024ae6aacb04afb6f1253d7e7820f909071d',
            'duration_in_minutes' => '11:35',
            'series_id' => 5,
            'is_paid' => true,
        ],
        [
            'title' => 'Handling Multiple File Uploads',
            'slug' => 's5-handling-multiple-uploads',
            'description' => <<<EOT
                Let's look at handling multiple file uploads at once using Livewire's file-upload system.
            EOT,
            'url' => 'https://player.vimeo.com/video/427510970',
            'code_url' => 'https://github.com/livewire/surge/commit/adf0710339f8e7e8ca8af652cc6b1a2f6dcd93a1',
            'duration_in_minutes' => '2:44',
            'series_id' => 5,
            'is_paid' => true,
        ],
        [
            'title' => 'Making File Inputs Look Good',
            'slug' => 's5-styling-file-inputs',
            'description' => <<<EOT
                The browser defaults for styling file inputs are ugly. Let's see if we can make things look prettier, but remain accessible. Alpine makes this easy.
            EOT,
            'url' => 'https://player.vimeo.com/video/427511024',
            'code_url' => 'https://github.com/livewire/surge/commit/2c48a6b6fabdec8cc713f5ac75330a2a6494f0ad',
            'duration_in_minutes' => '14:47',
            'series_id' => 5,
            'is_paid' => true,
        ],
        [
            'title' => 'Integrating With Filepond',
            'slug' => 's5-integrating-with-filepond',
            'description' => <<<EOT
                Filepond is a fantastic library for handling file-uploads on the front-end in JavaScript. In this episode we're going to look at the best way to integrate Livewire's file-upload system with Filepond. The result will be a seamless filepond blade component.
            EOT,
            'url' => 'https://player.vimeo.com/video/427511231',
            'code_url' => 'https://github.com/livewire/surge/commit/162523b7a9f81728f79b92e8c91584ed6ba9fcca',
            'duration_in_minutes' => '21:03',
            'series_id' => 5,
            'is_paid' => true,
        ],

        /**
         * V2 Upgrade
         */
        [
            'title' => 'Upgrade To V2',
            'slug' => 's6-upgrade-to-v2',
            'description' => <<<EOT
                We upgrade the Surge application from V1 to V2 and fix the little breaking changes. There's really not much, but it's worth knowing about them.
            EOT,
            'url' => 'https://player.vimeo.com/video/459037288',
            'code_url' => 'https://github.com/livewire/surge/commit/178796efdd455546d6dc7274175c76af31fcf4d0',
            'duration_in_minutes' => '13:20',
            'series_id' => 6,
            'is_paid' => false,
        ],
        [
            'title' => 'Refactoring Validation To $rules',
            'slug' => 's6-refactor-validation',
            'description' => <<<EOT
                We'll refactor the validation in Surge to use the new \$rules property and clean up other small areas of re-use.
            EOT,
            'url' => 'https://player.vimeo.com/video/459037421',
            'code_url' => 'https://github.com/livewire/surge/commit/e0429e361ad54f841649a9546db355abb4060724',
            'duration_in_minutes' => '6:17',
            'series_id' => 6,
            'is_paid' => false,
        ],
        [
            'title' => 'Binding Directly To Model Properties',
            'slug' => 's6-bind-to-models',
            'description' => <<<EOT
                In V2 you can wire:model bind directly to eloquent model properties. This opens up new potential and cleans up our components even more. Check it out.
            EOT,
            'url' => 'https://player.vimeo.com/video/459037466',
            'code_url' => 'https://github.com/livewire/surge/commit/e0429e361ad54f841649a9546db355abb4060724',
            'duration_in_minutes' => '7:43',
            'series_id' => 6,
            'is_paid' => false,
        ],
        [
            'title' => 'Refactor Pikaday & Trix to @entangle',
            'slug' => 's6-refactor-pikaday-trix',
            'description' => <<<EOT
                We're going to go deep in this video and refactor our previous Blade components for date picking and rich text editing to use the new @@entangle syntax. It's extremely powerful, but requires a bit of refactoring first.
            EOT,
            'url' => 'https://player.vimeo.com/video/459037463',
            'code_url' => 'https://github.com/livewire/surge/commit/a22e025ce314607ac10a7ed5717023f386fd08a8',
            'duration_in_minutes' => '27:58',
            'series_id' => 6,
            'is_paid' => false,
        ],

        /**
         * Data Tables
         */
        [
            'title' => 'Intro',
            'slug' => 's7-intro',
            'description' => <<<EOT
                This is not your average Surge screencast series. We are going to start simple, then go DEEP on data tables. As deep as we possibly can. We'll come out on the other side with some impressive functionality, but having written NO JavaScript.
            EOT,
            'url' => 'https://player.vimeo.com/video/466587467',
            'code_url' => '',
            'duration_in_minutes' => '2:16',
            'series_id' => 7,
            'is_paid' => false,
        ],
        [
            'title' => 'A Simple Table',
            'slug' => 's7-simple-table',
            'description' => <<<EOT
                Let's build a simple, static table of data as a starting point. This will establish a foundation and we'll ramp up from here.
            EOT,
            'url' => 'https://player.vimeo.com/video/466345629',
            'code_url' => 'https://github.com/livewire/surge/commit/a520a978122fed2c6501001db70288d240001b2b',
            'duration_in_minutes' => '16:13',
            'series_id' => 7,
            'is_paid' => false,
        ],
        [
            'title' => 'Pagination',
            'slug' => 's7-pagination',
            'description' => <<<EOT
                Let's add pagination to our simple data table. Livewire builds on Laravel's awesome pagination system so this will be cake.
            EOT,
            'url' => 'https://player.vimeo.com/video/466345719',
            'code_url' => 'https://github.com/livewire/surge/commit/1a5c95ec69687b1dadbcb342eb71e077cd0f429c',
            'duration_in_minutes' => '3:06',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Basic Search',
            'slug' => 's7-search',
            'description' => <<<EOT
                Let's add a basic search box that users can type into to filter data results in real-time.
            EOT,
            'url' => 'https://player.vimeo.com/video/466345708',
            'code_url' => 'https://github.com/livewire/surge/commit/e5367b864f205b91979c4509077f87b4ac3b0b80',
            'duration_in_minutes' => '11:02',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Basic Sorting',
            'slug' => 's7-sorting',
            'description' => <<<EOT
                Let's add sorting to our column headings. We'll make it simple for users to sort by "title", "amount", etc...
            EOT,
            'url' => 'https://player.vimeo.com/video/466345858',
            'code_url' => 'https://github.com/livewire/surge/commit/221688077e89c7b45c4a109f26e50995a8867f8d',
            'duration_in_minutes' => '9:06',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Edit Modal',
            'slug' => 's7-edit-modal',
            'description' => <<<EOT
                This is where things are going to start to ramp up. In this episode, we're going to add the ability to edit any given row inside a modal. This modal will be shared so we don't have 10 modals loaded on a page at the same time.
            EOT,
            'url' => 'https://player.vimeo.com/video/466345879',
            'code_url' => 'https://github.com/livewire/surge/commit/09daaee9bb8bca366c154bc9b5b839587c42c27d',
            'duration_in_minutes' => '28:38',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Create Modal',
            'slug' => 's7-create-modal',
            'description' => <<<EOT
                Because of certain design choices in Livewire adding a "Create Modal" in addition to the edit modal we just built will be incredibly simple and fun.
            EOT,
            'url' => 'https://player.vimeo.com/video/466345988',
            'code_url' => 'https://github.com/livewire/surge/commit/550b87faad1aa933cc6433dcf76e7329a4c0aebb',
            'duration_in_minutes' => '8:02',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Advanced Search',
            'slug' => 's7-advanced-search',
            'description' => <<<EOT
                We already implimented a basic search input for our table. Let's expand on that functionality with an expandible "Advanced Search" section above the table that gives users fine-tuned control over how to filter their results.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346034',
            'code_url' => 'https://github.com/livewire/surge/commit/4830232d734d5b0f6a77a26b0dd79a497c545f8c',
            'duration_in_minutes' => '26:56',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Bulk Export/Delete',
            'slug' => 's7-bulk-actions',
            'description' => <<<EOT
                In this cast, we're going to add checkboxes to our table and allow users to easily delete and export specific records from the table.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346201',
            'code_url' => 'https://github.com/livewire/surge/commit/80fa7bd4f07f505e7a71f6aad690e2afd4388638',
            'duration_in_minutes' => '11:10',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Select-All Checkboxes',
            'slug' => 's7-select-all',
            'description' => <<<EOT
                Now that we have basic "Bulk Actions" implemented. Let's make it more robust by adding a "select all" checkbox that is capable of selecting all the results on a page, but ALSO the entire data-set across all pages.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346211',
            'code_url' => 'https://github.com/livewire/surge/commit/41d2e52fe59cfb279a9400f63bd14c422b6b28a8',
            'duration_in_minutes' => '34:53',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Refactoring For Re-Usability',
            'slug' => 's7-refactoring',
            'description' => <<<EOT
                Along the way, our little data table has turned into something quite robust and increasingly complex. Let's take a break and refactor some of the functionality out into traits that can be used across your application in other data tables.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346355',
            'code_url' => 'https://github.com/livewire/surge/commit/8796c5a39fa7f200dc18c06c69bb1994893858a6',
            'duration_in_minutes' => '20:58',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Multi-Column Sorting',
            'slug' => 's7-multi-column-sorting',
            'description' => <<<EOT
                We added basic column sorting before, but often that's not enough. In this cast we're going to add the ability to sort by multiple columns at the same time and properly order their queries for the expected results.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346514',
            'code_url' => 'https://github.com/livewire/surge/commit/3d115e3c87b01c1ab6aac868b733b300a51f52fc',
            'duration_in_minutes' => '13:01',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Configuring Per-Page Results',
            'slug' => 's7-configuring-per-page',
            'description' => <<<EOT
                We've already added pagination to this table, but often users like to configure how many results to show on a given page. We're going to add that ability, and also make set that configuration for the entire user's session.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346555',
            'code_url' => 'https://github.com/livewire/surge/commit/70de85eeedec7ad7eeb28f5f27b33d9b440f904f',
            'duration_in_minutes' => '8:02',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Importing From CSVs',
            'slug' => 's7-csv-import',
            'description' => <<<EOT
                In this case we're going to add a system to import records into the table from a CSV. We're not going to stop at a contrived demo though. We'll go the extra mile and allow the user to configure what columns in their CSV should map to which fields in the data table.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346606',
            'code_url' => 'https://github.com/livewire/surge/commit/e5759e1c16a31ed72156bc89f0553ba1cdf770e2',
            'duration_in_minutes' => '30:57',
            'series_id' => 7,
            'is_paid' => true,
        ],
        [
            'title' => 'Making Everything Fast: Caching Rusults',
            'slug' => 's7-caching',
            'description' => <<<EOT
                Phew, we've come a long way. Our data table is extremely robust and our users are happy. However, there's ONE last touch up. Let's make sure we're only calling on the database when we need to, so that we don't slow down other interactions on the page.
            EOT,
            'url' => 'https://player.vimeo.com/video/466346694',
            'code_url' => 'https://github.com/livewire/surge/commit/19272827010c86695ea77c25b198af7cb0d58510',
            'duration_in_minutes' => '16:51',
            'series_id' => 7,
            'is_paid' => true,
        ],
    ];
}
