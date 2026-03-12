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
I stand amazed in the presence<br/>
Of Jesus the Nazarene<br/>
And wonder how he could love me<br/>
A sinner condemned unclean</p>
							<h5>Chorus 1</h5>
							<p>
How marvellous, how wonderful<br/>
And my song shall ever be<br/>
How marvellous, how wonderful<br/>
Is my Saviour’s love for me.</p>
							<h5>Chorus 2</h5>
							<p>
Then sings my soul,<br/>
My Saviour, God, to Thee<br/>
How great Thou art,<br/>
How great Thou art!</p>
							<h5>Chorus 3</h5>
							<p>
Dan moet ek juig,<br/>
Ny Redder en my God<br/>
How groot is U, how groot is U!<br/>
Want deur die hele skepping<br/>
Klink dit saam<br/>
Hoe heerlik Heer! U grote Naam!
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
