@extends('layouts.doctor')

@section('title', 'Add Patient')
@section('page_title', 'Register Patient')

@section('content')
<div class="container-fluid" style="padding:24px;">
    <div style="max-width:920px; margin:0 auto;">
        <div style="background:#fff; border-radius:8px; padding:18px; box-shadow:0 1px 2px rgba(0,0,0,0.04);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <div>
                    <h3 style="margin:0; font-size:18px; color:#0f172a;">Register Patient</h3>
                </div>
                <div>
                    <a href="{{ url()->previous() }}" style="background:#f3f4f6; color:#0f172a; padding:8px 10px; border-radius:6px; text-decoration:none;">&larr; Back</a>
                </div>
            </div>

            @if(session('success'))
                <div style="background:#ECFDF5; color:#065F46; padding:10px 12px; border-radius:6px; margin-bottom:12px;">{{ session('success') }}</div>
            @endif

            <form action="{{ route('doctor.patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display:flex; gap:20px;">
                    <div style="flex:1;">
                        <div style="margin-bottom:10px;">
                            <label style="display:flex; gap:12px; align-items:center;"><input type="radio" name="patient_type" value="new" checked /> <span style="font-weight:700;">Add New Patient</span></label>
                            <label style="display:flex; gap:12px; align-items:center; margin-left:18px;"><input type="radio" name="patient_type" value="establish" /> <span>Establish Patient</span></label>
                        </div>

                        <div style="background:#fff; border:1px solid #eef2f4; padding:18px; border-radius:8px;">
                            <h4 style="margin-top:0; font-size:16px; color:#0f172a;">Personal Information</h4>
                            <div style="display:flex; gap:12px;">
                                <div style="flex:1;">
                                    <input id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('first_name')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_first_name" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                                <div style="flex:1;">
                                    <input id="middle_name" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('middle_name')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_middle_name" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                                <div style="flex:1;">
                                    <input id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('last_name')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_last_name" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                            </div>

                            <div style="display:flex; gap:12px; margin-top:12px;">
                                <div style="flex:1;">
                                    <input id="email" name="email" placeholder="Email*" value="{{ old('email') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('email')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_email" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                                <div style="flex:1;">
                                    <input id="password" name="password" type="password" placeholder="Password*" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('password')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_password" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                            </div>

                            <div style="display:flex; gap:12px; margin-top:12px;">
                                <div style="flex:1;">
                                    <input id="contact_number" name="contact_number" placeholder="Contact Number*" value="{{ old('contact_number') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('contact_number')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_contact_number" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                                <div style="flex:1;">
                                    <input id="secondary_contact" name="secondary_contact" placeholder="Secondary Contact Number*" value="{{ old('secondary_contact') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('secondary_contact')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_secondary_contact" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                            </div>

                            <div style="display:flex; gap:12px; margin-top:12px;">
                                <div style="flex:1;">
                                    <input id="date_of_birth" name="date_of_birth" type="date" placeholder="Date of Birth*" value="{{ old('date_of_birth') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('date_of_birth')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_date_of_birth" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                                <div style="flex:1;">
                                    <select id="gender" name="gender" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;"><option value="">Gender</option><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select>
                                    @error('gender')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_gender" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top:16px; background:#fff; border:1px solid #eef2f4; padding:18px; border-radius:8px;">
                            <h4 style="margin-top:0; font-size:16px; color:#0f172a;">Address Information</h4>
                            <div>
                                <textarea id="address" name="address" placeholder="Address" style="width:100%; min-height:80px; padding:10px; border-radius:6px; border:1px solid #e6eef5;">{{ old('address') }}</textarea>
                                @error('address')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                <div id="client_address" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                            </div>
                            <div style="display:flex; gap:12px; margin-top:12px;">
                                <div style="flex:1;">
                                    <input id="city" name="city" placeholder="City" value="{{ old('city') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('city')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_city" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                                <div style="flex:1;">
                                    <input id="state" name="state" placeholder="State" value="{{ old('state') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('state')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_state" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                                <div style="flex:1;">
                                    <input id="zip_code" name="zip_code" placeholder="Zip Code" value="{{ old('zip_code') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                    @error('zip_code')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                                    <div id="client_zip_code" style="color:#c53030; font-size:13px; margin-top:6px; display:none;"></div>
                                </div>
                            </div>
                        </div>

                                                <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                                                    <button type="submit" style="background:#1aa179; color:#fff; padding:10px 16px; border-radius:8px; font-weight:700; border:none;">Register Patient</button>
                                                </div>
                    </div>

                    <div style="width:260px;">
                        <div style="text-align:center; background:#fff; border:1px solid #eef2f4; padding:18px; border-radius:8px;">
                            <div id="avatarPreview" style="width:110px; height:110px; border-radius:50%; margin:0 auto; background:#f3f4f6; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:24px; color:#374151;">AA</div>
                            <div style="margin-top:12px;">
                                <label for="profile_picture" style="background:#1aa179; color:#fff; padding:8px 12px; border-radius:20px; cursor:pointer; display:inline-block;">Upload Photo</label>
                                <input id="profile_picture" name="profile_picture" type="file" accept="image/*" style="display:none;" />
                                @error('profile_picture')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                            </div>
                            <div style="margin-top:8px; color:#6b7280; font-size:13px;">Changes are applied after clicking Register</div>
                        </div>

                        <div style="margin-top:12px; background:#fff; border:1px solid #eef2f4; padding:12px; border-radius:8px;">
                            <div style="font-weight:700; color:#0f172a;">Guardian</div>
                            <div style="margin-top:8px;"><input name="guardian_name" placeholder="Guardian Name" value="{{ old('guardian_name') }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                                @error('guardian_name')<div style="color:#c53030; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('profile_picture')?.addEventListener('change', function(e){
    const file = this.files[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = function(ev){
        const el = document.getElementById('avatarPreview');
        el.style.backgroundImage = `url(${ev.target.result})`;
        el.style.backgroundSize = 'cover'; el.style.backgroundPosition='center'; el.textContent='';
    };
    reader.readAsDataURL(file);
});
</script>

