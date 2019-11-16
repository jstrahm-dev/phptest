<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/report/CommentReport.php";
  $commentReport = new CommentReport();
  $report = $commentReport->report;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Web Programmer Test Project - Comment Report</title>
</head>
<body>
<h1>Comments are grouped by the following sections</h1>
<?php
  for ($i=0; $i<count($report); $i++) {
    echo "<h2>" . $report[$i]["header"] . "</h2>";
    echo "<p>Comments: " . count($report[$i]["commentRecords"]) . "</p>";
?>
<table border="1">
  <tr>
    <td>Order Id</td>
    <td>Comment</td>
    <td>Ship Date Expected</td>
  </tr>
<?php
    for ($x=0; $x<count($report[$i]["commentRecords"]); $x++) {
      echo "<tr><td>" . $report[$i]["commentRecords"][$x]["orderid"] . "</td>";
      echo "<td>" . $report[$i]["commentRecords"][$x]["comment"] . "</td>";
      echo "<td>" . $report[$i]["commentRecords"][$x]["shipdate"] . "</td></tr>";
    }
?>
</table>
<?php
  }
?>
</body>
</html>
