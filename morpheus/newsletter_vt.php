<?php
session_start();
error_reporting(0);
# # # # # # # # # # # # # # # # # # # # # # # # # # #
# www.pixel-dusche.de                               #
# björn t. knetter                                  #
# start 12/2003                                     #
#                                                   #
# post@pixel-dusche.de                              #
# frankfurt am main, germany                        #
# # # # # # # # # # # # # # # # # # # # # # # # # # #

global $morpheus;

$nlid = $_REQUEST['nlid'];
$save = $_REQUEST['save'];
$listUser = $_POST['listUser'];
$value_date_send_mail = $_POST['value_date_send_mail'];

include "cms_include.inc";

echo formSearch();

$mesage = '';

if ($save) {
	//echo 'ddd'; die();
    include '../inc/send.php';
    include "../nogo/config.php";

    $mid = '';
    $date = date('Y-m-d');

    foreach ($listUser as $user) {
        $mid .= $user . ',';
    }

    // save into table morp_newsletter_track
    $query = "insert into morp_newsletter_track(mids, date_create, date_send_mail, status, nlid) values('$mid', '$date', '$value_date_send_mail', 0, $nlid)";
    //echo $query; die();
    safe_query($query);

    /* // send mail to each user
	$body = getTextMail($nlid);
	//echo $body; die();

	//print_r($morpheus); die();
	$headerMail = $morpheus["mail_start"];
    $footerMail = $morpheus["mail_end"];

    $mail_txt = $headerMail . $body . $footerMail;

    foreach ($listUser as $mid) {
        //$to = getMailFormIduser($mid);
        //$to = 'vukynamkhtn@gmail.com';
        $to = 'post@pixel-dusche.de';
        $betreff = "News";

        sendMailSMTP($to, utf8_decode($betreff), utf8_decode($mail_txt));
    } */

    $mesage = '<div class="alert alert alert-success" role="alert">We will send mail to users as time you set</div>';
}

echo '<div id=content_big>
';

$query = "SELECT * FROM `morp_newsletter`";
$result = safe_query($query);
$sel = '';

$arrayNlid = array();

while ($row = mysqli_fetch_object($result)) {
    $sel .= '<option value=' . $row->nlid . '>' . $row->nlname . '</option>';
}

echo "<p><b>Send mail to users</b></p>" . '
<p>&nbsp;</p>
' . $mesage . '

<form method="post" name="dat" id="dat">
	<select name="nlid" id="nlid" style="width:500px;" >' . $sel . '</select> &nbsp; &nbsp; <label>Select Newletter</label>
	<br><br>
';

echo '<div id="list_user_search"><table border=0 cellspacing=1 cellpadding=0 class="autocol p20"><input type="checkbox" class="all_checkbox">';
echo '<tr>
        <th>Benutzername</th>
		<th>Anrede</th>
		<th>Vorname</th>
		<th>Name</th>
		<th>Institution</th>
		<th>berechtigt</th>
		<th>Mail bestätigt</th>
		<th>E-Mail</th>
	</tr>';

$query = "SELECT * FROM morp_intranet_user WHERE 1 ORDER BY isallowed DESC, optin DESC, nname, vname";
$result = safe_query($query);
$ct = mysqli_num_rows($result);
$change = $ct / 3;

while ($row = mysqli_fetch_object($result)) {
    $c++;

    $auth = explode("|", $row->auths);
    $authliste = array();
    foreach ($auth as $val) {
        $authliste[] = $auths_arr[$val];
    }

    echo '<tr' . ($row->isallowed ? '' : ' class="NOT"') . '>
			<td><input type="checkbox" value=' . ($row->mid) . ' class="td_checkbox" name="listUser[]">&nbsp; &nbsp;<a href="?mid=' . $row->mid . '">' . $row->email . '</a></td>
			<td>' . $row->anrede . ' ' . $row->titel . '</td>
			<td>' . $row->vname . '</td>
			<td>' . $row->nname . '</td>
			<td>' . $row->organisation . '</td>
			<td>' . $row->isallowed . '</td>
			<td>' . $row->optin . '</td>
			<td>' . $row->email . '</td>
			<td><a href="?del=' . $row->mid . '" class="btn btn-danger"><i class="fa fa-trash-o small"></i></a></td>
		</tr>';
}

echo '</table></div>
		<div id="waitbg" class="hide"></div>
		<div id="wave1" class="hide"></div>
		';

echo '<br><br><input type="hidden" name="save" id="save" value="1"><input type="hidden" name="value_date_send_mail" id="value_date_send_mail">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  SENDEN
</button>
</form>';

//modal
echo '<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <p>Are you sure to send mail to these user ? Please select time below</p>
         <input type="text" name="date_send_mail" id="date_send_mail" class="datepicker" placeholder="Date send mail">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn save_newletters" data-dismiss="modal">Save</button>
      </div>

    </div>
  </div>
</div>';
// end modal

include "footer.php";

