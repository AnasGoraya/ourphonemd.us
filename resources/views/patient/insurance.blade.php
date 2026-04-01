@extends('layouts.patient')

@section('title', 'Insurance & Billing - OurPhoneMD')

@section('content')
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"
                    style="color: #51A897; background-color: rgba(0, 0, 0, 0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 24px;">
                    <i class="bi bi-receipt me-2"></i>Insurance & Billing</h2>

                <!-- Tabs Navigation -->
                <div class="row mb-4" id="insuranceTabs" role="tablist"
                    style="background-color: #f8f9fa; padding: 10px; border-radius: 5px;">
                    <div class="col-6">
                        <button class="btn active" id="insurance-tab" data-bs-toggle="tab" data-bs-target="#insurance"
                            type="button" role="tab" aria-controls="insurance" aria-selected="true"
                            style="width: 100%; background-color: white; color: black;">
                            <i class="bi bi-shield-check me-2"></i>Insurance
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing"
                            type="button" role="tab" aria-controls="billing" aria-selected="false"
                            style="width: 100%; background-color: white; color: black;">
                            <i class="bi bi-credit-card me-2"></i>Billing & Payments
                        </button>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="tab-content" id="insuranceTabsContent">
                    <!-- Insurance Tab -->
                    <div class="tab-pane fade show active" id="insurance" role="tabpanel" aria-labelledby="insurance-tab">
                        <div id="insuranceContainer">
                            <!-- Insurance cards will be loaded here -->
                        </div>
                    </div>

                    <!-- Billing & Payments Tab -->
                    <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                        <div class="card shadow-sm">
                            <div class="card-body py-5">
                                <div class="text-center">
                                    <div
                                        style="width: 80px; height: 80px; margin: 0 auto 20px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-receipt fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-dark mb-2">No billing information</h5>
                                    <p class="text-muted mb-4">Your billing and payment details will appear here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Insurance Modal -->
    <div class="modal fade" id="addInsuranceModal" tabindex="-1" aria-labelledby="addInsuranceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 900px;">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fs-5" id="addInsuranceModalLabel"><i class="bi bi-plus-circle me-2"></i><span
                            id="modalTitle">Add Insurance Policy</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-4">Enter your insurance information below.</p>

                    <!-- Validation Error Alert -->
                    <div class="alert alert-danger alert-dismissible fade show d-none" id="validationErrorAlert"
                        role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the validation errors
                            below.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form id="addInsuranceForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="insuranceIdHidden" name="insurance_id_hidden" value="">
                        <div class="row">
                            <!-- Insurance Type -->
                            <div class="col-md-6 mb-3">
                                <label for="insuranceType" class="form-label fw-semibold">Insurance Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="insuranceType" name="insurance_type" required>
                                    <option value="">Select insurance type</option>
                                    <option value="health">Medicaid</option>
                                    <option value="dental">Non-Medicaid/Commerical</option>
                                </select>
                                <div class="invalid-feedback" id="insurance_typeError"></div>
                            </div>

                            <!-- Policy Number -->
                            <div class="col-md-6 mb-3">
                                <label for="policyNumber" class="form-label fw-semibold">Policy Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="policyNumber" name="policy_number"
                                    placeholder="Enter policy number" required>
                                <div class="invalid-feedback" id="policy_numberError"></div>
                            </div>

                            <!-- Member Name -->
                            <div class="col-md-6 mb-3">
                                <label for="memberName" class="form-label fw-semibold">Member Name <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="memberName" name="member_name" required>
                                    <option value="">Select who this insurance is for</option>
// ...existing code...
                                    <option value="self">You ({{ Auth::guard('patient')->user()->first_name }} {{ Auth::guard('patient')->user()->last_name }})</option>
                                    <!-- Family members will be loaded here dynamically -->
// ...existing code...
                                    <option value="self">You</option>
