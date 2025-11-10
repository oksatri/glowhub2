Laravel Reverb (Realtime) — setup notes

This project emits booking notifications via Laravel's Notification (database + broadcast) and a broadcast event `App\Events\BookingCreated` on the `bookings` channel.

Quick steps to enable realtime with Laravel Reverb (optional):

1. Install package (from project root):

    composer require laravel/reverb

2. Follow the package install prompt or publish the echo stub. Set environment variables in `.env`:

    VITE_REVERB_APP_KEY=your_key
    VITE_REVERB_HOST=your_reverb_host
    VITE_REVERB_PORT=6001
    VITE_REVERB_SCHEME=https

3. Configure `config/broadcasting.php` to use `reverb` driver if desired.

4. Build frontend assets (the app includes an Echo stub). In JS you can listen to bookings channel:

    import Echo from 'laravel-echo'
    window.Echo = new Echo({ broadcaster: 'reverb', /_ options _/ })

    Echo.channel('bookings')
    .listen('BookingCreated', (e) => {
    // update bell count / prepend notification
    });

5. Run queue worker for notifications if queued, and ensure broadcasting driver is running.

Notes:

-   The code currently sends database notifications to all users with `role = 'admin'` and also fires `BookingCreated` event. If you prefer private channels, change `BookingCreated::broadcastOn()` accordingly.
