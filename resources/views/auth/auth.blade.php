<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication | KANAYA KOST</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="bg-gray-50 flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900">KANAYA KOST</h1>
                <p class="mt-2 text-sm text-gray-600">Welcome back! Please sign in to your account</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="rounded-md bg-green-50 p-4 mb-4 animate-fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="rounded-md bg-red-50 p-4 mb-4 animate-fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div id="auth-container" class="bg-white shadow-md rounded-lg">
                <div id="auth-forms" class="auth-form-container relative">

                    <!-- Login Form -->
                    <div id="login-form" class="auth-form login-form p-8">
                        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Sign In</h2>
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label for="login-email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input id="login-email" name="email" type="email" autocomplete="email" required
                                    value="{{ old('email') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    Password
                                </label>

                                <div class="relative flex items-center">
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm pr-10 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                    <!-- Icon toggle -->
                                    <button
                                        type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute right-0 flex items-center justify-center w-10 h-full text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg id="password-show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="password-hide" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember-me" name="remember" type="checkbox"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Sign In
                                </button>
                            </div>
                        </form>
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Don't have an account?
                                <button onclick="showRegister()" class="font-medium text-indigo-600 hover:text-indigo-500">Sign up</button>
                            </p>
                        </div>
                    </div>

                    <!-- Register Form -->
                    <div id="register-form" class="auth-form register-form p-8">
                        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create Account</h2>
                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label for="register-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input id="register-name" name="name" type="text" autocomplete="name" required
                                    value="{{ old('name') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="register-email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input id="register-email" name="email" type="email" autocomplete="email" required
                                    value="{{ old('email') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="register-phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input id="register-phone" name="phone" type="tel" required
                                    pattern="[0-9]{10,15}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('phone') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Phone number must be 10-15 digits.</p>
                                @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="register-password" class="block text-sm font-medium text-gray-700">Password</label>

                                <div class="relative mt-1">
                                    <input
                                        id="register-password"
                                        name="password"
                                        type="password"
                                        autocomplete="new-password"
                                        required
                                        class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">

                                    <button
                                        type="button"
                                        onclick="togglePassword('register-password')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500">
                                        <svg id="register-password-show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="register-password-hide" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>

                                <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters and contain uppercase, lowercase, number, and special character.</p>
                                @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="register-password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>

                                <div class="relative mt-1">
                                    <input
                                        id="register-password-confirm"
                                        name="password_confirmation"
                                        type="password"
                                        autocomplete="new-password"
                                        required
                                        class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                    <button
                                        type="button"
                                        onclick="togglePassword('register-password-confirm')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500">
                                        <svg id="register-password-confirm-show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="register-password-confirm-hide" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded @error('terms') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                <label for="terms" class="ml-2 block text-sm text-gray-900">
                                    I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                                </label>
                            </div>
                            @error('terms')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Create Account
                                </button>
                            </div>
                        </form>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Already have an account?
                                <button onclick="showLogin()" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} KANAYA KOST. All rights reserved.</p>
            </div>
        </div>
    </div>
    <script>
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const authContainer = document.getElementById('auth-container');
        const authForms = document.getElementById('auth-forms');

        function showRegister() {
            document.getElementById('login-form').classList.add('hide-forward');
            document.getElementById('login-form').classList.remove('show-backward');
            document.getElementById('register-form').classList.add('show-forward');
            document.getElementById('register-form').classList.remove('hide-backward');
            authContainer.style.height = `${registerForm.offsetHeight}px`;
        }

        function showLogin() {
            document.getElementById('register-form').classList.add('hide-backward');
            document.getElementById('register-form').classList.remove('show-forward');
            document.getElementById('login-form').classList.add('show-backward');
            document.getElementById('login-form').classList.remove('hide-forward');
            authContainer.style.height = `${loginForm.offsetHeight}px`;
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const showIcon = document.getElementById(inputId + '-show');
            const hideIcon = document.getElementById(inputId + '-hide');

            if (input.type === 'password') {
                input.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
            }
        }

        // Initialize
        window.addEventListener('DOMContentLoaded', () => {
            // Set initial height
            authContainer.style.height = `${loginForm.offsetHeight}px`;

            // Check if we need to show register form initially
            @if(session('show_register') || $errors->has('name') || $errors->has('password_confirmation'))
            registerForm.classList.add('show-forward');
            loginForm.classList.add('hide-forward');
            authContainer.style.height = `${registerForm.offsetHeight}px`;
            @endif
        });

        // Handle errors to show appropriate form
        @if($errors->has('name') || $errors->has('password_confirmation') || $errors->has('terms'))
        document.addEventListener('DOMContentLoaded', function() {
            showRegister();
        });
        @endif
    </script>
</body>

</html>