@extends('layouts.doctor')

@section('title', 'Patients')
@section('page_title', 'Patients')

@section('content')

<div class="container-fluid" style="padding:24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <div>
            <h2 style="margin:0; color:#0f172a; font-size:22px;">Patients</h2>
            <p style="margin:4px 0 0; color:#6b7280;">All patients assigned to you</p>
        </div>
        <div>
            <a href="{{ url('doctor/patients/create') }}" class="btn" style="background:#1aa179; color:#fff; padding:10px 14px; border-radius:6px;">Add New Patient</a>
        </div>
    </div>

    <div style="background:#fff; border-radius:8px; padding:12px; box-shadow:0 1px 2px rgba(0,0,0,0.04);">
        <div style="display:flex; gap:12px; margin-bottom:12px; align-items:center;">
            <input id="searchName" placeholder="Name" style="flex:1; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
            <input id="searchDob" placeholder="Date of Birth" style="width:200px; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
            <input id="searchPhone" placeholder="Phone" style="width:200px; padding:10px; border-radius:6px; border:1px solid #e6eef5;" />
                <button id="searchBtn" style="background:#1aa179; border-color:#1aa179; color:#fff; padding:10px 14px; border-radius:6px;">Search</button>
        </div>
        <div id="patientsLiveResults" style="margin-bottom:12px; max-height:240px; overflow:auto; display:none; border-radius:6px; padding:6px; border:1px solid #f1f5f7;"></div>

        <div style="overflow:auto; max-height:72vh;">
            <table style="width:100%; border-collapse:collapse; min-width:1100px;">
                <thead>
                    <tr style="text-align:left; border-bottom:1px solid #e6eef5;">
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">PATIENT NAME</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">TYPE</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">PHONE</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">AGE</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">GENDER</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">ADDRESS</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">DATE OF BIRTH</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">GUARDIAN</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">REGISTERED ON</th>
                        <th style="padding:12px 8px; color:#6b7280; font-weight:700;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="patientsTableBody">
                    {{-- If a new patient was just created by doctor, show it at the top instantly --}}
                    @if(session('new_patient'))
                        @php $np = session('new_patient'); @endphp
                        <tr style="border-bottom:1px solid #f3f4f6; background:#f8fffb;">
                            <td style="padding:12px 8px; vertical-align:middle;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div style="width:36px; height:36px; border-radius:50%; background:#f3f4f6; display:flex; align-items:center; justify-content:center; color:#374151; font-weight:700;">{{ strtoupper(substr($np['first_name'] ?? '',0,1) . substr($np['last_name'] ?? '',0,1)) }}</div>
                                    <div>
                                        <div style="font-weight:700; color:#0f172a;">{{ $np['first_name'] }} {{ $np['last_name'] }}</div>
                                        <div style="color:#6b7280; font-size:13px;">{{ $np['email'] ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 8px; vertical-align:middle;"><span style="background:#FFEDD5; color:#9A3412; padding:6px 8px; border-radius:12px; font-weight:700;">Patient</span></td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $np['contact_number'] ?? '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $np['age'] ?? '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;"><span style="background:#DCFCE7; color:#166534; padding:6px 10px; border-radius:12px; font-weight:700;">{{ strtoupper($np['gender'] ?? '—') }}</span></td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $np['address'] ?? '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ isset($np['date_of_birth']) ? \Carbon\Carbon::parse($np['date_of_birth'])->format('n/j/Y') : '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $np['guardian_name'] ?? 'N/A' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">Just now</td>
                            <td style="padding:12px 8px; vertical-align:middle;"><a href="{{ url('doctor/patients/'.(session('new_patient')['id'] ?? '#')) }}" style="color:#1aa179; text-decoration:none; font-weight:700;">View</a></td>
                        </tr>
                    @endif
                    @forelse($patients as $p)
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:12px 8px; vertical-align:middle;">
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div style="width:36px; height:36px; border-radius:50%; background:#f3f4f6; display:flex; align-items:center; justify-content:center; color:#374151; font-weight:700;">{{ strtoupper(substr($p->first_name,0,1) . substr($p->last_name,0,1)) }}</div>
                                    <div>
                                        <div style="font-weight:700; color:#0f172a;">{{ $p->first_name }} {{ $p->last_name }}</div>
                                        <div style="color:#6b7280; font-size:13px;">{{ $p->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 8px; vertical-align:middle;">@if($p->appointments_with_doctor_count>1)<span style="background:#DBEAFE; color:#1E40AF; padding:6px 8px; border-radius:12px; font-weight:700;">Family Member</span>@else<span style="background:#FFEDD5; color:#9A3412; padding:6px 8px; border-radius:12px; font-weight:700;">Patient</span>@endif</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $p->contact_number ?? '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $p->calculated_age ?? $p->age ?? '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;"><span style="background:#DCFCE7; color:#166534; padding:6px 10px; border-radius:12px; font-weight:700;">{{ strtoupper($p->gender ?? '—') }}</span></td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $p->address ?? '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $p->date_of_birth ? $p->date_of_birth->format('n/j/Y') : '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $p->emergency_contact ?? 'N/A' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;">{{ $p->created_at ? $p->created_at->format('n/j/Y') : '—' }}</td>
                            <td style="padding:12px 8px; vertical-align:middle;"><a href="{{ url('doctor/patients/'.$p->id) }}" style="color:#1aa179; text-decoration:none; font-weight:700;">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="10" style="padding:20px; color:#6b7280;">No patients assigned yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('searchBtn')?.addEventListener('click', function(){
    const name = document.getElementById('searchName').value.toLowerCase();
    const dob = document.getElementById('searchDob').value.toLowerCase();
    const phone = document.getElementById('searchPhone').value.toLowerCase();
    const rows = Array.from(document.querySelectorAll('#patientsTableBody tr'));
    rows.forEach(r=>{
        const text = r.textContent.toLowerCase();
        if((!name || text.includes(name)) && (!dob || text.includes(dob)) && (!phone || text.includes(phone))){ r.style.display='table-row'; } else { r.style.display='none'; }
    });
});

// Live search for patients (name/email startsWith) using the existing API
const liveResults = document.getElementById('patientsLiveResults');
let liveTimer = null;
document.getElementById('searchName').addEventListener('input', function(){
    const q = this.value.trim();
    if(liveTimer) clearTimeout(liveTimer);
    if(!q){ liveResults.style.display='none'; return; }
    liveTimer = setTimeout(()=>{
        fetch('/api/doctor/patient-search', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify({q:q})})
        .then(r=>r.json()).then(json=>{
            const data = json.data || [];
            const ql = q.toLowerCase();
            const filtered = data.filter(d=> (d.name && d.name.toLowerCase().startsWith(ql)) || (d.email && d.email.toLowerCase().startsWith(ql)) );
            liveResults.innerHTML='';
            if(filtered.length===0){ liveResults.innerHTML = '<div style="color:#666;padding:10px">No matches</div>'; liveResults.style.display='block'; return; }
            filtered.forEach(p=>{
                const div = document.createElement('div'); div.style.padding='10px'; div.style.borderBottom='1px solid #f3f4f6'; div.style.cursor='pointer';
                div.innerHTML = `<div style="font-weight:700;color:#0f172a">${p.name}</div><div style="color:#6b7280;font-size:13px">${p.email||''}</div>`;
                div.addEventListener('click', ()=>{ window.location.href = '/doctor/patients/'+p.id; });
                liveResults.appendChild(div);
            });
            liveResults.style.display='block';
        }).catch(()=>{ liveResults.innerHTML = '<div style="color:#c53030;padding:10px">Search failed</div>'; liveResults.style.display='block'; });
    }, 220);
});
</script>
</script>

@endsection
