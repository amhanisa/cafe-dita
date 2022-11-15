<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cafe DITA</title>
    @vite('resources/scss/app.scss')
    @vite('resources/scss/themes/dark/app-dark.scss')
</head>

<body>
    <section class="container">

        <div class="row vh-100 align-items-md-center justify-content-center">
            <div class="col-lg-4 col-12 p-5">
                <div class="d-flex justify-content-center align-items-center">
                    <img class="mb-3" src="{{ asset('logo.svg') }}" alt="Cafe DITA" style="height: 2rem" />
                </div>

                <h3 class="text-center">Login</h1>

                    <form action="{{ url('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" name="username" type="text" value="{{ old('username') }}"
                                placeholder="Username">
                            @error('username')
                                <span class="validation-error"> {{ $message }} </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input class="form-control" name="password" type="password" placeholder="Password">
                            @error('password')
                                <span class="validation-error"> {{ $message }} </span>
                            @enderror
                        </div>
                        @error('notmatch')
                            <span class="validation-error"> {{ $message }} </span>
                        @enderror
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>

            </div>
        </div>
    </section>

    @vite('resources/js/app.js')

</body>

</html>

