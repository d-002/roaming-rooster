<?php

function insert_service($service): void
{
    ?>
    <div class="col-md-6 col-lg-4 page search-result">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($service["title"]) ?></h5>
                <p class="card-text text-muted"><?= htmlspecialchars(substr($service["description"], 0, 80)) ?>...</p>
                <div class="widget-list">
                    <img class="service-image" src="<?= htmlspecialchars($service["img_main_url"]) ?>"
                         alt="Main service image">
                    <img class="service-image" src="<?= htmlspecialchars($service["img_banner_url"]) ?>"
                         alt="Banner service image">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Provider: <?= $service["display_name"] ?></small>
                    <a href="/pages/service-details?id=<?= $service["id"] ?>" class="btn btn-sm btn-primary">Details</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function insert_product($product): void
{
    ?>
    <div class="card page search-result">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($product["title"]) ?></h5>
            <p class="card-text"><?= htmlspecialchars($product["description"]) ?></p>
        </div>
        <span class="badge bg-success fs-6">$<?= number_format($product["price"], 2) ?></span>
    </div>
    <?php
}
