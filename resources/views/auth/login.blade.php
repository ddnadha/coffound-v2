@include('components.head')

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="/logo.png" alt="logo" width="100">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Masuk untuk melanjutkan</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" class="needs-validation" novalidate=""
                                    action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ @old('email') }}" tabindex="1" required autofocus />
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="auth-forgot-password.html" class="text-small">
                                                    Lupa Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            value="{{ @old('password') }}" tabindex="2" />
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Masuk
                                        </button>
                                    </div>

                                </form>
                                <center>
                                    Belum punya akun ? <a href="{{ route('register') }}">Daftar Sekarang</a>
                                </center>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Didan Adha {{ date('Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('components.script')
</body>

</html>
