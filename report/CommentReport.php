<?php

  class CommentReport {

      function getCommentsThatContainString($contains_string) {
         $COMMENTS = array();
         $dbconn = mysqli_connect("localhost","devuser01","Ur2good8!","dev01");
         if (!$dbconn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
         }

         $sql = "SELECT orderid, comments, shipdate_expected FROM sweetwater_test";
         $sql .= " WHERE comments like '%" . $contains_string . "%';";
         $result = $dbconn->query($sql);

         if ($result->num_rows > 0) {
            $x = 0;
            while($row = $result->fetch_assoc()) {
               $COMMENTS[$x] = array (
                    orderid  => $row["orderid"],
                    comment  => $row["comments"],
                    shipdate => $row["shipdate_expected"]
                );
               $x++;
            }
         }

         $dbconn->close();
         return $COMMENTS;
      }


  }
?>