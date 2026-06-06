<x-admin-layout>

<div class="container mx-auto px-4 py-6 max-w-3xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.admin-users.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <i class='bx bx-arrow-back text-2xl'></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create New Admin User</h1>
        </div>
        <p class="text-gray-600 ml-11">Create a new administrator account with admin role</p>
    </div>

    <!-- Info Card -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
        <div class="flex items-start">
            <i class='bx bx-info-circle text-2xl text-blue-500 mr-3 mt-0.5'></i>
            <div>
                <h3 class="font-semibold text-blue-900 mb-1">Important Information</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• A random secure password will be automatically generated</li>
                    <li>• The new admin will receive a welcome email with their login credentials</li>
                    <li>• They should change their password after first login for security</li>
                    <li>• The admin role grants access to most admin panel features</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form method="POST" action="{{ route('admin.admin-users.store') }}" class="p-6 space-y-6" x-data="{ submitting: false }" @submit="submitting = true">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required
                       placeholder="e.g., John Smith"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class='bx bx-error-circle mr-1'></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required
                       placeholder="e.g., admin@example.com"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class='bx bx-error-circle mr-1'></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">
                    <i class='bx bx-envelope mr-1'></i>
                    A welcome email with login credentials will be sent to this address
                </p>
            </div>

            <!-- Role Information -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                    <i class='bx bx-shield text-xl text-blue-600 mr-2'></i>
                    Assigned Role
                </h3>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-700 font-medium">Administrator</p>
                        <p class="text-xs text-gray-600">Full access to admin panel features</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        <i class='bx bx-shield mr-1'></i>
                        Admin Role
                    </span>
                </div>
            </div>

            <!-- Security Info -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                <h3 class="font-semibold text-amber-900 mb-2 flex items-center">
                    <i class='bx bx-lock text-xl text-amber-600 mr-2'></i>
                    Password Security
                </h3>
                <p class="text-sm text-amber-800">
                    A strong, randomly generated password will be created automatically. The new admin will receive it via email and should change it immediately after their first login.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit"
                        :disabled="submitting"
                        :class="submitting ? 'opacity-70 cursor-not-allowed' : ''"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md transition-colors duration-200">
                    <template x-if="!submitting">
                        <i class='bx bx-user-plus text-xl mr-2'></i>
                    </template>
                    <template x-if="submitting">
                        <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </template>
                    <span x-text="submitting ? 'Creating...' : 'Create Admin User'"></span>
                </button>
                <a href="{{ route('admin.admin-users.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-colors duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Additional Information -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
            <i class='bx bx-help-circle text-xl text-gray-600 mr-2'></i>
            What happens next?
        </h3>
        <ol class="space-y-2 text-sm text-gray-700">
            <li class="flex items-start">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-600 font-semibold text-xs mr-3 mt-0.5">1</span>
                <span>Account is created with the <strong>admin</strong> role</span>
            </li>
            <li class="flex items-start">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-600 font-semibold text-xs mr-3 mt-0.5">2</span>
                <span>Welcome email is sent to the provided email address</span>
            </li>
            <li class="flex items-start">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-600 font-semibold text-xs mr-3 mt-0.5">3</span>
                <span>New admin can log in using their email and the password from the email</span>
            </li>
            {{-- <li class="flex items-start">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-600 font-semibold text-xs mr-3 mt-0.5">4</span>
                <span>Admin should change their password in their profile after first login</span>
            </li> --}}
        </ol>
    </div>
</div>
</x-admin-layout>

