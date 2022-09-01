<style>
	
</style>


<div class="container-full start__div" style="height:100px"></div>

<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="accordion" id="BUAlog">
		    	<div class="accordion-item">
					<h3 class="accordion-header" id="BUAlogin">
			  	  		<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLog" aria-expanded="true" aria-controls="collapseLog">
 <?php echo textvorlage(22); ?>
			  			</button>
					</h3>
					<div id="collapseLog" class="accordion-collapse collapse show" aria-labelledby="BUAlogin" data-bs-parent="#BUAlog">
						<div class="accordion-body">
							<div class="row">
								<div class="col-12 col-md-6 offset-md-3">
									<p class="mb3"><?php echo textvorlage(23); ?></p>
									<?php echo $output_login; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="accordion-item">
  			  		<h3 class="accordion-header" id="BUAregister">
			  			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReg" aria-expanded="false" aria-controls="collapseReg">
						  <?php echo textvorlage(35); ?>
			  			</button>
					</h3>
					<div id="collapseReg" class="accordion-collapse collapse" aria-labelledby="BUAregister" data-bs-parent="#BUAlog">
						<div class="accordion-body">
<?php include('page/register.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-12 mt-4 mb-4">&nbsp;</div>
	</div>
</div>

<div class="clearfix endFrame"></div>

