<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      body {
        background-image: url('assets/img/bg.jpg'); /* Replace with your image URL */
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin: 0;
      }
      .card {
        background-color: rgba(255, 255, 255, 0.2); /* Transparent white */
        backdrop-filter: blur(10px); /* Blurred glass effect */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Optional border */
      }
      .card h3, .card label {
        color: white; /* White text for contrast */
      }
      .form-control {
        background-color: rgba(255, 255, 255, 0.3);
        border: none;
        color: white;
      }
      .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
      }
      .form-control:focus {
        background-color: rgba(255, 255, 255, 0.5);
        color: black;
      }
      .login-link {
        text-align: center;
        margin-top: 10px;
      }
      .login-link a {
        color: white;
        text-decoration: none;
      }
      .login-link a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 350px;">
            <h3 class="text-center mb-3">Sign Up</h3>
            <form action="action/action_form.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text"name="username" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="re_password" class="form-label">Re-enter Password</label>
                    <input type="password" name="re_password" class="form-control" id="re_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>
            <p class="login-link">Already have an account?<a href="index.php"> Login</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
