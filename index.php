<?php

require 'common.inc';
require 'nntp.inc';

$s = nntp_connect("news.php.net")
  or die("failed to connect to news server");

nntp_cmd($s,"LIST",215)
  or die("failed to get list of news groups");
head();

echo '<table border="0" cellpadding="6" cellspacing="0"><tr><td>';

echo "<table class=\"grouplist\">\n";
echo '<tr><td class="grouplisthead">name</td><td class="grouplisthead">messages</td></tr>',"\n";
$class = "even";
while ($line = fgets($s, 1024)) {
  if ($line == ".\r\n") break;
  $line = chop($line);
  list($group,$high,$low,$active) = explode(" ", $line);
  echo "<tr>";
  echo "<td class=\"$class\">";
  echo "<a class=\"active$active\" href=\"group.php?group=$group\">$group</a>";
  echo "</td>\n";
  echo "<td align=\"right\" class=\"$class\">", $high-$low+1, "</td>\n";
  echo "</tr>\n";
  $class = $class == "even" ? "odd" : "even";
}
echo "</table>\n";

echo '</td><td valign="top">';
?>
<h1>Welcome!</h1>
<p>This is a completely experimental interface to the PHP mailing
lists as reflected on the <a href="news://news.php.net/">news.php.net
NNTP server</a>.</p>
<p>There may be a little more info <a href="README">here</a>.</p>
<?
echo '</td></tr></table>';

foot();