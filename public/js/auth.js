const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const authContainer = document.getElementById('auth-container');
const authForms = document.getElementById('auth-forms');

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const showIcon = document.getElementById(`${inputId}-show`);
    const hideIcon = document.getElementById(`${inputId}-hide`);

    if (input.type === 'password') {
        input.type = 'text';
        showIcon.classList.add('hidden');
        hideIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        hideIcon.classList.add('hidden');
        showIcon.classList.remove('hidden');
    }
}

function showRegister() {
    // Add height transition class
    authContainer.classList.add('height-transition');

    // Set new height before transition
    authContainer.style.height = `${registerForm.offsetHeight}px`;

    // Start form transitions
    loginForm.classList.add('hide-forward');
    registerForm.classList.add('show-forward');

    // Remove transition class after animation completes
    setTimeout(() => {
        authContainer.classList.remove('height-transition');
    }, 400);
}

function showLogin() {
    // Add height transition class
    authContainer.classList.add('height-transition');

    // Set new height before transition
    authContainer.style.height = `${loginForm.offsetHeight}px`;

    // Start form transitions
    registerForm.classList.add('hide-backward');
    loginForm.classList.add('show-backward');

    // Remove transition class after animation completes
    setTimeout(() => {
        authContainer.classList.remove('height-transition');
    }, 400);
}

// Initialize
window.addEventListener('DOMContentLoaded', () => {
    // Set initial height
    authContainer.style.height = `${loginForm.offsetHeight}px`;

    // Check if we need to show register form initially
    @if (session('show_register') || $errors->has('name') || $errors->has('password_confirmation'))
        registerForm.classList.add('show-forward');
    loginForm.classList.add('hide-forward');
    authContainer.style.height = `${registerForm.offsetHeight}px`;
    @endif
});

// Handle errors to show appropriate form
@if ($errors->has('name') || $errors->has('password_confirmation') || $errors->has('terms'))
    document.addEventListener('DOMContentLoaded', function () {
        showRegister();
    });
@endif