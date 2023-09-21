<?php
session_start();
require('modules/ad_login.php');
require('modules/common_functions.php');



if (array_key_exists('LOGGED_IN', $_SESSION)){
    if($_SESSION['LOGGED_IN'] != True){
        // last request was more than 30 minutes ago or user is not logged in
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
    } else {
        $_SESSION['LAST_ACTIVITY'] = time();
        header("Location: index.php");
    }}




if (isset($_POST['username']) || isset($_POST['username'])){
    if (check_login()){
        header("Location: index.php");
    }

    else{
        echo(html_header());
        echo('<div class="body_text">Forkert brugernavn og/eller password</div><br>');
    }
}
else {
    echo(html_header());
}

?>

<div class="datacontainer">
    <form action="" method="post">
    <table>
        <tr>
            <td>Brugernavn:</td>
            <td><input type="text" name="username" size="20" autofocus></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" size="20"></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><input type="submit" name="submit" value="Send"></td>
        </tr>
    </table>
    </form>
</div>

<?php
echo(html_footer());
?>
