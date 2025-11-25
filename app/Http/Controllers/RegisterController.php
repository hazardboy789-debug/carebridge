<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientDetail;
use App\Models\DoctorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Handle user registration (Patient or Doctor)
     */
    public function register(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                'contact'     => 'required|string|max:30',
                'password'    => 'required|min:6|confirmed',
                'role'        => 'required|in:patient,doctor',

                // Details fields
                'dob'         => 'nullable|date',
                'age'         => 'nullable|integer|min:0',
                'address'     => 'nullable|string|max:255',
                'gender'      => 'nullable|in:male,female,other',
                'description' => 'nullable|string|max:500',

                // Doctor-only fields
                'specialization' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
                'experience_years' => 'nullable|integer|min:0',
            ]);

            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'contact'  => $validated['contact'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'],
            ]);

            /**
             * Insert into patient_details or doctor_details based on role
             */
            if ($validated['role'] === 'patient') {
                
                PatientDetail::create([
                    'user_id'  => $user->id,
                    'dob'      => $validated['dob'] ?? null,
                    'age'      => $validated['age'] ?? null,
                    'address'  => $validated['address'] ?? null,
                    'gender'   => $validated['gender'] ?? null,
                    'status'   => 'active',
                ]);

            } else { // doctor registration

                DoctorDetail::create([
                    'user_id'         => $user->id,
                    'dob'             => $validated['dob'] ?? null,
                    'gender'          => $validated['gender'] ?? null,
                    'address'         => $validated['address'] ?? null,
                    'specialization'  => $validated['specialization'] ?? null,
                    'license_number'  => $validated['license_number'] ?? null,
                    'experience_years'=> $validated['experience_years'] ?? null,
                    'description'     => $validated['description'] ?? null,
                    'status'          => 'pending', // doctor needs approval
                ]);
            }

            DB::commit();

            // Log in user
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful!',
                'redirect' => $user->role === 'patient'
                    ? route('patient.dashboard')
                    : route('doctor.dashboard')
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Please fix validation errors.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error("Registration Error: ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Unexpected error. Try again later.'
            ], 500);
        }
    }
}
