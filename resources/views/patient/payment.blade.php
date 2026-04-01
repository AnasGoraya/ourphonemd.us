@extends('layouts.patient')

@section('title', 'Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Make Payment</h3>

                <div id="payment-message" class="alert d-none"></div>

                <form id="payment-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Amount (USD)</label>
                        <input type="number" id="amount" class="form-control" value="100" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Card Details</label>
                        <div id="card-element" class="form-control p-2"></div>
                    </div>

                    <button id="submit" class="btn btn-primary w-100 mt-3">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create("card", { hidePostalCode: true });
    card.mount("#card-element");

    const form = document.getElementById("payment-form");
    const messageBox = document.getElementById("payment-message");

    form.addEventListener("submit", async function(e) {
        e.preventDefault();
        messageBox.classList.add("d-none");

        const { token, error } = await stripe.createToken(card);

        if (error) {
            messageBox.classList.remove("d-none");
            messageBox.classList.add("alert-danger");
            messageBox.textContent = error.message;
            return;
        }

        const response = await fetch("{{ route('patient.charge') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                token: token.id,
                amount: document.getElementById("amount").value * 100,
                currency: "usd",
                description: "Appointment Payment"
            })
        });

        const data = await response.json();

        if (data.success) {
            messageBox.classList.remove("d-none");
            messageBox.classList.remove("alert-danger");
            messageBox.classList.add("alert-success");
            messageBox.textContent = "Payment successful! ✅";
        } else {
            messageBox.classList.remove("d-none");
            messageBox.classList.add("alert-danger");
            messageBox.textContent = data.error || "Payment failed.";
        }
    });
});
</script>
@endsection
