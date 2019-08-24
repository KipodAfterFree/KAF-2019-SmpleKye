<?php

include "../base/api.php";

$db = json_decode(file_get_contents("private/database.json"));

api("check", function ($action, $parameters) {
    global $db;
    if ($action === "give") {
        $giveResult = new stdClass();
        $giveResult->shash = shashRandom(2);
        $giveResult->seshID = random(128);
        $db->{$giveResult->seshID} = $giveResult->shash;
        save();
        return [true, $giveResult];
    } else if ($action === "check") {
        if (isset($parameters->seshID) && isset($parameters->result)) {
            if (isset($db->{$parameters->seshID})) {
                if (strlen($parameters->result) >= 3) {
                    if (checkPOW($parameters->seshID, $parameters->result)) {
                        unset($db->{$parameters->seshID});
                        save();
                        return [true, "NUFE{ju57_4_51mpl3_pr00F_0F_w0Rk}"];
                    } else {
                        return [false, "Wrong PoW"];
                    }
                } else {
                    return [false, "Wrong lengthed string"];
                }
            } else {
                return [false, "Redeemed already / Invalid SeshID"];
            }
        } else {
            return [false, "Missing parameters"];
        }
    }
    return [false, "Wups"];
});

echo json_encode($result);

function checkPOW($sid, $result)
{
    global $db;
    $str = $db->$sid . $result;
    return strpos(hash("sha256", $str), $str) !== false;
}

function shashRandom($l = 3)
{
    $current = str_shuffle("0123456789abcdef")[0];
    if ($l > 0) {
        return $current . shashRandom($l - 1);
    }
    return "";
}

function save()
{
    global $db;
    file_put_contents("private/database.json", json_encode($db));
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}