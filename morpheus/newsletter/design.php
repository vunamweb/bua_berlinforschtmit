<?php
global $morpheus, $dir, $navID;

$html = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="x-apple-disable-message-reformatting">
	<!--[if !mso]><!-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!--<![endif]-->
	<title>#title#</title>
	<!--[if mso]>
	<style type="text/css">
    table {border-collapse:collapse;border:0;border-spacing:0;margin:0;}
    div, td {padding:0;}
    div {margin:0 !important;}
	</style>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
	<style type="text/css">
  		@font-face { font-family: pica; src: url("'.$morpheus["url"].'fonts/Pica.ttf.woff") format("woff"); font-weight: normal; font-style: normal; }
		h1 {margin-top:0;margin-bottom:12px;font-family:Verdana,Helvetica,Arial;font-size:20px;line-height:28px;font-weight:bold;color:#000;}
		h2,h3 {margin-top:0;margin-bottom:12px;font-family:Verdana,Helvetica,Arial;font-size:16px;line-height:28px;font-weight:bold;color:#000;}
		h3 {font-size:13px;line-height:26px;font-weight:bold;color:#000;}
		p, ul, a {margin:0;font-family:Verdana,Helvetica,Arial;font-size:13px;line-height:24px;margin-bottom:24px;color:#000;}
		.zitat {margin-top:0;margin-bottom:12px;font-family:Courier new,Courier,serif;font-size:20px;line-height:28px;font-weight:normal;color:#000;}
		.circle { margin: 0 10px; }
		@media screen and (max-width: 350px) {
			.three-col .column {
				max-width: 100% !important;
			}
		}
		@media screen and (min-width: 351px) and (max-width: 460px) {
			.three-col .column {
				max-width: 50% !important;
			}
		}
		@media screen and (max-width: 460px) {
			.two-col .column {
				max-width: 100% !important;
			}
			.two-col img {
				width: 100% !important;
			}
		}
		@media screen and (min-width: 461px) {
			.three-col .column {
				max-width: 33.3% !important;
			}
			.two-col .column {
				max-width: 50% !important;
			}
			.sidebar .small {
				max-width: 16% !important;
			}
			.sidebar .large {
				max-width: 84% !important;
			}
		}
	</style>
</head>

<body style="margin:0;padding:0;word-spacing:normal;background-color:#ffffff;">
	<div style="display: none !important; mso-hide:all; font-size:0; max-height:0; line-height:0; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
		#preheader#
	</div>
	
	<div role="article" aria-roledescription="email" lang="en" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ffffff;">
		<table role="presentation" style="width:100%;border:0;border-spacing:0;">
			<tr>
				<td align="center">
					<!--[if mso]>
          <table role="presentation" align="center" style="width:800px;">
          <tr>
          <td>
          <![endif]-->
					<div class="outer" style="max-width:800px;margin-top:-2px;">

						#here_comes_the_message#						

						<div class="spacer" style="line-height:24px;height:24px;mso-line-height-rule:exactly;">&nbsp;</div>

						<table role="presentation" style="width:100%;border:0;border-spacing:0;background:#dfdfdf;">
							<tr>
								<td style="background-image: url(https://www.julianhopp.de/img/julian-mailing-footer-01.jpg); background-size:cover;height:152px;">
									<table style="width:100%;border:0;border-spacing:0;">
										<tbody>
											<tr>
												<td style="padding:30px 0 0;text-align:center;width:100%">
													<a class="circle" href="'.$morpheus["url"].'jh.php?uid=#uid#&nl=#nlid#&el=https://www.instagram.com/psychosophische.lebenspraxis/"><img src="'.$dir.'mthumb.php?uid=#uid#&nl=#nlid#&src=img/icon-instagram.png" alt="instagram" width="60"></a>
													<a class="circle" href="'.$morpheus["url"].'jh.php?uid=#uid#&nl=#nlid#&el=https://www.facebook.com/Julian.Hopp.Lebenspraxis/"><img src="'.$dir.'img/icon-facebook.png" alt="facebook" width="60"></a>
													<a class="circle" href="'.$morpheus["url"].'jh.php?uid=#uid#&nl=#nlid#&el=https://www.linkedin.com/in/julian-hopp-5769021b7/"><img src="'.$dir.'img/icon-linkedin.png" alt="linkedin" width="60"></a>
												</td>
											</tr>											
										</tbody>
									</table>
								</td>
							</tr>
						</table>		
						<table role="presentation" style="width:100%;border:0;border-spacing:0;">
							<tr>
								<td style="padding:10px;text-align:center;width:100%">
									<p style="margin:0;font-family:Verdana,Helvetica,Arial;font-size:13px;line-height:24px;">
										<a href="'.$morpheus["url"].'jh.php?uid=#uid#&nl=#nlid#&il='.$morpheus["url"].'" style="text-decoration:none;color:#000000;">Julian Ivo Hopp – www.julianhopp.de</a> | 
										<a href="'.$morpheus["url"].'jh.php?uid=#uid#&nl=#nlid#&il='.$morpheus["url"].$navID[16].'" style="text-decoration:none;color:#000000;">Abmeldung Newsletter</a><br/>
										<a href="'.$morpheus["url"].'jh.php?uid=#uid#&nl=#nlid#&il='.$morpheus["url"].$navID[6].'" style="text-decoration:none;color:#000000;">Impressum</a> | 
										<a href="'.$morpheus["url"].'jh.php?uid=#uid#&nl=#nlid#&il='.$morpheus["url"].$navID[7].'" style="text-decoration:none;color:#000000;">Datenschutz</a>
									</p>
								</td>
							</tr>
						</table>		


					</div>
					<!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
				</td>
			</tr>
		</table>
	</div>
</body>

</html>';