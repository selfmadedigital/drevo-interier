<?php
    $json = file_get_contents($API_HOST.'/kontakt');
    $contact = json_decode($json);

    $to = $contact->email_formular;
    $from = $_REQUEST['name'];
    $name = $_REQUEST['email'];
    $headers = "Od: $from";
    $subject = "You have a message from your OnePro.";

    $fields = array();
    $fields{"yourname"} = "name";
    $fields{"youremail"} = "email";
    $fields{"subject"} = "subject";
    $fields{"message"} = "message";

    $body = "Here is what was sent:\n\n"; foreach($fields as $a => $b){   $body .= sprintf("%20s: %s\n",$b,$_REQUEST[$a]); }

    $send = mail($to, $subject, $body, $headers);

?>