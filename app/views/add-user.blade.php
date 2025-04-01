@section('title', 'Admin Dashboard')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">User Accounts</h2>
                    <a href="#" onclick="addUserTab()" class="absolute px-4 py-2 bg-blue-500 rounded-md text-white font-semibold" style="transform: translate(1030%, -85%)">Add User</a>
                </div>
                <div class="px-6 py-4">
                    @foreach (['Administrator', 'Office', 'Student'] as $role)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ ucfirst($role) }} Accounts</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">ID</th>
                                            <th class="py-3 px-6 text-left">Name</th>
                                            <th class="py-3 px-6 text-left">Email</th>
                                            <th class="py-3 px-6 text-left">Created At</th>
                                            {{-- <th class="py-3 px-6 text-center">Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @foreach ($users->where('role', $role) as $user)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer" onclick="window.location.href='{{ route('users.edit', $user->id) }}'">
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->id }}</td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->name }}</td>
                                                <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                                                <td class="py-3 px-6 text-left">{{ $user->created_at->format('M d, Y') }}</td>
                                                {{-- <td class="py-3 px-6 text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a href="#" onclick="viewUserData('{{ json_encode($user) }}')" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </a>
                                                        <a href="#" onclick="editUserData({{ json_encode($user) }})" class="text-green-600 hover:text-green-900 mr-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </a>
                                                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="addUserTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div id="formUser"  class="bg-white rounded-lg shadow-lg" style="width: 400px; max-width: 90vw;">
                <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 border">
                    <h2 class="text-2xl font-semibold mb-6">Add New Account</h2>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                    
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                            <select name="role" id="role" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                <option value="">Select Role</option>
                                <option value="Administrator">Admin</option>
                                <option value="Office">Staff</option>
                                <option value="Student">Student</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md">
                                Create Account
                            </button>
                            <a href="#" onclick="hideAddUserTab()" class="text-indigo-500 hover:text-indigo-600 font-semibold">Cancel</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <!-- View User Data Modal -->
        <div id="viewUserDataTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div class="bg-white rounded-lg shadow-lg" style="width: 500px; max-width: 90vw;">
                <div class="bg-white rounded-lg shadow-lg p-6 border">
                    <h2 class="text-2xl font-semibold mb-6">User Details</h2>
                    <div class="flex items-center mb-4">
                        <img id="userProfilePicture" class="h-16 w-16 rounded-full object-cover mr-4" src="" alt="User Profile Picture">
                        <div>
                            <h3 id="userName" class="text-xl font-semibold"></h3>
                            <p id="userEmail" class="text-gray-600"></p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-700 font-semibold">Role:</p>
                        <p id="userRole" class="text-gray-600"></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-700 font-semibold">Created At:</p>
                        <p id="userCreatedAt" class="text-gray-600"></p>
                    </div>
                    <div class="flex justify-end">
                        <a href="#" onclick="hideViewUserData()" class="text-indigo-500 hover:text-indigo-600 font-semibold">Close</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Data Modal -->
        <div id="editUserDataTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div id="formEditData" class="bg-white rounded-lg shadow-lg" style="width: 400px; max-width: 90vw;">
                <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 border">
                    <h2 class="text-2xl font-semibold mb-6">Edit Account</h2>

                    <!-- Edit User Form -->
                    <form id="editUserForm" action="{{ route('users.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                            <input type="text" name="editName" id="editName" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" name="editEmail" id="editEmail" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                            <input type="password" name="editPassword" id="editPassword" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                            <select name="editRole" id="editRole" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                <option value="">Select Role</option>
                                <option value="Administrator">Admin</option>
                                <option value="Office">Staff</option>
                                <option value="Student">Student</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md">
                                Save Edit
                            </button>
                            <a href="#" onclick="hideEditUserData()" class="text-indigo-500 hover:text-indigo-600 font-semibold">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



<script>
    function addUserTab() {
        const addUserTab = document.getElementById('addUserTab');
        const formUser = document.getElementById('formUser');
        addUserTab.style.display = 'flex';
        addUserTab.classList.add('animated-show');
        formUser.classList.add('animated-pulse');

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                hideAddUserTab();
            }
        });
    }

    function hideAddUserTab() {
        const addUserTab = document.getElementById('addUserTab');
        const formUser = document.getElementById('formUser');
        addUserTab.classList.add('animated-vanish');
        formUser.classList.add('animated-close');

        setTimeout(() => {
            addUserTab.style.display = 'none';
            addUserTab.classList.remove('animated-pulse');
            formUser.classList.remove('animated-close');
            addUserTab.classList.remove('animated-vanish');
        }, 300);
    }    

    function viewUserData(userJson) {
        const user = JSON.parse(userJson);

        const viewUserDataTab = document.getElementById('viewUserDataTab');

        const updateForm = viewUserDataTab.querySelector('#editUserForm');
        const userProfilePicture = viewUserDataTab.querySelector('#userProfilePicture');
        const userName = viewUserDataTab.querySelector('#userName');
        const userEmail = viewUserDataTab.querySelector('#userEmail');
        const userRole = viewUserDataTab.querySelector('#userRole');
        const userCreatedAt = viewUserDataTab.querySelector('#userCreatedAt');

        updateForm.textContent = user.id;
        userProfilePicture.src = user.profile_picture;
        userName.textContent = user.name;
        userEmail.textContent = user.email;
        userRole.textContent = user.role;
        userCreatedAt.textContent = user.created_at; 

        viewUserDataTab.style.display = 'flex';
        viewUserDataTab.classList.add('animated-show');

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                hideViewUserData();
            }
        });
    }

    function hideViewUserData() {
        const viewUserDataTab = document.getElementById('viewUserDataTab');
        viewUserDataTab.classList.add('animated-vanish');

        setTimeout(() => {
            viewUserDataTab.style.display = 'none';
            viewUserDataTab.classList.remove('animated-vanish');
        }, 300);
    }

    function editUserData(userJson) {
    const user = JSON.parse(userJson);

    const editUserDataTab = document.getElementById('editUserDataTab');
    const formEditData = document.getElementById('formEditData');
    let editUserForm = formEditData.querySelector('#editUserForm');

    // If the form doesn't exist, create it and append it to formEditData
    if (!editUserForm) {
        editUserForm = document.createElement('form');
        editUserForm.id = 'editUserForm';
        editUserForm.action = `{{ route('users.update') }}`;
        editUserForm.method = 'POST';
        formEditData.appendChild(editUserForm);

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        editUserForm.appendChild(csrfToken);

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        editUserForm.appendChild(methodField);

        // Add a hidden input field for the user ID
        const userIdInput = document.createElement('input');
        userIdInput.type = 'hidden';
        userIdInput.name = 'id';
        userIdInput.value = user.id;
        editUserForm.appendChild(userIdInput);
    } else {
        // Update the hidden user ID input field
        const userIdInput = editUserForm.querySelector('input[name="id"]');
        if (userIdInput) {
            userIdInput.value = user.id;
        } else {
            const newUserIdInput = document.createElement('input');
            newUserIdInput.type = 'hidden';
            newUserIdInput.name = 'id';
            newUserIdInput.value = user.id;
            editUserForm.appendChild(newUserIdInput);
        }
    }

    // ... (the rest of the code remains the same)
}

    function hideEditUserData() {
        const editUserDataTab = document.getElementById('editUserDataTab');
        editUserDataTab.classList.add('animated-vanish');

        setTimeout(() => {
            editUserDataTab.style.display = 'none';
            editUserDataTab.classList.remove('animated-vanish');
        }, 300);
    }

    // document.addEventListener('keydown', function (event) {
    //     if (event.key === 'Escape' || event.keyCode === 27) {
    //         hideAddUserTab();
    //     }
    // });


</script>