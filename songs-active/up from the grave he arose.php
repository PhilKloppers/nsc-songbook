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
Low in the grave He lay,<br/>
Jesus my Saviour<br/>
Waiting the coming day,<br/>
Jesus my Lord!</p>
							<h5>Chorus</h5>
							<p>
Up from the grave He arose,<br/>
With a mighty triumph o’er His foes<br/>
He arose a victor<br/>
From the dark domain<br/>
And He lives forever<br/>
With his saints to reign<br/>
He arose, He arose,<br/>
Hallelujah, Christ arose!</p>
							<h5>Verse 2</h5>
							<p>
Vainly they watch His bed,<br/>
Jesus my Saviour<br/>
Vainly they seal the dead,<br/>
Jesus my Lord!</p>
							<h5>Verse 3</h5>
							<p>
Death cannot keep its prey,<br/>
Jesus my Saviour<br/>
He tore the bars away,<br/>
Jesus my Lord!
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
