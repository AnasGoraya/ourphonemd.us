@extends('layouts.patient')

@section('title', 'Book an Appointment - Step 4')

@section('content')
    <style>
        .text-customTeal {
            color: rgb(87, 165, 150) !important;
            font-weight: 700 !important;
        }

        .bg-customTeal {
            background-color: rgb(87, 165, 150) !important;
        }

        .border-customTeal {
            border-color: rgb(87, 165, 150) !important;
        }

        .bg-green-500 {
            background-color: rgb(87, 165, 150) !important;
        }
    </style>
    <div class="flex-1 p-4 lg:ml-0">
        <div class="max-w-4xl mx-auto">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="mb-6">
                <a class="d-inline-flex align-items-center text-secondary" href="{{ route('patient.appointment.dashboard') }}"
                    style="font-size: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-left mr-1">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    <span>Back to Appointments</span>
                </a>
            </div>
            <div class="rounded-xl border bg-white shadow-sm" style="border-color: #e3e6f0;">
                <div class="px-4 pt-4 pb-2">
                    <div class="h4 font-weight-bold text-customTeal mb-1">Book an Appointment</div>
                    <div class="text-muted mb-3" style="font-size: 0.98rem;">Complete the form below to schedule your
                    <div class="d-flex align-items-center justify-content-between mb-4" style="gap: 0.5rem;">
                        <div class="wizard-step active">1</div>
                        <div class="wizard-bar"></div>
                        <div class="wizard-step active">2</div>
                        <div class="wizard-bar"></div>
                        <div class="wizard-step active">3</div>
                        <div class="wizard-bar"></div>
                        <div class="wizard-step active">4</div>
                    </div>
                    <style>
                        .wizard-step {
                            width: 38px;
                            height: 38px;
                            border-radius: 50%;
                            background: rgb(87, 165, 150);
                            color: #fff;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: 700;
                            font-size: 1.2rem;
                            box-shadow: 0 2px 6px rgba(87, 165, 150, 0.08);
                            border: 2px solid rgb(87, 165, 150);
                            transition: background 0.2s, color 0.2s;
                        }
                                    <!-- Insurance Selection Section (shown when insurance payment is selected) -->
                        .wizard-bar {
                            flex: 1;
                            height: 4px;
                            background: linear-gradient(90deg, rgb(87, 165, 150) 60%, #e3e6f0 100%);
                            border-radius: 2px;
                            margin: 0 2px;
                        }
                    </style>
                                    <div id="insuranceSelection" class="hidden p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <h6 class="font-medium text-blue-800 mb-3">Select Insurance Policy</h6>
                                        <div id="insuranceOptions" class="space-y-2">
                                            <!-- Insurance options will be loaded here -->
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" onclick="window.location.href='{{ route('patient.insurance') }}'"
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium h-8 rounded-md text-xs px-3 py-2 bg-customTeal text-white hover:bg-customTeal/90 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-plus h-4 w-4">
                                                    <path d="M5 12h14"></path>
                                                    <path d="M12 5v14"></path>
                                                </svg>
                                                Add New Insurance
                                            </button>
                                        </div>
                                    </div>

                                    <!-- No Insurance Warning (shown when no insurance exists) -->
                                    <div id="noInsuranceWarning"
                                    <div
                                        class="flex items-center justify-between gap-2 p-2 bg-red-50 border border-red-200 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-circle-alert h-4 w-4 text-red-500">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" x2="12" y1="8" y2="12">
                                                </line>
                                                <line x1="12" x2="12.01" y1="16" y2="16">
                                                </line>
                                            </svg>
                                            <span class="text-sm text-red-700">Can't switch to insurance as
                                                {{ Auth::guard('patient')->user()->first_name }}
                                                {{ Auth::guard('patient')->user()->last_name }} doesn't have
                                                insurance</span>
                                        </div>
                                        <div>
                                            <button
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium h-8 rounded-md text-xs px-4 py-2 bg-customTeal text-white hover:bg-customTeal/90 hover:text-white"
                                                type="button" onclick="window.location.href='{{ route('patient.insurance') }}'">
                                            {{-- <button
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium h-8 rounded-md text-xs px-4 py-2 bg-customTeal text-white hover:bg-customTeal/90 hover:text-white"
                                                type="button">
>>>>>>> e848bd541e60b1a9b72896dfcdd382d35d4d30c7
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-shield h-4 w-4 text-white">
                                                    <path
                                                        d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                                    </path>
                                                </svg>
                                                Add Insurance
                                            </button>
                                            </button> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold">Total Amount (Card Payments):</span>
                                        <span class="text-2xl font-bold text-customTeal">$100</span>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t pt-4">
                                <div class="space-y-4">
                                    <div class="text-lg font-medium text-center">Payment Options for 1 pending
                                        appointment</div>
                                    <div class="bg-customTeal/5 p-4 rounded-lg border border-customTeal/20">
                                        <div class="flex justify-between items-center mb-3">
                                            <div>
                                                <h4 class="font-medium text-gray-600">Card Payment</h4>
                                                <p class="font-medium text-md"><span class="text-gray-700">1
                                                        appointment to pay with card for </span><span
                                                        class="text-customTeal/100">{{ Auth::guard('patient')->user()->first_name }}
                                                        {{ Auth::guard('patient')->user()->last_name }}</span></p>
                                            </div>
                                            <span class="text-xl font-bold text-customTeal/100">$100</span>
                                        </div>
                                        <button type="button"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-12 rounded-md px-8 w-full bg-customTeal/100 hover:bg-customTeal/80 text-white border-none"
                                            style="width: 100%; text-align: center; background-color: #51A897 !important; padding: 16px 32px; border: none !important; outline: none !important;"
                                            data-toggle="modal" data-target="#cardPaymentModal"
                                            onclick="document.getElementById('cardPaymentModal').style.display='block'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-credit-card h-4 w-4 mr-2">
                                                <rect width="20" height="14" x="2" y="5" rx="2">
                                                </rect>
                                                <line x1="2" x2="22" y1="10" y2="10">
                                                </line>
                                            </svg>
                                            Pay $100 with Card
                                        </button>
                                        <br>
                                        <br>
                                        <br>
                                        {{-- <form>
                                          <div id="card-element" class="form-control"></div>
                                          <button class="btn btn-primary w-100 mt-2" type="submit" onclick="createToken()">Submit</button>
                                      </form> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between pt-6">
                        <button type="button" onclick="window.history.back()"
                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-left h-4 w-4 mr-2">
                                <path d="m15 18-6-6 6-6"></path>
                            </svg>
                            Back to {{ Auth::guard('patient')->user()->first_name }}'s Form
                        </button>
                    </div>

                    <!-- Card Payment Modal -->
                    <div id="cardPaymentModal" class="modal" tabindex="-1" role="dialog"
                        style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.35);">
                        <div class="modal-dialog" role="document"
                            style="max-width:400px;margin:5% auto;">
                            <div class="modal-content rounded-lg shadow-lg"
                                style="background:#fff;">
                                <div class="modal-header d-flex justify-content-between align-items-center"
                                    style="border-bottom:1px solid #e3e6f0;padding:1rem 1.5rem;">
                                    <h5 class="modal-title text-customTeal">Card Payment</h5>
                                    <button type="button" class="close btn btn-light"
                                        onclick="window.location.href='{{ url('/patient/appointments/new/step4') }}'"
                                        style="font-size:1.5rem;line-height:1;">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    @if($errors->has('payment'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('payment') }}
                                        </div>
                                    @endif
                                    <form method="POST"
                                        action="{{ route('patient.appointments.pay') }}">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="cardName">Name on Card</label>
                                            <input type="text" class="form-control"
                                                id="cardName" name="cardName"
                                                placeholder="Full Name" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="cardNumber">Card Number</label>
                                            <input type="text" class="form-control"
                                                id="cardNumber" name="cardNumber"
                                                placeholder="XXXX XXXX XXXX XXXX" required maxlength="19"
                                                oninput="formatCardNumber(this)">
                                        <script>
                                        function formatCardNumber(input) {
                                            let value = input.value.replace(/\D/g, '');
                                            let formatted = value.match(/.{1,4}/g);
                                            input.value = formatted ? formatted.join(' ') : '';
                                        }
                                        </script>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="form-group col-md-6">
                                                <label for="cardExpMonth">Expiry Month</label>
                                                <input type="text" class="form-control"
                                                    id="cardExpMonth" name="cardExpMonth"
                                                    placeholder="MM" required maxlength="2" pattern="(0[1-9]|1[0-2])">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cardExpYear">Expiry Year</label>
                                                <input type="text" class="form-control"
                                                    id="cardExpYear" name="cardExpYear"
                                                    placeholder="YY" required maxlength="2" pattern="(2[5-9]|[3-9][0-9])">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="cardCVC">CVC</label>
                                            <input type="text" class="form-control"
                                                id="cardCVC" name="cardCVC" placeholder="CVC"
                                                required maxlength="4">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100" onclick="
                                            console.log('=== PAYMENT SUBMISSION ===');
                                            console.log('Card Name: ' + document.getElementById('cardName').value);
                                            console.log('Card Number: ****' + document.getElementById('cardNumber').value.slice(-4));
                                            console.log('Expiry: ' + document.getElementById('cardExpMonth').value + '/' + document.getElementById('cardExpYear').value);
                                            console.log('Submitting form to: {{ route('patient.appointments.pay') }}');
                                        ">Pay $100</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
