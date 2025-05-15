<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_])[A-Za-z\d@$!%*?&_]{8,}$/',
                'phone' => 'required|string|max:15|unique:users',
            ], [
                'password.regex' => 'Password must contain at least one uppercase, one lowercase, one number and one special character'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('show_register', true);
            }

            $validated = $validator->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
            ]);

            // Log in the user after registration
            Auth::login($user);

            return back()->with('success', 'Registration successful! Welcome to your account.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Registration failed. Please try again later.');
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $remember = $request->has('remember');
            $previousUrl = $request->input('previous', route('dashboard')); // Default ke dashboard

            if (!Auth::attempt($credentials, $remember)) {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            $request->session()->regenerate();

            // Simpan data user ke session
            $request->session()->put([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'user_email' => Auth::user()->email
            ]);

            $user = Auth::user();

            // Jika admin, redirect ke dashboard admin
            if ($user->role === 'admin') {
                return redirect()
                    ->to(route('admin.dashboard'))
                    ->with([
                        'success' => 'Welcome Admin!',
                        'user_name' => $user->name
                    ]);
            }

            return redirect()
                ->intended(route('dashboard'))
                ->with([
                    'success' => 'Login successful!',
                    'user_name' => $user->name
                ]);
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('show_login', true);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
