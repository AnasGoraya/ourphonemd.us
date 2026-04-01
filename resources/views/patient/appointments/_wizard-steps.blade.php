@props(['currentStep'])

<style>
    .wizard-step {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #e3e6f0;
        color: #aaa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 2px 6px rgba(87,165,150,0.08);
        border: 2px solid #e3e6f0;
        transition: background 0.2s, color 0.2s;
        flex-shrink: 0;
    }
    .wizard-step.active {
        background: rgb(87, 165, 150);
        color: #fff;
        border-color: rgb(87, 165, 150);
    }
    .wizard-bar {
        flex: 1;
        height: 4px;
        background: #e3e6f0;
        border-radius: 2px;
        margin: 0 2px;
        transition: background 0.3s;
    }
    .wizard-bar.active {
        background: rgb(87, 165, 150);
    }
</style>

<div class="d-flex align-items-center justify-content-between" style="gap: 0.5rem;">
    {{-- Step 1 --}}
    <div class="wizard-step {{ $currentStep >= 1 ? 'active' : '' }}">1</div>
    <div class="wizard-bar {{ $currentStep > 1 ? 'active' : '' }}"></div>

    {{-- Step 2 --}}
    <div class="wizard-step {{ $currentStep >= 2 ? 'active' : '' }}">2</div>
    <div class="wizard-bar {{ $currentStep > 2 ? 'active' : '' }}"></div>

    {{-- Step 3 --}}
    <div class="wizard-step {{ $currentStep >= 3 ? 'active' : '' }}">3</div>
    <div class="wizard-bar {{ $currentStep > 3 ? 'active' : '' }}"></div>

    {{-- Step 4 --}}
    <div class="wizard-step {{ $currentStep >= 4 ? 'active' : '' }}">4</div>
</div>
