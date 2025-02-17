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
        height: 100%;
        margin: 0;
        overflow: hidden;
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
      .content-box {
        background-color: rgba(255, 255, 255, 0.3); /* Transparent white */
        backdrop-filter: blur(10px); /* Blurred effect */
        border-radius: 15px;
        padding: 30px;
        width: 80%;
        max-width: 800px;
        color: black;
      }
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th, td {
        padding: 10px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        text-align: center;
        background-color: rgba(255, 255, 255, 0.5);
      }
      .btn-back {
        background-color: #6c757d;
        border: none;
      }
      .btn-back:hover {
        background-color: #5a6268;
      }
    </style>
  </head>
  <body>
    
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="content-box shadow text-center">
        <h3 class="mb-3">Dashboard</h3>
        <h5>Establishments</h5>
        <h5>Parking Areas</h5>
        
        <table class="mt-3">
          <thead>
            <tr>
              <th>Area Name</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Area 1</td>
              <td>Available</td>
            </tr>
            <tr>
              <td>Area 2</td>
              <td>Occupied</td>
            </tr>
            <tr>
              <td>Area 3</td>
              <td>Available</td>
            </tr>
          </tbody>
        </table>

        <button class="btn btn-secondary mt-3 btn-back">Go Back</button>
      </div>
    </div>

  </body>
</html>
