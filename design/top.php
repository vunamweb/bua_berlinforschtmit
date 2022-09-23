<?php
	include("nogo/nav_".$lan.".inc");
	if($sn2_id) $nav = preg_replace(array("/hn".$hn_id."/", "/hn".$cid."/", "/s".$sn2_id."/", "/n".$sn2_id."/", "/n".$hn_id."/"), array("active", "active", "active", "active", "active"), $nav);
	else $nav = preg_replace(array("/hn".$hn_id."/", "/s".$cid."/", "/n".$hn_id."/"), array("active", "active", "active"), $nav);
?>

<header>
    <div class="navbar navbar-expand-lg bsnav bsnav-dark bsnav-sticky black sticked in">
        <div class="container">
                <a class="navbar-brand" href="<?php echo $dir.($lang==1 ? '':'en/'); ?>"><img src="<?php echo $dir; ?>images/userfiles/image/berliner-universitaet-alliance_NEU.svg" alt="" class="logo" width="110" name="berliner universitaet alliance"></a>
                <button class="navbar-toggler toggler-spring" name="navbar"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse justify-content-md-end">
                    <ul class="navbar-nav navbar-mobile mr-0">
						<li class="nav-item"><a class="nav-link" href="<?php echo $dir.($lang==1 ? '':'en/'); ?>"><i class="fa fa-home"></i></a></li>
<?php 
						echo $nav;
						echo '<li class="nav-item"><a href="'.$dir.$lan.'/'.$navID[$kontakt_id].'" class="nav-link profile"><i class="fa fa-envelope"></i></a></li>';

// VU: IF IS LOG IN, THEN SHOW OWN MENU
if($userIsLogIn == $checkLogSession) {
?>
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="log" data-toggle="dropdown">Admin</a>
								<ul class="dropdown-menu fade-up" aria-labelledby="log">
<?php 
						echo $nav_logged_in;
						echo '</ul></a></li>';
						echo '<li class="nav-item"><a href="'.$dir.$lan.'/'.$navID[$profile_id].'" class="nav-link profile"><i class="fa fa-user"></i></a></li>';
						echo '<li class="nav-item logout"><a href="'.$dir.'?logout=1" class="nav-link profile"><i class="fa fa-sign-out"></i></a></li>';
} 
// VU: IF IS NOT LOG IN, THEN SHOW LOGIN, REGISTER
else { ?>
						<li class="nav-item"><a href="<?php echo $dir.$lan.'/login'; ?>" class="nav-link"><i class="fa fa-sign-in"></i></a></li> 
						<!-- <li class="nav-item"><a href="<?php echo $dir.$lan.'/register'; ?>" class="nav-link"><?php echo textvorlage(35); ?></a></li> -->
<?php } ?>
                    </ul>
					<ul class="language">
						<!--<li class="lang"><a href="<?php echo $dir.($lan == "de" ? 'en/' : ''); ?>"><?php echo ($lan == "de" ? 'en' : 'de'); ?></a></li>-->
<?php if($userIsLogIn==$checkLogSession) { ?> 						
<?php } ?>
					</ul>					
                </div>
        </div>
    </div>
</header>
<div class="spacing"></div>

	