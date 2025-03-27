<?php

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

?>
