@include('includes.screencast-cta')

## Parameters {#parameters}

You can pass data into a component by passing additional parameters into the `@livewire` directive. For example, let's say we have a `ShowContact` Livewire component that needs to know which contact to show. Here's how you would pass in a `contact` model.

@component('components.code', ['lang' => 'php'])
@verbatim
@livewire('show-contact', ['contact' => $contact])
@endverbatim
@endcomponent

If you are on Laravel 7 or greater, you can use the tag syntax.

@component('components.code', ['lang' => 'html'])
@verbatim
<livewire:show-contact :contact="$contact">
@endverbatim
@endcomponent

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount($contact)
    {
        $this->name = $contact->name;
        $this->email = $contact->email;
    }

    ...
}
@endverbatim
@endcomponent

You can pass multiple parameters to the `mount()` hook and receive them as additional parameters in the method signature:

@component('components.code', ['lang' => 'php'])
@verbatim
@livewire('show-contact', [
    'contact' => $contact,
    'sectionHeading' => 'Show Contact',
])
@endverbatim
@endcomponent

@component('components.code', ['lang' => 'html'])
@verbatim
<livewire:show-contact :contact="$contact" section-heading="Show Contact">
@endverbatim
@endcomponent

### Injecting Parameters {#injecting-parameters}

Like a controller, you can inject dependancies by adding type-hinted parameters before passed-in ones.

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;
use \Illuminate\Session\SessionManager

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount(SessionManager $session, $contact)
    {
        $session->put("contact.{$contact->id}.last_viewed", now());

        $this->name = $contact->name;
        $this->email = $contact->email;
    }

    ...
}
@endverbatim
@endcomponent

### Accessing The Current Request {#the-request}

Because `mount()` runs during the initial page load, it is the only place in a Livewire component you can reliably access Laravel's request object.

For example, you can set the initial value of a property based on a request parameter (possibly something passed in the query-string).

@component('components.code', ['lang' => 'php'])
@verbatim
use Livewire\Component;
use \Illuminate\Session\SessionManager

class ShowContact extends Component
{
    public $name;
    public $email;

    public function mount($contact, $sectionHeading = '')
    {
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->sectionHeading = request('section_heading', $sectionHeading);
    }

    ...
}
@endverbatim
@endcomponent
