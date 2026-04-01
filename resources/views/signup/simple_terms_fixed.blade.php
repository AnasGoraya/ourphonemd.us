<!DOCTYPE html>
<html>
<head>
    <title>Terms - OurPhoneMD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Terms & Conditions</h1>
                <div class="card">
                    <div class="card-body">
                        <p>Welcome to OurPhoneMD Terms and Conditions.</p>
                        <form action="/signup/accept-terms" method="POST">
                            @csrf
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="terms_accepted" required>
                                <label class="form-check-label">I accept the terms</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
