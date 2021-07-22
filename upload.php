<?php
  include 'SharePointAPI.php';
  use Thybag\SharePointAPI;
  
  # Getting WSDL (our own SharePoint)
  # wget https://hubsystemsconz.sharepoint.com/sites/SambaReplacement/_vti_bin/Lists.asmx?wsdl
  # get the domain and the site name then append "_vti_bin/Lists.asmx?wsdl"

  $username = "nathan@hubsystems.com.au";
  $password = "h538jjSBjtmC"; // This cannot contain symbols
  $wsdl = "SambaReplacement.wsdl";

  $filename = "steel.txt";
  $filepath = "steel.txt";

  try {
    $sp = new SharePointAPI($username, $password, $wsdl, "SPONLINE");

    # add new entry
    $uniqid = $filename . uniqid();
    $sp->write('First List', array('Title' => $uniqid));

    # find the item that we just added
    $query = $sp->query('First List')->where('Title', '=', $uniqid)->get();

    # print the values of the list 
    // foreach($first_list as $key => $value) {
    //   echo "entry:" . $key . "\n";
    //   foreach($value as $key => $value1) {
    //     echo "\t" . $key . ":" . $value1 . "\n";
    //   }
    // }

    # attach file 
    echo $filename . " attached to " . $uniqid . " with the id: " . $sp->addAttachment('First List', $query[0]['id'], $filename);

  } catch (Exception $e) {
    echo 'Caught Exception: ', $e->getMessage(), "\n";
    echo $e->getTraceAsString();
  }
?>