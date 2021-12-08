At Livewire we appreciate and welcome all contributions!

If that's something you would be interested in doing, we recommend going through this contribution guide first before starting.

* [Setup Livewire locally](#setup-livewire-locally) { .text-blue-800 }
    * [Fork Livewire](#fork-livewire) { .font-normal.text-sm.text-blue-800 }
    * [Git clone your fork locally](#clone-fork) { .font-normal.text-sm.text-blue-800 }
    * [Install dependencies](#install-dependencies) { .font-normal.text-sm.text-blue-800 }
    * [Configure dusk](#configure-dusk) { .font-normal.text-sm.text-blue-800 }
    * [Run tests](#setup-run-tests) { .font-normal.text-sm.text-blue-800 }
* [Bug fix/ feature development](#bug-fix-feature-development) { .text-blue-800 }
    * [Create a branch](#create-a-branch) { .font-normal.text-sm.text-blue-800 }
    * [Add failing tests](#add-failing-tests) { .font-normal.text-sm.text-blue-800 }
    * [Add working code](#add-working-code) { .font-normal.text-sm.text-blue-800 }
    * [Run tests](#development-run-tests) { .font-normal.text-sm.text-blue-800 }
    * [Submit PR](#submit-pr) { .font-normal.text-sm.text-blue-800 }
    * [Thanks for contributing! 🙌](#thanks) { .font-normal.text-sm.text-blue-800 }


## Setup Livewire locally {#setup-livewire-locally}

The first step is to create a fork of Livewire and set it up locally. You should only need to do this the first time.

### Fork Livewire {#fork-livewire}

Go to [the Livewire repository on GitHub](https://github.com/livewire/livewire) and fork the Livewire repository.

![Fork Livewire on GitHub](/img/docs/github-fork.png) {.border}

### Git clone your fork locally {#clone-fork}

Browse to your fork on GitHub, and click on the "code" button, and copy the provided URL.

![Clone Livewire on GitHub](/img/docs/github-clone.png) {.border}

Then in your local terminal run `git clone` and pass it your URL and the directory name you want Livewire cloned into.

@component('components.code', ['lang' => 'shell'])
git clone git@github.com:username/livewire.git ~/packages/livewire
@endcomponent

Once finished, `cd` into your local Livewire directory.

@component('components.code', ['lang' => 'shell'])
cd ~/packages/livewire
@endcomponent

### Install dependencies {#install-dependencies}

Install composer dependencies by running:

@component('components.code', ['lang' => 'shell'])
composer install
@endcomponent

Install npm dependencies by running:

@component('components.code', ['lang' => 'shell'])
npm install
@endcomponent

### Configure dusk {#configure-dusk}

A lot of Livewire's tests make use of `orchestral/testbench-dusk` which runs browser tests in Google Chrome (so you will need Chrome to be installed).

To get `orchestral/testbench-dusk` to run, you need to install the latest chrome driver by running:

@component('components.code', ['lang' => 'shell'])
./vendor/bin/dusk-updater detect --auto-update
@endcomponent

### Run tests {#setup-run-tests}

Once everything is configured, run all tests to make sure everything is working and passing.

To do this, run `phpunit` and confirm everything is running ok.

@component('components.code', ['lang' => 'shell'])
phpunit
@endcomponent

If the dusk tests don't run and you get an error, make sure you have run the command in the [Configure dusk](#configure-dusk) section above.

If you still get an error, the first time you try to run dusk tests, you may also need to close any Google Chrome instances you may have open and try running the tests again. After that, you should be able to leave Chrome open when running tests.


## Bug fix/ feature development {#bug-fix-feature-development}

Now it's time to start working on your bug fix or new feature.

### Create a branch {#create-a-branch}

To start working on a new feature or fix a bug, you should always create a new branch in your fork with the name of your feature or fix.

@component('components.tip')
Always create a new branch for your feature or fix.
@endcomponent

Do not use your master/ main branch of your fork as maintainers cannot modify PR's submitted from a master/main branch on a fork.

@component('components.warning')
Any PR's submitted from a master/main branch will be closed.
@endcomponent

### Add failing tests {#add-failing-tests}

The next step is to add failing tests for your code.

Livewire has both Dusk browser tests and standard PHPUnit unit tests, which you can find in `tests/Browser` and `tests/Unit` respectively.

Livewire runs both PHP and Javascript code, so Dusk browser tests are preferred to ensure everything works as expected, and can be supported with unit tests as required.

See below for an example of how a Livewire Dusk test should be structured:

@component('components.code', ['lang' => 'php'])
/** @test */
public function it_can_run_foo_action
{
    $this->browse(function ($browser) {
        Livewire::visit($browser, FooComponent::class)
            /**
             * Basic action (click).
             */
            ->waitForLivewire()->click('@foo')
            ->assertSeeIn('@output', 'foo')
            ;
    });
}
@endcomponent

You can see how to use Dusk in the [Laravel documententation](https://laravel.com/docs/8.x/dusk) as well as look at Livewire's existing browser tests for further examples.

### Add working code {#add-working-code}

Livewire has both PHP and javascript code, which you can find in the `src` directory for PHP and the `js` directory for javascript.

Change the code as required to fix the bug or add the new feature, but try to keep changes to a minimum. Consider splitting into multiple PR's if required.

@component('components.warning')
PR's that make too many changes or make unrelated changes may be closed.
@endcomponent

If you have updated any of Livewire's javascript code, you will need to recompile the assets.
To do this run `npm run build`, or you may start a watcher with `npm run watch`.

Compiled javascript assets should be committed with your changes.

@component('components.tip')
If you update any javascript, make sure to recompile assets and commit them.
@endcomponent

Once you have finished writing your code, do a review to ensure you haven't left any debugging code and formatting matches the existing style.

### Run tests {#development-run-tests}

The final step before submitting is to run all tests to ensure your changes haven't impacted anything else.

To do this, run `phpunit` and confirm everything is running ok.

@component('components.code', ['lang' => 'shell'])
phpunit
@endcomponent

If the Dusk browser tests don't run, see [Run tests](#setup-run-tests) in the Setup section above for more details

### Submit PR {#submit-pr}

Once all tests pass, then push your branch up to GitHub and submit your PR.

In your PR description make sure to provide a small example of what your PR does along with a thorough description of the improvement and reasons why it's useful.
Add links to any issues or discussions that are relevant for further details.

@component('components.tip')
For first-time contributors, tests won't run automatically, so they will need to be started by a maintainer.
@endcomponent

### Thanks for contributing! 🙌 {#thanks}

And that's it!

Maintainers will review your PR and give feedback as required.

Thanks for contributing to Livewire!