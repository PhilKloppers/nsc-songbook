<?php
	$filename = basename(__FILE__, '.php');
	$identifier = str_replace(array( '\'', '"', ',' , ';', '<', '>', ' '), '_', $filename);
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
Alleluia, Alleluia<br/>
For the Lord God Almighty reigns<br/>
Alleluia, Alleluia<br/>
For the Lord God Almighty reigns
							</p>
							<h5>Chorus 1</h5>
							<p>
Alleluia, Holy, Holy<br/>
Are You Lord God Almighty<br/>
Worthy is the Lamb<br/>
Worthy is the Lamb<br/>
							</p>
							<h5>Chorus 2</h5>
							<p>
You are Holy, Holy<br/>
Are You Lord God Almighty<br/>
Worthy is the Lamb<br/>
Worthy is the Lamb<br/>
Amen							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
