<?php

  class FixShipDate {

    function proc() {
      $fixShipDate = new FixShipDate();
      $records = $fixShipDate->getCommentsWithExpectedShipDates();
      for ($i=0; $i<count($records); $i++) {
        $fixShipDate->fix($records[$i]);
      }
    }

    function fix($record) {
      $orderId = $record["orderid"];
      $comment = trim(preg_replace('/\s\s+/', ' ', trim($record["comment"])));
      $dateString = substr($comment, -8);
      $time = strtotime($dateString);
      $newformat = date('Y-m-d',$time);
      $dbconn = mysqli_connect("localhost","devuser01","Ur2good8!","dev01");
      if (!$dbconn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
      }

      $sql = "update sweetwater_test set shipdate_expected='" . $newformat . "'";
      $sql .= " WHERE orderid='" . $orderId . "' limit 1";

      echo "Record OrderId: " . $orderId . " ship date: " . $newformat;
      if ($dbconn->query($sql) === TRUE) {
        echo " Record updated successfully<br />";
      } else {
        echo " Error updating record: " . $conn->error . "<br />";
      }

      $dbconn->close();

    }

    function getCommentsWithExpectedShipDates() {
      $fixRecords = array();
      $dbconn = mysqli_connect("localhost","devuser01","Ur2good8!","dev01");
      if (!$dbconn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
      }

      $sql = "SELECT orderid, comments FROM sweetwater_test";
      $sql .= " WHERE comments like '%Expected Ship Date%'";
      $result = $dbconn->query($sql);

      if ($result->num_rows > 0) {
        $x = 0;
        while($row = $result->fetch_assoc()) {
          $fixRecords[$x] = array (
            'orderid'  => $row["orderid"],
            'comment'  => $row["comments"]
          );
          $x++;
        }
      }

      $dbconn->close();
      return $fixRecords;
    }
  }
?>