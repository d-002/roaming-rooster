<!DOCTYPE html>
<head>
    <title>services_version2</title>
    <style>
        body { background-color: rgb(231, 247, 237); font: Arial; padding: 20px; }
        .search-box { color:yellow; }
        input[type="text"] { width: 300px; padding: 8px; }
        button { padding: 8px 15px; }
        .result-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .price { color: orange; font-weight: bold; }
    </style>
</head>
<body>
    <div class="search-box">
        <form method="GET">
            <input type="text" name="keyword" placeholder="enter the title"
                   value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php
    $items = [
        [
            'title' => 'Organic Apple',
            'description' => 'Higher in nutrient density and contain 0% dangerous chemicals that hurt human life, wildlife, and the environment',
            'price' => 7
        ],
        [
            'title' => 'Big Apple',
            'description' => 'Diameter least 10cm / Weight least 85g',
            'price' => 8
        ],
        [
            'title' => 'Fresh Apple',
            'description' => 'Pick apple after you buy, ensure the freshness',
            'price' => 9
        ],
        [
            'title' => 'Organic Banana',
            'description' => 'Higher in nutrient density and contain 0% dangerous chemicals that hurt human life, wildlife, and the environment',
            'price' => 7
        ],
        [
            'title' => 'Big Banana',
            'description' => 'Length least 18cm / Weight least 145g',
            'price' => 8
        ],
        [
            'title' => 'Fresh Banana',
            'description' => 'Pick Banana after you buy, ensure the freshness',
            'price' => 9
        ],
        [
            'title' => 'Organic Grape',
            'description' => 'Higher in nutrient density and contain 0% dangerous chemicals that hurt human life, wildlife, and the environment',
            'price' => 7
        ],
        [
            'title' => 'Big Grape',
            'description' => 'A bunch of grapes contain least 100 grapes, weight least 2kg',
            'price' => 8
        ],
        [
            'title' => 'Fresh Grape',
            'description' => 'Pick grapes after you buy, ensure the freshness',
            'price' => 9
        ],
        [
            'title' => 'Organic Peach',
            'description' => 'Higher in nutrient density and contain 0% dangerous chemicals that hurt human life, wildlife, and the environment',
            'price' => 7
        ],
        [
            'title' => 'Big Peach',
            'description' => 'Diameter least 10cm / Weight least 170g',
            'price' => 8
        ],
        [
            'title' => 'Fresh Peach',
            'description' => 'Pick peach after you buy, ensure the freshness',
            'price' => 9
        ],
        [
            'title' => 'Organic Watermelon',
            'description' => 'Higher in nutrient density and contain 0% dangerous chemicals that hurt human life, wildlife, and the environment',
            'price' => 7
        ],
        [
            'title' => 'Big Watermelon',
            'description' => 'Diameter least 40cm / Weight least 10kg',
            'price' => 8
        ],
        [
            'title' => 'Fresh Watermelon',
            'description' => 'Pick watermelon after you buy, ensure the freshness',
            'price' => 9
        ],
    ];

    $results = $items;
    $searchTitle = 'All services available';

    if (isset($_GET['keyword'])) {
        $keyword = trim($_GET['keyword']);
        
        if (!empty($keyword)) {
            $searchTitle = 'Search results: "' . htmlspecialchars($keyword) . '"';
            $filtered = [];
            
            foreach ($items as $item) {
                if (stripos($item['title'], $keyword) !== false) {
                    $filtered[] = $item;
                }
            }
            $results = $filtered;
        }
    }

    echo '<h3>' . $searchTitle . '</h3>';
    
    if (!empty($results)) {
        foreach ($results as $item) {
            echo '<div class="result-item">';
            echo '<h4>' . htmlspecialchars($item['title']) . '</h4>';
            echo '<p>' . htmlspecialchars($item['description']) . '</p>';
            echo '<p class="price">Price：€' . number_format($item['price'], 2) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>Services Not Found</p>';
    }
    ?>
</body>
</html>