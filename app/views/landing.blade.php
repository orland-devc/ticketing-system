<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Streamline communication at Pangasinan State University San Carlos City Campus with our advanced Inbox Management System featuring Chatbot Integration.">
    <meta name="keywords" content="Pangasinan State University, Inbox Management System, Chatbot Integration, Communication, Inquiries">
    <link rel="icon" href="{{ asset('images/PSU logo.png') }}" type="image/x-icon">
    <title>Inbox Management System - Pangasinan State University</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <style>
        /* Add custom styles here */
        /* Example: Change the header and footer colors */
        header {
            background-color: #003366; /* Navy blue */
            color: #fff;
        }
        footer {
            background-color: #003366;
            color: #fff;
        }
    </style>
</head>
<body class="font-sans" style="font-family:">
    <header class="text-gray-200 py-4 px-6 fixed w-full z-50">
        <!-- Changed background color and text color -->
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="font-bold text-xl">
                <img src="images/PSU logo.png" alt="Pangasinan State University" class="h-8 inline">
                Inbox Management System
            </a>
            <nav>
                <ul class="flex space-x-4 vertical-center">
                    <li><a href="#features" class="smooth-scroll hover:text-yellow-500 font-bold">Features</a></li>
                    <li><a href="#testimonials" class="smooth-scroll hover:text-yellow-500 font-bold">Testimonials</a></li>
                    <li><a href="#contact" class="smooth-scroll hover:text-yellow -500 font-bold">Contact</a></li>
                    <li style="">
                    
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/login') }}" class="bg-yellow-500 hover:bg-yellow-600 font-bold text-white py-2 px-4 rounded-full">Dashboard</a>
                            @else
                                <a href="{{ url('/login') }}" class="bg-yellow-500 hover:bg-yellow-600 font-bold text-white py-2 px-4 rounded-full">Get Started</a>
                            @endauth
                        @endif
                    
                </li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="top" class="bg-blue-900 text-white py-32 pt-24" style="background-image: url('/images/psuscschool.jpg'); background-size: cover; position: relative; background-repeat: no-repeat; height:105vh">
        <!-- Updated the background image to a more professional and formal one -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 51, 102, 0.75);">
            <!-- Changed the overlay color to a darker navy blue -->
            <div class="container mx-auto items-center">
                <div class="align-center justify-center flex" style="text-align: center">
                    <div style="max-width: 60%">
                        <img src="{{asset ('images/PSU logo.png')}}" class="w-40 center m-auto pointer-events-none animate-left" style="border-radius: 50%; border: 2px solid white">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4 select-none animate-right">Elevate Communication at<br>Pangasinan State University</h1>
                        <!-- Updated the headline to be more concise and compelling -->
                        <!-- Added animation classes for fading in from left and right -->
                        <p class="text-lg md:text-xl mb-8 animate-left">Streamline inquiries and enhance responsiveness with our advanced Inbox Management System featuring Chatbot Integration.</p>
                        <!-- Updated the value proposition to be more concise and focused on benefits -->
                        <!-- Added animation class for fading in from left -->
                        <a href="#features" class="bg-yellow-500 hover:bg-yellow-600 text-white py-4 px-6 font-bold rounded-full mr-3 transition-all duration-300 ease-in-out transform hover:scale-105">Explore Features</a>    
                        <!-- Added transition and transform classes for hover scale effect -->

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/login') }}" class="border border-white hover:bg-white text-white hover:text-gray-900 font-bold py-4 px-6 rounded-full ml-3 transition-all duration-300 ease-in-out transform hover:scale-105"><ion-icon name="arrow-forward-circle-outline"></ion-icon>Go to Dashboard</a>    
                            @else
                                <a href="{{ url('/login') }}" class="border border-white hover:bg-white text-white hover:text-gray-900 font-bold py-4 px-6 rounded-full ml-3 transition-all duration-300 ease-in-out transform hover:scale-105"><ion-icon name="arrow-forward-circle-outline"></ion -icon>Get Started</a> 
                            @endauth
                        @endif
                        <!-- Added transition and transform classes for hover scale effect -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="container mx-auto p-10 select-none">
        <h2 class="text-3xl font-bold mb-6 text-center">Key Features</h2>
        <div id="firstRow" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-200 hover:bg-white p-6 rounded-lg shadow-md transition-all duration-200 ease-in-out transform keyFeatures">
                <!-- Added transition and transform classes for hover scale effect -->
                <svg class="h-12 w-12 text-blue-900 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707-.707V9m-7 4a8 8 0 11-16 0 8 8 0 0116 0z" />
                </svg>
                <!-- Replaced the font awesome icon with a more visually appealing SVG icon -->
                <h3 class="text-xl font-bold mb-2">Inbox Management</h3>
                <p>Efficiently view, organize, and prioritize incoming messages and inquiries with powerful sorting and filtering capabilities, ensuring no request goes unnoticed.</p>
                <!-- Expanded the feature description to provide more details and benefits -->
            </div>
            <div class="bg-gray-200 hover:bg-white p-6 rounded-lg shadow-md transition-all duration-200 ease-in-out transform keyFeatures">
                <!-- Added transition and transform classes for hover scale effect -->
                <svg class="h-12 w-12 text-blue-900 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
                <!-- Replaced the font awesome icon with a more visually appealing SVG icon -->
                <h3 class="text-xl font-bold mb-2">Chatbot Integration</h3>
                <p>Get instant responses to frequently asked questions through our user-friendly chatbot interface, providing 24/7 support and reducing response times.</p>
                <!-- Expanded the feature description to provide more details and benefits -->
            </div>
            <div class="bg-gray-200 hover:bg-white p-6 rounded-lg shadow-md transition-all duration-200 ease-in-out transform keyFeatures">
                <!-- Added transition and transform classes for hover scale effect -->
                <svg class="h-12 w-12 text-blue-900 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <!-- Replaced the font awesome icon with a more visually appealing SVG icon -->
                <h3 class="text-xl font-bold mb-2">Message Routing</h3>
                <p>Inquiries are automatically routed to the respective department based on predefined categories, ensuring efficient and accurate handling of each request.</p>
                <!-- Expanded the feature description to provide more details and benefits -->
            </div>
        </div>
        <div id="testimonials"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 select-none">
            <div class="bg-gray-200 hover:bg-white p-6 rounded-lg shadow-md transition-all duration-200 ease-in-out transform keyFeatures">
                <!-- Added transition and transform classes for hover scale effect -->
                <svg class="h-12 w-12 text-blue-900 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                <!-- Replaced the font awesome icon with a more visually appealing SVG icon -->
                <h3 class="text-xl font-bold mb-2">Ticketing System</h3>
                <p>Track the status and progress of your inquiries with our intuitive ticketing system, ensuring transparency and accountability throughout the resolution process.</p>
                <!-- Expanded the feature description to provide more details and benefits -->
            </div>
            <div class="bg-gray-200 hover:bg-white p-6 rounded-lg shadow-md transition-all duration-200 ease-in-out transform keyFeatures">
                <!-- Added transition and transform classes for hover scale effect -->
                <svg class="h-12 w-12 text-blue-900 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <!-- Replaced the font awesome icon with a more visually appealing SVG icon -->
                <h3 class="text-xl font-bold mb-2">Reporting & Analytics</h3>
                <p>Gain valuable insights and data-driven decision-making with our comprehensive reporting and analytics features, identifying trends and areas for improvement.</p>
                <!-- Expanded the feature description to provide more details and benefits -->
            </div>
            <div class="bg-gray-200 hover:bg-white p-6 rounded-lg shadow-md transition-all duration-200 ease-in-out transform keyFeatures">
                <!-- Added transition and transform classes for hover scale effect -->
                <svg class="h-12 w-12 text-blue-900 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <!-- Replaced the font awesome icon with a more visually appealing SVG icon -->
                <h3 class="text-xl font-bold mb-2">Secure & Reliable</h3>
                <p>Experience peace of mind with our robust security measures and high availability, ensuring the confidentiality and integrity of your data and communications.</p>
                <!-- Expanded the feature description to provide more details and benefits -->
            </div>
        </div>
    </section>

    <section id="" class="container mx-auto p-10 select-none">
        <div class="container mx-auto">
        <h2 class="text-3xl font-bold mb-6 text-center text-black">Trusted by Our Users</h2>
        <!-- Updated the section heading to be more formal and compelling -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="hover:bg-white p-6 rounded-lg transition-all duration-200 ease-in-out transform testM">
                <!-- Added transition and transform classes for hover scale effect -->
                <p class="text-gray-600 mb-4">"The Inbox Management System has revolutionized the way we handle inquiries at Pangasinan State University. It's user-friendly, efficient, and has significantly improved our response times, enhancing the overall communication experience for our students and faculty."</p>
                <!-- Updated the testimonial content to be more formal and detailed -->
                <div class="flex items-center">
                    <div class="relative w-10 h-10 mr-3">
                        <img src="images/image.png" alt="Avatar" class="absolute inset-0 w-full h-full object-cover rounded-full" />
                    </div>
                    <!-- Replaced the placeholder avatar with a real image -->
                    <div>
                        <h4 class="font-bold">Chris Mark C. Aquino, MIT</h4>
                        <p class="text-gray-600">Student Council President</p>
                        <!-- Added a more specific role for the testimonial author -->
                    </div>
                </div>
            </div>

            <div class="hover:bg-white p-6 rounded-lg transition-all duration-200 ease-in-out transform testM">
                <!-- Added transition and transform classes for hover scale effect -->
                <p class="text-gray-600 mb-4">"The Chatbot Integration feature has been a game-changer for our department. It has significantly reduced the workload on our staff, allowing us to focus on more complex inquiries while providing prompt responses to common questions."</p>
                <!-- Updated the testimonial content to be more formal and detailed -->
                <div class="flex items-center">
                    <div class="relative w-10 h-10 mr-3">
                        <img src="images/juliet.png" alt="Avatar" class="absolute inset-0 w-full h-full object-cover rounded-full" />
                    </div>
                    <!-- Replaced the placeholder avatar with a real image -->
                    <div>
                        <h4 class="font-bold">Juliet V. Menor, DIT</h4>
                        <p class="text-gray-600">College Dean, CHMBAC</p>
                        <!-- Added a more specific role for the testimonial author -->
                    </div>
                </div>
            </div>

            <div class="hover:bg-white p-6 rounded-lg transition-all duration-200 ease-in-out transform testM">
                <!-- Added transition and transform classes for hover scale effect -->
                <p class="text-gray-600 mb-4">"The reporting and analytics features have provided us with invaluable insights into our communication patterns and areas for improvement. We've been able to make data-driven decisions to enhance our services and better meet the needs of our stakeholders."</p>
                <!-- Updated the testimonial content to be more formal and detailed -->
                <div class="flex items-center">
                    <div class="relative w-10 h-10 mr-3">
                        <img src="images/drbuted.jpg" alt="Avatar" class="absolute inset-0 w-full h-full object-cover rounded-full" />
                    </div>
                    <!-- Replaced the placeholder avatar with a real image -->
                    <div>
                        <h4 class="font-bold">Dr. Dexter R. Buted, DIT</h4>
                        <p class="text-gray-600">University President</p>
                        <!-- Added a more specific role for the testimonial author -->
                    </div>
                </div>
            </div>
            <!-- Add more testimonials here -->
        </div>
        </div>
    </section>

    <section id="contact" class="container mx-auto p-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Get in Touch</h2>
        <div class="flex flex-col md:flex-row justify-center items-center">
        <div class="md:w-1/2 mb-6 md:mb-0">
            <img src="images/contact-image.jpg" alt="Contact Image" class="rounded-lg shadow-lg">
        </div>
        <div class="md:w-1/2 md:pl-8">
            <p class="mb-4">Have a question or need assistance? Don't hesitate to reach out to us.</p>
            <form>
            <div class="mb-4">
                <label for="name" class="block font-bold mb-2">Name</label>
                <input type="text" id="name" class="w-full px-3 py-2 border border-gray-300 rounded transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Your Name" required>
                <!-- Added transition and focus styles for input fields -->
            </div>
            <div class="mb-4">
                <label for="email" class="block font-bold mb-2">Email</label>
                <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Your Email" required>
                <!-- Added transition and focus styles for input fields -->
            </div>
            <div class="mb-4">
                <label for="department" class="block font-bold mb-2">Department</label>
                <select id="department" class="w-full px-3 py-2 border border-gray-300 rounded transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Department</option>
                    <option value="admissions">Admissions</option>
                    <option value="registrar">Registrar</option>
                    <option value="finance">Finance</option>
                    <!-- Add more department options as needed -->
                </select>
                <!-- Added transition and focus styles for select field -->
            </div>
            <div class="mb-4">
                <label for="message" class="block font-bold mb-2">Message</label>
                <textarea id="message" class="w-full px-3 py-2 border border-gray-300 rounded transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" placeholder="Your Message" required></textarea>
                <!-- Added transition and focus styles for textarea -->
            </div>
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded transition-all duration-300 ease-in-out transform hover:scale-105">Submit</button>
            <!-- Added transition and transform classes for hover scale effect -->
        </form>
        </div>
    </div>
