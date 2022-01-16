<?php

function getTimeToDelivery(
    $latitudeFrom,
    $longitudeFrom,
    $latitudeTo,
    $longitudeTo,
    $earthRadius = 6371000
) {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    $speed = 165; //drone speed(m/s)
    $distance = $angle * $earthRadius;
    $minute = round($distance / $speed / 60);
    return $minute + 15;
}
function minutesToTimeArray($minute)
{
    $result = explode(":", date('H:i', mktime(0, $minute)));
    return $result;
}

// register.inc.php
function emptyInputRegis($uid, $postal, $email, $pwd)
{
    return empty($uid) || empty($postal) || empty($email) || empty($pwd);
}
function getPostalInfo($postal, $apikey)
{
    // $url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" . $postal;
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$postal}&language=ja&sensor=false&key={$apikey}";
    $arr = json_decode(file_get_contents($url), true);
    // echo json_encode(($arr));

    if ($arr['results'] == null)
        return $postal_info = "";
    else {
        $postal_info["address"] = $arr['results'][0]["address_components"][3]["long_name"] . "" . $arr['results'][0]["address_components"][2]["long_name"] . "" . $arr['results'][0]["address_components"][1]["long_name"];
        $postal_info["lat"] = $arr["results"][0]["geometry"]["location"]["lat"];
        $postal_info["long"] = $arr["results"][0]["geometry"]["location"]["lng"];
        return $postal_info;
    }
}
function invalidEmail($email)
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}
function userExists($conn, $uid, $email)
{
    $sql = "SELECT * FROM users_database WHERE user_id = ? OR user_email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../member/regist.php?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return $result = false;
    }
}
function creatUser($conn, $uid, $email, $pwd, $username, $postal, $address, $lat, $long)
// function creatUser($conn, $uid, $email, $pwd, $username)
{
    $sql = "INSERT INTO users_database (user_id, user_email, user_password, user_name, user_postal_code, user_address, user_lat, user_long) 
    VALUE (?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../member/regist.php?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ssssssss", $uid, $email, $pwd, $username, $postal, $address, $lat, $long);
    // mysqli_stmt_bind_param($stmt, "ssss", $uid, $email, $pwd, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../member/regist-result.php");
}

//login.inc.php
function emptyInputLogin($email, $pwd)
{
    return empty($email) || empty($pwd);
}
function loginUser($conn, $uid, $email, $pwd)
{
    $userExists = userExists($conn, $uid, $email);

    if ($userExists === false) {
        header("location: ../member?error=wrongLogin");
        exit();
    }
    $checkPwd = ($userExists['user_password'] === $pwd);
    if ($checkPwd === false) {
        header("location: ../member?error=wrongLogin");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION['email'] = $userExists['user_email'];
        $_SESSION['userid'] = $userExists['user_id'];
        $_SESSION['username'] = $userExists['user_name'];
        $_SESSION['avatar'] = $userExists['user_avatar'];
        $_SESSION['postal_code'] = $userExists['user_postal_code'];
        $_SESSION['postal_info'] = $userExists['user_address'];
        $_SESSION['lat'] = $userExists['user_lat'];
        $_SESSION['long'] = $userExists['user_long'];
        $check = $userExists['registered'];
        if ($check == 1)
            header("location: ../mypage");
        else
            header("location: ../mypage/index-registered.php");
        exit();
    }
}
//drone-register.inc.php
function registerDrone($conn, $userid)
{
    $sql = "UPDATE users_database SET registered = '1' WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//profile-edit.inc.php
function editUserProfile($conn, $edit, $userid, $type)
{
    $sql = "UPDATE users_database SET " . $type . " = ? WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ss", $edit, $userid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function editUserAddress($conn, $code, $info, $lat, $long, $userid)
{
    $sql = "UPDATE users_database SET user_postal_code = ?, user_address = ?, user_lat = ?, user_long = ? WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "sssss", $code, $info, $lat, $long, $userid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//shopping-order.inc.php
function createTransacton($conn, $total)
{
    $sql = "INSERT INTO transactions_database (transaction_amount) VALUE (?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "s", $total);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function createShoppingDelivery($conn, $user_id, $store_name, $store_lat, $store_long, $order_info, $time)
{
    date_default_timezone_set('Asia/Tokyo');
    $date = new DateTime("08:00:00");
    if (empty($time))
        $delivery_time = $date->format("Y-m-d H:i:s");
    else
        $delivery_time = date('Y-m-d') . " " . $time . ":00";
    $sql = "INSERT INTO deliveries_database (user_id, store_name, store_lat, store_long, order_info, created_at) VALUE (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ssssss", $user_id, $store_name, $store_lat, $store_long, $order_info, $delivery_time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
// friend-add.inc.php
function addFriend($conn, $user_id, $friend_id)
{
    $sql = "INSERT INTO friends_list (user_id, friend_id) VALUE (?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ss", $user_id, $friend_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
// friend-remove.inc.php
function removeFriend($conn, $user_id, $friend_id)
{
    $sql = "DELETE FROM friends_list WHERE user_id = ? AND friend_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ss", $user_id, $friend_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
// friend-delivery.inc.php
function createFriendDelivery($conn, $user_id, $store_name, $store_lat, $store_long, $order_info, $date, $time)
{
    date_default_timezone_set('Asia/Tokyo');
    if (empty($date))
        $delivery_time = date('Y-m-d H:i:s');
    else
        $delivery_time = $date . " " . $time . ":00";
    $sql = "INSERT INTO deliveries_database (user_id, store_name, store_lat, store_long, order_info, created_at ) VALUE (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ssssss", $user_id, $store_name, $store_lat, $store_long, $order_info, $delivery_time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
// upload-image.inc.php
function setUserAvatar($conn, $userid)
{
    $sql = "UPDATE users_database SET user_avatar = ? WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ss", $userid, $userid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// 
// mypage
// 
// mypage/schedule.php
function getUserHistory($conn, $user_id)
{
    $historyinfo = array();
    $sql = "SELECT * FROM completed_deliveries_database WHERE user_id = ? ORDER BY created_at DESC;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        while ($row =  $result->fetch_assoc()) {
            $entry = array();
            $createdAt = explode(" ", $row['created_at']); // [0] => date [1] => time
            $date = explode("-", $createdAt[0]);
            $entry['date'] = $date;
            $time = explode(":", $createdAt[1]);
            $entry['time'] = $time;
            $entry['total_time'] = $row['total_time'];
            $entry['store'] = explode("*", $row['stores_name']);
            $entry['delivery_time'] = explode("*", $row['deliveries_time']);
            foreach ($entry['delivery_time'] as $key => $element) {
                if ($key != 0) {
                    $entry['delivery_time'][$key] += $entry['delivery_time'][$key - 1];
                }
            }
            $order = explode("*", $row['orders_info']);
            foreach ($order as $key => $element) {
                $temp = explode("/", $element);
                foreach ($temp as $i => $aux) {
                    if (!empty($aux)) {
                        $temp2 = explode("_", $aux);
                        $entry['order'][$key][$i]['id'] = $temp2[0];
                        $entry['order'][$key][$i]['item'] = $temp2[1];
                        $entry['order'][$key][$i]['price'] = $temp2[2];
                        $entry['order'][$key][$i]['quantity'] = $temp2[3];
                    }
                }
            }
            array_push($historyinfo, $entry);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }
    return $historyinfo;
}

// 
//shopping
// 
function getCategoryNavBar($conn)
{
    $category = array();
    $sql = mysqli_query($conn, "SELECT * FROM categories ORDER BY id;");
    while ($row = mysqli_fetch_assoc($sql)) {
        $entry = array();
        $entry['name'] = $row['category_name'];
        $entry['id'] = $row['category_id'];
        array_push($category, $entry);
    }
    mysqli_free_result($sql);
    return $category;
};

// shopping/index.php
function getClosestStoreInfo($conn, $lat, $long)
{
    $storeinfo = array();
    $sql = mysqli_query($conn, "SELECT * FROM business_database;");
    while ($row = mysqli_fetch_assoc($sql)) {
        $entry = array();
        $entry["id"] = $row['category_id'];
        $entry["name"] = $row['store_name'];
        $entry["address"] = "〒" . $row['store_postal_code'] . " " . $row['store_address'];
        $entry["phonenumber"] = $row['store_phonenumber'];
        $entry["code"] = $row['store_code'];
        $entry["lat"] = $row['store_lat'];
        $entry["long"] = $row['store_long'];
        $entry["time"] = getTimeToDelivery($lat, $long, $row['store_lat'], $row['store_long']);
        array_push($storeinfo, $entry);
    }
    mysqli_free_result($sql);
    $time = array_column($storeinfo, 'time');
    array_multisort($time, SORT_ASC, $storeinfo);
    return $storeinfo = array_slice($storeinfo, 0, 8);
}

// shopping/menu-store.php
function getStoreInfo($conn, $id)
{
    $storeinfo = array();
    $sql = "SELECT * FROM business_database WHERE category_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        while ($row =  $result->fetch_assoc()) {
            $entry = array();
            $entry["name"] = $row['store_name'];
            $entry["address"] = "〒" . $row['store_postal_code'] . " " . $row['store_address'];
            $entry["phonenumber"] = $row['store_phonenumber'];
            $entry["code"] = $row['store_code'];
            $entry["lat"] = $row['store_lat'];
            $entry["long"] = $row['store_long'];
            array_push($storeinfo, $entry);
        }
        mysqli_stmt_close($stmt);
        return $storeinfo;
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }
};

// shopping/menu.php
function getMenu($conn, $id)
{
    $menu = array();
    $sql = "SELECT * FROM menu_database WHERE category_id = ? ORDER BY item_code;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        while ($row =  $result->fetch_assoc()) {
            $entry = array();
            $entry['code'] = $row['item_code'];
            $entry['name'] = $row['item_name'];
            $entry['price'] = $row['item_value'];
            array_push($menu, $entry);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }
    return $menu;
}
// shopping/menu-result.php
function getDeliverySchedule($conn, $username, $lat, $long)
{
    $schedule = array();
    $sql = "SELECT * FROM deliveries_database WHERE user_id = ? ORDER BY created_at";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../mypage?error=stmtFailed");
        exit;
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        $entry = array();
        while ($row =  $result->fetch_assoc()) {

            $entry['id'] = $row['delivery_id'];
            $entry['createdAt'] = $row["created_at"];
            $entry['arrival_time'] = "";
            $entry['return_time'] = "";
            $entry['store_name'] = $row['store_name'];
            $entry['order_info'] = $row['order_info'];
            $entry['store_lat'] = $row['store_lat'];
            $entry['store_long'] = $row['store_long'];
            $entry['reroute'] = false;

            array_push($schedule, $entry);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }

    foreach ($schedule as $key => $element) {
        $date = new DateTime($element['createdAt']);

        if ($key == 0 || $date->format('Y-m-d H:i') > $schedule[$key - 1]['arrival_time']->format('Y-m-d H:i')) {
            $time = getTimeToDelivery($lat, $long, $element['store_lat'], $element['store_long']);

            $schedule[$key]['arrival_time'] = new DateTime($element['createdAt']);
            $schedule[$key]['arrival_time']->modify('+' . $time . ' minute');

            $schedule[$key]['return_time'] = new DateTime($schedule[$key]['arrival_time']->format('Y-m-d H:i'));
            $schedule[$key]['return_time']->modify('+' .  $time . ' minute');
        } else {
            $schedule[$key - 1]['reroute'] = true;

            $schedule[$key]['arrival_time'] = new DateTime($schedule[$key - 1]['arrival_time']->format('Y-m-d H:i'));
            $time = getTimeToDelivery($schedule[$key - 1]['store_lat'], $schedule[$key - 1]['store_long'], $element['store_lat'], $element['store_long']);
            $schedule[$key]['arrival_time']->modify('+' . $time . ' minute');

            $schedule[$key]['return_time'] = new DateTime($schedule[$key]['arrival_time']->format('Y-m-d H:i'));
            $time = getTimeToDelivery($element['store_lat'], $element['store_long'], $lat, $long);
            $schedule[$key]['return_time']->modify('+' . $time . ' minute');
        }
    }
    if (empty($schedule))
        return $schedule = "";
    else
        return $schedule;
}
// shopping/search-result.php
function getSearchResult($conn, $inquiry, $lat, $long)
{
    $searchResult = array();
    $param = "%{$inquiry}%";
    $sql = "SELECT c.category_id,
    b.store_name, b.store_address, b.store_postal_code, b.store_code, b.store_lat, b.store_long
    FROM categories c
    INNER JOIN business_database b ON 
    c.category_id = b.category_id
    WHERE c.category_id LIKE ? OR category_name LIKE ? OR b.store_name LIKE ? 
    OR b.store_address LIKE ?
    ORDER BY b.store_name";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ssss", $param, $param, $param, $param);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        while ($row =  $result->fetch_assoc()) {
            $entry["id"] = $row['category_id'];
            $entry["name"] = $row['store_name'];
            $entry["address"] = "〒" . $row['store_postal_code'] . " " . $row['store_address'];
            $entry["phonenumber"] = $row['store_phonenumber'];
            $entry["code"] = $row['store_code'];
            $entry["lat"] = $row['store_lat'];
            $entry["long"] = $row['store_long'];
            $entry["time"] = getTimeToDelivery($lat, $long, $row['store_lat'], $row['store_long']);
            array_push($searchResult, $entry);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }
    return $searchResult;
}
// 
// delivery
// 
// delivery/index.php
function getFriendList($conn, $userid)
{
    $friendlist = array();
    $sql = "SELECT users_database.user_id, user_name, user_lat, user_long, user_avatar FROM friends_list 
    JOIN users_database ON users_database.user_id = friends_list.friend_id 
    AND friends_list.user_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../delivery?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        while ($row =  $result->fetch_assoc()) {
            $entry = array();
            $entry['id'] = $row['user_id'];
            $entry['name'] = $row['user_name'];
            $entry['avatar'] = $row['user_avatar'];
            $entry['lat'] = $row['user_lat'];
            $entry['long'] = $row['user_long'];
            array_push($friendlist, $entry);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }
    return $friendlist;
}
function getUserList($conn, $userid, $lat, $long)
{
    $userlist = array();
    $sql = "SELECT DISTINCT user_id, user_name, user_avatar,user_lat, user_long FROM users_database WHERE users_database.user_id <> ? AND NOT EXISTS(SELECT * FROM friends_list WHERE friends_list.user_id = ? AND friends_list.friend_id = users_database.user_id) ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../delivery?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ss", $userid, $userid);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        while ($row =  $result->fetch_assoc()) {
            $entry = array();
            $entry['id'] = $row['user_id'];
            $entry['name'] = $row['user_name'];
            $entry['avatar'] = $row['user_avatar'];
            $entry["time"] = getTimeToDelivery($lat, $long, $row['user_lat'], $row['user_long']);
            array_push($userlist, $entry);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }

    $time = array_column($userlist, 'time');
    array_multisort($time, SORT_ASC, $userlist);
    // print_r($userlist);
    // exit;
    return $userlist;
}
// delivery/friend-search.php
function friendSearch($conn, $userid, $inquiry)
{
    $param = "%{$inquiry}%";
    $userlist = array();
    $sql = "SELECT DISTINCT * FROM users_database 
    WHERE users_database.user_id <> ? 
    AND NOT EXISTS(SELECT * FROM friends_list WHERE friends_list.user_id = ? AND friends_list.friend_id = users_database.user_id) 
    AND (user_id LIKE ? OR user_name LIKE ? OR user_address LIKE ? OR user_email LIKE ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../delivery?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "ssssss", $userid, $userid, $param, $param, $param, $param);
    mysqli_stmt_execute($stmt);
    if ($result = $stmt->get_result()) {
        while ($row =  $result->fetch_assoc()) {
            $entry = array();
            $entry['id'] = $row['user_id'];
            $entry['name'] = $row['user_name'];
            $entry['avatar'] = $row['user_avatar'];
            array_push($userlist, $entry);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $stmt. " . mysqli_error($conn);
    }
    return $userlist;
}
