<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Sidebar with Bootstrap 5.3</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      overflow-x: hidden;
    }

    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 100;
      width: 250px;
      background-color: #343a40;
      padding-top: 1rem;
      transition: all 0.3s;
    }

    .sidebar .nav-link {
      color: white;
    }

    .sidebar.collapsed {
      width: 0;
      padding: 0;
    }

    .content {
      margin-left: 250px;
      transition: margin-left 0.3s;
    }

    .content.collapsed {
      margin-left: 0;
    }
  </style>
</head>
<body>
  <div class="sidebar bg-dark" id="sidebar">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
    </ul>
  </div>

  <div class="content" id="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <button class="btn btn-primary" id="sidebarToggle">Toggle Sidebar</button>
    </nav>
    <div class="container-fluid">
      <h1 class="mt-4">Responsive Sidebar</h1>
      <p>This is a simple sidebar example using Bootstrap 5.3. Resize the browser window to see the sidebar collapse.</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('content').classList.toggle('collapsed');
    });
  </script>
</body>
</html>
