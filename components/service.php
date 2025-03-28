<?php

function insert_service($service): void
{
    ?>
    <div class="col-md-6 col-lg-4 page search-result">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($service['title']) ?></h5>
                <p class="card-text text-muted"><?= htmlspecialchars(substr($service['description'], 0, 80)) ?>...</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Provider: Seller<?= $service['user_id'] ?></small>
                    <a href="/pages/service_detail?id=<?= $service['id'] ?>" class="btn btn-sm btn-primary">Details</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function insert_product($product): void
{
    ?>
    <div class="card page search-result shadow-sm">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($product['title']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        </div>
    </div>
    <?php
}
