
To prevent users from tampering with Livewire requests between component dehydration and rehydration, Livewire passes a "checksum" along with every request, that ensures all the data, the component name, and id haven't been tampered with.

Outside of that measure, Livewire uses normal Laravel requests, so CSRF, Sanitization, etc... will all be the exact same as a normal AJAX request.
