بہت زبردست ✅ یہ فیچر “User Activation/Deactivation” ہے — یعنی ایڈمن کسی بھی یوزر کو Active یا Inactive کرسکے،
اور Inactive یوزر لاگ اِن نہ کرسکے۔
آئیے مکمل step-by-step دیکھتے ہیں 👇

🧱 Step 1 — Migration Update

پہلے اپنے users table میں ایک نیا column status add کریں۔

🔹 Run this artisan command:
php artisan make:migration add_status_to_users_table --table=users


پھر migration فائل میں یہ لکھیں 👇

public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('status', ['active', 'inactive'])->default('active');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}


اور پھر:

php artisan migrate

⚙️ Step 2 — Model Update (User.php)

app/Models/User.php میں fillable میں status بھی شامل کریں:

protected $fillable = [
    'name',
    'email',
    'password',
    'role_id',
    'verification_token',
    'email_verified_at',
    'email_status',
    'status', // ✅ Add this line
];

🧠 Step 3 — Controller Logic Update (Login Check)

AuthController میں login function کے اندر
email verification کے بعد یہ چیک لگائیں 👇

// 🔒 Check if email verified
if (!$user->email_verified_at) {
    return back()->with('error', 'Please verify your email before logging in.');
}

// 🚫 Check if user is active
if ($user->status !== 'active') {
    return back()->with('error', 'Your account is inactive. Please contact admin.');
}

🧰 Step 4 — Admin User Management میں Status Change Feature

اپنے User Management Page (resources/views/admin/users.blade.php) میں
جہاں آپ کے پاس Edit/Delete کے بٹن ہیں، وہاں ایک Status Toggle (Active/Inactive) بھی لگا دیں۔

✳️ Replace your action column section like this:
<td>
    {{-- Edit Button --}}
    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
        <i class="fa fa-edit"></i>
    </button>

    {{-- Delete Form --}}
    <form action="{{ url('/admin/users/delete/' . $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
    </form>

    {{-- ✅ Status Toggle --}}
    <form action="{{ url('/admin/users/toggle-status/' . $user->id) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-sm {{ $user->status == 'active' ? 'btn-success' : 'btn-secondary' }}">
            {{ ucfirst($user->status) }}
        </button>
    </form>
</td>

🧩 Step 5 — Admin Controller Logic

اپنے AdminController میں ایک نیا function بنا لیں:

public function toggleUserStatus($id)
{
    $user = User::findOrFail($id);

    // Toggle status
    $user->status = $user->status === 'active' ? 'inactive' : 'active';
    $user->save();

    return back()->with('success', 'User status updated successfully!');
}

🛣️ Step 6 — Route Add

routes/web.php میں add کریں:

Route::post('/admin/users/toggle-status/{id}', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');

✅ Step 7 — Table Header میں “Status” Add کریں

User Management page کی table header میں add کریں:

<th>Status</th>


اور row میں (Actions سے پہلے) یہ لگائیں:

<td>
    <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
        {{ ucfirst($user->status) }}
    </span>
</td>

💡 Result:

ایڈمن dashboard پر ہر user کے ساتھ “Active / Inactive” button ہوگا۔

ایڈمن بٹن دبائے → status toggle ہو جائے گا۔

اگر user inactive ہے تو وہ login نہیں کرسکے گا۔

Active user ہی login کرسکتا ہے۔

چاہیں تو میں ابھی اسی کے مطابق مکمل updated User Management blade file دے دوں (ready-to-use sidebar layout کے ساتھ)؟

ChatGPT can make mistakes. Check important info.
