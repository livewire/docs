* [Component Changes](#component-changes) { .text-blue-800 }
    * [Single Component Changes](#single-component-changes) { .text-blue-800 }
    * [Multiple Component Changes](#multiple-component-changes) { .text-blue-800 }
* [Livewire Changes](#livewire-changes) { .text-blue-800 }
* [Page Expired Dialog and Hook](#page-expired-dialog-and-hook) { .text-blue-800 }
    * [Page Expired Dialog](#page-expired-dialog) { .text-blue-800 }
    * [Page Expired Hook](#page-expired-hook) { .text-blue-800 }

## Component Changes {#component-changes}

### Single Component Changes {#single-component-changes}

You can manage versioning of your components by implementing a static method `getDeploymentHash()` in each component, which returns a hash or identifier of the current version of your component.

For example you may use a static property on your component and return it's value from `getDeploymentHash()`

@component('components.code', ['lang' => 'php'])
public static $DEPLOYMENT_HASH = 'abc';

public static function getDeploymentHash()
{
    return static::$DEPLOYMENT_HASH;
}
@endcomponent

If the above method is implemented, Livewire will add that hash to the component payload.

Then on subsequent requests if the hash has changed for that particular component, then Livewire will trigger the page expired dialog or hook (see below) for any users that have that component running in their brwoser.

To get it to do this, you just need to change the hash.

@component('components.code', ['lang' => 'php'])
public static $DEPLOYMENT_HASH = 'xyz';
@endcomponent

### Multiple Component Changes {#multiple-component-changes}

You can also manage versioning of all of your components together.

To achieve this, you will need to create an abstract component class that all of your components extend from.

In your abstract component class you would implement the `getDeploymentHash()` as described above.

@component('components.code', ['lang' => 'php'])
namespace App\Http\Livewire;

use Livewire\Component;

abstract class MyAbstractComponent extends Component
{
    public static $DEPLOYMENT_HASH = 'aaa';

    public static function getDeploymentHash()
    {
        return self::$DEPLOYMENT_HASH;
    }
}
@endcomponent

Next step is to ensure your components now extend the abstract component.

@component('components.code', ['lang' => 'php'])
namespace App\Http\Livewire;

use Livewire\Component;

class MyComponent extends MyAbstractComponent
{
    public function render()
    {
        return view('livewire.my-component');
    }
}
@endcomponent

Finally, to change the deployment hash all of your components, you just need to update the hash in your abstract component class.

This will then trigger the page expired dialog or hook (see below) for all components, that extend the abstract class, that are currently running in users browsers.

## Livewire Changes {#livewire-changes}

Occasionally there will be changes to Livewire's internal method signatures that will require a refresh of any components currently running in the browser (we try to keep these to a minimum).

To achieve this, Livewire uses an internal deployment hash and keeps track of whether it has changed or not.

If Livewire's deployment hash has changed, it will trigger the page expired dialog or hook (see below).

## Page Expired Dialog and Hook {#page-expired-dialog-and-hook}

### Page Expired Dialog {#page-expired-dialog}

By default, if a deployment hash doesn't match (see above) or a users session has expired, then Livewire will display a confirmation dialog prompting the user to refresh the page.

### Page Expired Hook {#page-expired-hook}

If the default page expired dialog isn't suitable, you can implement your own solution for notifying users, by using the page expired hook.

To do this you would pass a javascript callback to `Livewire.onPageExpired()` that handles notifying your users.

@component('components.code', ['lang' => 'js'])
Livewire.onPageExpired(() => confirm('Page Expired'))
@endcomponent

@component('components.tip')
You could dispatch a browser event from the page expired callback, that Alpine could listen for to show a custom dialog modal prompting users to refresh their page.
@endcomponent

You need to either place the `Livewire.onPageExpired()` call after Livewire's scripts in your layout file
@component('components.code', ['lang' => 'blade'])
@verbatim
<livewire:scripts />
<script>
    Livewire.onPageExpired(() => confirm('Page Expired'))
</script>
@endverbatim
@endcomponent

Or wrap it in an event lister that waits for Livewire to load

@component('components.code', ['lang' => 'blade'])
<script>
    document.addEventListener('livewire:load', () => {
        Livewire.onPageExpired(() => confirm('Page Expired'))
    })
</script>
@endcomponent