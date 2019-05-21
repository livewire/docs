---
title: Nesting Components
description: todo
extends: _layouts.documentation
section: content
---

# Nesting Components

Livewire supports nesting components. This feature, allows you to compose components from other components, which is an incredibly powerful architectural pattern.

Here is an example of a nested component:

@codeComponent([
    'viewName' => 'Parent Component Template',
])
@slot('view')
@verbatim
<div>
    @livewire('user-profile', $user)
</div>
@endverbatim
@endslot
@endcodeComponent

## Keyed Components

Similar to VueJs, if you render a component inside a loop, Livewire has trouble keeping track of changes made to those compoents. To remedy this, livewire offers a special "key" syntax:

@codeComponent([
    'viewName' => 'Parent Component Template',
])
@slot('view')
@verbatim
<div>
    @foreach ($users as $user)
        @livewire('user-profile', $user, key($user->id))
    @endforeach
</div>
@endverbatim
@endslot
@endcodeComponent

> Note: Livewire doesn't actually call PHP's "key()" function, it just uses "key()" as a signifier in it's blade parser.
