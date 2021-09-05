<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <title>تسجيل الدخول</title>
</head>
<body class="bg-dark">
    <div class="d-flex justify-content-center p-5 mt-5 w-100">

        {{-- <form action="{{route('myauth.check')}}" method="POST">
            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{Session::get('fail')}}
                </div>
            @endif
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                <span class="text-danger"></span>
             </div>
             <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password">
                <span class="text-danger"></span>
             </div>
             <button type="submit" class="btn btn-block btn-primary">Sign In</button>
             <br>
             <a href="{{route('myauth.register')}}">I don't have an account, create new</a>
        </form> --}}
        {{------------------------------------------------------------}}

        <form style="background: #343a40;" class="text-light p-5 login-form" action="{{route('myauth.check')}}" method="POST">
            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{Session::get('fail')}}
                </div>
            @endif
            @csrf
            <div class="d-flex justify-content-center mb-3">
                <img src="{{asset('img/1-modified.png')}}" class="" width="100" height="100">

            </div>
            <div class="mb-3 w-100">
              <label for="exampleInputEmail1" class="form-label">Email address</label>
              <input placeholder="Enter Email" type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{old('email')}}">
              <span class="text-danger">@error('email'){{ $message }}@enderror</span>

            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input placeholder="Enter Password" type="password" class="form-control" name="password" id="exampleInputPassword1">
              <span class="text-danger">@error('password'){{ $message }}@enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
    </div>
</body>
</html>