</section>

<section>
    <div class="bg-gray-800 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold leading-9 text-white">Contact Information</h2>
            <p class="mt-2 text-lg leading-7 text-gray-400">Get in touch with us for more information or inquiries.</p>
            <div class="mt-8 flex">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium leading-6 text-white">Email</h3>
                    <p class="mt-1 text-base leading-6 text-gray-400">inquiries@psu.edu.ph</p>
                </div>
            </div>
            <div class="mt-8 flex">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium leading-6 text-white">Phone</h3>
                    <p class="mt-1 text-base leading-6 text-gray-400">(+63) 123-456-7890</p>
                </div>
            </div>
            <div class="mt-8 flex">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium leading-6 text-white">Address</h3>
                    <p class="mt-1 text-base leading-6 text-gray-400">123 University Ave, San Carlos City, Pangasinan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-gray-800 text-white py-6">
  <div class="container mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center">
      <div class="mb-4 md:mb-0">
        &copy; Pangasinan State University
      </div>
      <nav>
        <ul class="flex space-x-4">
          <li><a href="#" class="hover:text-yellow-500 transition-colors duration-300">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-yellow-500 transition-colors duration-300">Terms of Use</a></li>
          <li><a href="#contact" class="smooth-scroll hover:text-yellow-500 transition-colors duration-300">Contact</a></li>
          <li><a href="https://www.psu.edu.ph" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-500 transition-colors duration-300">University Website</a></li>
        </ul>
      </nav>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>

