<?php
global $jsFunc, $dir, $haslogin, $loginid, $navID, $lan;

$haslogin = 0;

$output .= '
<div class="container">
	<div id="kontaktformular">
		<form class="frmContact regForm leftalgn text-left" id="kontaktf" method="post">
			<div class="row">
				<div class="col-12">
					<div id="message" class=" alert alert-danger text-center hide"></div>
					<div id="warn" class="hide alert alert-danger" role="alert"></div>
				</div>
				<div class="row">
					<div class="col-6 col-md-3">
						<div class="form-group">
							<select id="anrede" name="anrede" class="form-control" required>
								<option value="">'.textvorlage(63).'</option>
								<option value="'.textvorlage(64).'">'.textvorlage(64).'</option>
								<option value="'.textvorlage(65).'">'.textvorlage(65).'</option>
							</select>
						</div>
					</div>
						
					<div class="col-6 col-md-3">
						<div class="form-group">
							<input id="titel" name="titel" placeholder="'.textvorlage(62).'" type="text" class="form-control">
						</div>
					</div>
						
					<div class="col-6 col-md-3">
						<div class="form-group">
							<input id="vorname" name="vorname" required="" placeholder="'.textvorlage(4).' *" type="text" class="form-control">
						</div>
					</div>
						
					<div class="col-6 col-md-3">
						<div class="form-group">
							<input id="name" name="name" required="" placeholder="Name *" type="text" class="form-control">
						</div>					
					</div>					
						
					<div class="col-6 col-md-6">
						<div class="form-group">
							<input id="institution" name="institution" required="" placeholder="Institution *" type="text" class="form-control">
						</div>
					</div>



	
					<div class="col-6 col-md-6">
						<div class="form-group">
							<select id="status" name="status" class="form-control">
								<option value="">'.textvorlage(58).'</option>
';

					$sql_status = "SELECT * FROM morp_intranet_user_status WHERE stID<99 ORDER BY status";
					$res_status 	= safe_query($sql_status);
					while($rw = mysqli_fetch_object($res_status)) {
						$output .= '<option value="'.$rw->stID.'">'.$rw->status.'</option>';
					}

$output .= '
								<option value="99">'.textvorlage(59).'</option>
							</select>
						</div>					
					</div>

<!--						
					<div class="col-6 col-md-6">
						<div class="form-group">
							<input id="website" name="website" placeholder="Website" type="text" class="form-control">
						</div>
					</div>
-->
				</div>	
					
				<div class="row">
					<div class="col-6 col-md-4">
						<div class="form-group">
							<input id="email" name="email" required="" placeholder="'.textvorlage(10).' *" type="text" class="form-control">
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<input type="password" id="pass1" name="pass1" required="" placeholder="'.textvorlage(16).' *" class="form-control">
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<input type="password" id="pass2" name="pass2" required="" placeholder="'.textvorlage(37).' *" class="form-control">
						</div>
					</div>
					<div class="col-12">
						<p class="small">'.textvorlage(34).'</sm></p>
					</div>
				</div>
	
				<div class="row">
					<div class="col-12 mt2">
						<p class="small text-left"><input id="datenschutz" type="checkbox" name="datenschutz" required=""><label class="ds" for="datenschutz"> '.textvorlage(33).'</label></p>
					</div>
					<div class="col-12 col-md-6 offset-md-3 text-center">
						<button class="btn btn-info btn-send sendform" type="submit">'.textvorlage(67).'</button>
					</div>
				</div>
						
			</div>
		</form>
	</div>
	
<!--
	<div class="row">
		<div class="col-12 text-center">
			<p><a href="'.$dir.$lan.'/'.$navID[$loginid].'" class="pfeil">Login</a></p>
		</div>
	</div>
-->
</div>

';

$jsFunc = '
  $(".sendform").on("click", function(event) {
	  console.log(8);
		var data = $("#kontaktf").serializeArray();
		data = JSON.stringify(data);
		var pflicht=1;
		var warn = "<br><br>";
 	   	pr=$("#datenschutz").prop("checked"); if(pr==false) pflicht=0; 
		pr = $("#anrede").val();  if(pr=="") { pflicht=0; warn += "Anrede<br>"; }		
		pr = $("#vorname").val();  if(pr=="") { pflicht=0; warn += "Vorname<br>"; }		
		pr = $("#name").val();  if(pr=="") { pflicht=0; warn += "Name<br>"; }		
		pr = $("#email").val();  if(pr=="") { pflicht=0; warn += "E-Mail<br>"; }		
		pr = $("#institution").val();  if(pr=="") { pflicht=0; warn += "Institution<br>"; }		
		pr = $("#status").val();  if(pr=="") { pflicht=0; warn += "Status<br>"; }		
		pw1 = $("#pass1").val();  if(pw1=="") { pflicht=0;  }		
		pw2 = $("#pass2").val();  if(pw2=="") { pflicht=0;  }		
		if(pflicht==1) {
			event.preventDefault();
		    request = $.ajax({
		        url: "'.$dir.'page/registerme.php",
		        type: "post",
		        datatype:"json",
		        data: "lan='.$lan.'&portal=BC&mystring='.md5("pixeldusche".date("ymd")).'&cid=1&data="+data,
		        success: function(msg) {
	                console.log(msg);
					 
					if(msg == "xxx") { $("#warn").html("<h2>'.textvorlage(27).'</h2>"); showAlert("#warn"); }
					else if(msg == "mailfailed") { $("#warn").html("<h3>'.textvorlage(28).'</h3>"); showAlert("#warn"); }
					else if(msg == "pwfailed") { $("#warn").html("<h3>'.textvorlage(29).'</h3>"); showAlert("#warn"); }
					else if(msg == "pwfaileds") { $("#warn").html("<h3>'.textvorlage(30).'</h3>"); showAlert("#warn"); }
		            else if(msg == "Mail sent") $("#kontaktformular").html("'.textvorlage(31).'");
	                else $("#kontaktformular").html("'.textvorlage(32).': "+msg+"");
	            }
		    });
		} else {
			$("#message").html("Bitte füllen Sie alle Pflichtfelder aus"+warn);
			$("#message").addClass("auto");
			$("#message").removeClass("hide");
			setTimeout(function(){
				$("#message").addClass("hide");
				$("#message").removeClass("auto");
			},1000);
			$(".miss").on("click", function() {
				$(this).removeClass("miss");
			 });	
		}
    });
	
	function showAlert(div) {
		$(div).removeClass("hide");
		setTimeout(function () {
    		$(div).addClass("hide");
		}, 2000);
	}
';
