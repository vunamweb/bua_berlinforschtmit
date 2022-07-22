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
		h1 {margin-top:0;margin-bottom:12px;font-family:filson-soft,Courier new,Courier,serif;font-size:20px;line-height:28px;font-weight:bold;}
		h2,h3 {margin-top:0;margin-bottom:12px;font-family:filson-soft,Courier new,Courier,serif;font-size:16px;line-height:28px;font-weight:bold;}
		p {margin:0;font-family:filson-soft,Courier new,Courier,serif;font-size:13px;line-height:24px;}
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
	
	<div role="article" aria-roledescription="email" lang="en" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#f7f3f0;">
		<table role="presentation" style="width:100%;border:0;border-spacing:0;">
			<tr>
				<td align="center">
					<!--[if mso]>
          <table role="presentation" align="center" style="width:660px;">
          <tr>
          <td style="padding:20px 0;">
          <![endif]-->
					<div class="outer" style="width:96%;max-width:660px;margin:20px auto;">

						
						#here_comes_the_message#
						



						<div class="spacer" style="line-height:24px;height:24px;mso-line-height-rule:exactly;">&nbsp;</div>


						<table role="presentation" style="width:100%;border:0;border-spacing:0;background:#dfdfdf;">
							<tr>
								<td valign="middle" class="hero" style="background-image: url(https://www.julianhopp.de/img/julian-mailing-footer-01.jpg); background-size: cover; height: 152px;">
									<table>
										<tbody><tr>
											<td>
												<div class="text" style="padding: 0 3em; text-align: center;">
													<p style="margin:0;font-family:filson-soft,Courier new,Courier,serif;font-size:13px;line-height:24px;">
														'.$morpheus["client"].'<br/>
														'.nl2br($morpheus["subline"]).'<br/><br/>										
														tel• '.$morpheus["mobile"].'<br/>
														mail• '.$morpheus["email"].'<br/>
														web• <a href="https://www.julianhopp.de">https://www.julianhopp.de</a><br/>
													</p>
												</div>
											</td>
										</tr></tbody>
									</table>
								</td>
							</tr>
						</table>
						
						
						<div class="spacer" style="line-height:24px;height:24px;mso-line-height-rule:exactly;">&nbsp;</div>

						<table role="presentation" style="width:100%;border:0;border-spacing:0;">
							<tr>
								<td style="padding:10px;text-align:center;">
									
									<p style="margin:0;font-family:filson-soft,Courier new,Courier,serif;font-size:13px;line-height:24px;">
										<a href="'.$morpheus["url"].'" style="text-decoration:none;color:#000000;">'.$navID[1].'Impressum</a> | <a href="'.$morpheus["url"].'" style="text-decoration:none;color:#000000;">Datenschutz</a> | <a href="'.$morpheus["url"].'" style="text-decoration:none;color:#000000;">Abmeldung Newsletter</a>
									</p>
								</td>
							</tr>
						</table>


						<div class="spacer" style="line-height:40px;height:40px;mso-line-height-rule:exactly;">&nbsp;</div>

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