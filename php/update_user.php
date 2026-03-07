<?php
session_start();
header("Content-Type: text/xml; charset=UTF-8");
if (!isset($_POST['txt_xml_Account']) || empty($_POST['txt_xml_Account'])) {
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<UserAccount><Error>No XML received</Error></UserAccount>';
    exit;
}

$Account =$_POST['txt_xml_Account'];
$xml = new DOMDocument();
$xml -> loadXML($Account);
if(!$xml->schemaValidate('C:/xampp/htdocs/MangaWeb/XSD/account.xsd')){
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<UserAccount><Error>Invalid XML</Error></UserAccount>';
    exit;
}else{
    include("db_connect.php");
    if (!isset($_SESSION['UserID'])) {
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<UserAccount><Error>Not logged in</Error></UserAccount>';
        exit;
    }
    $xmlAccount = simplexml_import_dom($xml);
    $userID = $_SESSION['UserID'] ;
    $fname = $xmlAccount -> FirstName;
    $lname =$xmlAccount-> LastName;
    $email = $xmlAccount->Email;
    $contact =$xmlAccount->ContactNumber ;
    $street = $xmlAccount->Street ;
    $city = $xmlAccount->City;
    $password =$xmlAccount->Password;
    if (!empty($password)) {
    $query = "UPDATE users SET FirstName='$fname', LastName='$lname', Email='$email', ContactNumber='$contact', Street='$street', City='$city', password='$password' WHERE UserID='$userID'";
    } else {
        $query = "UPDATE users SET FirstName='$fname', LastName='$lname', Email='$email', ContactNumber='$contact', Street='$street', City='$city' WHERE UserID='$userID'";
    }
    
}

if (!mysqli_query($conn, $query)) {
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<UserAccount><Error>Database update failed</Error></UserAccount>';
    exit;
}

$res = $conn->query("SELECT FirstName, LastName, Email, ContactNumber, Street, City FROM Users WHERE UserID='$userID'");
$user = $res->fetch_assoc();

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<UserAccount>
  <FirstName><?= htmlspecialchars($user['FirstName']) ?></FirstName>
  <LastName><?= htmlspecialchars($user['LastName']) ?></LastName>
  <Email><?= htmlspecialchars($user['Email']) ?></Email>
  <ContactNumber><?= htmlspecialchars($user['ContactNumber']) ?></ContactNumber>
  <Street><?= htmlspecialchars($user['Street']) ?></Street>
  <City><?= htmlspecialchars($user['City']) ?></City>
</UserAccount>

