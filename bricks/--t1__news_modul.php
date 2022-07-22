<?php
/* pixel-dusche.de */
global $dir, $navID, $cid;

// $sql = "SELECT * FROM news WHERE ngid=1 AND `sichtbar`=1 ORDER BY nerstellt DESC LIMIT 0,100";
$heute = date("Y-m-d");

if($cid == 1) $max = "LIMIT 0,3";
else $max = "";

$ngid = $text ? $text : 1;

$sql = "SELECT * FROM morp_cms_news WHERE ngid=$ngid AND `sichtbar`=1 AND ( nvon='0000-00-00' OR ( nvon <= '$heute' AND nbis >= '$heute' ) ) ORDER BY nerstellt DESC $max";
$res = safe_query($sql);
$anz = mysqli_num_rows($res);
$x = 0;

if($cid > 1 && $ngid == 2) {
    while ($row = mysqli_fetch_object($res)) {
        $output .= '
        <div class="box_content_items">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <h3>'.euro_dat($row->nerstellt).'<br>
                        '.$row->nsubtitle.'</h3>
                        <h2>'.$row->ntitle.'</h2>
                        <p>'.nl2br($row->ntext).'</p>
                        <a href="#" class="btn btngoto">Zum Artikel</a>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="border border-secondary"><img src="'.$dir.'images/news/'.$row->img1.'" alt="'.$row->ntitle.'" class="img-fluid"></div>
                    </div>
                </div>
            </div>';

    }
}
elseif($cid > 1) {
    while ($row = mysqli_fetch_object($res)) {
        $pdf = '';

            if($row->pid) {
                $sql = "SELECT * FROM `morp_cms_pdf` WHERE pid=".$row->pid;
                $rs = safe_query($sql);
                $rw = mysqli_fetch_object($rs);
                $pdf = $rw->pname;
                $pdf = ' <p><a href="'.$dir.'pdf/'.$pdf.'" class="btn btn_green mb-0" target="_blank">'.$rw->pdesc.'</a></p>';

            }

        $output .= '
        <div class="box_content_items">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <h3>'.$row->nsubtitle.'</h3>
                    <h2>'.$row->ntitle.'</h2>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <div class="multicol"><p>'.nl2br($row->ntext).'</p>
                           '.$pdf.'
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    }
}
else {
	$output .= '                    <div class="row">
';

	while ($row = mysqli_fetch_object($res)) {

	$x++;

	$link = '';
/*
	if($row->nlink) {
		if(isin("http", $row->nlink)) {
			$link = '<p class="pt2"><a href="'.$row->nlink.'" target="_blank"><i class="fa fa-external-link"></i> &nbsp; '.$row->nlink.'</a></p>';
		}
		else $link = '<p class="pt2"><a href="'.$dir.$navID[$row->nlink].'"><i class="fa fa-external-link"></i>  &nbsp; weitere Informationen</a></p>';

	}
*/
	$pdf = '';
/*
	if($row->pid) {
		$sql = "SELECT * FROM morp_cms_pdf WHERE pid=".$row->pid;
		$rs = safe_query($sql);
		$rw = mysqli_fetch_object($rs);
		$pdf = $rw->pname;
		$pdf = '<p class="pt2"><a href="'.$dir.'pdf/'.$pdf.'" target="_blank"><i class="fa fa-download"></i> &nbsp; PDF / '.$rw->pdesc.'</a></p>';

	}
*/

	$output .= '
                        <div class="col-12 col-lg-4">
                            <div class="box_services">
                                <div class="box_img">
                                    <a href="services.php"><img src="'.$dir.'images/news/'.$row->img1.'" alt="'.$row->ntitle.'" class="img-fluid"></a>
                                </div>
                                <h3>'.nl2br($row->ntitle).'</h3>
                                <h4><a href="services.php">'.$row->nsubtitle.'</a></h4>
                                <p>'.nl2br($row->nabstr).'</p>
                                <a href="'.$dir.$navID[6].'#n'.$row->nid.'" class="btn btn_news">zu Aktuelles</a>
                            </div>
                        </div>';
	}
}

$output .= '</div>';

$morp = "NEWS Modul /";

?>