<script>
// Client-side form validation to prevent submission until all required fields are valid
document.addEventListener('DOMContentLoaded', function(){
    const form = document.querySelector('form[action="{{ route('doctor.patients.store') }}"]');
    if(!form) return;

    const csrfToken = '{{ csrf_token() }}';
    let emailExists = false;

    // Check email uniqueness via AJAX when email input loses focus and clear flag on input
    const emailInput = document.getElementById('email');
    if(emailInput){
        emailInput.addEventListener('blur', function(){
            const val = (this.value||'').toString().trim();
            if(!val) return;
            // basic format quick check
            if(!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(val)) return;
            fetch('{{ url('/doctor/patients/check-email') }}', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken},
                body: JSON.stringify({email: val})
            }).then(r=>r.json()).then(json=>{
                if(json.exists){
                    emailExists = true;
                    showError('email', 'This email is already registered');
                } else {
                    emailExists = false;
                    const el = document.getElementById('client_email'); if(el){ el.style.display='none'; el.textContent=''; }
                    const input = document.getElementById('email'); if(input) input.style.borderColor='';
                }
            }).catch(()=>{});
        });
        // when user edits email again, clear the previous exists flag so submit triggers a fresh check
        emailInput.addEventListener('input', function(){ emailExists = false; const el = document.getElementById('client_email'); if(el){ el.style.display='none'; el.textContent=''; } this.style.borderColor=''; });
    }

    function clearClientErrors(){
        const els = document.querySelectorAll('[id^="client_"]');
        els.forEach(e=>{ e.style.display='none'; e.textContent=''; });
        const inputs = form.querySelectorAll('input,textarea,select');
        inputs.forEach(i=>{ i.style.borderColor=''; });
    }

    function showError(fieldId, msg){
        const el = document.getElementById('client_'+fieldId);
        const input = document.getElementById(fieldId);
        if(el){ el.textContent = msg; el.style.display = 'block'; }
        if(input){ input.style.borderColor = '#c53030'; }
    }

    function validate(){
        clearClientErrors();
        let valid = true;
        const nameRegex = /^[A-Za-z\s]+$/;
        const passRegex = /^[A-Za-z0-9]+$/;

        const requiredFields = ['first_name','middle_name','last_name','email','password','contact_number','secondary_contact','date_of_birth','gender','address','city','state','zip_code','guardian_name'];
        requiredFields.forEach(fid => {
            const el = document.getElementById(fid);
            const val = el ? (el.value||'').toString().trim() : '';
            if(!val){ showError(fid, 'This field is required'); valid = false; }
        });

        // names: no special chars
        ['first_name','middle_name','last_name'].forEach(nid=>{
            const el = document.getElementById(nid);
            if(el){ const v = el.value.trim(); if(v && !nameRegex.test(v)){ showError(nid,'Special characters are not allowed'); valid = false; } }
        });

        // password rules
        const pw = document.getElementById('password');
        if(pw){ const pv = pw.value.trim(); if(pv && pv.length < 6){ showError('password','Password must be at least 6 characters'); valid = false; } else if(pv && !passRegex.test(pv)){ showError('password','Special characters are not allowed in password'); valid = false; } }

        // basic email format
        const email = document.getElementById('email');
        if(email){ const ev = email.value.trim(); if(ev && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(ev)){ showError('email','Invalid email address'); valid = false; } }

        // server-side uniqueness flag validation
        if(emailExists){ showError('email', 'This email is already registered'); valid = false; }

        return valid;
    }

    form.addEventListener('submit', async function(e){
        // perform an email uniqueness check here as well (in case the user didn't blur the field)
        const emailEl = document.getElementById('email');
        const emailVal = emailEl ? (emailEl.value||'').toString().trim() : '';
        if(emailVal && !emailExists && /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(emailVal)){
            try{
                const resp = await fetch('{{ url('/doctor/patients/check-email') }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken}, body: JSON.stringify({email: emailVal})});
                const js = await resp.json();
                emailExists = !!js.exists;
                if(emailExists){ showError('email','This email is already registered'); }
            } catch(err){ /* ignore network errors here; server validation will catch duplicates */ }
        }

        if(!validate()){
            e.preventDefault();
            const firstError = document.querySelector('[id^="client_"]:not([style*="display:none"])');
            if(firstError){ firstError.scrollIntoView({behavior:'smooth', block:'center'}); }
            return false;
        }
        // allow submit
        return true;
    });
});
</script>

@endsection
