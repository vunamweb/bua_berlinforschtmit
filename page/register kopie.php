<?php
global $jsFunc, $dir;

$output .= '

	<div id="kontaktformular">
		<form class="frmContact leftalgn text-left" id="kontaktf" method="post">
			<div class="row">
				<div class="col-12 col-md-10 offset-md-1">
					<div id="warn" class="hide alert alert-danger" role="alert"></div>
				</div>
				<div class="col-12 col-md-5 offset-md-1">
					<input type="Hidden" name="fid" value="3">
											
					<div class="form-group">
						<input id="vorname" name="vorname" required="" placeholder="Vorname *" type="text" class="form-control">
					</div>
					
					<div class="form-group">
						<input id="name" name="name" required="" placeholder="Name *" type="text" class="form-control">
					</div>
			
					<div class="form-group">
						<input id="emailadresse" name="emailadresse" required="" placeholder="E-Mail *" type="text" class="form-control">
					</div>
					
					<button class="btn btn-info btn-send sendform" type="submit">Absenden</button>
				
				</div>
				<div class="col-12 col-md-5">
					<div class="form-group">
						<input type="password" id="pass1" name="pass1" required="" placeholder="Passwort *" class="form-control">
					</div>
					<div class="form-group">
						<input type="password" id="pass2" name="pass2" required="" placeholder="Passwort bestätigen *" class="form-control">
					</div>
					<p class="small">Das Passwort sollte aus minimum 6 Zeichen bestehen.</sm></p>
				</div>

				<div class="col-12 col-md-10 offset-md-1 mt2">
		
					<p class="small"><input id="datenschutz" type="checkbox" name="datenschutz" required=""> &nbsp; Ich habe die Datenschutzerklärung zur Kenntnis genommen. Ich stimme zu, dass meine Angaben und Daten zur Beantwortung meiner Anfrage elektronisch erhoben und gespeichert werden. Hinweis: Sie können Ihre Einwilligung jederzeit für die Zukunft per E-Mail an <a href="mailto:post@pixel-dusche.de"><u>post@pixel-dusche.de</u></a> widerrufen. Detaillierte Informationen zum Umgang mit Nutzerdaten finden Sie in unserer <a href="https://www.pixeldusche.com/taunus/datenschutz/" target="_blank"><u>Datenschutzerklärung</u></a></p>
				</div>
				<div class="col-12 col-md-6">
		
				</div>
						
			</div>
		</form>
	</div>
';

$jsFunc = '
  $(".sendform").on("click", function(event) {
		var data = $("#kontaktf").serializeArray();
		data = JSON.stringify(data);
		var pflicht=1;
 	   	pr=$("#datenschutz").prop("checked"); if(pr==false) pflicht=0; 
		pr = $("#name").val(); if(pr=="") pflicht=0;		
		pw1 = $("#pass1").val(); if(pw1=="") pflicht=0;		
		pw2 = $("#pass2").val(); if(pw2=="") pflicht=0;		
		pr = $("#vorname").val(); if(pr=="") pflicht=0;		
		pr = $("#emailadresse").val(); 
		if(pr=="") pflicht=0;		
		if(pflicht==1) {
			event.preventDefault();
		    request = $.ajax({
		        url: "'.$dir.'page/registerme.php",
		        type: "post",
		        datatype:"json",
		        data: "mystring='.md5("pixeldusche".date("ymd")).'&cid=1&data="+data,
		        success: function(msg) {
	                 console.log(msg);
					 
					 if(msg == "xxx") { $("#warn").html("<h2>Sie haben bereits einen Zugang</h2>"); showAlert("#warn"); }
					 else if(msg == "pwfailed") { $("#warn").html("<h3>Ihre Passwörter stimmen nicht überein</h3>"); showAlert("#warn"); }
					 else if(msg == "pwfaileds") { $("#warn").html("<h3>Ihre Passwort sollte aus mind. 6 Zeichen bestehen</h3>"); showAlert("#warn"); }
		            // if(msg == "Mail sent") $("#kontaktformular").html("<h2>Vielen Dank für Ihre Registrierung</h2><p>Wir melden uns schnellstmöglich bei Ihnen</p>");
	                // else $("#kontaktformular").html("Die Anfrage wurde nicht gesendet. Es gab einen Fehler: "+msg+"");
	            }
		    });
		} else console.log("not sent");
    });
	
	function showAlert(div) {
		$(div).removeClass("hide");
		setTimeout(function () {
    		$(div).addClass("hide");
		}, 2000);
	}
';
