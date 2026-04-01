@extends('layouts.signup')

@section('title', 'Prerequisites - OurPhoneMD')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center w-full h-full bg-blend-multiply" style="background-image: url('https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg?t=st=1746139347~exp=1746142947~hmac=c73e58a65605a23c92ca600973692cc8372440233a35d7e4552b6ae9d820da4c&w=1060');">
        <div class="absolute inset-0 bg-customTeal/20"></div>
    </div>
    <div class="w-full max-w-5xl bg-white rounded-lg shadow-xl p-4 pb-6 z-10">
        <div class="mt-8">
            <form action="{{ route('signup.confirm-prerequisites') }}" method="POST" class="space-y-2">
                @csrf
                <div class="w-full flex items-center justify-between border-b border-gray-200 pb-2 mb-4 -mt-6">
                    <a href="{{ route('signup.back-to-terms') }}" class="flex items-center px-3 py-1.5 rounded-md transition-all duration-200 text-gray-600 hover:text-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left h-4 w-4 mr-1.5">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                        <span class="text-sm font-medium">Back</span>
                    </a>
                    <h2 class="text-xl font-semibold text-customTeal">Prerequisites</h2>
                    <div class="w-20"></div>
                </div>
                <div class="space-y-2">
                    <div class="space-y-6">
                        <div class="rounded-xl border bg-card text-card-foreground shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="font-semibold leading-none tracking-tight text-center">
                                    <span class="text-red-600 text-2xl font-semibold block mb-2">BEFORE MOVING FORWARD MAKE SURE AND HAVE THESE THINGS.</span>
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="flex flex-col md:flex-row justify-around items-center gap-8 py-6">
                                    <div class="flex flex-col items-center w-48">
                                        <img alt="Email/Text Messaging" loading="lazy" width="60" height="60" decoding="async" data-nimg="1" src="/images/gmail.png" style="color: transparent;">
                                        <div class="font-bold text-lg text-center mt-4">Access to Email/Text Messaging</div>
                                    </div>
                                    <div class="flex flex-col items-center w-48">
                                        <img alt="Insurance" loading="lazy" width="60" height="60" decoding="async" data-nimg="1" src="/images/treatment-plan.png" style="color: transparent;">
                                        <div class="font-bold text-lg text-center mt-4">Access to Insurance</div>
                                        <div class="text-purple-700 text-sm mt-2 text-center">[ Insurance Card Information ]</div>
                                    </div>
                                    <div class="flex flex-col items-center w-48">
                                        <img alt="Pharmacy Details" loading="lazy" width="60" height="60" decoding="async" data-nimg="1" src="/images/hand-with-a-pill.png" style="color: transparent;">
                                        <div class="font-bold text-lg text-center mt-4">Pharmacy Details</div>
                                        <div class="text-purple-700 text-sm mt-2 text-center">[ Name, Contact Number, Address ]</div>
                                    </div>
                                    <div class="flex flex-col items-center w-48">
                                        <img alt="Hospital Details" loading="lazy" width="60" height="60" decoding="async" data-nimg="1" src="/images/hospital.png" style="color: transparent;">
                                        <div class="font-bold text-lg text-center mt-4">Hospital Details</div>
                                        <div class="text-purple-700 text-sm mt-2 text-center">[ Name, Contact Number, Address ]</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 id="radix-:r3o:" class="sr-only">Insurance</h2>
                <div class="flex justify-between -mt-6">
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input shadow-sm hover:text-accent-foreground h-9 px-4 py-2 bg-customTeal hover:bg-teal-700 text-white w-32" type="button" onclick="window.location.href='{{ route('signup.back-to-terms') }}'">
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
