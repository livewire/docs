# Installation
Livewire has both a PHP component AND a Javascript component. You need to make sure both are available in your project before you can use it.

## Step 1: Include the PHP
```bash
> composer require calebporzio/livewire
```

## Step 2: Include the JavaScript
You can either include the JavaScript via the provided Blade helper (easiest), or include it via NPM if you have a build pipeline for your JavaScript.

### Option A) Blade Snippet

<div title="Component"><div title="Component__class"><div char="fade">

```html
    ...
```
</div>

```php
    {!! Livewire::scripts() !!}
```
<div char="fade">

```html
</body>
</html>
```
</div></div></div>

### Option B) install via NPM

```bash
> npm install laravel-livewire --save-dev
```

```js
import Livewire from 'laravel-livewire'

window.livewire = new Livewire
```
