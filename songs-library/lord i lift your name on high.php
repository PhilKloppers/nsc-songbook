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
Lord I lift Your name on high<br/>
Lord, I love to sing Your praises<br/>
I’m so glad You’re in my life<br/>
I’m so glad You came to save us</p>
							<h5>Verse</h5>
							<p>
You came from heaven to earth<br/>
To show the way<br/>
From the earth to the cross<br/>
My debt to pay<br/>
From the cross to the grave<br/>
From the grave to the sky<br/>
Lord I lift Your name on high
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
