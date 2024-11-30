<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women in FinTech</title>
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="main.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <img id="logo" src="logo.png" width="60px" height="auto">
            <a class="navbar-brand" href="index.php">Women in FinTech</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" datatarget="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_member.php">Add Member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="notifications.php">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="resources.php">Resources</a>
                    </li>
                </ul>
            </div>
            <button id="dark-mode-toggle" class="btn btn-secondary">Dark Mode</button>
        </div>
    </nav>
    <div class="search-bar-container">
        <form class="form-inline" method="GET" action="search.php">
            <input class="form-control search-bar" type="search" name="query" placeholder="Search members" aria-label="Search">
            <button class="btn" type="submit">Search</button>
        </form>
    </div>
    <div class="container mt-4">