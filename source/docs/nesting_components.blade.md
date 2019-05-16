---
title: Nesting Components
description: todo
extends: _layouts.documentation
section: content
---

Livewire supports nesting components. This feature, allows you to compose components from other components, which is an incredibly powerful architectural pattern.

Here is an example of a nested component:
<div title="Component">
<div title="Component__view">

Parent Component Template
```html
<div>
    @livewire('user-profile', $user)
</div>
```
</div></div>

## Keyed Components

Similar to VueJs, if you render a component inside a loop, Livewire has trouble keeping track of changes made to those compoents. To remedy this, livewire offers a special "key" syntax:

<div title="Component">
<div title="Component__view">

Parent Component Template
```html
<div>
    @foreach ($users as $user)
        @livewire('user-profile', $user, key($user->id))
    @endforeach
</div>
```
</div></div>

> Note: Livewire doesn't actually call PHP's "key()" function, it just uses "key()" as a signifier in it's blade parser.
