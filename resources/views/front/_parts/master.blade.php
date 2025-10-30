<!DOCTYPE html>
<html lang="en">

<head>
    <title>GlowHub</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/Glowhub - Logo-2.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('icomoon/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">
    @include('front._parts.header')
    @yield('content')
    @include('front._parts.footer')

    <!-- Scroll to Top Button -->
    <div id="scrollToTop" class="scroll-to-top">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Custom MUA JavaScript -->
    <script>
        $(document).ready(function() {
            // Smooth scrolling for navigation links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
            });

            // Add animation on scroll
            function animateOnScroll() {
                $('.mua-finder-card, .testimonial-card, .process-step').each(function() {
                    var elementTop = $(this).offset().top;
                    var elementBottom = elementTop + $(this).outerHeight();
                    var viewportTop = $(window).scrollTop();
                    var viewportBottom = viewportTop + $(window).height();

                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('animate__animated animate__fadeInUp');
                    }
                });
            }

            // Trigger animation on page load and scroll
            animateOnScroll();
            $(window).scroll(function() {
                animateOnScroll();

                // Show/hide scroll to top button
                if ($(this).scrollTop() > 300) {
                    $('#scrollToTop').addClass('show');
                } else {
                    $('#scrollToTop').removeClass('show');
                }
            });

            // Scroll to top functionality
            $('#scrollToTop').on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 800, 'easeInOutCubic');
            });

            // Tab functionality for services
            $('.tab-item').click(function() {
                var tab = $(this).data('tab');

                // Remove active class from all tabs and content
                $('.tab-item').removeClass('active');
                $('.tab-content').removeClass('active');

                // Add active class to clicked tab
                $(this).addClass('active');
                $('#' + tab).addClass('active');
            });

            // Form validation and submission
            $('form').submit(function(e) {
                e.preventDefault();

                // Simple validation
                var isValid = true;
                $(this).find('input[required], textarea[required], select[required]').each(function() {
                    if ($(this).val() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (isValid) {
                    alert('Message sent successfully! We will contact you soon.');
                    $(this)[0].reset();
                } else {
                    alert('Please fill in all required fields.');
                }
            });
        });
    </script>
</body>

</html>
