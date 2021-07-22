<?php
  # to get the read me
  include 'SharePointAPI.php';
  use Thybag\SharePointAPI;
  
  # get WSDL
  # wget https://hubsystemsconz.sharepoint.com/sites/SambaReplacement/_vti_bin/Lists.asmx?wsdl
  # ^ That should get the wsdl for the one we have for our development


  try {

    $sp = new SharePointAPI("nathan@hubsystems.com.au", "h538jjSBjtmC", "SambaReplacement.wsdl", "SPONLINE");

    // get list by name 
    $first_list = $sp->read('First List');

    # print the values of the list 
    foreach($first_list as $key => $value) {
      echo "entry:" . $key . "\n";
      foreach($value as $key => $value1) {
        echo "\t" . $key . ":" . $value1 . "\n";
      }
    }

    # add new entry (report name or something best to be unique)

    # get the position of new entry

    # attach the entry
    print_r($sp->addAttachment('First List', 0, 'foo.txt'));

  } catch (Exception $e) {
    echo 'Caught Exception: ', $e->getMessage(), "\n";
    echo $e->getTraceAsString();
  }
?>