// ...existing code...
                                </select>
                                <div class="invalid-feedback" id="member_nameError"></div>
                            </div>

                            <!-- Group Number -->
                            <div class="col-md-6 mb-3">
                                <label for="groupNumber" class="form-label fw-semibold">Group Number</label>
                                <input type="text" class="form-control" id="groupNumber" name="group_number"
                                    placeholder="Enter group number (optional)">
                                <div class="invalid-feedback" id="group_numberError"></div>
                            </div>

                            <!-- Insurance Provider -->
                            <div class="col-md-6 mb-3">
                                <label for="insuranceProvider" class="form-label fw-semibold">Insurance Provider <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="insuranceProvider" name="insurance_provider" required>
                                    <option value="">Select insurance provider</option>
                                    <option value="aetna">Aetna Better Health
                                    </option>
                                    <option value="cigna">Anthem Medicaid
                                    </option>
                                    <option value="united">Humana KY Medicaid
                                    </option>
                                    <option value="bluecross">Passport/Molina
                                    </option>
                                    <option value="humana">StraightKY Medicaid
                                    </option>
                                    <option value="kaiser"> United Healthcare Medicaid
                                    </option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="invalid-feedback" id="insurance_providerError"></div>
                            </div>

                            <!-- EDI Payer -->
                            <div class="col-md-6 mb-3">
                                <label for="ediPayer" class="form-label fw-semibold">EDI Payer ID</label>
                                <input type="text" class="form-control" id="ediPayer" name="edi_payer"
                                    placeholder="Enter EDI payer ID (optional)">
                                <div class="invalid-feedback" id="edi_payerError"></div>
                            </div>

                            <!-- Insurance ID -->
                            <div class="col-md-6 mb-3">
                                <label for="insuranceIdField" class="form-label fw-semibold">Insurance ID <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="insuranceIdField" name="insurance_id"
                                    placeholder="Enter insurance ID" required>
                                <div class="invalid-feedback" id="insurance_idError"></div>
                            </div>

                            <!-- Coverage Type -->
                            <div class="col-md-6 mb-3">
                                <label for="coverageType" class="form-label fw-semibold">Coverage Type</label>
                                <select class="form-select" id="coverageType" name="coverage_type">
                                    <option value="">Select coverage type</option>
                                    <option value="individual">Individual</option>
                                    <option value="family">Family</option>
                                    <option value="group">Group</option>
                                    <option value="employer">Employer Provided</option>
                                </select>
                                <div class="invalid-feedback" id="coverage_typeError"></div>
                            </div>

                            <!-- Effective Date -->
                            <div class="col-md-6 mb-3">
                                <label for="effectiveDate" class="form-label fw-semibold">Effective Date</label>
                                <input type="date" class="form-control" id="effectiveDate" name="effective_date">
                                <div class="invalid-feedback" id="effective_dateError"></div>
                            </div>

                            <!-- Expiration Date -->
                            <div class="col-md-6 mb-3">
                                <label for="expirationDate" class="form-label fw-semibold">Expiration Date</label>
                                <input type="date" class="form-control" id="expirationDate" name="expiration_date">
                                <div class="invalid-feedback" id="expiration_dateError"></div>
                            </div>

                            <!-- Relationship -->
                            <div class="col-12 mb-3">
                                <label for="relationship" class="form-label fw-semibold">Relationship to Subscriber <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="relationship" name="relationship" required>
                                    <option value="">Select relationship</option>
                                    <option value="self">Self (Subscriber)</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="child">Child</option>
                                    <option value="parent">Parent</option>
                                    <option value="other">Other Dependent</option>
                                </select>
                                <div class="invalid-feedback" id="relationshipError"></div>
                            </div>

                            <!-- Primary Insurance Checkbox -->
                            <div class="col-12 mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="primaryInsurance"
                                        name="is_primary">
                                    <label class="form-check-label fw-semibold" for="primaryInsurance">
                                        This is my primary insurance
                                    </label>
                                </div>
                            </div>

                            <!-- Subscriber Information Section -->
                            <div class="col-12 mb-4">
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-3"><i class="bi bi-person-circle me-2"></i>Subscriber
                                            Information</h6>

                                        <div class="row">
                                            <!-- Subscriber Name -->
                                            <div class="col-md-6 mb-3">
                                                <label for="subscriberName" class="form-label fw-semibold">Subscriber
                                                    Name</label>
                                                <input type="text" class="form-control" id="subscriberName"
                                                    name="subscriber_name" placeholder="e.g., John Doe">
                                                <div class="invalid-feedback" id="subscriber_nameError"></div>
                                            </div>

                                            <!-- Subscriber Copay -->
                                            <div class="col-md-6 mb-3">
                                                <label for="subscriberCopay" class="form-label fw-semibold">Subscriber
                                                    Copay</label>
                                                <input type="text" class="form-control" id="subscriberCopay"
                                                    name="subscriber_copay" placeholder="e.g., $25">
                                                <div class="invalid-feedback" id="subscriber_copayError"></div>
                                            </div>

                                            <!-- Subscriber SSN -->
                                            <div class="col-md-6 mb-3">
                                                <label for="subscriberSSN" class="form-label fw-semibold">Subscriber
                                                    SSN</label>
                                                <input type="text" class="form-control" id="subscriberSSN"
                                                    name="subscriber_ssn" placeholder="e.g., 123-45-6789">
                                                <div class="invalid-feedback" id="subscriber_ssnError"></div>
                                            </div>

                                            <!-- Subscriber Date of Birth -->
                                            <div class="col-md-6 mb-3">
                                                <label for="subscriberDOB" class="form-label fw-semibold">Subscriber Date
                                                    of Birth</label>
                                                <input type="date" class="form-control" id="subscriberDOB"
                                                    name="subscriber_date_of_birth">
                                                <div class="invalid-feedback" id="subscriber_date_of_birthError"></div>
                                            </div>

                                            <!-- Subscriber Address -->
                                            <div class="col-12 mb-3">
                                                <label for="subscriberAddress" class="form-label fw-semibold">Subscriber
                                                    Address</label>
                                                <input type="text" class="form-control" id="subscriberAddress"
                                                    name="subscriber_address" placeholder="Enter subscriber address">
                                                <div class="invalid-feedback" id="subscriber_addressError"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Images Section -->
                            <div class="col-12 mb-4">
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-3"><i class="bi bi-card-image me-2"></i>Insurance Card
                                            Images (Optional)</h6>
                                        <p class="text-muted mb-3">Upload images of both sides of your insurance card for
                                            verification.</p>

                                        <div class="row">
                                            <!-- Front of Card -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Front of Card</label>
                                                <div class="card border-dashed h-100"
                                                    style="border: 2px dashed #dee2e6; cursor: pointer; transition: all 0.3s; min-height: 180px;"
                                                    id="cardFrontDropZone">
                                                    <div class="card-body text-center d-flex flex-column justify-content-center py-4"
                                                        id="cardFrontContent">
                                                        <i class="bi bi-cloud-upload fa-2x text-muted mb-2"
                                                            style="display: block;"></i>
                                                        <p class="text-muted mb-2">Drag & drop or click to upload</p>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary mt-1 select-image-btn"
                                                            onclick="document.getElementById('cardFrontInput').click()">
                                                            <i class="bi bi-folder2-open me-1"></i>Select Image
                                                        </button>
                                                        <input type="file" id="cardFrontInput" name="card_front_image"
                                                            accept="image/*" style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="card_front_imageError"></div>
                                            </div>

                                            <!-- Back of Card -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Back of Card</label>
                                                <div class="card border-dashed h-100"
                                                    style="border: 2px dashed #dee2e6; cursor: pointer; transition: all 0.3s; min-height: 180px;"
                                                    id="cardBackDropZone">
                                                    <div class="card-body text-center d-flex flex-column justify-content-center py-4"
                                                        id="cardBackContent">
                                                        <i class="bi bi-cloud-upload fa-2x text-muted mb-2"
                                                            style="display: block;"></i>
                                                        <p class="text-muted mb-2">Drag & drop or click to upload</p>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary mt-1 select-image-btn"
                                                            onclick="document.getElementById('cardBackInput').click()">
                                                            <i class="bi bi-folder2-open me-1"></i>Select Image
                                                        </button>
                                                        <input type="file" id="cardBackInput" name="card_back_image"
                                                            accept="image/*" style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="card_back_imageError"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light p-3">
                            <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success px-3" id="submitBtn"
                                style="background-color: #62B1A1; color: white; font-weight: 600;">
                                <i class="bi bi-check-circle me-2"></i><span id="submitBtnText">Add Insurance</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let editingInsuranceId = null;
        let addInsuranceModal = null;

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing insurance module...');

            // Initialize modal instance
            const modalElement = document.getElementById('addInsuranceModal');
            if (modalElement) {
                addInsuranceModal = new bootstrap.Modal(modalElement);
            }

                loadInsurances();
                loadFamilyMembers();
                setupFormHandler();
                setupFileUploads();
                setupMemberSelection();
        });

        function setupFileUploads() {
            setupDropZone('cardFrontDropZone', 'cardFrontInput', 'cardFrontContent');
            setupDropZone('cardBackDropZone', 'cardBackInput', 'cardBackContent');

            document.getElementById('cardFrontInput').addEventListener('change', function() {
                handleFileSelect(this, 'cardFrontContent');
            });

            document.getElementById('cardBackInput').addEventListener('change', function() {
                handleFileSelect(this, 'cardBackContent');
            });
        }

        function setupDropZone(dropZoneId, inputId, contentId) {
            const dropZone = document.getElementById(dropZoneId);
            if (!dropZone) return;

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropZone.style.backgroundColor = '#f8f9fa';
                dropZone.style.borderColor = '#adb5bd';
            }

            function unhighlight() {
                dropZone.style.backgroundColor = '';
                dropZone.style.borderColor = '#dee2e6';
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                const input = document.getElementById(inputId);
                if (input) {
                    input.files = files;
                    const event = new Event('change', {
                        bubbles: true
                    });
                    input.dispatchEvent(event);
                }
            }

            dropZone.addEventListener('click', function() {
                document.getElementById(inputId).click();
            });
        }

        function handleFileSelect(input, contentId) {
            const file = input.files[0];
            const content = document.getElementById(contentId);
            if (!content || !file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                content.innerHTML = `
            <div class="text-center">
                <img src="${e.target.result}" style="max-width: 100%; max-height: 120px; border-radius: 6px; border: 1px solid #dee2e6;">
                <p class="text-muted mt-2 mb-0 small"><i class="bi bi-check-circle-fill text-success me-1"></i>${file.name}</p>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-1 select-image-btn" onclick="resetFileUpload('${input.id}', '${contentId}')">
                    <i class="bi bi-arrow-repeat me-1"></i>Change
                </button>
            </div>
        `;
            };
            reader.readAsDataURL(file);
        }

        function resetFileUpload(inputId, contentId) {
            const input = document.getElementById(inputId);
            const content = document.getElementById(contentId);
            if (!input || !content) return;

            input.value = '';
            const imageType = inputId === 'cardFrontInput' ? 'Front' : 'Back';
            content.innerHTML = `
        <i class="bi bi-cloud-upload fa-2x text-muted mb-2" style="display: block;"></i>
        <p class="text-muted mb-2">Drag & drop or click to upload</p>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-1 select-image-btn" onclick="document.getElementById('${inputId}').click()">
            <i class="bi bi-folder2-open me-1"></i>Select ${imageType} Image
        </button>
    `;
        }

        function clearValidationErrors() {
            document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.form-control, .form-select').forEach(el => el.classList.remove('is-invalid'));
            const alert = document.getElementById('validationErrorAlert');
            if (alert) alert.classList.add('d-none');
        }

        function showValidationErrors(errors) {
            clearValidationErrors();
            const validationAlert = document.getElementById('validationErrorAlert');
            if (validationAlert) validationAlert.classList.remove('d-none');

            for (const field in errors) {
                const errorEl = document.getElementById(field + 'Error');
                const inputEl = document.getElementById(field) || document.getElementById(field.replace('_', '') +
                    'Field') || document.querySelector(`[name="${field}"]`);
                if (errorEl && inputEl) {
                    errorEl.textContent = errors[field][0];
                    errorEl.style.display = 'block';
                    inputEl.classList.add('is-invalid');
                }
            }
        }

        async function loadInsurances() {
            try {
                const response = await fetch('/api/insurance', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const container = document.getElementById('insuranceContainer');

                if (!response.ok) {
                    const text = await response.text();
                    console.error('Server error loading insurances:', response.status, text);
                    showAlert('Error loading insurances (server).', 'danger');
                    return;
                }

                const raw = await response.text();
                if (!raw) {
                    console.error('Empty response from /api/insurance');
                    showAlert('Error loading insurances (empty response).', 'danger');
                    return;
                }

                let result;
                try {
                    result = JSON.parse(raw);
                } catch (err) {
                    console.error('Invalid JSON response from /api/insurance:', raw);
                    showAlert('Error loading insurances (invalid server response).', 'danger');
                    return;
                }

                if (result.success && result.insurances && result.insurances.length > 0) {
                    let html = '';
                    result.insurances.forEach(insurance => {
                        const primaryBadge = insurance.is_primary ?
                            '<span class="badge bg-success ms-2">Primary</span>' : '';
                        const effectiveDate = insurance.effective_date ? new Date(insurance.effective_date)
                            .toLocaleDateString() : 'N/A';
                        const expirationDate = insurance.expiration_date ? new Date(insurance.expiration_date)
                            .toLocaleDateString() : 'N/A';

                        let expandedDetails = `
                    <div class="expanded-details mt-4 pt-4 border-top" id="details-${insurance.id}" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Insurance Type</strong></small><span>${insurance.insurance_type}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Policy Number</strong></small><span>${insurance.policy_number}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Insurance ID</strong></small><span>${insurance.insurance_id}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Group Number</strong></small><span>${insurance.group_number || 'N/A'}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Coverage Type</strong></small><span>${insurance.coverage_type || 'N/A'}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>EDI Payer ID</strong></small><span>${insurance.edi_payer || 'N/A'}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Effective Date</strong></small><span>${effectiveDate}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Expiration Date</strong></small><span>${expirationDate}</span></div>
                            <div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Relationship</strong></small><span>${insurance.relationship}</span></div>
                        </div>
                        <h6 class="fw-bold mt-4 mb-3"><i class="bi bi-person-circle me-2"></i>Subscriber Information</h6>
                        <div class="row">
                            ${insurance.subscriber_name ? `<div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Name</strong></small><span>${insurance.subscriber_name}</span></div>` : ''}
                            ${insurance.subscriber_copay ? `<div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Copay</strong></small><span>${insurance.subscriber_copay}</span></div>` : ''}
                            ${insurance.subscriber_ssn ? `<div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>SSN</strong></small><span>${insurance.subscriber_ssn}</span></div>` : ''}
                            ${insurance.subscriber_date_of_birth ? `<div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>DOB</strong></small><span>${new Date(insurance.subscriber_date_of_birth).toLocaleDateString()}</span></div>` : ''}
                            ${insurance.subscriber_address ? `<div class="col-12 mb-3"><small class="text-muted d-block"><strong>Address</strong></small><span>${insurance.subscriber_address}</span></div>` : ''}
                        </div>
                `;

                        if (insurance.card_front_image_url || insurance.card_back_image_url) {
                            expandedDetails +=
                                `<h6 class="fw-bold mt-4 mb-3"><i class="bi bi-card-image me-2"></i>Card Images</h6><div class="row">`;
                            if (insurance.card_front_image_url) expandedDetails +=
                                `<div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Front</strong></small><img src="${insurance.card_front_image_url}" style="max-width: 100%; max-height: 150px; border-radius: 4px;"></div>`;
                            if (insurance.card_back_image_url) expandedDetails +=
                                `<div class="col-md-6 mb-3"><small class="text-muted d-block"><strong>Back</strong></small><img src="${insurance.card_back_image_url}" style="max-width: 100%; max-height: 150px; border-radius: 4px;"></div>`;
                            expandedDetails += '</div>';
                        }
                        expandedDetails += '</div>';

                        html += `
                    <div class="d-flex justify-content-start mb-4">
                        <div class="card shadow-sm insurance-card-main" style="width: 50%; background: white; border: none; border-radius: 12px;">
                            <div class="card-body p-4">
                                <div style="background: #EDF6F4; padding: 1rem; border-radius: 12px 12px 0 0; margin: -1rem -1rem 1rem -1rem;">
                                    <div class="d-flex justify-content-between align-items-start mb-0">
                                        <div>
                                            <h5 class="card-title mb-1" style="color: black; font-weight: 700;">${insurance.insurance_provider}</h5> <br>
                                            <small style="color: #6c757d; font-size: 0.85em; display: block;"> .Policy</small>
                                            ${primaryBadge}
                                        </div>
                                        <div class="btn-group btn-group-sm" role="group" style="background-color: #EDF6F4; padding: 4px; border-radius: 6px;">
                                            <button type="button" class="btn btn-outline-secondary view-btn" onclick="toggleDetails(${insurance.id})" title="View Details" id="viewBtn-${insurance.id}" style="border: none;">
                                                <i class="bi bi-eye" style="font-size: 1.2em;"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="editInsurance(${insurance.id})" title="Edit" style="border: none;">
                                                <i class="bi bi-pencil" style="font-size: 1.2em;"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="deleteInsurance(${insurance.id})" title="Delete" style="border: none;">
                                                <i class="bi bi-trash" style="font-size: 1.2em;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4"><small class="text-muted d-block"><strong>Insurance ID</strong></small><span class="fw-semibold" style="color: #2c5f57;">${insurance.insurance_id}</span></div>
                                    <div class="col-md-4"><small class="text-muted d-block"><strong>Member Name</strong></small><span class="fw-semibold" style="color: #2c5f57;">${insurance.member_name === 'self' ? 'You' : insurance.member_name}</span></div>
                                    <div class="col-md-4"><small class="text-muted d-block"><strong>Active Since</strong></small><span class="fw-semibold" style="color: #2c5f57;">${effectiveDate}</span></div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-12"><small class="text-muted d-block"><strong>Status</strong></small><span style="color: #16A37C;">Active</span></div>
                                </div>
                                ${expandedDetails}
                            </div>
                        </div>
                    </div>
                `;
                    });

                    container.innerHTML = html;
                } else {
                    container.innerHTML = `
                <div class="card shadow-sm">
                    <div class="card-body py-5">
                        <div class="text-center">
                            <div style="width: 80px; height: 80px; margin: 0 auto 20px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-wallet2 fa-2x text-muted"></i>
                            </div>
                            <h5 class="text-dark mb-2">Add Your First Insurance Policy</h5>
                            <p class="text-muted mb-4">You haven't added any insurance policies yet.</p>
                            <button type="button" class="btn px-4" style="background-color: #62B1A1; color: white; font-weight: 600;" data-bs-toggle="modal" data-bs-target="#addInsuranceModal" onclick="resetFormForAdd()">
                                <i class="bi bi-plus me-2"></i>Add Your First Insurance Policy
                            </button>
                        </div>
                    </div>
                </div>
            `;
                }
            } catch (error) {
                console.error('Error loading insurances:', error);
                showAlert('Error loading insurances', 'danger');
            }
        }

        function toggleDetails(insuranceId) {
            const detailsElement = document.getElementById(`details-${insuranceId}`);
            const viewBtn = document.getElementById(`viewBtn-${insuranceId}`);

            if (detailsElement && viewBtn) {
                if (detailsElement.style.display === 'none') {
                    detailsElement.style.display = 'block';
                    viewBtn.classList.add('active');
                } else {
                    detailsElement.style.display = 'none';
                    viewBtn.classList.remove('active');
                }
            }
        }

        function resetFormForAdd() {
            editingInsuranceId = null;

            // Reset form
            const form = document.getElementById('addInsuranceForm');
            if (form) form.reset();

            // Reset file uploads
            resetFileUpload('cardFrontInput', 'cardFrontContent');
            resetFileUpload('cardBackInput', 'cardBackContent');

            // Reset hidden field
            const insuranceIdHidden = document.getElementById('insuranceIdHidden');
            if (insuranceIdHidden) insuranceIdHidden.value = '';

            // Reload family members to ensure dropdown is up to date
            loadFamilyMembers();

            // Update modal title and button text - with null checks
            const modalTitle = document.getElementById('modalTitle');
            const submitBtnText = document.getElementById('submitBtnText');

            if (modalTitle) modalTitle.textContent = 'Add Insurance Policy';
            if (submitBtnText) submitBtnText.textContent = 'Add Insurance';

            clearValidationErrors();
        }

        async function editInsurance(insuranceId) {
            try {
                const response = await fetch(`/api/insurance?id=${insuranceId}`);
                const result = await response.json();
                let insurance = result.insurances ? result.insurances.find(ins => ins.id === insuranceId) : null;

                if (!insurance) {
                    showAlert('Unable to load insurance data', 'danger');
                    return;
                }

                editingInsuranceId = insuranceId;

                // Set form values with null checks
                const setValue = (id, value) => {
                    const element = document.getElementById(id);
                    if (element) element.value = value || '';
                };

                const setChecked = (id, checked) => {
                    const element = document.getElementById(id);
                    if (element) element.checked = checked || false;
                };

                setValue('insuranceType', insurance.insurance_type);
                setValue('policyNumber', insurance.policy_number);
                setValue('memberName', insurance.member_name);
                setValue('groupNumber', insurance.group_number);
                setValue('insuranceProvider', insurance.insurance_provider);
                setValue('ediPayer', insurance.edi_payer);
                setValue('insuranceIdField', insurance.insurance_id);
                setValue('coverageType', insurance.coverage_type);
                setValue('effectiveDate', insurance.effective_date ? insurance.effective_date.split(' ')[0] : '');
                setValue('expirationDate', insurance.expiration_date ? insurance.expiration_date.split(' ')[0] : '');
                setValue('relationship', insurance.relationship);
                setChecked('primaryInsurance', insurance.is_primary);

                setValue('subscriberName', insurance.subscriber_name);
                setValue('subscriberCopay', insurance.subscriber_copay);
                setValue('subscriberSSN', insurance.subscriber_ssn);
                setValue('subscriberDOB', insurance.subscriber_date_of_birth ? insurance.subscriber_date_of_birth.split(
                    ' ')[0] : '');
                setValue('subscriberAddress', insurance.subscriber_address);

                const insuranceIdHidden = document.getElementById('insuranceIdHidden');
                if (insuranceIdHidden) insuranceIdHidden.value = insuranceId;

                const modalTitle = document.getElementById('modalTitle');
                const submitBtnText = document.getElementById('submitBtnText');

                if (modalTitle) modalTitle.textContent = 'Edit Insurance Policy';
                if (submitBtnText) submitBtnText.textContent = 'Save Changes';

                clearValidationErrors();

                // Use the modal instance we created
                if (addInsuranceModal) {
                    addInsuranceModal.show();
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error loading insurance data: ' + error.message, 'danger');
            }
        }

        function setupFormHandler() {
            const form = document.getElementById('addInsuranceForm');
            if (!form) return;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

                clearValidationErrors();

                try {
                    const formData = new FormData(form);
                    const insuranceIdHidden = document.getElementById('insuranceIdHidden');
                    const insuranceId = insuranceIdHidden ? insuranceIdHidden.value : null;

                    let url = '/api/insurance';
                    let method = 'POST';

                    if (insuranceId) {
                        url = `/api/insurance/${insuranceId}`;
                        formData.append('_method', 'PUT');
                    }

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token')
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        showAlert(insuranceId ? 'Insurance updated successfully!' :
                            'Insurance added successfully!', 'success');
                        resetFormForAdd();

                        // Use the modal instance to hide
                        if (addInsuranceModal) {
                            addInsuranceModal.hide();
                        }

                        setTimeout(() => loadInsurances(), 1000);
                    } else {
                        if (result.errors) showValidationErrors(result.errors);
                        else showAlert(result.message || 'Error saving insurance', 'danger');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Error: ' + error.message, 'danger');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        }

        async function deleteInsurance(id) {
            if (!confirm('Are you sure you want to delete this insurance?')) return;

            try {
                const response = await fetch(`/api/insurance/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || '',
                    }
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('Insurance deleted successfully!', 'success');
                    loadInsurances();
                } else {
                    showAlert(result.message || 'Error deleting insurance', 'danger');
                }
            } catch (error) {
                showAlert('Error: ' + error.message, 'danger');
                console.error('Error:', error);
            }
        }

        async function loadFamilyMembers() {
            try {
                const response = await fetch('/api/family-members');
                const result = await response.json();

                if (result.success && result.data) {
                    const memberSelect = document.getElementById('memberName');
                    // Clear existing family member options (keep placeholder and self option)
                    while (memberSelect.options.length > 2) {
                        memberSelect.remove(2);
                    }

                    // Add family members
                    result.data.forEach(member => {
                        const option = document.createElement('option');
                        option.value = member.id;
                        option.textContent = `${member.first_name} ${member.last_name}`;
                        option.setAttribute('data-relationship', member.relationship);
                        memberSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading family members:', error);
            }
        }

        function setupMemberSelection() {
            const memberSelect = document.getElementById('memberName');
            const relationshipSelect = document.getElementById('relationship');

            if (!memberSelect || !relationshipSelect) return;

            memberSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const relationship = selectedOption.getAttribute('data-relationship');

                if (this.value === 'self') {
                    relationshipSelect.value = 'self';
                } else if (relationship) {
                    // Map family member relationship to insurance relationship
                    const relationshipMap = {
                        'spouse': 'spouse',
                        'child': 'child',
                        'parent': 'parent',
                        'sibling': 'other',
                        'other': 'other'
                    };
                    relationshipSelect.value = relationshipMap[relationship] || 'other';
                }
            });
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML =
                `${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;

            const container = document.querySelector('.container-fluid');
            if (container) {
                container.insertBefore(alertDiv, container.firstChild);
                setTimeout(() => alertDiv.remove(), 5000);
            }
        }
    </script>

    <style>
        .insurance-card-main {
            transition: all 0.3s ease;
        }

        .insurance-card-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
        }

        .view-btn.active {
            background-color: #6c757d;
            color: white;
            border-color: #6c757d;
        }

        .border-dashed {
            border: 2px dashed #dee2e6 !important;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .border-dashed:hover {
            border-color: #adb5bd !important;
            background-color: #f8f9fa;
        }

        .select-image-btn {
            border: 1px solid #6c757d;
            color: #495057;
            background-color: transparent;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .select-image-btn:hover {
            background-color: #6c757d;
            color: white;
            border-color: #6c757d;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
            font-weight: 500;
        }

        #validationErrorAlert {
            border-left: 4px solid #dc3545;
        }
    </style>
@endsection



