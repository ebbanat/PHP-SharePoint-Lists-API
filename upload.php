<?php
  include 'SharePointAPI.php';
  use Thybag\SharePointAPI;
  
  # Getting WSDL (our own SharePoint) this is different for every SharePoint site.
  # wget https://hubsystemsconz.sharepoint.com/sites/SambaReplacement/_vti_bin/Lists.asmx?wsdl
  # get the domain and the site name then append "_vti_bin/Lists.asmx?wsdl"

  $username = "nathan@hubsystems.com.au";
  $password = "h538jjSBjtmC"; // This cannot contain symbols
  $wsdl = "SambaReplacement.wsdl";

  $file = $_SERVER['argv'][1];

  try {
    $sp = new SharePointAPI($username, $password, $wsdl, "SPONLINE");

    # add new entry
    $uniqid = basename($file) . uniqid();
    $sp->write('First List', array('Title' => $uniqid));

    # find the item that we just added
    $query = $sp->query('First List')->where('Title', '=', $uniqid)->get();

    # print the values of the list 
    $first_list = $sp->read('First List', 25);
    foreach($first_list as $key => $value) {
      echo "entry:" . $key . "\n";
      foreach($value as $key => $value1) {
        echo "\t" . $key . ":" . $value1 . "\n";
      }
    }

    # attach file 
    echo $file . " attached to " . $uniqid . " with the id: " . $sp->addAttachment('First List', $query[0]['id'], $file) . "\n";

  } catch (Exception $e) {
    echo 'Caught Exception: ', $e->getMessage(), "\n";
    echo $e->getTraceAsString();
  }
