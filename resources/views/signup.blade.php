<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 rounded-4" style="max-width: 450px; width: 100%;">
            <h3 class="text-center mb-4 text-primary fw-bold">Create an Account</h3>

            <form action="{{ route('registration') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name"
                        required>
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        placeholder="Choose a username" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com"
                        required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter a strong password" required>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-semibold">Sign Up</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <small>Already have an account?
                    <a href="{{ route('log') }}" class="text-decoration-none fw-semibold text-primary">Login</a>
                </small>
            </div>
        </div>
    </div>

</body>

</html>