<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['error'] = "You must log in first!";
    header("Location: index.php");
    exit();
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <style>
      body {
        background-image: url('assets/img/bg.jpg'); /* Replace with your image */
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin: 0;
      }
      .header {
        background-color: rgba(255, 255, 255, 0.3); /* Semi-transparent white */
        backdrop-filter: blur(10px); /* Blurred effect */
        color: black; /* Dark text for better contrast */
        padding: 15px 20px;
      }
      .logout-btn {
        background-color: #dc3545;
        border: none;
      }
      .logout-btn:hover {
        background-color: #c82333;
      }
      .card {
        background-color: rgba(255, 255, 255, 0.3); /* Transparent white */
        backdrop-filter: blur(10px); /* Blurred effect */
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: black; /* Dark text for readability */
      }
      .container {
        height: calc(100vh - 70px); /* Adjust height considering the header */
      }
    </style>
  </head>
  <body>
    
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="container d-flex justify-content-center align-items-center">
      <div class="row">
        <div class="col-md-6">
          <div class="card shadow text-center p-4">
            <h5>Card 1</h5>
            <p>Some description here...</p>
            <button class="btn btn-light">View</button>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow text-center p-4">
            <h5>Card 2</h5>
            <p>Some description here...</p>
            <button class="btn btn-light">View</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
