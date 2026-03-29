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
						<h5>Verse 1</h5>
							<p>
The splendour of the King<br/>
Clothed in majesty<br/>
Let all the earth rejoice<br/>
All the earth rejoice<br/>
He wraps Himself in light <br/>
And darkness tries to hide<br/>
And trembles at His voice<br/>
And trembles at His voice
							</p>
							<h5>Chorus</h5>
							<p>
How great is our God<br/>
Sing with me<br/>
How great is our God<br/>
And all will see how great<br/>
How great is our God
							</p>
							<h5>Verse 2</h5>
							<p>
Age to age He stands<br/>
And time is in His hands<br/>
Beginning and the End<br/>
Beginning and the End<br/>
The Godhead three in one<br/>
Father Spirit Son<br/>
The Lion and the Lamb<br/>
The Lion and the Lamb
							</p>
							<h5>Bridge</h5>
							<p>
Name above all names<br/>
Worthy of all praise<br/>
My heart will sing<br/>
How great is our God
							</p>
							<h5>Chorus (AFR)</h5>
							<p>
Hoe groot is ons God<br/>
Ons sing hoe groot is ons God<br/>
Almal sal sien<br/>
Hoe groot is ons God
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
