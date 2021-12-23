* [Livewire Changes](#livewire-changes) { .text-blue-800 }
* [Page Expired Dialog and Hook](#page-expired-dialog-and-hook) { .text-blue-800 }
    * [Page Expired Dialog](#page-expired-dialog) { .text-blue-800 }
    * [Page Expired Hook](#page-expired-hook) { .text-blue-800 }

## Livewire Changes {#livewire-changes}

Occasionally there will be changes to Livewire's internal method signatures that will require a refresh of any components currently running in the browser (we try to keep these to a minimum).

To achieve this, Livewire uses an internal deployment hash and keeps track of whether it has changed or not.

If Livewire's deployment hash has changed, it will trigger the [page expired dialog or hook](#page-expired-dialog-and-hook).

## Page Expired Dialog and Hook {#page-expired-dialog-and-hook}

### Page Expired Dialog {#page-expired-dialog}

By default, if a deployment hash doesn't match (see above) or a users session has expired, then Livewire will display a confirmation dialog prompting the user to refresh the page.

![Page Expired Dialog](/img/docs/page-expired-dialog.png) {.border.w-full}

### Page Expired Hook {#page-expired-hook}

If the default page expired dialog isn't suitable, you can implement a custom solution for notifying users, by using the page expired hook.

To do this you would pass a javascript callback to `Livewire.onPageExpired()` that handles notifying your users.

@component('components.code', ['lang' => 'js'])
Livewire.onPageExpired((response, message) => {})
@endcomponent

@component('components.tip')
You could dispatch a browser event from the page expired callback, that Alpine could listen for to show a custom dialog modal prompting users to refresh their page.
@endcomponent

You need to either place the `Livewire.onPageExpired()` call after Livewire's scripts in your layout file
@component('components.code', ['lang' => 'blade'])
@verbatim
<livewire:scripts />
<script>
    Livewire.onPageExpired((response, message) => {})
</script>
@endverbatim
@endcomponent

Or wrap it in an event lister that waits for Livewire to load

@component('components.code', ['lang' => 'blade'])
<script>
    document.addEventListener('livewire:load', () => {
        Livewire.onPageExpired((response, message) => {})
    })
</script>
@endcomponent