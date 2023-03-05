<?PHP

function mail_tronic($to, $subject, $body){
    require_once "Mail.php";
    if (strlen($_REQUEST['message']) < 0) {
        die;
    }
    $body = wordwrap($body, 70);

    $headers = array ('From' => $_ENV['MAIL_FROM'], 'To' => $to,'Subject' => $subject);
    $smtp = Mail::factory('smtp',
        array ('host' => $_ENV['MAIL_SMTP'],
            'port' => $_ENV['MAIL_PORT'],
            'auth' => true,
            'username' => $_ENV['MAIL_USER'],
            'password' => $_ENV['MAIL_PASS']));

    $mail = $smtp->send($to, $headers, $body);
    if (PEAR::isError($mail)) {
        // echo $mail->getMessage();
        $mail->getMessage();
    }
    $smtp->send("info@lukaspastva.sk", $headers, $body);
}

session_cache_expire(60);
session_start();
ob_start();
ini_set('arg_separator.output', '&amp;');
date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

$name = $_REQUEST['name'] ?? 'name';
$email = $_REQUEST['email'] ?? 'email';
$phone = $_REQUEST['phone'] ?? 'phone';
$message = $_REQUEST['message'] ?? 'message';
$msg = "Message from web ".$_SERVER['SERVER_NAME']."\n\n\nName: " . $name . "\nEmail: " . $email . "\nPhone: " . $phone . "\nMessage: " . $message;

mail_tronic($_ENV['MAIL_TO'], "Message from web ".$_SERVER['SERVER_NAME'], $msg);