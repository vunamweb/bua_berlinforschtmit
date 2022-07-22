<?php
// session_start();
// print_r($_SESSION);
# print_r($_POST);

global $dir, $navID, $mid, $js;

$min = 6;

$output .= newPW($min, $mid);

$js = '
$(document).ready(function() {
	$(".reset_send").on("click", function(event) {
		event.preventDefault();
		pflicht=1;
		pw1 = $("#pw1").val(); if(pw1=="") pflicht=0;		
		pw2 = $("#pw2").val(); if(pw2=="") pflicht=0;		
		sec = $("#sec").val(); 
		if(pflicht==1) {
			request = $.ajax({
				url: "page/login-newpass-set.php",
				type: "post",
				datatype:"json",
				data: "mystring='.md5("pixeldusche".date("ymd")).'&pw1="+pw1+"&pw2="+pw2+"&sec="+sec+"&min='.$min.'",
				success: function(msg) {
					 console.log(msg);			
					if(msg == "newpwsuccess") { $("#warn").html("<h2>'.str_replace(array("\n", "\r"), array("",""," - "), textvorlage(57)).'</h2>"); showAlert("#warn"); $("#resetform").addClass("hide"); document.location.href="'.$dir.'?hn=profil&cont=profil"; }
					else { $("#warn").html("<h2>"+msg+"</h2>"); showAlert("#warn"); }
				}
			});
		} else {
			$("#warn").html("<h2>'.str_replace(array("\n", "\r"), array("",""," - "), textvorlage(46)).'</h2>"); 
			showAlert("#warn"); 
		}
	});
	
	function showAlert(div) {
		$(div).removeClass("hide");
		setTimeout(function () {
			$(div).addClass("hide");
		}, 2000);
	}
})
';


			//$("#warn").html("<h2>'.str_replace(array("\n", "<br />"), "-", textvorlage(46)).'</h2>"); showAlert("#warn"); 
