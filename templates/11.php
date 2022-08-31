<?php
/* pixel-dusche.de */

global $emotional, $headerImg;
global $uniqueID, $fileID, $lastUsedTemplateID, $anzahlOffenerDIV, $templateIsClosed;

$fileID = basename(__FILE__, '.php');
$lastUsedTemplateID = $fileID;

$edit_mode_class = 'container_edit ';

if($lastUsedTemplateID && $lastUsedTemplateID != $fileID && !$templateIsClosed) {
	for($i=1; $i<=$anzahlOffenerDIV; $i++) $template .= '					</div>
';

	$template .= '
				</section>
';
	$templateIsClosed=1;
}


$template = '

<div class="carousel slide" data-bs-ride="carousel" id="carouselExampleIndicators">
	<div class="carousel-indicators">
		<button aria-label="Slide 1" class="active" data-bs-slide-to="0" data-bs-target="#carouselExampleIndicators" type="button"></button> <button aria-label="Slide 2" data-bs-slide-to="1" data-bs-target="#carouselExampleIndicators" type="button"></button> <button aria-label="Slide 3" data-bs-slide-to="2" data-bs-target="#carouselExampleIndicators" type="button"></button>
	</div>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img alt="..." class="d-block w-100" src="https://i.postimg.cc/LsTXqTNZ/1.jpg">
			<div class="carousel-caption">
				<h5 class="animated bounceInRight" style="animation-delay: 1s">Web Design</h5>
				<p class="animated bounceInLeft d-none d-md-block" style="animation-delay: 2s">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
				<p class="animated bounceInRight" style="animation-delay: 3s"><a href="#">Learn More</a></p>
			</div>
		</div>
		<div class="carousel-item">
			<img alt="..." class="d-block w-100" src="https://i.postimg.cc/C1rx7Kyh/2.jpg">
			<div class="carousel-caption">
				<h5 class="animated bounceInRight" style="animation-delay: 1s">Graphics Design</h5>
				<p class="animated bounceInLeft d-none d-md-block" style="animation-delay: 2s">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
				<p class="animated bounceInRight" style="animation-delay: 3s"><a href="#">Learn More</a></p>
			</div>
		</div>
		<div class="carousel-item">
			<img alt="..." class="d-block w-100" src="https://i.postimg.cc/c4nL7ZFW/3.jpg">
			<div class="carousel-caption">
				<h5 class="animated bounceInRight" style="animation-delay: 1s">Photography</h5>
				<p class="animated bounceInLeft d-none d-md-block" style="animation-delay: 2s">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
				<p class="animated bounceInRight" style="animation-delay: 3s"><a href="#">Learn More</a></p>
			</div>
		</div>
	</div><button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleIndicators" type="button"><span aria-hidden="true" class="carousel-control-prev-icon"></span> <span class="visually-hidden">Previous</span></button> <button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleIndicators" type="button"><span aria-hidden="true" class="carousel-control-next-icon"></span> <span class="visually-hidden">Next</span></button>
</div>

#cont#
            <section class="'.$edit_mode_class.'sectionbanner">
                <ul>
					'.$headerImg.'                    
                </ul>
			'.edit_bar($content_id,"edit_class").'
            </section>
';

