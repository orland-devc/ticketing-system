<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .custom-shape-divider-bottom-1647382936 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .custom-shape-divider-bottom-1647382936 svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 50px;
        }
        .custom-shape-divider-bottom-1647382936 .shape-fill {
            fill: #FFFFFF;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div x-data="{ tab: 'about', showModal: false }" class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Profile Content -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative h-64 animate-gradient">
                        <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture" class="absolute bottom-0 left-8 transform translate-y-1/2 w-32 h-32 rounded-full border-4 border-white shadow-lg" style="z-index: 100;">
                        <div class="custom-shape-divider-bottom-1647382936">
                            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="pt-20 pb-8 px-8">
                        <h1 class="text-3xl font-bold text-gray-800">{{ Auth::user()->name }}</h1>
                        <p class="text-xl text-gray-600">{{ Auth::user()->role }}</p>
                        <div class="mt-6 flex flex-wrap gap-4">
                            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Web Development</span>
                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">UI/UX Design</span>
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Project Management</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
                    <div class="flex space-x-4 mb-6">
                        <button @click="tab = 'about'" :class="{ 'bg-blue-500 text-white': tab === 'about', 'bg-gray-200 text-gray-700': tab !== 'about' }" class="px-4 py-2 rounded-lg transition duration-300">About</button>
                        <button @click="tab = 'experience'" :class="{ 'bg-blue-500 text-white': tab === 'experience', 'bg-gray-200 text-gray-700': tab !== 'experience' }" class="px-4 py-2 rounded-lg transition duration-300">Experience</button>
                        <button @click="tab = 'skills'" :class="{ 'bg-blue-500 text-white': tab === 'skills', 'bg-gray-200 text-gray-700': tab !== 'skills' }" class="px-4 py-2 rounded-lg transition duration-300">Skills</button>
                        <button @click="tab = 'projects'" :class="{ 'bg-blue-500 text-white': tab === 'projects', 'bg-gray-200 text-gray-700': tab !== 'projects' }" class="px-4 py-2 rounded-lg transition duration-300">Projects</button>
                    </div>
                    
                    <div x-show="tab === 'about'">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">About Me</h2>
                        <p class="text-gray-600 leading-relaxed">
                            Passionate developer with a keen eye for design and a love for creating seamless user experiences. When not coding, you'll find me exploring new coffee shops or hiking in nature.
                        </p>
                        <div class="mt-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">My Coding Journey</h3>
                            <div id="journey-timeline" class="relative">
                                <!-- Timeline items will be dynamically added here -->
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="tab === 'experience'" x-cloak>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Experience</h2>
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">Senior Developer at Tech Co.</h3>
                                    <p class="text-gray-600">2018 - Present</p>
                                    <p class="mt-2 text-gray-600">Led development of flagship product, increasing user engagement by 40%.</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">Junior Developer at StartUp Inc.</h3>
                                    <p class="text-gray-600">2015 - 2018</p>
                                    <p class="mt-2 text-gray-600">Contributed to backend development and improved system efficiency.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="tab === 'skills'" x-cloak>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Skills</h2>
                        <canvas id="skillsChart" width="400" height="200"></canvas>
                    </div>

                    <div x-show="tab === 'projects'" x-cloak>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Featured Projects</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300" @click="showModal = true">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Project Alpha</h3>
                                <p class="text-gray-600">A revolutionary app that simplifies task management.</p>
                            </div>
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300" @click="showModal = true">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Project Beta</h3>
                                <p class="text-gray-600">An AI-powered analytics dashboard for businesses.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar - Colleagues and Activity Feed -->
            <div class="lg:w-1/3 space-y-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Colleagues</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <img src="https://via.placeholder.com/50" alt="Colleague 1" class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Jane Doe</h3>
                                <p class="text-gray-600">UX Designer</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <img src="https://via.placeholder.com/50" alt="Colleague 2" class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">John Smith</h3>
                                <p class="text-gray-600">Full Stack Developer</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <img src="https://via.placeholder.com/50" alt="Colleague 3" class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Emily Brown</h3>
                                <p class="text-gray-600">Project Manager</p>
                            </div>
                        </div>
                    </div>
                    <button class="mt-6 w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">View All Colleagues</button>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-800">Completed React course on Udemy</p>
                                <p class="text-sm text-gray-600">2 days ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-800">Contributed to open-source project</p>
                                <p class="text-sm text-gray-600">1 week ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">GitHub Activity</h2>
                    <div id="github-activity" class="space-y-4">
                        <!-- GitHub activity will be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Modal -->
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.away="showModal = false">
        <div class="bg-white p-8 rounded-lg max-w-2xl w-full">
            <h2 class="text-2xl font-bold mb-4">Project Details</h2>
            <p class="text-gray-600 mb-4">This is where you'd put more detailed information about the project, including technologies used, your role, and key achievements.</p>
            <div id="project-visualisation" class="w-full h-64 bg-gray-200 rounded-lg mb-4">
                <!-- 3D project visualisation will be rendered here -->
            </div>
            <button @click="showModal = false" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('skillsData', () => ({
                init() {
                    const ctx = document.getElementById('skillsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: ['JavaScript', 'React', 'Node.js', 'Python', 'UI/UX', 'Database'],
                            datasets: [{
                                label: 'Skill Level',
                                data: [90, 85, 75, 80, 70, 85],
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgb(54, 162, 235)',
                                pointBackgroundColor: 'rgb(54, 162, 235)',
                                pointBorderColor: '#000',
                                pointHoverBackgroundColor: '#000',
                                pointHoverBorderColor: 'rgb(54, 162, 235)'
                            }]
                        },
                        options: {
                            scales: {
                                r: {
                                    angleLines: {
                                        display: false
                                    },
                                    suggestedMin: 0,
                                    suggestedMax: 100
                                }
                            }
                        }
                    });

                    // Initialize 3D project visualisation
                    this.init3DProjectVisualisation();

                    // Initialize coding journey timeline
                    this.initCodingJourneyTimeline();

                    // Fetch and display GitHub activity
                    this.fetchGitHubActivity();
                }
            }))
        })

        // 3D Project Visualisation
        function init3DProjectVisualisation() {
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer();
            renderer.setSize(400, 300);
            document.getElementById('project-visualisation').appendChild(renderer.domElement);

            const geometry = new THREE.BoxGeometry();
            const material = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
            const cube = new THREE.Mesh(geometry, material);
            scene.add(cube);

            camera.position.z = 5;

            function animate() {
                requestAnimationFrame(animate);
                cube.rotation.x += 0.01;
                cube.rotation.y += 0.01;
                renderer.render(scene, camera);
            }
            animate();
        }

        // Coding Journey Timeline
        function initCodingJourneyTimeline() {
            const timeline = [
                { year: 2015, event: 'Started learning to code' },
                { year: 2016, event: 'Built first website' },
                { year: 2018, event: 'Landed first developer job' },
                { year: 2020, event: 'Led major project at Tech Co.' },
                { year: 2022, event: 'Contributed to popular open-source project' }
            ];

            const timelineContainer = document.getElementById('journey-timeline');
            timeline.forEach((item, index) => {
                const eventElement = document.createElement('div');
                eventElement.classList.add('flex', 'items-center', 'mb-4');
                eventElement.innerHTML = `
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">${item.year}</div>
                    <div class="ml-4">
                        <p class="text-gray-800 font-semibold">${item.event}</p>
                    </div>
                `;
                timelineContainer.appendChild(eventElement);

                // Animate timeline items
                gsap.from(eventElement, {
                    opacity: 0,
                    x: -50,
                    duration: 0.5,
                    delay: index * 0.2,
                    scrollTrigger: {
                        trigger: eventElement,
                        start: 'top bottom-=100',
                    }
                });
            });
        }

        // Fetch GitHub Activity
        function fetchGitHubActivity() {
            // This is a mock function. In a real scenario, you'd fetch data from GitHub's API
            const mockActivity = [
                { type: 'commit', repo: 'awesome-project', message: 'Fixed critical bug in login system' },
                { type: 'pull_request', repo: 'open-source-contrib', message: 'Added new feature for user profiles' },
                { type: 'issue', repo: 'community-project', message: 'Reported performance issue in dashboard' }
            ];

            const activityContainer = document.getElementById('github-activity');
            mockActivity.forEach(activity => {
                const activityElement = document.createElement('div');
                activityElement.classList.add('flex', 'items-center', 'space-x-4');
                activityElement.innerHTML = `
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-800">${activity.type} in ${activity.repo}</p>
                        <p class="text-sm text-gray-600">${activity.message}</p>
                    </div>
                `;
                activityContainer.appendChild(activityElement);
            });
        }
    </script>
</body>
</html>