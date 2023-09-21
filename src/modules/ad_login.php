<?php
/*
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

function check_login(){



if (isset($_POST['username']) && isset($_POST['password'])){

if (!empty($_POST['username']) && !empty($_POST['password'])){


$user = preg_replace( "/[^a-zA-Z0-9_\ -]/", "", $_POST['username'] );

$password = str_replace(array('\\', '*', '(', ')'), array('\5c', '\2a', '\28', '\29'), $_POST['password']);
for ($i = 0; $i<strlen($password); $i++) {
    $char = substr($password, $i, 1);
    if (ord($char)<32) {
        $hex = dechex(ord($char));
        if (strlen($hex) == 1) $hex = '0' . $hex;
        $password = str_replace($char, '\\' . $hex, $password);
    }
} // Converts non alphabetical characters to ACII this is to avoid ldap_injection


$host = getenv('ldap_host');
$domain = getenv('ldap_domain');
$basedn = getenv('ldap_basedn');
$group = getenv('ldap_group');

$ad = ldap_connect("ldap://{$host}.{$domain}"); // 

if (!$ad){
	return;
}
ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
$lbind = @ldap_bind($ad, "{$user}@{$domain}", $password);

if (!$lbind){
    ldap_unbind($ad);
	return;
}
$userdn = getDN($ad, $user, $basedn);
if (checkGroupEx($ad, $userdn, getDN($ad, $group, $basedn))) {
    $_SESSION['LOGGED_IN'] = True;
    $_SESSION['LAST_ACTIVITY'] = time();
    $_SESSION['USERNAME'] = getCN($userdn);
    $_SESSION['ref'] = getenv('ldap_group');
    ldap_unbind($ad);
    return true;
} else {
    ldap_unbind($ad);
    return;
}





} // End check empty post

} // end check isset post
}

/*
* This function searchs in LDAP tree ($ad -LDAP link identifier)
* entry specified by samaccountname and returns its DN or epmty
* string on failure.
*/
function getDN($ad, $samaccountname, $basedn) {
    $attributes = array('dn');
    $result = ldap_search($ad, $basedn,
        "(samaccountname={$samaccountname})", $attributes);
    if ($result === FALSE) { return ''; }
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count']>0) { return $entries[0]['dn']; }
    else { return ''; };
}

/*
* This function retrieves and returns CN from given DN
*/
function getCN($dn) {
    preg_match('/[^,]*/', $dn, $matchs, PREG_OFFSET_CAPTURE, 3);
    return $matchs[0][0];
}

/*
* This function checks group membership of the user, searching only
* in specified group (not recursively).
*/
function checkGroup($ad, $userdn, $groupdn) {
    $attributes = array('members');
    $result = ldap_read($ad, $userdn, "(memberof={$groupdn})", $attributes);
    if ($result === FALSE) { return FALSE; };
    $entries = ldap_get_entries($ad, $result);
    return ($entries['count'] > 0);
}

/*
* This function checks group membership of the user, searching
* in specified group and groups which is its members (recursively).
*/
function checkGroupEx($ad, $userdn, $groupdn) {
    $attributes = array('memberof');
    $result = ldap_read($ad, $userdn, '(objectclass=*)', $attributes);
    if ($result === FALSE) { return FALSE; };
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count'] <= 0) { return FALSE; };
    if (empty($entries[0]['memberof'])) { return FALSE; } else {
        for ($i = 0; $i < $entries[0]['memberof']['count']; $i++) {
            if ($entries[0]['memberof'][$i] == $groupdn) { return TRUE; }
            elseif (checkGroupEx($ad, $entries[0]['memberof'][$i], $groupdn)) { return TRUE; };
        };
    };
    return FALSE;
}


?>