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
							<h5>Verse 1</h5>
							<p>
Alive, Alive, Alive forever more<br/>
My Jesus is alive,<br/>
Alive for ever more<br/>
Alive, Alive, Alive forever more<br/>
My Jesus is alive!</p>
							<h5>Chorus</h5>
							<p>
Sing Hallelujah, sing Hallelujah<br/>
My Jesus is alive, alive forever more<br/>
Sing Hallelujah, sing Hallelujah<br/>
My Jesus is alive!
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
