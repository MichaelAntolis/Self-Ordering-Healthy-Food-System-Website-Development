<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Profile;
use App\Models\NutritionTracking;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout', 'profile', 'updateProfile');
        $this->middleware('auth:customer')->only('logout', 'profile', 'updateProfile');
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $credentials['is_active'] = true; // Hanya customer aktif yang bisa login

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $customer = Auth::guard('customer')->user();
            $customer->updateLastLogin();
            
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            if ($customer->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang Admin ' . $customer->name . '!');
            }
            
            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang, ' . $customer->name . '!');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput();
    }

    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'allergies' => 'nullable|string',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat customer baru
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'address' => $request->address,
                'allergies' => $request->allergies,
                'is_active' => true,
                'role' => Customer::ROLE_CUSTOMER,
            ]);

            // Buat profile default
            Profile::create([
                'customer_id' => $customer->id,
                'diet_type' => null,
                'low_carb' => false,
                'high_protein' => false,
                'low_fat' => false,
                'gluten_free' => false,
                'dairy_free' => false,
            ]);

            // Buat nutrition tracking default
            NutritionTracking::create([
                'customer_id' => $customer->id,
                'total_calories' => 0,
                'total_protein' => 0,
                'total_carbs' => 0,
                'total_fat' => 0,
            ]);

            // Login otomatis setelah register
            Auth::guard('customer')->login($customer);
            $customer->updateLastLogin();

            return redirect()->route('home')
                ->with('success', 'Registrasi berhasil! Selamat datang, ' . $customer->name . '!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.')
                ->withInput();
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout');
    }

    // Tampilkan profile
    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        $customer->load(['profile', 'nutritionTracking']);
        
        $recentOrders = $customer->orders()
            ->with(['foods'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('auth.profile', compact('customer', 'recentOrders'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
            // Profile fields
            'diet_type' => 'nullable|string',
            'low_carb' => 'boolean',
            'high_protein' => 'boolean',
            'low_fat' => 'boolean',
            'gluten_free' => 'boolean',
            'dairy_free' => 'boolean',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update customer data
            $customerData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'allergies' => $request->allergies,
            ];

            // Jika ada password baru
            if ($request->filled('password')) {
                if ($request->filled('current_password')) {
                    if (!Hash::check($request->current_password, $customer->password)) {
                        return redirect()->back()
                            ->withErrors(['current_password' => 'Password lama tidak benar'])
                            ->withInput();
                    }
                }
                $customerData['password'] = $request->password;
            }

            $customer->update($customerData);

            // Update profile
            $profileData = [
                'diet_type' => $request->diet_type,
                'low_carb' => $request->boolean('low_carb'),
                'high_protein' => $request->boolean('high_protein'),
                'low_fat' => $request->boolean('low_fat'),
                'gluten_free' => $request->boolean('gluten_free'),
                'dairy_free' => $request->boolean('dairy_free'),
            ];

            $customer->profile()->updateOrCreate(
                ['customer_id' => $customer->id],
                $profileData
            );

            return redirect()->back()
                ->with('success', 'Profile berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profile')
                ->withInput();
        }
    }
}