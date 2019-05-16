---
title: Quickstart
description: todo
extends: _layouts.documentation
section: content
---
## Install Livewire

*Include the PHP*
```bash
composer require calebporzio/livewire
```

*Include the JavaScript (on every page that will be using Livewire)*

@component('_partials.code', ['lang' => 'html'])@verbatim
    ...
    {!! Livewire::scripts() !!}
</body>
</html>
@endverbatim@endcomponent

## Create a component

Run the following command to generate a new Livewire component called `counter`.

```bash
php artisan make:livewire counter
```

Running this command will generate the following two files:
