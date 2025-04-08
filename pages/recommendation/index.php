<!DOCTYPE html>
<html lang="en">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");

insert_head("Recommendation");
?>

<style>
    body {
        background-color: #CCFFCC;
    }

    .top-cell, .image-card {
        border: 1px solid #ddd;
        padding: 20px;
        text-align: center;
        transition: transform 0.2s;
    }

    .top-cell:hover {
        transform: translateY(-5px);
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 30px;
        padding: 0 15px;
    }

    .image-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<body>
<div class="container-fluid p-4">
    <div class="row g-4">
        <div class="col">
            <a href="#" class="text-decoration-none text-dark">
                <div class="top-cell h-100">
                    <h3>Roaming Rooster</h3>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="#" class="text-decoration-none text-dark">
                <div class="top-cell h-100">
                    <h3>Search</h3>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="#" class="text-decoration-none text-dark">
                <div class="top-cell h-100">
                    <h3>Chat</h3>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="#" class="text-decoration-none text-dark">
                <div class="top-cell h-100">
                    <h3>Profile</h3>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="#" class="text-decoration-none text-dark">
                <div class="top-cell h-100">
                    <h3>Notification</h3>
                </div>
            </a>
        </div>
    </div>
</div>

<hr>

<h1>Foods</h1>

<div class="image-grid">
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
</div>


<hr>

<h1>Flowers</h1>

<div class="image-grid">
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
    <div class="image-card">
        <img src="/assets/images/logo.png" alt="Dummy image">
    </div>
</div>
</body>
</html>