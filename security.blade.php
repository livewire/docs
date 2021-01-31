Before understanding the security features of Livewire, it's important to have a full understanding of a Livewire component's lifecycle.

Unlike normal Blade components or includes, Livewire components have a lifecycle that spans beyond the initial page load. From the developer's experience, a Livewire component appears to be a long-living, real-time object that reacts to browser interactions and magically updates.

This is a facade. In reality, a Livewire component is almost the same as a normal Blade component when a page loads, except that it stores information about the current state of the component (public properties) and stores them in JavaScript to then send to the server later when a user triggers an update from the browser.

For any given component there is an "initial request" to create the component, then "subsequent requests" for every update following.

The "state" of a Livewire component at any given time is stored in JavaScript in the browser. When an update is triggered, that state gets sent to the server to "hydrate" a Livewire component before performing the desired user interaction.

After the update triggered from the user interaction is applied, the component re-renders itself (to provide updated HTML to the browser), and "dehydrates" it's state to be sent to JavaScript and stored for the next update.

If you think about it, it is EXTREMELY important that Livewire makes "subsequent requests" secure. Otherwise, a malicous person could tamper with the "state" stored in JavaScript and cause unintended behavior when the server re-hydrates the component on a subsequent update.

A good example of this would be if you set an eloquent model as a public property on a Livewire component. Livewire has to store the ID of that model and pass it to the front-end. If a bad-actor changes that ID in JavaScript, on the next update, they have gained access to an eloquent model they don't own!

To prevent this, Livewire has a "checksum" system. Every time a Livewire component "dehydrates" it creates a "checksum" of all the important information on the server to send to the front-end. When a subsequent request is made to the server, the checksum is used to verify that the state hasn't been tampered with in any way.

In addition to protecting against state tampering, Livewire keeps track of the original browser endpoint that loaded the Livewire component initially. This is used to lookup any middleware that was applied to that endpoing and re-apply it to subsequent Livewire requests.

This protects against "re-playing" Livewire component requests against invalid sessions. For example, if you are logged in as an admin of a site and there is a Livewire component that shows sensitive information from the database, a bad-actor could re-play a previous request to that Livewire component from a non-authorized user's browser and gain access to that senstive information. Instead, because Livewire replays authentication middleware, when the bad-actor replays the sensitive request, Livewire will apply the original "admin" middleware and the request will fail.

The checksum and middleware re-applying are the two measures that Livewire takes to ensure Livewire isn't used as a backdoor into your application.
