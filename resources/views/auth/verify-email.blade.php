<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="mt-6 text-2xl font-bold text-gray-900">Verify your email</h2>
            <p class="mt-2 text-sm text-gray-600">
                We sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
                Please check your inbox and spam folder.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow sm:rounded-lg sm:px-10 space-y-4">
                @if (session('status') === 'verification-link-sent')
                    <div class="rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="text-sm text-gray-600 text-center">
                    Verify your email before checkout and downloading purchased content.
                </p>

                <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
                    @csrf
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Resend verification email
                    </button>
                </form>

                <form method="POST" action="{{ route('auth.logout') }}" class="text-center">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
