<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
  data-assets-path="{{asset('public')}}/assets/" data-template="vertical-menu-template" data-style="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Deven Health Care | Admin Login</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('public')}}/assets/images/logo.png">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/fonts/remixicon/remixicon.css" />
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/fonts/flag-icons.css" />

  <!-- Menu waves for no-customizer fix -->
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/node-waves/node-waves.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{asset('public')}}/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/typeahead-js/typeahead.css" />
  <!-- Vendor -->
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/@form-validation/form-validation.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/css/pages/page-auth.css" />

  <!-- Helpers -->
  <script src="{{asset('public')}}/assets/vendor/js/helpers.js"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="{{asset('public')}}/assets/vendor/js/template-customizer.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="{{asset('public')}}/assets/js/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
      <div class="authentication-inner py-6">
        <!-- Register Card -->
        <div class="card p-md-7 p-1">
          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
            <a href="{{asset('/')}}" class="app-brand-link gap-2">
                <img alt="Logo" src="{{asset('public')}}/assets/images/full_logo.png"
                style="height: 80px!important;" />
            </a>
          </div>
          <!-- /Logo -->
          <div class="card-body mt-1">
            <form  method="POST" action="{{ route('login') }}">
                @csrf
              <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
                <label for="email">Email</label>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-5 form-password-toggle">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control" name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <label for="password">Password</label>
                  </div>
                  <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                </div>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <button class="btn btn-primary d-grid w-100">Sign In</button>
            </form>
          </div>
        </div>
        <!-- Register Card -->
        <img alt="mask" src="{{asset('public')}}/assets/img/illustrations/auth-basic-register-mask-light.png"
          class="authentication-image d-none d-lg-block"
          data-app-light-img="illustrations/auth-basic-register-mask-light.png"
          data-app-dark-img="illustrations/auth-basic-register-mask-dark.png" />
      </div>
    </div>
  </div>

  <!-- / Content -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="{{asset('public')}}/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/popper/popper.js"></script>
  <script src="{{asset('public')}}/assets/vendor/js/bootstrap.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/hammer/hammer.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/i18n/i18n.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="{{asset('public')}}/assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{asset('public')}}/assets/vendor/libs/@form-validation/popular.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/@form-validation/bootstrap5.js"></script>
  <script src="{{asset('public')}}/assets/vendor/libs/@form-validation/auto-focus.js"></script>

  <!-- Main JS -->
  <script src="{{asset('public')}}/assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="{{asset('public')}}/assets/js/pages-auth.js"></script>
</body>

</html>