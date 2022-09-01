
</main>
<?php 
	// print_r($morpheus); 
?>

<footer>
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <h2><?php echo nl2br($morpheus["client"]); ?></h2>
                    <p class="mb-0"><?php echo nl2br($morpheus["subline"]); ?></p>
                </div>
                <div class="col-12 col-lg-3">
                    <h2><?php echo $morpheus["praxis"]; ?></h2>
                    <p><?php echo nl2br($morpheus["vcard"]); ?></p>
                    <p>Tel.: <a href="tel:beratung@rieger-praxis.de"><?php echo $morpheus["fon"]; ?></a><br>
                    <a href="mailto:<?php echo $morpheus["email"]; ?>"><u><?php echo $morpheus["email"]; ?></u></a></p>
                </div>
                <div class="col-12 col-lg-3 opentime">
                    <h2>Sprechzeiten</h2>
                    <p><?php echo nl2br($morpheus["zeiten"]); ?></p>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="box_address">
                        <h2><?php echo $morpheus["c_hl"]; ?></h2>
                        <p class="mb-0">Tel.: <a href="tel:<?php echo $morpheus["c_fon"]; ?>"><?php echo $morpheus["c_fon"]; ?></a><br>
                        <a href="mailto:<?php echo $morpheus["c_mail"]; ?>"><?php echo $morpheus["c_mail"]; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="container-fluid meta">
	<div class="container text-center">
		<ul class="nav-meta">
			<?php echo $nav_meta; ?>
		</ul>
	</div>	
</div>

<div id="waitbg"></div>
<div id="wave1"></div>

<?php
if($morpheus_edit) include("design/edit.php");
?>

<script src="<?php echo $dir; ?>js/jquery.min.js"></script>
<script src="<?php echo $dir; ?>js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $dir; ?>js/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo $dir; ?>js/current-device.min.js"></script>
<script src="<?php echo $dir; ?>js/isotope.pkgd.js"></script>
<script src="<?php echo $dir; ?>js/flickity.pkgd.min.js"></script>
<script src="<?php echo $dir; ?>js/flickity-fade.js"></script>
<script src="<?php echo $dir; ?>js/functions.js?v=<?php echo $rand; ?>"></script>
<?php if($morpheus_edit) { ?>
<script src="<?php echo $dir; ?>js/functions_edit.js?v=<?php echo $rand; ?>"></script>
<?php } ?>

<script type="text/javascript">
if("device.ipad() === %s", device.ipad()) {

}

// console.log(device.mobile());
// console.log(device.ipad());

$(document).ready(function() {
	target = window.location.hash;
	if(target) {
		wW = $(window).width();
		// $("html, body").animate({scrollTop: 0}, 0);
        $('html, body').stop().animate({
            scrollTop: $(target).offset().top - 50
		}, 500);
	}
	$('.linkbox').on("click", function() {
		event.preventDefault();
  		ref = $(this).attr("ref");
  		location.href = (ref);
  	});
	// startPage();
});
$(window).resize(function() {
	
});

<?php global $formMailAntwort, $plichtArray;
	if($formMailAntwort) {
		$pflicht = ' pr=$("#datenschutz").prop("checked"); if(pr==false) pflicht=0; pr = $("#eintrag").val(); if(pr=="") pflicht=0; ';
		foreach($plichtArray as $val) {
			$pflicht .= '		pr = $("#'.$val.'").val(); if(pr=="") pflicht=0;';
		}
?>
    $(".sendform").on("click", function(event) {
		var data = $("#kontaktf").serializeArray();
		data = JSON.stringify(data);
		var pflicht=1;

<?php echo $pflicht; ?>
		if(pflicht==1) {
			event.preventDefault();
		    request = $.ajax({
		        url: "<?php echo $dir; ?>page/sendmail.php",
		        type: "post",
		        datatype:'json',
		        data: 'mystring=<?php echo md5("pixeldusche".date("ymd")); ?>&cid=<?php echo $cid; ?>&data='+data,
		        // data: 'mystring=<?php echo md5("pixeldusche".date("ymd")); ?>&data='+data+'&pixel='+$("#eintrag").val(),
		        success: function(msg) {
	                // console.log(msg);
	                if(msg == "Mail sent") {
						$('.title').html("");
						$('#kontaktformular').html("<?php echo str_replace("\n", "", $formMailAntwort); ?>");
					}
	                // else if(msg == "Captcha") $('#kontaktformular').html("Die Anfrage wurde nicht gesendet. Es gab einen Fehler.");
	                else $('#kontaktformular').html("Die Anfrage wurde nicht gesendet. Es gab einen Fehler: "+msg+"");
	            }
		    });
		} else console.log("not sent");
    });
<?php } ?>
<?php global $jsFunc; echo $jsFunc; ?>

</script>
