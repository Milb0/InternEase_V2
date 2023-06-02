<?php
$title = "InternEase - Identity";
$style_file = "assets/css/whoami.css";
$cssframewrok = '';
require_once "../app/includes/header.php"; 
require_once "../app/includes/bootstrap.php";
?>
<main>
    <header>
        <h1>Identify Your Self<br><span class="h1span">to get you started</span></h1> 
    </header>
    <section class="cards">
        <article class="card">
            <img src="assets/images/Student.png" alt="Student Picture">
            <h2>Student</h2>
            <a href="student/index.php">
                <p>Get Started</p>
            </a>
        </article>
        <article class="card">
            <img src="assets/images/Teacher.png" alt="Head of Department Picture">
            <h2>Head of Department</h2>
            <a href="DepartmentHead/index.php">
                <p>Get Started</p>
            </a>
        </article>
        <article class="card">
            <img src="assets/images/Supervisor.png" alt="Internship Supervisor Picture">
            <h2>Internship Supervisor</h2>
            <a href="internship-supervisor/index.php">
                <p>Get Started</p>
            </a>
        </article>
    </section>
    <a href="index.php" title="Home">
        <div class="home-icon" style="position: fixed; bottom: 20px; right: 20px; background-color: #006653; width: 55px; height: 55px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 30px; font-weight: bold; color: #ffffff;">
            <i class="fa fa-home fa-xs"></i>
        </div>
    </a>
</main>

<?php
require_once "../app/includes/footer.php"; ?>
