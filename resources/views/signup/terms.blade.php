
@extends('layouts.signup')

@section('title', 'Terms & Conditions - OurPhoneMD')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center w-full h-full bg-blend-multiply" style="background-image: url('https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060');">
        <div class="absolute inset-0 bg-teal-500/20"></div>
    </div>
    <div class="w-full max-w-5xl bg-white rounded-lg shadow-xl p-4 pb-6 z-10">
        <div class="mt-8">
            <form action="{{ route('signup.accept-terms') }}" method="POST" class="space-y-2">
                @csrf
                <div class="w-full flex items-center justify-between border-b border-gray-200 pb-2 mb-4 -mt-6">
                    <button type="button" disabled class="flex items-center px-3 py-1.5 rounded-md transition-all duration-200 text-gray-400 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left h-4 w-4 mr-1.5">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                        <span class="text-sm font-medium">Back</span>
                    </button>
                    <h2 class="text-xl font-semibold text-teal-600">Terms & Conditions</h2>
                    <div class="w-20"></div>
                </div>
                <div class="space-y-2">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 overflow-y-auto space-y-4">
                        <div class="text-center space-y-1">
                            <h3 class="font-semibold text-lg">OurPhoneMD Terms of Service</h3>
                            <p class="text-gray-500">Please review our terms and conditions below</p>
                        </div>
                        <p>Welcome to OurPhoneMD. By accessing our services, you agree to be bound by these Terms and Conditions.</p>
                        <h4 class="font-medium text-base mt-2">1. Medical Services</h4>
                        <p>OurPhoneMD provides telemedicine consultations and related healthcare services.</p>
                        <h4 class="font-medium text-base mt-2">2. Privacy Policy</h4>
                        <p>We are committed to protecting your privacy. All personal and medical information is handled in accordance with HIPAA regulations.</p>
                        <h4 class="font-medium text-base mt-2">3. User Responsibilities</h4>
                        <p>You agree to provide accurate, complete, and updated information about yourself.</p>
                        <h4 class="font-medium text-base mt-2">4. Medical Emergencies</h4>
                        <p>OurPhoneMD is not designed for emergency situations. If you are experiencing a medical emergency, please dial 911 immediately.</p>
                    </div>
                    <div class="pt-4 pl-4 pb-1">
                        <div class="flex flex-row items-center mx-auto text-center space-x-2 space-y-0">
                            <input type="checkbox" name="terms_accepted" id="terms_accepted" class="form-check-input" required>
                            <label for="terms_accepted" class="text-sm font-medium leading-none">I have read and accept the terms and conditions</label>
                        </div>
                        @error('terms_accepted')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-between -mt-6">
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input shadow-sm hover:text-accent-foreground h-9 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white w-32" type="button" onclick="window.location.href='{{ route('signup.back-to-terms') }}'">
                        Previous
                    </button>
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 shadow h-9 px-4 py-2 ml-auto bg-teal-600 hover:bg-teal-700 text-white w-32" type="submit">
                        Next
                    </button>
                </div>
            </form>
        </div>
        <div class="text-center mt-6">
            <p class="font-bold text-red-600 text-sm">CUSTOMER SUPPORT/APPOINTMENT BY PHONE</p>
            <p class="font-bold text-gray-900">(270) 769-0110</p>
        </div>
    </div>
</div>
@endsection