<style>
    .keyFeatures:hover {
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2), /* Bottom shadow */
                0 -4px 10px rgba(0, 0, 0, 0.1); /* Top shadow */
        scale: 1.04;
    }

    .testM:hover {
        box-shadow: 0 10px 10px rgba(92, 67, 255, 0.2), /* Bottom shadow */
                0 -4px 10px rgba(92, 67, 255, 0.1); /* Top shadow */
        scale: 1.04;
    }

    ion-icon {
        position: relative;
        font-size: 25px;
        top: 6px;
        margin-right: 5px;
    }

    .none {
        opacity: 0;
    }

    @keyframes slideInFromLeft {
        0% {
            opacity: 0;
            transform: translateX(-100%);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-left {
        animation: slideInFromLeft 1s ease;
    }

    @keyframes slideInFromRight {
        0% {
            opacity: 0;
            transform: translateX(100%);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-right {
        animation: slideInFromRight 1s ease;
    }

</style>

<script>
    // Function to handle smooth scrolling
    function smoothScroll(target, duration) {
        const targetElement = document.querySelector(target);
        const targetPosition = targetElement.offsetTop;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        let startTime = null;

        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const run = ease(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) requestAnimationFrame(animation);
        }

        function ease(t, b, c, d) {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        }

        requestAnimationFrame(animation);
    }

    // Function to handle smooth scroll on anchor click
    document.querySelectorAll('.smooth-scroll').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('href');
            const duration = 1000; // Adjust the duration as needed
            smoothScroll(target, duration);
        });
    });

    // Function to handle form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(form);

        // Send form data to server via AJAX
        fetch('/submit-form', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                alert('Thank you for your message!');
                form.reset();
            } else {
                alert('Something went wrong. Please try again later.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again later.');
        });
    });

    // Function to add hover scale effect to elements
    const hoverScaleElements = document.querySelectorAll('.hover-scale');
    hoverScaleElements.forEach(function(element) {
        element.addEventListener('mouseover', function() {
            this.classList.add('transform', 'hover:scale-105', 'transition-all', 'duration-300', 'ease-in-out');
        });
        element.addEventListener('mouseout', function() {
            this.classList.remove('transform', 'hover:scale-105', 'transition-all', 'duration-300', 'ease-in-out');
        });
    });
</script>