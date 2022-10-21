<?php
		$sprungID = array("de"=>6, "en"=>57 );

	    $ac = $lan == "de" ? "Ich akzeptiere" : "I accept";
		$wl = $lan == "de" ? "Datenschutzerklärung" : "Privacy Statement";
		$ac = $lan == "de" ? "Auswahl Zustimmen" : "Agree selection";
		$acall = $lan == "de" ? "Alle akzeptieren" : "Accept all";
		$ab = $lan == "de" ? "Ablehnen" : "Deny";
		
		$dsgvo_text = $lan == "de" ? '<p><b>AUCH WIR VERWENDEN COOKIES:</b></p>
        <p>Wir möchten die Informationen auf dieser Webseite auf Ihre Bedürfnisse anpassen. Zu diesem Zweck setzen wir sog. Cookies ein. Entscheiden Sie bitte selbst, welche Arten von Cookies bei der Nutzung der Website eingesetzt werden sollen. Weitere Informationen erhalten Sie in unserer' : '<p><b>We also use COOKIES:</b></p>
        <p>We would like to adapt the information on this website to your needs. For this purpose, we use so-called cookies. Please decide for yourself which types of cookies to use when using the website. For more information, please see our';
?>

	<div id="cookie_disclaimer" class="row<?php echo isset($_COOKIE["disclaimer_v21"]) ? ' hide' : ""; ?>">
		<div class="col-12 col-lg-10 col-md-8">
			<?php echo $dsgvo_text; ?> <a href="<?php echo $dir.$lan.'/'.$navID[$sprungID[$lan]]; ?>"><u><?php echo $wl; ?></u></a>.</p>
			<table>
			 	<tr class="ul">
					<td width="50%">
						<h4><input type="checkbox" id="komfort" checked="" disabled> &nbsp; Technisch notwendige Cookies</h4>
						<p class="mt1"><span class="mobileOn">Technisch notwendige Cookies</span> sind erforderlich, um alle Funktionen dieser Website bereitzustellen und standardmäßig aktiviert</p>
					</td>
					<td width="50%">
					<div id="optout-form">
						<h4><input type="checkbox" id="komfort" <?php echo $komfort ? 'checked' : ''; ?>> &nbsp; Dienste Dritter</h4>
						<p class="mt1"><span class="mobileOn">Dienste Dritter </span> und ähnliche Technologien würden wir gerne verwenden, um u.A. Videos auf unserer Seite direkt einzubinden.</p>
					</div>	
					</td>
				</tr>			
			</table>			
		</div>	
		<div class="col-12 col-lg-2 col-md-4">
			<a href="#" id="acceptall" class="btn btn-info btnMore font_weiss"><?php echo $acall; ?></a> 
			<a href="#" id="cookie_stop" class="btn acc"><?php echo $ac; ?></a>
		</div>
		
	</div>
   
	<script type="text/javascript">	
	$(function(){
	    $('#cookie_detail').click(function(){
			event.preventDefault();
		    ishide = $('.cookie_detail').hasClass("hide");
		    if(ishide) { $(this).addClass("on"); $('.cookie_detail').removeClass("hide"); }
		    else {  $(this).removeClass("on"); $('.cookie_detail').addClass("hide"); }
		});
		
	    $('#acceptall').click(function(){
	        $('#cookie_disclaimer').slideUp("slow");

	        var nDays = 60;
	        var aDays = 720;
	        var cookieValue = "true";
	        var today = new Date();
	        var expire = new Date();
	        var expireDel = new Date();
	        expire.setTime(today.getTime() + 3600000*24*nDays);
	        expireDel.setTime(today.getTime() - 3600000*24*100);

	        var cookieName = "disclaimer_v21";
			document.cookie = cookieName+"="+escape(cookieValue)+";expires="+expire.toGMTString()+";path=/";
			var cookieName = "komfort";
			document.cookie = cookieName+"="+escape(cookieValue)+";expires="+expire.toGMTString()+";path=/";
			
	     });
	     $('#cookie_stop').click(function(){
		    var komfort =$('#komfort').prop('checked');
			var marketing =$('#marketing').prop('checked');

	        $('#cookie_disclaimer').slideUp("slow");

	        var nDays = 60;
	        var aDays = 720;
	        var cookieValue = "true";
	        var today = new Date();
	        var expire = new Date();
	        var expireDel = new Date();
	        expire.setTime(today.getTime() + 3600000*24*nDays);
	        expireDel.setTime(today.getTime() - 3600000*24*100);

	        var cookieName = "disclaimer_v21";
			document.cookie = cookieName+"="+escape(cookieValue)+";expires="+expire.toGMTString()+";path=/";
			if(komfort==true) {
				var cookieName = "komfort";
				expire.setTime(today.getTime() + 3600000*24*nDays);
				document.cookie = cookieName+"="+escape(cookieValue)+";expires="+expire.toGMTString()+";path=/";
				location.reload();
			}
			else if(komfort==false) {
				var cookieName = "komfort";
				document.cookie = cookieName+"='';expires="+expireDel.toGMTString()+";path=/";
			}
	    });
	});		
	</script>
	<script>
	  var _paq = window._paq = window._paq || [];
	  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
	  _paq.push(["setDoNotTrack", true]);
	  _paq.push(["disableCookies"]);
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  (function() {
		var u="//knowledge-exchange.berlin-university-alliance.de/berlinforschtmit/analytics/";
		_paq.push(['setTrackerUrl', u+'matomo.php']);
		_paq.push(['setSiteId', '1']);
		var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
