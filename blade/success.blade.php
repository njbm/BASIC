
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #d1e7dd;
        }
        .success-box {
            margin-top: 100px;
            padding: 40px;
            border-radius: 10px;
            background-color: #fff;
            border: 2px solid #198754;
            box-shadow: 0 0 10px rgba(25, 135, 84, 0.4);
        }
        .success-icon {
            font-size: 80px;
            color: #198754;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="success-box mx-auto col-md-6">
            <div class="success-icon mb-3">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h2 class="text-success">Payment Successful</h2>
            <p class="lead">Thank you! Your transaction has been completed successfully.</p>
            <p>We’ve received your payment and are processing your order.</p>
            <a href="/" class="btn btn-success mt-3">Return to Homepage</a>
        </div>
    </div>


</body>
</html>
