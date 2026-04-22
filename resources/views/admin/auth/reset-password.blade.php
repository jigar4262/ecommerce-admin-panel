<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('build/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="text-center mb-4">
                            <h4 class="mb-1">Reset Password</h4>
                            
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif



                        <form method="POST" data-parsley-validate action="{{ route('reset.submit') }}">
                           @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email address" >
                                <div class="form-control-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>

                            <div class="form-group position-relative has-icon-left mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" >
                                <div class="form-control-icon">
                                    <i class="bi bi-lock"></i>
                                </div>
                            </div>

                            <div class="form-group position-relative has-icon-left mb-3">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" >
                                <div class="form-control-icon">
                                    <i class="bi bi-lock"></i>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Reset Password
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
