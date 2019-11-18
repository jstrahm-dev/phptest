<?php

  class CommentReport {

    public $report;

    function __construct() {
      $this->report = array();
      $this->report[0] = array (
          'header'=> "Comments about candy",
          'commentRecords'=> array()
      );
      $this->report[1] = array (
          'header'=> "Comments about call me / don't call me",
          'commentRecords'=> array()
      );
      $this->report[2] = array (
          'header'=> "Comments about who referred me",
          'commentRecords'=> array()
      );
      $this->report[3] = array (
          'header'=> "Comments about signature requirements upon delivery",
          'commentRecords'=> array()
      );
      $this->report[4] = array (
          'header'=> "Miscellaneous comments",
          'commentRecords'=> array()
      );
      $this->generateReport();
    }

    function generateReport() {
      $commentRecords = $this->getComments();
      for ($i=0; $i<count($commentRecords); $i++) {
        $this->addCommentToReprt($commentRecords[$i]);
      }
    }

    function getComments() {
      $commentRecords = array();
      $dbconn = mysqli_connect("localhost","devuser01","Ur2good8!","dev01");
      if (!$dbconn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
      }

      $sql = "SELECT orderid, comments, shipdate_expected FROM sweetwater_test";
      $result = $dbconn->query($sql);

      if ($result->num_rows > 0) {
        $x = 0;
        while($row = $result->fetch_assoc()) {
          $commentRecords[$x] = array (
            'orderid' => $row["orderid"],
            'comment'  => $row["comments"],
            'shipdate' => $row["shipdate_expected"]
          );
          $x++;
        }
      }

      $dbconn->close();
      return $commentRecords;
    }

    function addCommentToReprt($commentRecord) {
      switch (true) {
        case stristr($commentRecord["comment"],'candy'):
          $this->report[0]["commentRecords"][] = $commentRecord;
          break;
        case stristr($commentRecord["comment"],'call me'):
          $this->report[1]["commentRecords"][] = $commentRecord;
          break;
        case stristr($commentRecord["comment"],'referred'):
          $this->report[2]["commentRecords"][] = $commentRecord;
          break;
        case stristr($commentRecord["comment"],'delivery'):
          $this->report[3]["commentRecords"][] = $commentRecord;
          break;
        default:
          $this->report[4]["commentRecords"][] = $commentRecord;
          break;
      }

    }
  }
?>