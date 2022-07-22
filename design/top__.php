<?php
	include("nogo/nav_".$lan.".inc");
	// if($sn2_id) $nav = preg_replace(array("/n".$hn_id."n/", "/s".$cid."/", "/s".$sn2_id."/", "/data-scroll".$cid."/", "/".str_replace('/','\/',$dir.$navID[$cid])."/"), array("active", "active", "active", "data-scroll", ""), $nav);
	$nav = preg_replace(array("/n".$hn_id."n/", "/s".$cid."/", "/data-scroll".$cid."/"), array("active", "active", "active", "data-scroll"), $nav);

?>

<header>
    <nav class="navbar navbar-expand-xl bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $dir; ?>"><img src="<?php echo $dir; ?>images/Logo_Myriam_Rieger.svg" alt="" class="img-fluid" width="45"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto">
<?php if($userIsLogIn) { ?> 
                    <?php echo $nav; ?>
<?php } ?>			
					<li class="lang"><a href="<?php echo $dir.($lan == "de" ? 'en/' : ''); ?>"><?php echo ($lan == "de" ? 'en' : 'de'); ?></a></li>
                </ul>
            </div>

        </div>
    </nav>
</header>

<main id="main" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
	
