@extends('layouts.signup')

@section('title', 'Age Verification - OurPhoneMD')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center w-full h-full bg-blend-multiply" style="background-image: url('https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060');">
        <div class="absolute inset-0 bg-customTeal/20"></div>
    </div>
    <div class="w-full max-w-5xl bg-white rounded-lg shadow-xl p-4 pb-6 z-10">
        <div class="mt-8">
            <form action="{{ route('signup.submit-age-verification') }}" method="POST" class="space-y-2">
                @csrf
                <div class="w-full flex items-center justify-between border-b border-gray-200 pb-2 mb-4 -mt-6">
                    <a href="{{ route('signup.back-to-prerequisites') }}" class="flex items-center px-3 py-1.5 rounded-md transition-all duration-200 text-gray-600 hover:text-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left h-4 w-4 mr-1.5">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                        <span class="text-sm font-medium">Back</span>
                    </a>
                    <h2 class="text-xl font-semibold text-customTeal">Age Verification</h2>
                    <div class="w-20"></div>
                </div>
                <div class="space-y-2">
                    <div class="space-y-6">
                        <div class="rounded-xl border bg-card text-card-foreground border-customTeal/20 shadow-md overflow-hidden">
                            <div class="bg-gradient-to-r from-customTeal to-customTeal/70 p-1"></div>
                            <div class="flex flex-col space-y-1.5 p-6 pb-2">
                                <p class="text-gray-500 text-sm mb-4">Please select the option that best describes your situation</p>
                            </div>
                            <div class="p-6 pt-0 space-y-6">
                                <div class="space-y-5">
                                    <label for="adult" class="block relative border rounded-md p-4 cursor-pointer transition-colors border-gray-200 hover:border-customTeal/50">
                                        <div class="flex items-start space-x-3 space-y-0">
                                            <input id="adult" class="h-6 w-6 mt-1 accent-teal-700 border-gray-300 focus:ring-customTeal" type="radio" name="age_verification" value="adult" required>
                                            <div>
                                                <div class="font-medium text-gray-800">I am 18 years or older</div>
                                                <p class="text-sm text-gray-500">I am registering for myself and can provide identification</p>
                                            </div>
                                        </div>
                                    </label>
                                    <label for="guardian" class="block relative border rounded-md p-4 cursor-pointer transition-colors border-gray-200 hover:border-customTeal/50">
                                        <div class="flex items-start space-x-3 space-y-0">
                                            <input id="guardian" class="h-6 w-6 mt-1 accent-teal-700 border-gray-300 focus:ring-customTeal" type="radio" name="age_verification" value="guardian" required>
                                            <div>
                                                <div class="font-medium text-gray-800">I am a parent or legal guardian</div>
                                                <p class="text-sm text-gray-500">I am registering on behalf of someone under 18 years old</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-md text-sm">
                                    <p><strong>Important:</strong> Valid identification and/or legal guardianship documentation may be required during your first visit.</p>
                                </div>
                                @error('age_verification')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <h2 id="radix-:r3o:" class="sr-only">Insurance</h2>
                <div class="flex justify-between -mt-6">
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input shadow-sm hover:text-accent-foreground h-9 px-4 py-2 bg-customTeal hover:bg-teal-700 text-white w-32" type="button" onclick="window.location.href='{{ route('signup.back-to-prerequisites') }}'">
                        Previous
                    </button>
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 shadow h-9 px-4 py-2 ml-auto bg-customTeal hover:bg-teal-700 text-white w-32" type="submit">
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
