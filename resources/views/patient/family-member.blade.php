@extends('layouts.patient')

@section('title', 'Family Members - OurPhoneMD')

@section('content')
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="mt-4 container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h2
                        style="color: #51A897; font-family: ui-sans-serif, system-ui, sans-serif; font-size: 24px; font-weight: 700;">
                        <i class="bi bi-people me-2"></i>Family Members
                    </h2>
                   <button type="button" class="px-3 btn"
    style="background-color: #62B1A1; color: white; font-weight: 600;"
    onclick="showFirstFamilyMemberOptions();">
    <i class="bi bi-plus me-2"></i>Add Family Member
</button>
                </div>

                <!-- Search Bar -->
                <div class="mb-4">
                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text bg-light border-light" style="border-right: none;">
                            <i class="bi bi-search" style="color: #999;"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-light" id="searchInput"
                            placeholder="Search family members..." style="border-left: none;">
                    </div>
                </div>

                <!-- Family Members Container -->
                <div id="familyMembersContainer">
                    <!-- Loading spinner -->
                    <div id="loadingSpinner" class="py-5 text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading family members...</p>
                    </div>
                </div>

                <!-- Page Overlay -->
                <div id="pageOverlay"
                    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999;">
                </div>

                <!-- Inline Form Container -->
                <div id="inlineFormContainer" style="display: none; margin-top: 20px; position: relative;">
                    <div class="shadow-sm card">
                        <div class="p-4 card-body" style="position: relative;">
                            <!-- Initial Options Screen -->
                            <div id="initialOptionsScreen">
                                <div class="mb-3 d-flex align-items-center">
                                    <i class="bi bi-person-plus me-2" style="color: #62B1A1; font-size: 18px;"></i>
                                    <h5 class="mb-0" style="color: #62B1A1; font-weight: 700; font-size: 18px;">Add Family Member</h5>
                                </div>
                                <p class="mb-4 text-muted" style="font-size: 15px;">You can either use your own information as a starting point or add completely new information for the family member.</p>

                                <div class="gap-3 row">
                                    <div class="col-12">
                                        <button type="button" class="p-3 btn w-100"
                                            style="background-color: #62B1A1; color: white; font-weight: 600; text-align: left; border-radius: 8px; border: none;"
                                            onclick="goToForm(true)">
                                            <i class="bi bi-person me-2"></i>
                                            <span>
                                                <div style="font-weight: 700; font-size: 15px;">Use my information</div>
                                                <small style="display: block; font-weight: 400; font-size: 13px; margin-top: 2px;">Pre-fill with your details</small>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="p-3 btn w-100"
                                            style="background-color: white; color: #495057; font-weight: 600; text-align: left; border-radius: 8px; border: 1px solid #e9ecef;"
                                            onclick="goToForm(false)">
                                            <i class="bi bi-person-add me-2"></i>
                                            <span>
                                                <div style="font-weight: 700; font-size: 15px;">Add new information</div>
                                                <small style="display: block; font-weight: 400; font-size: 13px; margin-top: 2px;">Start with empty form</small>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Screen (Hidden by default) -->
                            <div id="formScreen" style="display: none;">
                                <div class="mb-3 d-flex align-items-center">
                                    <i class="bi bi-person-plus me-2" style="color: #62B1A1; font-size: 18px;"></i>
                                    <h5 class="mb-0" style="color: #62B1A1; font-weight: 700; font-size: 18px;">Personal Information</h5>
                                </div>
                                <p class="mb-4 text-muted" style="font-size: 14px;">Enter your family members personal details below.</p>

                                <!-- Validation Error Alert -->
                                <div class="alert alert-danger alert-dismissible fade show d-none" id="validationErrorAlert" role="alert">
                                    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the validation errors below.</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <form id="addFamilyMemberForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="familyMemberId" name="family_member_id_hidden" value="">

                                    <!-- Profile Picture Section -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold" style="color: #51A897; font-size: 14px;">
                                            <i class="bi bi-image me-2"></i>Profile Picture
                                        </label>
                                        <div class="gap-3 d-flex align-items-center">
                                            <div id="profilePicturePreview"
                                                style="width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-person fa-2x text-muted"></i>
                                            </div>
                                            <div>
                                                <input type="file" id="profilePicture" name="profile_picture"
                                                    accept="image/*" style="display: none;">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    onclick="document.getElementById('profilePicture').click()">
                                                    <i class="bi bi-upload me-1"></i>Choose File
                                                </button>
                                                <small class="mt-2 d-block text-muted">No file chosen</small>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback d-block" id="profile_pictureError"></div>
                                    </div>

                                    <!-- Personal Information Section -->
                                    <div class="mb-4">
                                        <h6 class="mb-3 fw-bold" style="color: #51A897; font-size: 14px;">
                                            <i class="bi bi-person-circle me-2"></i>Personal Information
                                        </h6>

                                        <div class="row">
                                            <!-- First Name -->
                                            <div class="mb-3 col-md-6">
                                                <label for="first_name" class="form-label fw-semibold"
                                                    style="font-size: 13px;">First Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="first_name"
                                                    name="first_name" placeholder="John" required>
                                                <div class="invalid-feedback" id="first_nameError"></div>
                                            </div>

                                            <!-- Middle Name -->
                                            <div class="mb-3 col-md-6">
                                                <label for="middle_name" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Middle Name</label>
                                                <input type="text" class="form-control" id="middle_name"
                                                    name="middle_name" placeholder="Ibrahim">
                                                <div class="invalid-feedback" id="middle_nameError"></div>
                                            </div>

                                            <!-- Last Name -->
                                            <div class="mb-3 col-md-6">
                                                <label for="last_name" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Last Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="last_name"
                                                    name="last_name" placeholder="Smith" required>
                                                <div class="invalid-feedback" id="last_nameError"></div>
                                            </div>

                                            <!-- Relationship -->
                                            <div class="mb-3 col-md-6">
                                                <label for="relationship" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Relationship<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="relationship" name="relationship"
                                                    required>
                                                    <option value="">Select relationship</option>
                                                    <option value="spouse">Spouse</option>
                                                    <option value="child">Child</option>
                                                    <option value="parent">Parent</option>
                                                    <option value="sibling">Sibling</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <div class="invalid-feedback" id="relationshipError"></div>
                                            </div>

                                            <!-- Date of Birth -->
                                            <div class="mb-3 col-md-6">
                                                <label for="date_of_birth" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Date of Birth<span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="date_of_birth"
                                                    name="date_of_birth" placeholder="mm/dd/yyyy" required>
                                                <div class="invalid-feedback" id="date_of_birthError"></div>
                                            </div>

                                            <!-- Gender -->
                                            <div class="mb-3 col-md-6">
                                                <label for="gender" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Gender<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="gender" name="gender" required>
                                                    <option value="">Select gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <div class="invalid-feedback" id="genderError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address Information Section -->
                                    <div class="mb-4">
                                        <h6 class="mb-3 fw-bold" style="color: #51A897; font-size: 14px;">
                                            <i class="bi bi-geo-alt me-2"></i>Address Information
                                        </h6>

                                        <div class="row">
                                            <!-- Address -->
                                            <div class="mb-3 col-12">
                                                <label for="address" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Address<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    placeholder="House 12, street 1 Gulzare Ibrahim, near Medcare Hospital"
                                                    required>
                                                <div class="invalid-feedback" id="addressError"></div>
                                            </div>

                                            <!-- City -->
                                            <div class="mb-3 col-md-6">
                                                <label for="city" class="form-label fw-semibold"
                                                    style="font-size: 13px;">City<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="city" name="city"
                                                    placeholder="Gulzamewala" required>
                                                <div class="invalid-feedback" id="cityError"></div>
                                            </div>

                                            <!-- State -->
                                            <div class="mb-3 col-md-6">
                                                <label for="state" class="form-label fw-semibold"
                                                    style="font-size: 13px;">State<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="state" name="state"
                                                    placeholder="Florida" required>
                                                <div class="invalid-feedback" id="stateError"></div>
                                            </div>

                                            <!-- Zip Code -->
                                            <div class="mb-3 col-md-6">
                                                <label for="zipCode" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Zip Code<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="zip_code"
                                                    name="zip_code" placeholder="28335" required>
                                                <div class="invalid-feedback" id="zip_codeError"></div>
                                            </div>

                                            <!-- Email Address -->
                                            <div class="mb-3 col-md-6">
                                                <label for="email" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Email Address<span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="email@example.com" required>
                                                <small class="mt-1 d-block text-muted">For appointment notifications and
                                                    reminders</small>
                                                <div class="invalid-feedback" id="emailError"></div>
                                            </div>

                                            <!-- Phone Number -->
                                            <div class="mb-3 col-md-6">
                                                <label for="phone" class="form-label fw-semibold"
                                                    style="font-size: 13px;">Phone Number<span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" id="phone" name="phone"
                                                    placeholder="+1 (123) 123-1234" required>
                                                <div class="invalid-feedback" id="phoneError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Insurance Information Section -->
                                    <div class="mb-4">
                                        <h6 class="mb-3 fw-bold" style="color: #51A897; font-size: 14px;">
                                            <i class="bi bi-shield-check me-2"></i>Insurance Information
                                        </h6>

                                        <div class="mb-3 form-check">
                                            <input class="form-check-input" type="checkbox" id="useParentInsurance"
                                                name="use_parent_insurance">
                                            <label class="form-check-label" for="useParentInsurance"
                                                style="font-size: 13px;">
                                                Use parent's insurance(s) as inline
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="addInsurance"
                                                name="add_insurance">
                                            <label class="form-check-label text-danger" for="addInsurance"
                                                style="font-size: 13px;">
                                                I want to add insurance for this family member
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Inline Form Footer -->
                        <div class="card-footer" style="background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
                            <!-- Initial Options Footer (Shown by default) -->
                            <div id="initialOptionsFooter">
                                <button type="button" class="btn btn-light" onclick="hideInlineForm()">
                                    <i class="bi bi-x-circle me-1"></i>Close
                                </button>
                            </div>

                            <!-- Form Footer (Hidden by default) -->
                            <div id="formFooter" style="display: none; width: 100%;">
                                <button type="button" class="btn btn-light" onclick="backToOptions()">
                                    <i class="bi bi-arrow-left me-1"></i>Back
                                </button>
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-light" onclick="hideInlineForm()">
                                        <i class="bi bi-x-circle me-1"></i>Cancel
                                    </button>
                                    <button type="button" class="px-3 btn" id="submitBtn"
                                        style="background-color: #62B1A1; color: white; font-weight: 600;" onclick="submitFamilyMemberForm()">
                                        <i class="bi bi-check-circle me-1"></i><span id="submitBtnText">Save Family
                                            Member</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Family Member Modal -->
    <div class="modal fade" id="editFamilyMemberModal" tabindex="-1" aria-labelledby="editFamilyMemberModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 760px;">
            <div class="modal-content"
                style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                    <h5 class="modal-title" id="editFamilyMemberModalLabel"
                        style="color: #51A897; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-person-plus me-2"></i>Edit Family Member
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="p-4 modal-body">
                    <p class="mb-4 text-muted" style="font-size: 14px;">Update your family member's personal details below.</p>

                    <!-- Validation Error Alert -->
                    <div class="alert alert-danger alert-dismissible fade show d-none" id="editValidationErrorAlert" role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the validation errors below.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form id="editFamilyMemberForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="editFamilyMemberId" name="family_member_id_hidden" value="">

                        <!-- Profile Picture Section -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: #51A897; font-size: 14px;">
                                <i class="bi bi-image me-2"></i>Profile Picture
                            </label>
                            <div class="gap-3 d-flex align-items-center">
                                <div id="editProfilePicturePreview"
                                    style="width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person fa-2x text-muted"></i>
                                </div>
                                <div>
                                    <input type="file" id="editProfilePicture" name="profile_picture"
                                        accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="document.getElementById('editProfilePicture').click()">
                                        <i class="bi bi-upload me-1"></i>Choose File
                                    </button>
                                    <small class="mt-2 d-block text-muted">No file chosen</small>
                                </div>
                            </div>
                            <div class="invalid-feedback d-block" id="edit_profile_pictureError"></div>
                        </div>

                        <!-- Personal Information Section -->
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold" style="color: #51A897; font-size: 14px;">
                                <i class="bi bi-person-circle me-2"></i>Personal Information
                            </h6>

                            <div class="row">
                                <!-- First Name -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_first_name" class="form-label fw-semibold"
                                        style="font-size: 13px;">First Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_first_name"
                                        name="first_name" placeholder="John" required>
                                    <div class="invalid-feedback" id="edit_first_nameError"></div>
                                </div>

                                <!-- Middle Name -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_middle_name" class="form-label fw-semibold"
                                        style="font-size: 13px;">Middle Name</label>
                                    <input type="text" class="form-control" id="edit_middle_name"
                                        name="middle_name" placeholder="Ibrahim">
                                    <div class="invalid-feedback" id="edit_middle_nameError"></div>
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_last_name" class="form-label fw-semibold"
                                        style="font-size: 13px;">Last Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_last_name"
                                        name="last_name" placeholder="Smith" required>
                                    <div class="invalid-feedback" id="edit_last_nameError"></div>
                                </div>

                                <!-- Relationship -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_relationship" class="form-label fw-semibold"
                                        style="font-size: 13px;">Relationship<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_relationship" name="relationship"
                                        required>
                                        <option value="">Select relationship</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="child">Child</option>
                                        <option value="parent">Parent</option>
                                        <option value="sibling">Sibling</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_relationshipError"></div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_date_of_birth" class="form-label fw-semibold"
                                        style="font-size: 13px;">Date of Birth<span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="edit_date_of_birth"
                                        name="date_of_birth" placeholder="mm/dd/yyyy" required>
                                    <div class="invalid-feedback" id="edit_date_of_birthError"></div>
                                </div>

                                <!-- Gender -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_gender" class="form-label fw-semibold"
                                        style="font-size: 13px;">Gender<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_gender" name="gender" required>
                                        <option value="">Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_genderError"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Section -->
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold" style="color: #51A897; font-size: 14px;">
                                <i class="bi bi-geo-alt me-2"></i>Address Information
                            </h6>

                            <div class="row">
                                <!-- Address -->
                                <div class="mb-3 col-12">
                                    <label for="edit_address" class="form-label fw-semibold"
                                        style="font-size: 13px;">Address<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_address" name="address"
                                        placeholder="House 12, street 1 Gulzare Ibrahim, near Medcare Hospital"
                                        required>
                                    <div class="invalid-feedback" id="edit_addressError"></div>
                                </div>

                                <!-- City -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_city" class="form-label fw-semibold"
                                        style="font-size: 13px;">City<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_city" name="city"
                                        placeholder="Gulzamewala" required>
                                    <div class="invalid-feedback" id="edit_cityError"></div>
                                </div>

                                <!-- State -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_state" class="form-label fw-semibold"
                                        style="font-size: 13px;">State<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_state" name="state"
                                        placeholder="Florida" required>
                                    <div class="invalid-feedback" id="edit_stateError"></div>
                                </div>

                                <!-- Zip Code -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_zipCode" class="form-label fw-semibold"
                                        style="font-size: 13px;">Zip Code<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_zip_code"
                                        name="zip_code" placeholder="28335" required>
                                    <div class="invalid-feedback" id="edit_zip_codeError"></div>
                                </div>

                                <!-- Email Address -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_email" class="form-label fw-semibold"
                                        style="font-size: 13px;">Email Address<span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="edit_email" name="email"
                                        placeholder="email@example.com" required>
                                    <small class="mt-1 d-block text-muted">For appointment notifications and
                                        reminders</small>
                                    <div class="invalid-feedback" id="edit_emailError"></div>
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-3 col-md-6">
                                    <label for="edit_phone" class="form-label fw-semibold"
                                        style="font-size: 13px;">Phone Number<span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="edit_phone" name="phone"
                                        placeholder="+1 (123) 123-1234" required>
                                    <div class="invalid-feedback" id="edit_phoneError"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Insurance Information Section -->
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold" style="color: #51A897; font-size: 14px;">
                                <i class="bi bi-shield-check me-2"></i>Insurance Information
                            </h6>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" id="edit_useParentInsurance"
                                    name="use_parent_insurance">
                                <label class="form-check-label" for="edit_useParentInsurance"
                                    style="font-size: 13px;">
                                    Use parent's insurance(s) as inline
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_addInsurance"
                                    name="add_insurance">
                                <label class="form-check-label text-danger" for="edit_addInsurance"
                                    style="font-size: 13px;">
                                    I want to add insurance for this family member
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                    <button type="button" class="px-3 btn" id="editSubmitBtn"
                        style="background-color: #62B1A1; color: white; font-weight: 600;" onclick="updateFamilyMember()">
                        <i class="bi bi-check-circle me-1"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Family Member Modal with Options -->
    <div class="modal fade" id="addFamilyMemberModal" tabindex="-1" aria-labelledby="addFamilyMemberModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 760px;">
            <div class="modal-content"
                style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                    <h5 class="modal-title" id="addFamilyMemberModalLabel"
                        style="color: #51A897; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-person-plus me-2"></i>Add Family Member
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="p-4 modal-body">
                    <p class="mb-4 text-muted" style="font-size: 15px;">This modal is for adding family members from the
                        header button. Use the inline form below for the "Add Your First Family Member" button.</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let editingFamilyMemberId = null;
        let allFamilyMembers = [];

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Family members page loaded');
            loadFamilyMembers();
            setupFormHandler();
            setupSearch();
            setupProfilePictureUpload();
            setupEditProfilePictureUpload();
        });

        function setupSearch() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    filterFamilyMembers(this.value.toLowerCase());
                });
            }
        }

        function setupProfilePictureUpload() {
            const profilePictureInput = document.getElementById('profilePicture');
            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.getElementById('profilePicturePreview');
                            if (preview) {
                                preview.innerHTML = `
                                    <img src="${e.target.result}" style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover;">
                                `;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        function setupEditProfilePictureUpload() {
            const profilePictureInput = document.getElementById('editProfilePicture');
            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.getElementById('editProfilePicturePreview');
                            if (preview) {
                                preview.innerHTML = `
                                    <img src="${e.target.result}" style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover;">
                                `;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        // async function loadFamilyMembers() {
        //     try {
        //         const container = document.getElementById('familyMembersContainer');
        //         if (!container) return;

        //         // Show loading spinner
        //         container.innerHTML = `
        //             <div id="loadingSpinner" class="py-5 text-center">
        //                 <div class="spinner-border" style="color: #62B1A1;" role="status">
        //                     <span class="visually-hidden">Loading...</span>
        //                 </div>
        //                 <p class="mt-2 text-muted">Loading family members...</p>
        //             </div>
        //         `;

        //         // FIXED: Use correct API endpoint
        //         const response = await fetch('/api/family-members', {
        //             headers: {
        //                 'Accept': 'application/json',
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             }
        //         });
        async function loadFamilyMembers() {
    try {
        const container = document.getElementById('familyMembersContainer');
        if (!container) return;

        // Show loading spinner
        container.innerHTML = `
            <div id="loadingSpinner" class="py-5 text-center">
                <div class="spinner-border" style="color: #62B1A1;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading family members...</p>
            </div>
        `;

        // ✅ CORRECTED: Remove /patient prefix
        const response = await fetch('/api/family-members', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });


                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success && result.data && result.data.length > 0) {
                    allFamilyMembers = result.data;
                    displayFamilyMembers(result.data);
                } else {
                    showNoFamilyMembers();
                }
            } catch (error) {
                console.error('Error loading family members:', error);
                showNoFamilyMembers();
                showAlert('Error loading family members: ' + error.message, 'danger');
            }
        }

        function displayFamilyMembers(members) {
            const container = document.getElementById('familyMembersContainer');
            if (!container) return;

            if (members.length === 0) {
                showNoFamilyMembers();
                return;
            }

            const membersHTML = members.map(member => {
                const initials = (member.first_name.charAt(0) + member.last_name.charAt(0)).toUpperCase();
                const formattedDOB = formatDate(member.date_of_birth);

                return `
                    <div class="mb-4 family-member-card"
                         data-id="${member.id}"
                         data-name="${member.full_name.toLowerCase()}"
                         data-relationship="${member.relationship.toLowerCase()}">
                        <div class="shadow-sm card" style="border: none; border-radius: 10px; ${member.has_insurance ? 'border-left: 4px solid #28a745 !important;' : ''}">
                            <div class="p-4 card-body">
                                <!-- Top Section: Name, Created Date, and Action Icons -->
                                <div class="mb-3 d-flex align-items-start justify-content-between">
                                    <div class="gap-3 d-flex align-items-start" style="flex: 1; min-width: 0;">
                                        <!-- Profile Picture / Initials -->
                                        <div style="width: 60px; height: 60px; background-color: ${member.has_insurance ? '#D4F4DD' : '#D4EEE8'}; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; position: relative; ${member.has_insurance ? 'border: 2px solid #28a745;' : ''}">
                                            <span style="font-weight: 700; color: ${member.has_insurance ? '#28a745' : '#62B1A1'}; font-size: 18px;">${initials}</span>
                                            ${member.has_insurance ? '<i class="bi bi-shield-check" style="position: absolute; top: -8px; right: -8px; background-color: #28a745; color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; line-height: 1;"></i>' : ''}
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <h6 class="mb-1" style="color: #1F2937; font-weight: 700; font-size: 16px; word-break: break-word;">
                                                ${member.full_name}
                                            </h6>
                                            <small class="text-muted" style="font-size: 12px;">Added on ${member.created_at}</small>
                                        </div>
                                    </div>
                                    <!-- Action Icons -->
                                    <div class="gap-2 d-flex" style="flex-shrink: 0;">
                                        <button type="button" class="btn btn-sm btn-light"
                                                title="Edit"
                                                onclick="openEditFamilyMemberModal(${member.id})"
                                                style="border: 1px solid #E5E7EB; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; padding: 0;">
                                            <i class="bi bi-pencil" style="color: #62B1A1;"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light"
                                                onclick="deleteFamilyMember(${member.id})"
                                                title="Delete"
                                                style="border: 1px solid #E5E7EB; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; padding: 0;">
                                            <i class="bi bi-trash" style="color: #DC2626;"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Info Section: DOB, Relationship, Phone, Email, etc. -->
                                <div style="border-top: 1px solid #E5E7EB; padding-top: 15px;">
                                    <div class="row">
                                        <div class="mb-3 col-md-6 col-lg-3">
                                            <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">DOB</small>
                                            <div style="font-weight: 600; font-size: 13px; color: #374151;">
                                                <i class="bi bi-calendar2 me-1 text-muted" style="font-size: 12px;"></i>${formattedDOB}
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6 col-lg-3">
                                            <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Relationship</small>
                                            <div style="font-weight: 600; font-size: 13px; color: #374151; text-transform: capitalize;">
                                                <i class="bi bi-person me-1 text-muted" style="font-size: 12px;"></i>${member.relationship}
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6 col-lg-3">
                                            <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Phone</small>
                                            <div style="font-weight: 600; font-size: 13px; color: #374151;">
                                                <i class="bi bi-telephone me-1 text-muted" style="font-size: 12px;"></i>${member.phone}
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6 col-lg-3">
                                            <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Email</small>
                                            <div style="font-weight: 600; font-size: 13px; color: #374151;">
                                                <i class="bi bi-envelope me-1 text-muted" style="font-size: 12px;"></i>${member.email}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Insurance and Appointments (visible after expand or at bottom) -->
                                    <div class="card-details" style="display: none; border-top: 1px solid #E5E7EB; padding-top: 15px; margin-top: 15px;">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Gender</small>
                                                <div style="font-weight: 600; font-size: 13px; color: #374151; text-transform: capitalize;">
                                                    ${member.gender}
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Insurance</small>
                                                <div style="font-weight: 600; font-size: 13px;">
                                                    ${member.use_parent_insurance ? '<span class="badge" style="background-color: #D1FAE5; color: #065F46;">1 Policy</span>' : '<span class="badge" style="background-color: #F3F4F6; color: #4B5563;">No Insurance</span>'}
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Address</small>
                                                <div style="font-weight: 600; font-size: 13px; color: #374151;">
                                                    ${member.address}, ${member.city}, ${member.state} ${member.zip_code}
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Appointments</small>
                                                <div style="font-weight: 600; font-size: 13px; color: #374151;">
                                                    <i class="bi bi-calendar-check me-1" style="font-size: 12px;"></i>0 Total
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- View Profile Link -->

                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = membersHTML;
        }

        function showNoFamilyMembers() {
            const container = document.getElementById('familyMembersContainer');
            if (!container) return;

            container.innerHTML = `
                <div class="shadow-sm card">
                    <div class="py-5 card-body">
                        <div class="text-center">
                            <div style="width: 80px; height: 80px; margin: 0 auto 20px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-people fa-2x text-muted"></i>
                            </div>
                            <h6 class="mb-2 text-dark" style="font-size: 16px;">No family members found</h6>
                            <p class="mb-3 text-muted" style="font-size: 14px;">You haven't added any family members yet.</p>
                            <button type="button" class="px-3 btn" id="addFirstFamilyMemberBtn" style="background-color: #62B1A1; color: white; font-weight: 600; font-size: 14px;" onclick="showFirstFamilyMemberOptions();">
                                <i class="bi bi-plus me-2"></i>Add Your First Family Member
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function filterFamilyMembers(query) {
            if (!query) {
                // If search is empty, show all members
                displayFamilyMembers(allFamilyMembers);
                return;
            }

            const filteredMembers = allFamilyMembers.filter(member => {
                const fullName = member.full_name.toLowerCase();
                const relationship = member.relationship.toLowerCase();
                return fullName.includes(query) || relationship.includes(query);
            });

            displayFamilyMembers(filteredMembers);
        }

        function showFirstFamilyMemberOptions() {
            const container = document.getElementById('familyMembersContainer');
            const overlay = document.getElementById('pageOverlay');
            const inlineForm = document.getElementById('inlineFormContainer');
            const initialOptionsScreen = document.getElementById('initialOptionsScreen');
            const formScreen = document.getElementById('formScreen');
            const initialOptionsFooter = document.getElementById('initialOptionsFooter');
            const formFooter = document.getElementById('formFooter');

            if (container) container.style.display = 'none';
            if (overlay) overlay.style.display = 'block';
            if (inlineForm) inlineForm.style.display = 'block';

            if (initialOptionsScreen) initialOptionsScreen.style.display = 'block';
            if (formScreen) formScreen.style.display = 'block';
            if (initialOptionsFooter) initialOptionsFooter.style.display = 'block';
            if (formFooter) formFooter.style.display = 'none';

            if (initialOptionsScreen) {
                initialOptionsScreen.style.position = 'fixed';
                initialOptionsScreen.style.zIndex = '10000';
                initialOptionsScreen.style.transform = 'translate(-50%, -50%)';
                initialOptionsScreen.style.left = '50%';
                initialOptionsScreen.style.top = '40%';
                initialOptionsScreen.style.width = '450px';
                initialOptionsScreen.style.backgroundColor = 'white';
                initialOptionsScreen.style.borderRadius = '12px';
                initialOptionsScreen.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.15)';
                initialOptionsScreen.style.padding = '20px';
            }

            if (formScreen) {
                formScreen.style.opacity = '0.5';
                formScreen.style.pointerEvents = 'none';
            }
        }

        function goToForm(useFamilyMemberInfo) {
            const initialOptionsScreen = document.getElementById('initialOptionsScreen');
            const formScreen = document.getElementById('formScreen');
            const initialOptionsFooter = document.getElementById('initialOptionsFooter');
            const formFooter = document.getElementById('formFooter');
            const overlay = document.getElementById('pageOverlay');

            if (initialOptionsScreen) initialOptionsScreen.style.display = 'none';
            if (formScreen) formScreen.style.display = 'block';
            if (initialOptionsFooter) initialOptionsFooter.style.display = 'none';
            if (formFooter) formFooter.style.display = 'flex';

            if (formScreen) {
                formScreen.style.opacity = '1';
                formScreen.style.pointerEvents = 'auto';
            }

            if (overlay) overlay.style.display = 'none';

            if (useFamilyMemberInfo) {
                // Pre-fill with user's information
                // document.getElementById('firstName').value = 'Your First Name';
                // document.getElementById('lastName').value = 'Your Last Name';
                // etc...
            }
        }

        function goToInlineForm(useFamilyMemberInfo) {
            showInlineForm();
            if (useFamilyMemberInfo) {
                // Pre-fill with user's information
            }
        }

        function showInlineForm() {
            const inlineForm = document.getElementById('inlineFormContainer');
            if (inlineForm) {
                inlineForm.style.display = 'block';
                inlineForm.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        function hideInlineForm() {
            const inlineForm = document.getElementById('inlineFormContainer');
            const overlay = document.getElementById('pageOverlay');
            const container = document.getElementById('familyMembersContainer');

            if (inlineForm) inlineForm.style.display = 'none';
            if (overlay) overlay.style.display = 'none';
            if (container) container.style.display = 'block';

            resetFormForAdd();
            showInitialOptions();
        }

        function backToOptions() {
            const container = document.getElementById('familyMembersContainer');
            const overlay = document.getElementById('pageOverlay');
            const initialOptionsScreen = document.getElementById('initialOptionsScreen');
            const formScreen = document.getElementById('formScreen');
            const initialOptionsFooter = document.getElementById('initialOptionsFooter');
            const formFooter = document.getElementById('formFooter');

            if (container && container.style.display === 'none') {
                if (overlay) overlay.style.display = 'block';
                if (initialOptionsScreen) initialOptionsScreen.style.display = 'block';
                if (formScreen) formScreen.style.display = 'block';
                if (initialOptionsFooter) initialOptionsFooter.style.display = 'block';
                if (formFooter) formFooter.style.display = 'none';

                if (initialOptionsScreen) {
                    initialOptionsScreen.style.position = 'fixed';
                    initialOptionsScreen.style.zIndex = '10000';
                    initialOptionsScreen.style.transform = 'translate(-50%, -50%)';
                    initialOptionsScreen.style.left = '50%';
                    initialOptionsScreen.style.top = '30%';
                    initialOptionsScreen.style.width = '400px';
                    initialOptionsScreen.style.backgroundColor = 'white';
                    initialOptionsScreen.style.borderRadius = '12px';
                    initialOptionsScreen.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.15)';
                    initialOptionsScreen.style.padding = '20px';
                }

                if (formScreen) {
                    formScreen.style.opacity = '0.5';
                    formScreen.style.pointerEvents = 'none';
                }
            } else {
                if (overlay) overlay.style.display = 'none';
                if (initialOptionsScreen) initialOptionsScreen.style.display = 'block';
                if (formScreen) formScreen.style.display = 'none';
                if (initialOptionsFooter) initialOptionsFooter.style.display = 'block';
                if (formFooter) formFooter.style.display = 'none';
            }
        }

        function showInitialOptions() {
            const initialOptionsScreen = document.getElementById('initialOptionsScreen');
            const formScreen = document.getElementById('formScreen');
            const initialOptionsFooter = document.getElementById('initialOptionsFooter');
            const formFooter = document.getElementById('formFooter');

            if (initialOptionsScreen) initialOptionsScreen.style.display = 'block';
            if (formScreen) formScreen.style.display = 'none';
            if (initialOptionsFooter) initialOptionsFooter.style.display = 'block';
            if (formFooter) formFooter.style.display = 'none';

            if (initialOptionsScreen) {
                initialOptionsScreen.style.position = 'static';
                initialOptionsScreen.style.zIndex = 'auto';
                initialOptionsScreen.style.transform = 'none';
            }
            if (formScreen) {
                formScreen.style.opacity = '1';
                formScreen.style.pointerEvents = 'auto';
            }
        }

        function resetFormForAdd() {
            editingFamilyMemberId = null;
            const form = document.getElementById('addFamilyMemberForm');
            if (form) form.reset();

            const familyMemberId = document.getElementById('familyMemberId');
            if (familyMemberId) familyMemberId.value = '';

            const profilePicturePreview = document.getElementById('profilePicturePreview');
            if (profilePicturePreview) {
                profilePicturePreview.innerHTML = '<i class="bi bi-person fa-2x text-muted"></i>';
            }

            // Reset button text
            const submitBtnText = document.getElementById('submitBtnText');
            if (submitBtnText) submitBtnText.textContent = 'Save Family Member';

            // Reset to initial options screen
            if (document.getElementById('initialOptionsScreen')) {
                document.getElementById('initialOptionsScreen').style.display = 'block';
                document.getElementById('formScreen').style.display = 'none';
                document.getElementById('initialOptionsFooter').style.display = 'block';
                document.getElementById('formFooter').style.display = 'none';
            }

            clearValidationErrors();
        }

        function clearValidationErrors() {
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                if (el) el.style.display = 'none';
            });
            document.querySelectorAll('.form-control, .form-select').forEach(el => {
                if (el) el.classList.remove('is-invalid');
            });
            const alert = document.getElementById('validationErrorAlert');
            if (alert) alert.classList.add('d-none');
        }

        function clearEditValidationErrors() {
            document.querySelectorAll('#editFamilyMemberForm .invalid-feedback').forEach(el => {
                if (el) el.style.display = 'none';
            });
            document.querySelectorAll('#editFamilyMemberForm .form-control, #editFamilyMemberForm .form-select').forEach(el => {
                if (el) el.classList.remove('is-invalid');
            });
            const alert = document.getElementById('editValidationErrorAlert');
            if (alert) alert.classList.add('d-none');
        }

        function showValidationErrors(errors) {
            clearValidationErrors();
            const alert = document.getElementById('validationErrorAlert');
            if (alert) alert.classList.remove('d-none');

            for (const field in errors) {
                const errorEl = document.getElementById(field + 'Error');
                const inputEl = document.getElementById(field) || document.querySelector(`[name="${field}"]`);
                if (errorEl && inputEl) {
                    errorEl.textContent = errors[field][0];
                    errorEl.style.display = 'block';
                    inputEl.classList.add('is-invalid');
                }
            }
        }

        function showEditValidationErrors(errors) {
            clearEditValidationErrors();
            const alert = document.getElementById('editValidationErrorAlert');
            if (alert) alert.classList.remove('d-none');

            for (const field in errors) {
                const errorEl = document.getElementById('edit_' + field + 'Error');
                const inputEl = document.getElementById('edit_' + field) || document.querySelector(`#editFamilyMemberForm [name="${field}"]`);
                if (errorEl && inputEl) {
                    errorEl.textContent = errors[field][0];
                    errorEl.style.display = 'block';
                    inputEl.classList.add('is-invalid');
                }
            }
        }

        function setupFormHandler() {
            // Form handler is now called by submitFamilyMemberForm()
        }

        // async function submitFamilyMemberForm() {
        //     const form = document.getElementById('addFamilyMemberForm');
        //     if (!form) return;

        //     const submitBtn = document.getElementById('submitBtn');
        //     if (!submitBtn) return;

        //     const originalText = submitBtn.innerHTML;
        //     submitBtn.disabled = true;
        //     submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        //     clearValidationErrors();

        //     try {
        //         const formData = new FormData(form);
        //         const familyMemberId = editingFamilyMemberId;

        //         let url = '/patient/api/family-members'; // FIXED: Added /patient prefix
        //         let method = 'POST';

        //         if (familyMemberId) {
        //             url = `/patient/api/family-members/${familyMemberId}`; // FIXED: Added /patient prefix
        //             method = 'PUT';
        //             // For PUT request, we need to append the method since FormData doesn't support PUT
        //             formData.append('_method', 'PUT');
        //         }

        //         const response = await fetch(url, {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        //                 'Accept': 'application/json',
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             },
        //             body: formData
        //         });

    //     async function submitFamilyMemberForm() {
    // const form = document.getElementById('addFamilyMemberForm');
    // if (!form) return;

    // const submitBtn = document.getElementById('submitBtn');
    // if (!submitBtn) return;

    // const originalText = submitBtn.innerHTML;
    // submitBtn.disabled = true;
    // submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    // clearValidationErrors();

    // try {
    //     const formData = new FormData(form);
    //     const familyMemberId = editingFamilyMemberId;

    //     // ✅ CORRECTED: Remove /patient prefix
    //     let url = '/api/family-members';
    //     let method = 'POST';

    //     if (familyMemberId) {
    //         url = `/api/family-members/${familyMemberId}`; // ✅ CORRECTED: Remove /patient prefix
    //         method = 'PUT';
    //         formData.append('_method', 'PUT');
    //     }

    //     const response = await fetch(url, {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //             'Accept': 'application/json',
    //             'X-Requested-With': 'XMLHttpRequest'
    //         },
    //         body: formData
    //     });


    //             // Handle non-JSON responses
    //             const contentType = response.headers.get('content-type');
    //             if (!contentType || !contentType.includes('application/json')) {
    //                 const text = await response.text();
    //                 console.error('Non-JSON response:', text);
    //                 throw new Error('Server returned non-JSON response. Please check the API endpoint.');
    //             }

    //             const result = await response.json();

    //             if (result.success) {
    //                 showAlert(familyMemberId ? 'Family member updated successfully!' :
    //                     'Family member added successfully!', 'success');
    //                 resetFormForAdd();

    //                 // Close modal
    //                 const modalElement = document.getElementById('addFamilyMemberModal');
    //                 const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
    //                 if (modal) modal.hide();

    //                 // Reload family members
    //                 setTimeout(() => loadFamilyMembers(), 500);
    //             } else {
    //                 if (result.errors) {
    //                     showValidationErrors(result.errors);
    //                 } else {
    //                     showAlert(result.message || 'Error saving family member', 'danger');
    //                 }
    //             }
    //         } catch (error) {
    //             console.error('Error:', error);
    //             showAlert('Error: ' + error.message, 'danger');
    //         } finally {
    //             submitBtn.disabled = false;
    //             submitBtn.innerHTML = originalText;
    //         }
    //     }

    //     async function toggleCardDetails(btn, memberId) {
    //         const card = btn.closest('.family-member-card');
    //         const details = card.querySelector('.card-details');
    //         const isVisible = details.style.display !== 'none';

    //         if (isVisible) {
    //             details.style.display = 'none';
    //             btn.innerHTML = '<i class="bi bi-eye" style="color: #62B1A1;"></i>';
    //             btn.title = 'View Details';
    //         } else {
    //             details.style.display = 'block';
    //             btn.innerHTML = '<i class="bi bi-eye-slash" style="color: #62B1A1;"></i>';
    //             btn.title = 'Hide Details';
    //         }
    //     }
async function submitFamilyMemberForm() {
    const form = document.getElementById('addFamilyMemberForm');
    if (!form) return;

    const submitBtn = document.getElementById('submitBtn');
    if (!submitBtn) return;

    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    clearValidationErrors();

    try {
        const formData = new FormData(form);
        const familyMemberId = editingFamilyMemberId;

        let url = '/api/family-members';
        let method = 'POST';

        if (familyMemberId) {
            url = `/api/family-members/${familyMemberId}`;
            method = 'PUT';
            formData.append('_method', 'PUT');
        }

        // Debug: Log form data
        console.log('Form Data:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }

        console.log('URL:', url);
        console.log('Method:', method);

        const response = await fetch(url, {
            method: 'POST', // Always use POST for FormData with _method
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        console.log('Response Status:', response.status);
        console.log('Response OK:', response.ok);

        // Handle non-JSON responses
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text);
            throw new Error('Server returned non-JSON response. Status: ' + response.status);
        }

        const result = await response.json();
        console.log('Server Response:', result);

        if (result.success) {
            showAlert(familyMemberId ? 'Family member updated successfully!' :
                'Family member added successfully!', 'success');
            resetFormForAdd();
            hideInlineForm();
            setTimeout(() => loadFamilyMembers(), 500);
        } else {
            if (result.errors) {
                showValidationErrors(result.errors);
            } else {
                showAlert(result.message || 'Error saving family member', 'danger');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Error: ' + error.message, 'danger');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}
        function formatDate(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
        }

        // async function editFamilyMember(id) {
        //     try {
        //         editingFamilyMemberId = id;

        //         // Get member details from API - FIXED: Added /patient prefix
        //         const response = await fetch(`/api/family-members/${id}`, {
        //             headers: {
        //                 'Accept': 'application/json',
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             }
        //         });
async function editFamilyMember(id) {
    try {
        editingFamilyMemberId = id;

        // ✅ CORRECTED: Remove /patient prefix
        const response = await fetch(`/api/family-members/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (!result.success || !result.data) {
                    showAlert('Error loading family member details', 'danger');
                    return;
                }

                const member = result.data;

                // Reset form before populating
                const editForm = document.getElementById('editFamilyMemberForm');
                if (editForm) editForm.reset();

                // Populate form with member data
                document.getElementById('editFamilyMemberId').value = id;
                document.getElementById('edit_first_name').value = member.first_name || '';
                document.getElementById('edit_middle_name').value = member.middle_name || '';
                document.getElementById('edit_last_name').value = member.last_name || '';
                document.getElementById('edit_relationship').value = member.relationship || '';
                document.getElementById('edit_date_of_birth').value = member.date_of_birth || '';
                document.getElementById('edit_gender').value = member.gender || '';
                document.getElementById('edit_address').value = member.address || '';
                document.getElementById('edit_city').value = member.city || '';
                document.getElementById('edit_state').value = member.state || '';
                document.getElementById('edit_zip_code').value = member.zip_code || '';
                document.getElementById('edit_email').value = member.email || '';
                document.getElementById('edit_phone').value = member.phone || '';
                document.getElementById('edit_useParentInsurance').checked = member.use_parent_insurance || false;
                document.getElementById('edit_addInsurance').checked = member.add_insurance || false;

                // Update profile picture preview if exists
                if (member.profile_picture_url) {
                    document.getElementById('editProfilePicturePreview').innerHTML = `
                        <img src="${member.profile_picture_url}" style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover;">
                    `;
                } else {
                    document.getElementById('editProfilePicturePreview').innerHTML = '<i class="bi bi-person fa-2x text-muted"></i>';
                }

                // Open modal
                const modal = new bootstrap.Modal(document.getElementById('editFamilyMemberModal'));
                modal.show();
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            }
        }

        // async function updateFamilyMember() {
        //     const form = document.getElementById('editFamilyMemberForm');
        //     if (!form) return;

        //     const submitBtn = document.getElementById('editSubmitBtn');
        //     if (!submitBtn) return;

        //     const originalText = submitBtn.innerHTML;
        //     submitBtn.disabled = true;
        //     submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        //     clearEditValidationErrors();

        //     try {
        //         const formData = new FormData(form);
        //         const familyMemberId = document.getElementById('editFamilyMemberId').value;

        //         if (!familyMemberId) {
        //             showAlert('Error: No family member ID found', 'danger');
        //             return;
        //         }

        //         formData.append('_method', 'PUT');

        //         // FIXED: Added /patient prefix
        //         const response = await fetch(`/api/family-members/${familyMemberId}`, {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        //                 'Accept': 'application/json',
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             },
        //             body: formData
        //         });
        async function updateFamilyMember() {
            const form = document.getElementById('editFamilyMemberForm');
            if (!form) return;

            const submitBtn = document.getElementById('editSubmitBtn');
            if (!submitBtn) return;

            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

            clearEditValidationErrors();

            try {
                const formData = new FormData(form);
                const familyMemberId = document.getElementById('editFamilyMemberId').value;

        if (!familyMemberId) {
            showAlert('Error: No family member ID found', 'danger');
            return;
        }

        formData.append('_method', 'PUT');

        // ✅ CORRECTED: Remove /patient prefix
        const response = await fetch(`/api/family-members/${familyMemberId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });
                // Handle non-JSON responses
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    console.error('Non-JSON response:', text);
                    throw new Error('Server returned non-JSON response. Please check the API endpoint.');
                }

                const result = await response.json();

                if (result.success) {
                    showAlert('Family member updated successfully!', 'success');

                    // Close modal
                    const modalElement = document.getElementById('editFamilyMemberModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                    if (modal) modal.hide();


                    // Reload family members
                    setTimeout(() => loadFamilyMembers(), 500);
                } else {
                    if (result.errors) {
                        showEditValidationErrors(result.errors);
                    } else {
                        showAlert(result.message || 'Error updating family member', 'danger');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }

        // async function deleteFamilyMember(id) {
        //     if (!confirm('Are you sure you want to delete this family member? This action cannot be undone.')) {
        //         return;
        //     }

        //     try {
        //         // FIXED: Added /patient prefix
        //         const response = await fetch(`/api/family-members/${id}`, {
        //             method: 'DELETE',
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('[name="_token"]')?.value,
        //                 'Accept': 'application/json',
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             }
        //         });
        async function deleteFamilyMember(id) {
    if (!confirm('Are you sure you want to delete this family member? This action cannot be undone.')) {
        return;
    }

    try {
        // ✅ CORRECTED: Remove /patient prefix
        const response = await fetch(`/api/family-members/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('[name="_token"]')?.value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

                const result = await response.json();

                if (result.success) {
                    showAlert('Family member deleted successfully!', 'success');
                    setTimeout(() => loadFamilyMembers(), 500);
                } else {
                    showAlert(result.message || 'Error deleting family member', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            }
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
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        }
    </script>

    <style>
        .family-member-card {
            transition: all 0.3s ease;
        }

        .family-member-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
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

        #validationErrorAlert, #editValidationErrorAlert {
            border-left: 4px solid #dc3545;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.3) !important;
        }
    </style>
@endsection
