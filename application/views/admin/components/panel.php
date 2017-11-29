				
						<div class="col-md-<?= (isset($panelgrid)) ? @$grid : '12'; ?> col-sm-<?= (isset($panelgrid)) ? @$panelgrid : '12'; ?> col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2><?=$label; ?></h2>
									<?php if ( isset($toolbox) && @$toolbox == '' ): ?>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
											<ul class="dropdown-menu" role="menu">
												<?php if ( @$panel_menu_item != null ) { foreach( @$panel_menu_item as $menu ) { ?>
												<li><a href="<?= $menu['url']; ?>"><?= $menu['label']; ?></a></li>
												<?php } } ?>
											</ul>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a></li>
									</ul>
									<?php endif; ?>

									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<?=$content; ?>
									
								</div>
							</div>
						</div>