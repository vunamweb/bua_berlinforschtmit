<?php
session_start();
# # # # # # # # # # # # # # # # # # # # # # # # # # # 
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
#                                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # # 

$newsletter_in = 'in';
include("cms_include.inc");

echo '<div id=content_big>
';
	
$nlid = isset($_POST["nlid"]) ? $_POST["nlid"] : '';
$save = isset($_POST["save"]) ? $_POST["save"] : '';

$query  = "SELECT * FROM `morp_newsletter_track` WHERE 1 GROUP BY nlid ORDER BY date_create";
$result = safe_query($query);
$sel = '';
$first = ''; 

while($row = mysqli_fetch_object($result)) {
	if(!$first) $first = $row->nlid;
	
	$tmp = $row->nlid;
	$rw = mysqli_fetch_object($res);	
	$sql  = "SELECT * FROM `morp_newsletter` WHERE nlid=$tmp";
	$res = safe_query($sql);
	$rw = mysqli_fetch_object($res);	
	
	$sel .= '<option value="'.$row->nlid.'"'.($row->nlid == $nlid ? ' selected' : '').'>'.$rw->nlname.'</option>';
}

if(!$nlid) $nlid = $first;

$mesage = '';

if ($save == 1) {
	//echo 'ddd'; die();
    include '../inc/send.php';
	include "../nogo/config.php";
	
	$query  = "SELECT * FROM `morp_newsletter_track` WHERE nlid = $nlid and status = 1";
	$result = safe_query($query);
	
	$listUser = '';
	
	while ($row = mysqli_fetch_object($result)) {
		$listUser .= $row->mids;
	}

	$listUser = explode(',', $listUser);

    // send mail to each user again
	$body = getTextMail_($nlid);
	//echo $body; die();

	//print_r($morpheus); die();
	/*$headerMail = $morpheus["mail_start"];
    $footerMail = $morpheus["mail_end"];*/

    $mail_txt = $body;

    foreach ($listUser as $mid) {
        //$to = getMailFormIduser($mid);
        //$to = 'vukynamkhtn@gmail.com';
        $to = 'post@pixel-dusche.de';
        $betreff = "News";

        sendMailSMTP($to, utf8_decode($betreff), utf8_decode($mail_txt));
    }

    $mesage = '<div class="alert alert alert-success" role="alert">Mail is sent to users again</div>';
}

echo "<p><b>TRACKING</b></p>".'
<p>&nbsp;</p>
'.$mesage.'

<form method="post" name="dat" id="dat">
	<select name="nlid" id="nlid_tracking" style="width:500px;" >' . $sel . '</select> &nbsp; &nbsp; <label>Select Newletter</label>
	<br><br>
	<input type="hidden" name="save" id="save" value="1">
	<br><br>
	<input type="submit" />
</form>
<p>&nbsp;</p>';

echo '
<div class="container">
<div class="row">
<table class="autocol" style="width:100%;">';

$query  = "SELECT * FROM `morp_newsletter_track` WHERE nlid =$nlid and status = 1 ORDER by date_create";
//echo $query; die();
$result = safe_query($query);

while ($row = mysqli_fetch_object($result)) {
	// echo $row->email;
	$mids = explode(",", $row->mids);
	$class = '';
	if (isin("^Social", $row->site)) $class = ' style="background:#e2e2e2;"';

	foreach($mids as $mid) {
	   if($mid != '') {
		$mail = getMailFormIduser_($mid);

		echo '<tr><td'.$class.'>'.$mail.'</td><td nowrap'.$class.'>'.($row->datum).'</td></tr>';
	   }
	}
}
?>

</table>
</div>
</div>

</div>

<?php
include("footer.php");
function getMailFormIduser_($mid)
{
    $query = "SELECT * FROM morp_intranet_user WHERE mid = " . $mid . "";
    $result = safe_query($query);
    $row = mysqli_fetch_object($result);

    return $row->email;
}

function getTextMail_($nlid)
{
    global $morpheus;
    $url = $morpheus['url'] . 'preview.php?nlid='.$nlid.'';

    $content = $morpheus['mail_start'] . file_get_contents($url) . $morpheus['mail_end'];

    return $content;

    //echo $content; die();
    /*$query = "SELECT * FROM morp_newsletter_cont WHERE nlcid = " . $nlcid . "";
    $result = safe_query($query);
    $row = mysqli_fetch_object($result);

    return $row->text;*/
}
?>

