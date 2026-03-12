<?php
	$filename = basename(__FILE__, '.php');
	$identifier = str_replace(' ', '_', $filename);
?>
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-<?php echo $identifier; ?>">
						<button
							class="accordion-button collapsed"
							type="button"
							data-mdb-toggle="collapse"
							data-mdb-target="#collapse-<?php echo $identifier; ?>"
							aria-expanded="false"
							aria-controls="collapse-<?php echo $identifier; ?>"
						>
							<strong><?php echo strtoupper($filename); ?></strong>
						</button>
					</h2>
					<div id="collapse-<?php echo $identifier; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $identifier; ?>" data-mdb-parent="#accordionExample">
						<div class="accordion-body">
						<!-------------------------->
						<!--Edit this section only-->
						<!-------------------------->
							<h5>Verse</h5>
							<p>
I know He rescued my soul,<br/>
His blood has covered my sin<br/>
I believe . . .  I believe<br/>
My shame He’s taken away,<br/>
My pain is healed in His name<br/>
I believe . . .  I believe<br/>
I’ll raise a banner<br/>
My Lord has conquered the grave</p>
							<h5>Chorus</h5>
							<p>
My Redeemer lives!  My Redeemer lives!<br/>
My Redeemer lives!  My Redeemer lives!</p>
							<h5>Bridge</h5>
							<p>
You lift my burdens, I’ll rise with you,<br/>
I’m dancing on this mountain top<br/>
To see Your Kingdom come 
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
