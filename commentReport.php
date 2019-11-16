<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/report/CommentReport.php";
  $commentReport = new CommentReport();
  $comments = $commentReport->getCommentsThatContainString("candy");

  echo count($comments);
  for ( $i=0; $i<count($comments); $i++) {
    echo $comments[$i]["orderid"];
    echo "<br />";
  }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Web Programmer Test Project - Comment Report</title>
</head>
<body>
<h1>Comments are grouped by the following sections</h1>
<h2>Comments about candy</h2>
<h2>Comments about call me / don't call me</h2>
<h2>Comments about who referred me</h2>
<h2>Comments about signature requirements upon delivery</h2>
<h2>Miscellaneous comments (everything else)</h2>
</body>
</html>
