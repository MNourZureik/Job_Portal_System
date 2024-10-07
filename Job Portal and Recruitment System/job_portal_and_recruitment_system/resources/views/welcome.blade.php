<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal | Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .welcome-container {
            text-align: center;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <h1>Welcome to the Job Portal</h1>
    <p>Find your next career opportunity with us.</p>
    <div>
        <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success">Register</a>
    </div>
</div>

<script>
    // Check if JWT token exists in localStorage
    if (localStorage.getItem('jwt_token')) {
        // If token exists, redirect to dashboard
        window.location.href = '/dashboard';
    }
</script>

</body>
</html>
