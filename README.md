# Livewire Documentation

## Running Locally
* `composer install`
* `cp .env.example .env`
* `valet link` (or whatever you use to serve sites locally)
* Go to `/docs/quickstart`

## Building static site
(within this directory)

* `./generate`

Running this command will generate static files inside the `dist` folder. This get's auto-deployed to netlify on push.

## Adding/Modifying Pages

All pages are stored as Markdown in the `pages` directory. You can add/modify anything in there. If you add a page, make sure to register it in `routes.php`.
