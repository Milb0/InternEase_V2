<?php
$title = "InternEase - Home";
$style_file = "assets/css/style.css";
require_once "../app/includes/header.php"; ?>
<header>
    <nav>
        <div class="logo-name">
            <img src="assets/images/logo.png" alt="Website Logo">
            <h id="WebsiteName">InternEase</h>
        </div>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <ul class="menu">
            <li><a href="#SecondSection">Why InternEase</a></li>
            <li><a href="#footer">Contact Us</a></li>
            <li class="sign-in-button"><a href="whoami.php">Sign In</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="hero" id="FirstSection">
        <div class="container">
            <img src="assets/images/Student_home.png" alt="Student Image">
            <div class="hero-text">
                <h1>Internship for Everyone</h1>
                <p>Connect you to thoudsands of talented freelancer from any industry. You can have the best people in just
                    few simple steps.</p>
                <button onclick="window.location.href='whoami.php'">Get Started</button>
            </div>
        </div>
    </section>
    <section class="why-us" id="SecondSection">
        <div class="why-us-title">
            <h2>Why InternEase?</h2>
            <p>Our mission is to provide internships for everyone.</p>
        </div>
        <div class="why-us-cards">
            <div class="why-us-card">
                <img src="assets/images/card-1.png" alt="Card 1">
                <h3>Time &amp; Efforts Consuming</h3>
                <p>With InternEase, you get access to thousands of talented freelancers from any industry.</p>
            </div>
            <div class="why-us-card">
                <img src="assets/images/card-2.png" alt="Card 2">
                <h3>Exhausting Process for the Students</h3>
                <p>We make it easy to find the best people for your project in just a few simple steps.</p>
            </div>
            <div class="why-us-card">
                <img src="assets/images/card-3.png" alt="Card 3">
                <h3>Cost-Effective Solutions</h3>
                <p>Our competitive pricing and flexible plans make hiring affordable and hassle-free.</p>
            </div>
        </div>
        <div class="why-us-title">
            <h3>We came To solve those problems with</h3>
        </div>
        <div class="why-us-cards">
            <div class="why-us-card">
                <img src="assets/images/card-4.png" alt="Card 4">
                <h3>Services Digitalisation</h3>
                <p>With InternEase, you get access to thousands of talented freelancers from any industry.</p>
            </div>
            <div class="why-us-card">
                <img src="assets/images/card-5.png" alt="Card 5">
                <h3>All in One Platform</h3>
                <p>We make it easy to find the best people for your project in just a few simple steps.</p>
            </div>
        </div>
    </section>
</main>
<footer>
    <div class="footer" id="footer">
        <div class="row">
            <li style="list-style-type: none">Contact us</li>
            <a href="mailto:internease@univ-constantine2.dz" title="Email"><i class="fa fa-envelope"></i></a>
            <a title="031 78 32 15"><i class="fa fa-phone"></i></a>
            <a href="https://www.facebook.com/universiteconstantine2" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
            <a href="https://youtube.com/@universiteabdelhamidmehric4020" target="_blank" title="YouTube"><i class="fa fa-youtube"></i></a>
            <a href="https://twitter.com/uc2am" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
        </div>

        <div class="row">
            <ul>
                <li><a href="#">Useful Links</a></li>
                <li><a href="#">Sign up</a></li>
            </ul>
        </div>

        <div class="row">
            INTERNEASE || Designed By: Milb
        </div>
    </div>
</footer>
<?php 
$script_file= "assets/js/app.js";
require_once "../app/includes/footer.php"; ?>