<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDeskPro - University Support System</title>

    <link rel="icon" href="{{ asset('images/system logo no bg.png') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #e0f2fe, #dbeafe, #ede9fe);
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile Menu Styles */
        .mobile-menu-button {
            display: none;
        }

        .mobile-nav {
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-menu-button {
                display: block;
                z-index: 60;
            }

            .desktop-nav {
                display: none;
            }

            .mobile-nav {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(37, 99, 235, 0.98);
                padding: 5rem 2rem 2rem;
                z-index: 50;
            }

            .mobile-nav.show {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }

            .mobile-nav a {
                color: white;
                font-size: 1.25rem;
                padding: 1rem;
                width: 100%;
                text-align: center;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Mobile Home Section */
            #home .container {
                width: 100% !important;
                padding: 1rem;
            }

            #home h2 {
                font-size: 2rem;
                line-height: 1.2;
                margin-bottom: 1rem;
            }

            #home p {
                font-size: 1rem;
                padding: 0 0.5rem;
                margin-bottom: 1.5rem;
            }

            #home .buttons {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                padding: 0 1rem;
            }

            #home .buttons a {
                width: 100%;
                text-align: center;
                margin: 0;
            }

            /* Mobile Sections */
            #services .grid,
            #how-it-works .grid,
            #testimonials .grid,
            footer .grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 1rem;
            }

            /* Mobile Chatbot */
            #chatbot-button {
                width: 50px;
                height: 50px;
                bottom: 1rem;
                right: 1rem;
                font-size: 1.5rem;
            }

            #chatbot-container {
                width: calc(100% - 2rem);
                bottom: 4.5rem;
                right: 1rem;
            }

            /* Mobile Contact Form */
            #contact form {
                padding: 0 1rem;
            }

            /* Mobile Footer */
            footer {
                padding: 2rem 1rem;
            }

            footer .grid > div {
                text-align: center;
                padding: 1rem 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            footer .social-icons {
                justify-content: center;
                padding: 1rem 0;
            }
        }

        /* Tablet Optimization */
        @media (min-width: 769px) and (max-width: 1024px) {
            .container {
                padding: 0 2rem;
            }

            #services .grid,
            #how-it-works .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Enhanced Animations */
        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/system logo no bg 3.png') }}" alt="PSU Logo" class="h-10 w-10 mr-2 rounded-full border border-white">
                <h1>PSU HelpDeskPro</h1>
            </div>
            
            <button class="mobile-menu-button">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <ul class="flex space-x-6">
                    <li><a href="#home" class="hover:text-blue-200 transition duration-300">Home</a></li>
                    <li><a href="#services" class="hover:text-blue-200 transition duration-300">Services</a></li>
                    <li><a href="#how-it-works" class="hover:text-blue-200 transition duration-300">How It Works</a></li>
                    <li><a href="#contact" class="hover:text-blue-200 transition duration-300">Contact</a></li>
                </ul>
            </nav>

            <!-- Mobile Navigation -->
            <nav class="mobile-nav">
                <a href="#home" class="hover:bg-blue-700 transition duration-300">Home</a>
                <a href="#services" class="hover:bg-blue-700 transition duration-300">Services</a>
                <a href="#how-it-works" class="hover:bg-blue-700 transition duration-300">How It Works</a>
                <a href="#contact" class="hover:bg-blue-700 transition duration-300">Contact</a>
            </nav>
        </div>
    </header>

    <style>
        #chatbot-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 70px;
            height: 70px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        #chatbot-button:hover {
            background-color: #0056b3;
            scale: 1.1;
        }

        #chatbot-button.open {
            background-color: #0056b3;
            scale: 1.2;
        }

        #chatbot-container {
            position: fixed;
            bottom: 100px;
            right: 20px;
            width: 300px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: none;
            z-index: 1000;
            padding: 15px;
        }

        #chatbot-container.open {
            display: block;
        }

    </style>

    <main class="">

        <button id="chatbot-button" class="text-3xl">
            <i id="open" class="fa-solid fa-comments"></i>
        </button>
    
        <div id="chatbot-container" class="border">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/botbot.png') }}" alt="" class="h-16 w-16 mb-2 rounded-full">
                <a href="ai.psu" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-700 w-full text-white" style="text-align: center">Proceed to Chatbot</a>
            </div>
            
        </div>

        <script>
            const chatbotButton = document.getElementById('chatbot-button');
            const chatbotContainer = document.getElementById('chatbot-container');
            const open = document.getElementById('open');
            const close = document.getElementById('close');

            chatbotButton.addEventListener('click', () => {
                chatbotContainer.classList.toggle('open');
                chatbotButton.classList.toggle('open');
            });
        </script>

        <section id="home" class="gradient-bg min-h-screen flex items-center mx-auto relative">
            <div class="container w-1/2 mx-auto px-4 text-center text-white" style="z-index: 40">
                <h2 class="text-5xl font-bold mb-6 fade-in">Welcome to HelpDeskPro</h2>
                {{-- <p class="text-xl mb-8 fade-in">Your one-stop solution for all university-related inquiries and concerns</p> --}}
                <p class="text-xl mb-8 fade-in">Streamline inquiries and enhance responsiveness with our advanced Inbox Management System featuring Chatbot Integration.</p>

                @if (Route::has('login'))
                    @auth
                        <a href="login" class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition duration-200 inline-block fade-in">Get Started</a>
                    @else
                        <a href="login/student" class="bg-blue-600 text-white mr-4 px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition duration-200 inline-block fade-in">Login</a>
                        <a href="register" class="bg-white text-gray-800 px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-200 transition duration-200 inline-block fade-in">Sign Up</a>
                    @endauth
                    
                @endif
            </div>
        
            <div class="top-0 fade-in absolute min-h-screen w-full">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <img src="{{ asset('images/students3.png') }}" alt="University students using HelpDeskPro" class="h-screen w-full shadow-lg object-cover">
            </div>
        </section>        

        <section id="services" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12">Our Services</h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-blue-50 p-8 rounded-lg shadow-md">
                        <i class="fas fa-ticket-alt text-4xl text-blue-600 mb-4"></i>
                        <h4 class="text-2xl font-semibold mb-4">Ticket System</h4>
                        <p class="mb-4">Submit and track tickets for any school-related questions or concerns. Our dedicated team is here to help you.</p>
                        <ul class="list-disc list-inside mb-4">
                            <li>24/7 ticket submission</li>
                            <li>Real-time status updates</li>
                            <li>Priority handling for urgent issues</li>
                        </ul>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-300">Learn More &rarr;</a>
                    </div>
                    <div class="bg-blue-50 p-8 rounded-lg shadow-md">
                        <i class="fas fa-robot text-4xl text-blue-600 mb-4"></i>
                        <h4 class="text-2xl font-semibold mb-4">ChatBot Assistant</h4>
                        <p class="mb-4">Get instant answers to frequently asked questions with our AI-powered chatbot. Available 24/7 for your convenience.</p>
                        <ul class="list-disc list-inside mb-4">
                            <li>Instant responses</li>
                            <li>Multi-language support</li>
                            <li>Seamless handover to human support when needed</li>
                        </ul>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-300">Try it Now &rarr;</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12">How It Works</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-white rounded-full p-6 inline-block mb-4 transform hover:scale-110 transition duration-300">
                            <i class="fas fa-user-plus text-4xl text-blue-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">1. Create an Account</h4>
                        <p>Sign up with your university email to access our services.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-full p-6 inline-block mb-4 transform hover:scale-110 transition duration-300">
                            <i class="fas fa-ticket-alt text-4xl text-blue-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">2. Submit a Ticket</h4>
                        <p>Describe your issue or question in detail for our team to assist you.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-full p-6 inline-block mb-4 transform hover:scale-110 transition duration-300">
                            <i class="fas fa-comments text-4xl text-blue-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">3. Get Help</h4>
                        <p>Receive timely responses and solutions from our dedicated support team.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-blue-600 text-white">
            <div class="container mx-auto px-4 text-center">
                <h3 class="text-3xl font-bold mb-6 fade-in">Ready to Get Started?</h3>
                <p class="text-xl mb-8 fade-in">Join thousands of students who are already using HelpDeskPro for their university support needs.</p>
                <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-100 transition duration-300 inline-block fade-in">Sign Up Now</a>
            </div>
        </section>

        <section id="testimonials" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12 fade-in">What Our Users Say</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                        <p class="mb-4">"HelpDeskPro has made getting help so much easier. I love how quick and efficient the system is!"</p>
                        <p class="font-semibold">- Sarah J., Computer Science Student</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                        <p class="mb-4">"The chatbot is incredibly helpful for quick questions. It's like having a personal assistant!"</p>
                        <p class="font-semibold">- Mike T., Business Administration Student</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                        <p class="mb-4">"As a faculty member, I appreciate how organized and streamlined the ticket system is. It's a game-changer!"</p>
                        <p class="font-semibold">- Dr. Emily R., Professor of Psychology</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12 fade-in">Contact Us</h3>
                <div class="max-w-lg mx-auto">
                    <form class="space-y-4 fade-in">
                        <div>
                            <label for="name" class="block mb-1">Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="message" class="block mb-1">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-lg font-semibold mb-4">About HelpDeskPro</h5>
                    <p class="text-sm">HelpDeskPro is the leading support system for universities, providing efficient ticket management and AI-powered assistance.</p>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                    <ul class="text-sm">
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">Home</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">Services</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">About Us</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Contact Us</h5>
                    <ul class="text-sm">
                        <li>Email: support@helpdeskpro.com</li>
                        <li>Phone: (123) 456-7890</li>
                        <li>Address: 123 University Ave, College Town, ST 12345</li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Follow Us</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-sm">
                <p>&copy; 2024 HelpDeskPro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Smooth scroll for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });


            // Header opacity change on scroll
            const header = document.querySelector('header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('bg-opacity-90');
                } else {
                    header.classList.remove('bg-opacity-90');
                }
            });

            // Animated counter for statistics
            function animateValue(obj, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    obj.innerHTML = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            const statsSection = document.querySelector('#statistics');
            const statsObserver = new IntersectionObserver((entries, observer) => {
                if (entries[0].isIntersecting) {
                    document.querySelectorAll('.stat-number').forEach(el => {
                        animateValue(el, 0, parseInt(el.innerHTML), 2000);
                    });
                    observer.unobserve(entries[0].target);
                }
            }, { threshold: 0.5 });

            if (statsSection) {
                statsObserver.observe(statsSection);
            }

            // GSAP animations
            gsap.registerPlugin(ScrollTrigger);

            gsap.from("#services .fade-in", {
                opacity: 0,
                y: 50,
                stagger: 0.2,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#services",
                    start: "top 80%",
                }
            });

            gsap.from("#how-it-works .fade-in", {
                opacity: 0,
                y: 50,
                stagger: 0.2,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#how-it-works",
                    start: "top 80%",
                }
            });

            // Chatbot toggle
            const chatbotToggle = document.querySelector('#chatbot-toggle');
            const chatbotWindow = document.querySelector('#chatbot-window');

            if (chatbotToggle && chatbotWindow) {
                chatbotToggle.addEventListener('click', () => {
                    chatbotWindow.classList.toggle('hidden');
                });
            }

            // Form submission handling
            const contactForm = document.querySelector('#contact form');
            if (contactForm) {
                contactForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    // Here you would typically send the form data to your server
                    alert('Thank you for your message! We will get back to you soon.');
                    contactForm.reset();
                });
            }






            // Mobile Menu Toggle
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileNav = document.querySelector('.mobile-nav');
            
            mobileMenuButton.addEventListener('click', () => {
                mobileNav.classList.toggle('show');
                mobileMenuButton.innerHTML = mobileNav.classList.contains('show') 
                    ? '<i class="fas fa-times text-2xl"></i>' 
                    : '<i class="fas fa-bars text-2xl"></i>';
            });

            // Close mobile menu when clicking links
            document.querySelectorAll('.mobile-nav a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileNav.classList.remove('show');
                    mobileMenuButton.innerHTML = '<i class="fas fa-bars text-2xl"></i>';
                });
            });


            // Scroll Animations
            const fadeInElements = document.querySelectorAll('.fade-in');
            const fadeInObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });

            fadeInElements.forEach(element => {
                fadeInObserver.observe(element);
            });

            // Header Scroll Effect
            let lastScroll = 0;
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;
                const header = document.querySelector('header');
                
                if (currentScroll <= 0) {
                    header.style.backgroundColor = '#2563eb';
                } else if (currentScroll > lastScroll) {
                    header.style.backgroundColor = 'rgba(37, 99, 235, 0.95)';
                }
                lastScroll = currentScroll;
            });


        });
    </script>
</body>
</html>