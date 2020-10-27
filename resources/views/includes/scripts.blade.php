<script src="{{ mix('js/main.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Animate the Jellyfish logo because why not?
        animate({elements: '#Jelly', transform: ['translateY(0%)', 'translateY(-3%)'], easing: 'in-out-cubic'}).then(() => {
            animate({elements: '#Jelly', transform: ['translateY(-3%)', 'translateY(3%)'], loop: true, direction: 'alternate', easing: 'in-out-cubic', duration: 2000})
        })
    })
</script>
@livewireScripts
@stack('scripts')
