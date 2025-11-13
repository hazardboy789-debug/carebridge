<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'contact' => 'required|string|max:30',
                'password' => 'required|min:6|confirmed',
                'dob' => 'nullable|date',
                'age' => 'nullable|integer|min:0',
                'address' => 'nullable|string|max:255',
                'gender' => 'nullable|in:male,female,other',
                'description' => 'nullable|string|max:500',
            ], [
                'name.required' => 'Please enter your name.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'contact.required' => 'Please enter your contact number.',
                'password.required' => 'Please enter a password.',
                'password.min' => 'Password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
            ]);

            DB::beginTransaction();

            try {
                // Create the user
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'contact' => $validated['contact'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'patient',
                ]);

                // Create user details
                UserDetail::create([
                    'user_id' => $user->id,
                    'dob' => $validated['dob'] ?? null,
                    'age' => $validated['age'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'gender' => $validated['gender'] ?? null,
                    'description' => $validated['description'] ?? null,
                    'status' => 'active',
                ]);

                DB::commit();

                // Log the user in
                Auth::login($user);

                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful! Redirecting to dashboard...',
                    'redirect' => route('patient.dashboard')
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Registration Error: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed. Please try again.'
                ], 500);
            }

        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json([
                'success' => false,
                'message' => 'Please correct the errors below.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Unexpected Registration Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }
}
