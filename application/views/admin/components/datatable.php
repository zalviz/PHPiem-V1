			
			<?php if( isset($description) ) { ?><p class="text-muted font-13 m-b-30"><?= @$description; ?></p><? } ?>
			<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
				<thead>
					<tr>
					<?php foreach ( $theads as $th ) { ?>
						<th>$th</th>
					<?php } ?>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $dtrows as $row ) { ?>
					<tr>
					<?php foreach ($row as $k => $col) { ?>
						<td>$col</td>
					<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
