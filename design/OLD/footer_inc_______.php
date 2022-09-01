	
	<footer>
		<div class="footer_bottom">
			<div class="container">
				<div class="row">					
					<div class="col-12 col-lg-12">
						<ul class="list_nav">

<?php if($userIsLogIn==$checkLogSession) echo $nav_h; else { 
							echo '<li><a href="'.getUrl(18).'">Home</a></li>';
							$pages = array(4,18,);
							foreach($pages as $key) {
								echo '<li><a href="'.getUrl($key).'">'.$navarrayFULL[$key].'</a></li>';								
							}
?>
							
<?php } ?>
						</ul>
						<hr>
						<ul class="list_bottom">
							<li class="copyr"><a href="https://www.berlin-university-alliance.de/" target="_blank">© BERLIN UNIVERSITY ALLIANCE</a></li>
<?php echo $nav_meta; ?>
							<li><a href="<?php echo $dir.$lan.'/'.$navID[$loginid]; ?>"><?php echo textvorlage(22); ?></a></li> 
							<li><a href="<?php echo $dir.$lan.'/'.$navID[$registerid]; ?>"><?php echo textvorlage(35); ?></a></li> 
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<div class="container partner">
		<div class="row">
			<div class="col-12 flex-container">
	<?php echo getVorlagenText(35, $lang, $dir); ?>
			</div>
		</div>
	</div>
	
	<div class='back-to-top d-none d-lg-inline-block' id='back-to-top' title='Back to top'></div>
	
	<div class="bsnav-mobile d-block d-xl-none">
		<div class="bsnav-mobile-overlay"></div>
		<div class="navbar"></div>
	</div>
	
</div>


<!-- <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
  Link with href
</a> -->

<?php if($firstLogin) { ?> 
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="myToastStart" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
	<div class="toast-header">
	  <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg>

	  <strong class="me-auto">BUA message</strong>
	  <small>now</small>
	  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
	</div>
	<div class="toast-body">
	  Welcome <?php echo $_SESSION["vname"].' '.$_SESSION["nname"]; ?> to BUA global health portal
	</div>
  </div>
</div>
<?php } ?>

<?php
if($morpheus_edit) include("design/edit.php");
?>

<script src="<?php echo $dir; ?>js/jquery.min.js"></script>
<script src="<?php echo $dir; ?>js/jquery.easing.min.js"></script>
<!-- <script src="<?php echo $dir; ?>js/popper.min.js"></script> -->
<script src="<?php echo $dir; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $dir; ?>js/bsnav.min.js"></script>
<script src="<?php echo $dir; ?>js/ekko-lightbox.min.js"></script>
<script src="<?php echo $dir; ?>js/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo $dir; ?>js/isotope.pkgd.js" type="text/javascript"></script>
<script src="<?php echo $dir; ?>js/functions.js"></script>
<?php if($morpheus_edit) { ?>
<script src="<?php echo $dir; ?>js/functions_edit.js?v=<?php echo $rand; ?>"></script>
<?php } ?>

<script>
$(document).ready(function() {
	$('.uploadimg').click(function() {
		console.log('hit');
		$('#imgModal .modal-body').load($(this).data('href'), function(e) {
			$('#imgModal').modal('show')
		});
	});
	
	// target = window.location.hash;
	// if(target) {
	// 	wW = $(window).width();
	// 	$("html, body").animate({scrollTop: 0}, 0);
    //     $('html, body').stop().animate({
    //         scrollTop: $(target).offset().top - 100
	// 	}, 2500, 'easeInOutExpo');
	// }
	setSection();

	$("#myBtn").click(function(){
		$("#myToast").toast("show");
	});

	$("#myToastStart").toast("show");
});

$(window).resize(function() {
	setSection();
});

$(document).on('click', '[data-toggle="lightbox"]', function(event) {
	console.log(8);
	event.preventDefault();
	$(this).ekkoLightbox({
		alwaysShowClose: true
	});
});

function setSection() {
	wW = $(window).width();
	faktor = 911/1920;
	nH = ( wW * faktor );
	nLeftH = ( wW / 1200 );
	left = 350;
	right = 80;
	if(wW >= 1200) {
		$('.box_topbanner_item').css({"height":"500px"});
		$('.section_topbanner').css({"height":"600px"});
		$('.top-left').css({"width":left+"px","top":"140px"});
		$('.top-right').css({"width":right+"px","top":"350px"});
	}
	else {
		nL = left * nLeftH;
		nR = right * nLeftH;
		topfaktor = (100 * nLeftH) * -1;
		if(wW > 992) topfaktor = 130;
		else if(wW > 800) topfaktor = 10;
		else if(wW > 769) topfaktor = 0;
		else topfaktor = 0;
		$('.box_topbanner_item').css({"height":nH+"px"});
		nH = nH+40;
		$('.section_topbanner').css({"height":nH+"px"});
		$('.top-left').css({"width":nL+"px","top":topfaktor+"px"});
		$('.top-right').css({"width":nR+"px","top":topfaktor+"px"});
	}
}
$(document).ready(function() {
	// $('a.dd').on("click", function() {
	// 	ref = $(this).attr("href");
	// 	if(ref) location.href = ref;
	// 	event.preventDefault();
	// });
});

$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this).attr('href');
        $anchor = $anchor.split('#');
        $('html, body').stop().animate({
            scrollTop: $("#"+$anchor[1]).offset().top - 100
        }, 1500, 'easeInOutExpo');
		$(".collapse").removeClass("show");
        event.preventDefault();
    });
});
$('.linkbox').on("click", function() {
	event.preventDefault();
	ref = $(this).attr("ref");
	location.href = (ref);
});
  
<?php
	global $jsFunc, $js;

	echo $js . $jsFunc;

	global $formMailAntwort, $plichtArray;
	if($formMailAntwort) {
		$pflicht = ' pr=$("#datenschutz").prop("checked"); if(pr==false) pflicht=0; ';
		foreach($plichtArray as $val) {
			$pflicht .= '		pr = $("#'.$val.'").val(); if(pr=="") pflicht=0;';
		}
?>
    $(".sendform").on("click", function(event) {
		var data = $("#kontaktf").serializeArray();
		data = JSON.stringify(data);
		var pflicht=1;

<?php 
	global $register_form;
	echo $pflicht; 
?>

		if(pflicht==1) {
			event.preventDefault();
		    request = $.ajax({
		        url: "<?php echo $dir; ?>page/sendmail<?php echo $register_form ? '_register' : ''; ?>.php",
		        type: "post",
		        datatype:'json',
		        data: 'mystring=<?php echo md5("pixeldusche".date("ymd")); ?>&data='+data,
		        success: function(msg) {
	                console.log(msg);
	                if(msg == "Mail sent") $('#kontaktformular').html("<div class='alert alert-primary' role='alert'><?php echo str_replace("\n", "", $formMailAntwort); ?></div>");
	                 //else if(msg == "Captcha") $('#kontaktformular').html("Die Anfrage wurde nicht gesendet. Es gab einen Fehler.");
	                else $('#kontaktformular').html("The request was not sent. There was an error: "+msg+". Please contact us directly.<br/><br/>Die Anfrage wurde nicht gesendet. Es gab einen Fehler: "+msg+". Bitte nehmen Sie direkt Kontakt zu uns auf.");
	            }
		    });
		} else console.log("form not sent");
    });
<?php } ?>

</script>