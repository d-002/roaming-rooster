<?php

function search_service(PDO $db, $query): array
{
    return service_request($db, "SELECT id FROM services WHERE title LIKE '%' || :query || '%' OR description LIKE '%' || :query || '%'", ["query" => $query]);
}

function search_sub_service(PDO $db, $query): array
{
    $prepared = $db->prepare(<<<EOD
SELECT sub_services.title AS title,
    sub_services.description AS description,
    user_id, price, availability
FROM sub_services
JOIN services ON sub_services.service_id = services.id
WHERE sub_services.title LIKE '%' || :query || '%'
    OR sub_services.description LIKE '%' || :query || '%'
    OR services.title LIKE '%' || :query || '%'
    OR services.description LIKE '%' || :query || '%'
EOD
    );
    $result = $prepared->execute(["query" => $query]);
    if (!$result) return [];
    return $prepared->fetchAll();
}

function quick_service_search(PDO $database, $query): array
{
    $prepared = $database->prepare("SELECT title FROM services WHERE title LIKE '%' || :query || '%'");
    $result = $prepared->execute(["query" => $query]);
    if (!$result) return [];

    $services = $prepared->fetchAll();
    foreach ($services as $service) {
        $service["query_distance"] = levenshtein($query, $service["title"], 1, 2, 2);
    }

    usort($services, function ($a, $b) {
        return $a["query_distance"] < $b["query_distance"];
    });

    return $services;
}

function scoreResults($results, $keys, $query): void
{
    $sound = soundex($query);
    foreach ($results as $result) {
        $result["score"] = 0;
        foreach ($keys as $key) {
            $key_sound = soundex($result[$key]);
            if ($key_sound !== $sound)
                $result["score"] += levenshtein($query, $result[$key], 1, 2, 2);
        }
    }
}

function orderResults($results): void
{

}
