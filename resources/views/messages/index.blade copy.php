
@section('title', 'Messages')

<x-app-layout>
<style>
    p {
        font-size: 16px;
    }
</style>
<div class="flex h-screen" style="">
    <!-- Sidebar -->
    <div class="w-screen">
        <div class="flex h-screen bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Chat List (Left Side) -->
            <div class="w-1/4 border-r border-gray-200">
                <div class="px-4 py-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800">Messages</h2>
                </div>
                <div class="overflow-y-auto h-full">
                    <!-- Chat List Items -->
                    <div class="p-4 border-b border-gray-200 hover:bg-gray-50 cursor-pointer">
                        <div class="flex items-center mb-2">
                            <img src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-1/456445801_2244700645866434_6418148109749604750_n.jpg?stp=dst-jpg_s200x200&_nc_cat=102&ccb=1-7&_nc_sid=0ecb9b&_nc_eui2=AeGAGPNkH1lR6Swb5_elVPxoec5XhGHI9nN5zleEYcj2c4TuKMWeNRTmNIpYBAUHjsBhOH1VBYb6mftOgnNsZMF4&_nc_ohc=wZO3UyQ06eMQ7kNvgGw2llB&_nc_ht=scontent.fmnl17-5.fna&oh=00_AYC9B4_TCQIxYJ4omFDOgE1q-MwQUPea7te2xFpr4jJKTQ&oe=66DD1279" alt="User 1" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <h3 class="text-gray-800 font-semibold">Wilbur Grefaldo</h3>
                                <p class=" text-gray-600">You: Okay naman so far</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">2 mins ago</p>
                    </div>
                    <div class="p-4 border-b border-gray-200 hover:bg-gray-50 cursor-pointer">
                        <div class="flex items-center mb-2">
                            <img src="https://scontent.fmnl17-4.fna.fbcdn.net/v/t39.30808-1/453773225_2247510978934607_3469568608843802206_n.jpg?stp=dst-jpg_s200x200&_nc_cat=104&ccb=1-7&_nc_sid=0ecb9b&_nc_eui2=AeElKf0-q9w7bOwGZ7mW1vMySYL4qHTQKFVJgviodNAoVW-B2j75OQ_H79L7A8Vx19zjTmwziPQegoECrsSpGg8w&_nc_ohc=4yU6SoeUzOcQ7kNvgFUorDl&_nc_ht=scontent.fmnl17-4.fna&oh=00_AYBQTfNzQvJbber3Fcck53uhovshM-hiX2IRkeeMgMV2HQ&oe=66DD15A7" alt="User 2" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <h3 class="text-gray-800 font-semibold">Veronica Dalisay</h3>
                                <p class="text-gray-600">Can we meet tomorrow?</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">1 hour ago</p>
                    </div>
                    <!-- Add more chat list items here -->
                </div>
            </div>

            <!-- Conversation Area (Right Side) -->
            <div class="w-3/4 flex flex-col">
                <!-- Conversation Header -->
                <div class="p-4 border-b border-gray-200 flex items-center">
                    <img src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-1/456445801_2244700645866434_6418148109749604750_n.jpg?stp=dst-jpg_s200x200&_nc_cat=102&ccb=1-7&_nc_sid=0ecb9b&_nc_eui2=AeGAGPNkH1lR6Swb5_elVPxoec5XhGHI9nN5zleEYcj2c4TuKMWeNRTmNIpYBAUHjsBhOH1VBYb6mftOgnNsZMF4&_nc_ohc=wZO3UyQ06eMQ7kNvgGw2llB&_nc_ht=scontent.fmnl17-5.fna&oh=00_AYC9B4_TCQIxYJ4omFDOgE1q-MwQUPea7te2xFpr4jJKTQ&oe=66DD1279" alt="Current User" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Wilbur Grefaldo</h2>
                        <p class="text-sm ml-3 text-green-500"><ion-icon name="ellipse" class="absolute" style="margin-top: 3px; margin-left: -15px;"></ion-icon>Online</p>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4">
                    <!-- Received Message -->
                    <div class="flex mb-4">
                        <img src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-1/456445801_2244700645866434_6418148109749604750_n.jpg?stp=dst-jpg_s200x200&_nc_cat=102&ccb=1-7&_nc_sid=0ecb9b&_nc_eui2=AeGAGPNkH1lR6Swb5_elVPxoec5XhGHI9nN5zleEYcj2c4TuKMWeNRTmNIpYBAUHjsBhOH1VBYb6mftOgnNsZMF4&_nc_ohc=wZO3UyQ06eMQ7kNvgGw2llB&_nc_ht=scontent.fmnl17-5.fna&oh=00_AYC9B4_TCQIxYJ4omFDOgE1q-MwQUPea7te2xFpr4jJKTQ&oe=66DD1279" alt="John Doe" class="w-8 h-8 rounded-full mr-2">
                        <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                            <p class="">Hey, how's it going?</p>
                        </div>
                    </div>

                    <!-- Sent Message -->
                    <div class="flex mb-4 justify-end">
                        <div class="bg-blue-500 text-white rounded-lg p-3 max-w-xs">
                            <p class="">Okay naman so far</p>
                        </div>
                    </div>

                    <!-- Add more messages here -->
                </div>

                <!-- Message Input Area -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <input type="text" placeholder="Type a message..." class="w-full border border-gray-300 rounded-full py-2 px-4 mr-2 focus:outline-none focus:border-blue-500">
                        <button class="bg-blue-500 text-white rounded-full p-2 hover:bg-blue-600 focus:outline-none">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
