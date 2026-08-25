import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'

Alpine.plugin(collapse)

window.Alpine = Alpine

Alpine.start()
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.hash !== '#booking') {
        return;
    }

    const booking = document.getElementById('booking');

    if (!booking) {
        return;
    }

    requestAnimationFrame(() => {
        booking.scrollIntoView({
            behavior: 'instant',
            block: 'start',
        });
    });
});
