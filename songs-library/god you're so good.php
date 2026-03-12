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
                        <h5>Verse 1</h5><p>
Amazing love that welcomes me<br/>
The kindness of mercy<br/>
That bought with blood wholeheartedly<br/>
My soul undeserving</p>
<h5>Chorus</h5><p>
God You're so good<br/>
God You're so good<br/>
God You're so good<br/>
You're so good to me</p>
<h5>Verse 2</h5><p>
Behold the cross age to age<br/>
And hour by hour<br/>
The dead are raised the sinner saved<br/>
The work of Your power</p>
<h5>Bridge</h5><p>
I am blessed I am called<br/>
I am healed I am whole<br/>
I am saved in Jesus' name<br/>
Highly favored anointed<br/>
Filled with Your pow'r<br/>
For the glory of Jesus' name</p>
<h5>Verse 3</h5><p>
And should this life bring suffering<br/>
Lord I will remember<br/>
What Calvary has bought for me<br/>
Both now and forever</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
