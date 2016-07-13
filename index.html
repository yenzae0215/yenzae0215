<?php

/*
 * Faucet in a BOX
 * https://faucetinabox.com/
 *
 * Copyright (c) 2014-2016 LiveHome Sp. z o. o.
 *
 * This file is part of Faucet in a BOX.
 *
 * Faucet in a BOX is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Faucet in a BOX is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Faucet in a BOX.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once("script/common.php");

if(!$pass) {
    // first run
    header("Location: admin.php");
    die("Please wait...");
}

if(array_key_exists("p", $_GET) && in_array($_GET["p"], ["admin", "password-reset"])) {
    header("Location: admin.php?p={$_GET["p"]}");
    die("Please wait...");
}

#reCaptcha template
$recaptcha_template = <<<TEMPLATE
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha" data-sitekey="<:: your_site_key ::>"></div>
<noscript>
  <div style="width: 302px; height: 352px;">
    <div style="width: 302px; height: 352px; position: relative;">
      <div style="width: 302px; height: 352px; position: absolute;">
        <iframe src="https://www.google.com/recaptcha/api/fallback?k=<:: your_site_key ::>"
                frameborder="0" scrolling="no"
                style="width: 302px; height:352px; border-style: none;">
        </iframe>
      </div>
      <div style="width: 250px; height: 80px; position: absolute; border-style: none;
                  bottom: 21px; left: 25px; margin: 0px; padding: 0px; right: 25px;">
        <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                  class="g-recaptcha-response"
                  style="width: 250px; height: 80px; border: 1px solid #c1c1c1;
                         margin: 0px; padding: 0px; resize: none;" value="">
        </textarea>
      </div>
    </div>
  </div>
</noscript>
TEMPLATE;

if(!empty($_POST["mmc"])) {
    $_SESSION["$session_prefix-mouse_movement_detected"] = true;
    die();
}

// show main page
$q = $sql->query("SELECT value FROM Faucetinabox_Settings WHERE name = 'template'");
$template = $q->fetch();
$template = $template[0];
if(!file_exists("templates/{$template}/index.php")) {
    $templates = glob("templates/*");
    if($templates)
        $template = substr($templates[0], strlen("templates/"));
    else
        die(str_replace('<:: content ::>', "<div class='alert alert-danger' role='alert'>No templates found!</div>", $master_template));
}

if(array_key_exists("HTTPS", $_SERVER) && $_SERVER["HTTPS"])
    $protocol = "https://";
else
    $protocol = "http://";

if (array_key_exists("$session_prefix-address_input_name", $_SESSION) && array_key_exists($_SESSION["$session_prefix-address_input_name"], $_POST)) {
    $_POST['address'] = $_POST[$_SESSION["$session_prefix-address_input_name"]];
} else {
    if($display_errors && $_SERVER['REQUEST_METHOD'] == "POST") {
        if(array_key_exists("$session_prefix-address_input_name", $_SESSION)) {
            trigger_error("Post request, but session is invalid.");
        } else {
            trigger_error("Post request, but invalid address input name.");
        }
    }
    unset($_POST['address']);
}


$data = array(
    "paid" => false,
    "disable_admin_panel" => $disable_admin_panel,
    "address" => "",
    "captcha_valid" => !array_key_exists('address', $_POST),
    "captcha" => false,
    "enabled" => false,
    "error" => false,
    "reflink" => $protocol.$_SERVER['HTTP_HOST'].strtok($_SERVER['REQUEST_URI'], '?').'?r='
);
if(array_key_exists('address', $_POST)) {
    $data["reflink"] .= $_POST['address'];
} else if (array_key_exists('address', $_COOKIE)) {
    $data["reflink"] .= $_COOKIE['address'];
    $data["address"] = $_COOKIE['address'];
} else {
    $data["reflink"] .= 'Your_Address';
}


$q = $sql->query("SELECT name, value FROM Faucetinabox_Settings WHERE name <> 'password'");

while($row = $q->fetch()) {
    if ($row[0] == "safety_limits_end_time") {
        $time = strtotime($row[1]);
        if ($time !== false && $time < time()) {
            $row[1] = "";
        }
    }
    $data[$row[0]] = $row[1];
}

if(time() - $data['last_balance_check'] > 60*10) {
    $fb = new FaucetBOX($data['apikey'], $data['currency'], $connection_options);
    $ret = $fb->getBalance();
    if(array_key_exists('balance', $ret)) {
        if($data['currency'] != 'DOGE')
            $balance = $ret['balance'];
        else
            $balance = $ret['balance_bitcoin'];
        $q = $sql->prepare("UPDATE Faucetinabox_Settings SET value = ? WHERE name = ?");
        $q->execute(array(time(), 'last_balance_check'));
        $q->execute(array($balance, 'balance'));
        $data['balance'] = $balance;
        $data['last_balance_check'] = time();
    }
}

$data['unit'] = 'satoshi';
if($data["currency"] == 'DOGE')
    $data["unit"] = 'DOGE';


#MuliCaptcha: Firstly check chosen captcha system
$captcha = array('available' => array(), 'selected' => null);
if ($data['solvemedia_challenge_key'] && $data['solvemedia_verification_key'] && $data['solvemedia_auth_key']) {
    $captcha['available'][] = 'SolveMedia';
}
if ($data['recaptcha_public_key'] && $data['recaptcha_private_key']) {
    $captcha['available'][] = 'reCaptcha';
}
if ($data['ayah_publisher_key'] && $data['ayah_scoring_key']) {
    $captcha['available'][] = 'AreYouAHuman';
}
if ($data['funcaptcha_public_key'] && $data['funcaptcha_private_key']) {
    $captcha['available'][] = 'FunCaptcha';
}

#MuliCaptcha: Secondly check if user switched captcha or choose default
if (array_key_exists('cc', $_GET) && in_array($_GET['cc'], $captcha['available'])) {
    $captcha['selected'] = $captcha['available'][array_search($_GET['cc'], $captcha['available'])];
    $_SESSION["$session_prefix-selected_captcha"] = $captcha['selected'];
} elseif (array_key_exists("$session_prefix-selected_captcha", $_SESSION) && in_array($_SESSION["$session_prefix-selected_captcha"], $captcha['available'])) {
    $captcha['selected'] = $_SESSION["$session_prefix-selected_captcha"];
} else {
    if($captcha['available'])
        $captcha['selected'] = $captcha['available'][0];
    if (in_array($data['default_captcha'], $captcha['available'])) {
        $captcha['selected'] = $data['default_captcha'];
    } else if($captcha['available']) {
        $captcha['selected'] = $captcha['available'][0];
    }
}



#MuliCaptcha: And finally handle chosen captcha system
switch ($captcha['selected']) {
    case 'SolveMedia':
        require_once("libs/solvemedialib.php");
        $data["captcha"] = solvemedia_get_html($data["solvemedia_challenge_key"], null, is_ssl());
        if (array_key_exists('address', $_POST)) {
            $resp = solvemedia_check_answer(
                $data['solvemedia_verification_key'],
                getIP(),
                (array_key_exists('adcopy_challenge', $_POST) ? $_POST['adcopy_challenge'] : ''),
                (array_key_exists('adcopy_response', $_POST) ? $_POST['adcopy_response'] : ''),
                $data["solvemedia_auth_key"]
            );
            $data["captcha_valid"] = $resp->is_valid;
        }
    break;
    case 'reCaptcha':
        $data["captcha"] = str_replace('<:: your_site_key ::>', $data["recaptcha_public_key"], $recaptcha_template);
        if (array_key_exists('address', $_POST)) {
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$data["recaptcha_private_key"].'&response='.(array_key_exists('g-recaptcha-response', $_POST) ? $_POST["g-recaptcha-response"] : '').'&remoteip='.getIP();
            $resp = json_decode(file_get_contents($url), true);
            $data['captcha_valid'] = $resp['success'];
        }
    break;
    case 'AreYouAHuman':
        require_once("libs/ayahlib.php");
        $ayah = new AYAH(array(
            'publisher_key' => $data['ayah_publisher_key'],
            'scoring_key' => $data['ayah_scoring_key'],
            'web_service_host' => 'ws.areyouahuman.com',
            'debug_mode' => false,
            'use_curl' => !($connection_options['disable_curl'])
        ));
        $data['captcha'] = $ayah->getPublisherHTML();
        if (array_key_exists('address', $_POST)) {
            $score = $ayah->scoreResult();
            $data['captcha_valid'] = $score;
        }
    break;
    case 'FunCaptcha':
        require_once("libs/funcaptcha.php");
        $funcaptcha = new FUNCAPTCHA();

        $data["captcha"] =  $funcaptcha->getFunCaptcha($data["funcaptcha_public_key"]);

        if (array_key_exists('address', $_POST)) {
            $data['captcha_valid'] =  $funcaptcha->checkResult($data["funcaptcha_private_key"]);
        }
    break;
}

$data['captcha_info'] = $captcha;

if($data['captcha'] && $data['apikey'] && $data['rewards'])
    $data['enabled'] = true;


// check if ip eligible
$q = $sql->prepare("SELECT TIMESTAMPDIFF(MINUTE, last_used, CURRENT_TIMESTAMP()) FROM Faucetinabox_IPs WHERE ip = ?");
$q->execute(array(getIP()));
if ($time = $q->fetch()) {
    $time = intval($time[0]);
    $required = intval($data['timer']);
    $data['time_left'] = ($required-$time).' minutes';
    $data['eligible'] = $time >= intval($data['timer']);
} else {
    $data["eligible"] = true;
}

$rewards = explode(',', $data['rewards']);
$total_weight = 0;
$nrewards = array();
foreach($rewards as $reward) {
    $reward = explode("*", trim($reward));
    if(count($reward) < 2) {
        $reward[1] = $reward[0];
        $reward[0] = 1;
    }
    $total_weight += intval($reward[0]);
    $nrewards[] = $reward;
}
$rewards = $nrewards;
if(count($rewards) > 1) {
    $possible_rewards = array();
    foreach($rewards as $r) {
        $chance_per = 100 * $r[0]/$total_weight;
        if($chance_per < 0.1)
            $chance_per = '< 0.1%';
        else
            $chance_per = round(floor($chance_per*10)/10, 1).'%';

        $possible_rewards[] = $r[1]." ($chance_per)";
    }
} else {
    $possible_rewards = array($rewards[0][1]);
}

$data['address_eligible'] = true;

if (array_key_exists('address', $_POST) &&
   $data['captcha_valid'] &&
   $data['enabled'] &&
   $data['eligible']
) {

    $q = $sql->prepare("SELECT TIMESTAMPDIFF(MINUTE, last_used, CURRENT_TIMESTAMP()) FROM Faucetinabox_Addresses WHERE `address` = ?");
    $q->execute(array(trim($_POST['address'])));
    if ($time = $q->fetch()) {
        $time = intval($time[0]);
        $required = intval($data['timer']);
        $data['time_left'] = ($required-$time).' minutes';
        $eligible = $time >= intval($data['timer']);
    } else {
        $eligible = true;
    }
    $data['address_eligible'] = $eligible;
    if($eligible) {
        $r = mt_rand()/mt_getrandmax();
        $t = 0;
        foreach($rewards as $reward) {
            $t += intval($reward[0])/$total_weight;
            if($t > $r) {
                break;
            }
        }

        if (strpos($reward[1], '-') !== false) {
            $reward_range = explode('-', $reward[1]);
            $from = floatval($reward_range[0]);
            $to = floatval($reward_range[1]);
            $reward = mt_rand($from, $to);
        } else {
            $reward = floatval($reward[1]);
        }
        if($data["currency"] == "DOGE")
            $reward = $reward * 100000000;

        $q = $sql->prepare("SELECT balance FROM Faucetinabox_Refs WHERE address = ?");
        $q->execute(array(trim($_POST["address"])));
        if($b = $q->fetch()) {
            $refbalance = floatval($b[0]);
        } else {
            $refbalance = 0;
        }
        $fb = new FaucetBOX($data["apikey"], $data["currency"], $connection_options);
        $address = trim($_POST["address"]);
        if (empty($address)) {
            $ret = array(
                "success" => false,
                "message" => "Invalid address.",
                "html" => "<div class=\"alert alert-danger\">Invalid address.</div>"
            );
        } else if (in_array($address, $security_settings["address_ban_list"])) {
            $ret = array(
                "success" => false,
                "message" => "Unknown error.",
                "html" => "<div class=\"alert alert-danger\">Unknown error.</div>"
            );
        } else {
            $ret = $fb->send($address, $reward);
        }
        if($ret["success"] && $refbalance > 0)
            $ret = $fb->sendReferralEarnings(trim($_POST["address"]), $refbalance);
        if($ret['success']) {
            setcookie('address', trim($_POST['address']), time() + 60*60*24*60);
            if(array_key_exists('balance', $ret)) {
                $q = $sql->prepare("UPDATE Faucetinabox_Settings SET `value` = ? WHERE `name` = 'balance'");

                if($data['unit'] == 'satoshi')
                    $data['balance'] = $ret['balance'];
                else
                    $data['balance'] = $ret['balance_bitcoin'];
                $q->execute(array($data['balance']));
            }

            $sql->exec("UPDATE Faucetinabox_Settings SET value = '' WHERE `name` = 'safety_limits_end_time' ");

            // handle refs
            // deduce balance
            $q = $sql->prepare("UPDATE Faucetinabox_Refs SET balance = balance - ? WHERE address = ?");
            $q->execute(array($refbalance, trim($_POST['address'])));
            // add balance
            if(array_key_exists('r', $_GET) && trim($_GET['r']) != trim($_POST["address"])) {
                $q = $sql->prepare("INSERT IGNORE INTO Faucetinabox_Refs (address) VALUES (?)");
                $q->execute(array(trim($_GET["r"])));
                $q = $sql->prepare("INSERT IGNORE INTO Faucetinabox_Addresses (`address`, `ref_id`, `last_used`) VALUES (?, (SELECT id FROM Faucetinabox_Refs WHERE address = ?), CURRENT_TIMESTAMP())");
                $q->execute(array(trim($_POST['address']), trim($_GET['r'])));
            }
            $refamount = floatval($data['referral'])*$reward/100;
            $q = $sql->prepare("SELECT address FROM Faucetinabox_Refs WHERE id = (SELECT ref_id FROM Faucetinabox_Addresses WHERE address = ?)");
            $q->execute(array(trim($_POST['address'])));
            if($ref = $q->fetch()) {
                if(!in_array(trim($ref[0]), $security_settings['address_ban_list'])) {
                    $fb->sendReferralEarnings(trim($ref[0]), $refamount);
                }
            }

            if($refbalance > 0) {
                $data['paid'] = '<div class="alert alert-success">'.htmlspecialchars($reward).' '.$unit.' + '.htmlspecialchars($refbalance).' '.$unit.' for referrals was sent to <a target="_blank" href="https://faucetbox.com/check/'.rawurlencode(trim($_POST["address"])).'">your FaucetBOX.com address</a>.</div>';
            } else {
                if($data['unit'] == 'satoshi')
                    $data['paid'] = $ret['html'];
                else
                    $data['paid'] = $ret['html_coin'];
            }
        } else {
            $response = json_decode($ret["response"]);
            if ($response && property_exists($response, "status") && $response->status == 450) {
                // how many minutes until next safety limits reset?
                $end_minutes  = (date("i") > 30 ? 60 : 30) - date("i");
                // what date will it be exactly?
                $end_date = date("Y-m-d H:i:s", time()+$end_minutes*60-date("s"));
                $sql->prepare("UPDATE Faucetinabox_Settings SET value = ? WHERE `name` = 'safety_limits_end_time' ")->execute([$end_date]);
            }
            $data['error'] = $ret['html'];
        }
        if($ret['success'] || $fb->communication_error) {
            $q = $sql->prepare("INSERT INTO Faucetinabox_IPs (`ip`, `last_used`) VALUES (?, CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE `last_used` = CURRENT_TIMESTAMP()");
            $q->execute(array(getIP()));
            $q = $sql->prepare("INSERT INTO Faucetinabox_Addresses (`address`, `last_used`) VALUES (?, CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE `last_used` = CURRENT_TIMESTAMP()");
            $q->execute(array(trim($_POST["address"])));

            // suspicious checks
            $q = $sql->query("SELECT value FROM Faucetinabox_Settings WHERE name = 'template'");
            if($r = $q->fetch()) {
                if(stripos(file_get_contents('templates/'.$r[0].'/index.php'), 'libs/mmc.js') !== FALSE) {
                    if($fake_address_input_used || !empty($_POST["honeypot"])) {
                        suspicious($security_settings["ip_check_server"], "honeypot");
                    }

                    if(empty($_SESSION["$session_prefix-mouse_movement_detected"])) {
                        suspicious($security_settings["ip_check_server"], "mmc");
                    }
                }
            }
        }
    }
}

if(!$data['enabled'])
    $page = 'disabled';
elseif($data['paid'])
    $page = 'paid';
elseif($data['eligible'] && $data['address_eligible'])
    $page = 'eligible';
else
    $page = 'visit_later';
$data['page'] = $page;

if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest") {
    trigger_error("AJAX call that would break session");
    die();
}

$_SESSION["$session_prefix-address_input_name"] = randHash(rand(25,35));
$data['address_input_name'] = $_SESSION["$session_prefix-address_input_name"];

$data['rewards'] = implode(', ', $possible_rewards);

$q = $sql->query("SELECT url_name, name FROM Faucetinabox_Pages ORDER BY id");
$data["user_pages"] = $q->fetchAll();

$allowed = array("page", "name", "rewards", "short", "error", "paid", "captcha_valid", "captcha", "captcha_info", "time_left", "referral", "reflink", "template", "user_pages", "timer", "unit", "address", "balance", "disable_admin_panel", "address_input_name", "block_adblock", "iframe_sameorigin_only", "button_timer", "safety_limits_end_time");

preg_match_all('/\$data\[([\'"])(custom_(?:(?!\1).)*)\1\]/', file_get_contents("templates/$template/index.php"), $matches);
foreach(array_unique($matches[2]) as $box) {
    $key = "{$box}_$template";
    if(!array_key_exists($key, $data)) {
        $data[$key] = '';
    }
    $allowed[] = $key;
}

foreach(array_keys($data) as $key) {
    if(!(in_array($key, $allowed))) {
        unset($data[$key]);
    }
}

foreach(array_keys($data) as $key) {
    if(array_key_exists($key, $data) && strpos($key, 'custom_') === 0) {
        $data[substr($key, 0, strlen($key) - strlen($template) - 1)] = $data[$key];
        unset($data[$key]);
    }
}

if(array_key_exists('p', $_GET)) {
    $q = $sql->prepare("SELECT url_name, name, html FROM Faucetinabox_Pages WHERE url_name = ?");
    $q->execute(array($_GET['p']));
    if($page = $q->fetch()) {
        $data['page'] = 'user_page';
        $data['user_page'] = $page;
    } else {
        $data['error'] = "<div class='alert alert-danger'>That page doesn't exist!</div>";
    }
}

$data['address'] = htmlspecialchars($data['address']);

if(!empty($_SESSION["$session_prefix-mouse_movement_detected"])) {
    unset($_SESSION["$session_prefix-mouse_movement_detected"]);
}

require_once('templates/'.$template.'/index.php');
