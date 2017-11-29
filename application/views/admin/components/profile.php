									
									<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
										<div class="profile_img">
											<div id="crop-avatar">
												<!-- Current avatar -->
												<img style="border:1px solid #eee;" class="img-responsive avatar-view" src="<?= (isset($qrcodeimg) || $qrcodeimg != '') ? $qrcodeimg :site_url('assets/images/no-avatar.jpg'); ?>" alt="Avatar" title="Change the avatar">
											</div>
										</div>
										<h3><?= @$fullname; ?></h3>

										<ul class="list-unstyled user_data">
											<li><i class="fa fa-qrcode user-profile-icon"></i> <?= @$ticket_code; ?></li>
											<li><i class="fa fa-envelope user-profile-icon"></i> <?= (isset($email)) ? @$email : 'No email'; ?></li>
											<li><i class="fa fa-phone user-profile-icon"></i> <?= @$handphone; ?></li>
											<li><i class="fa fa-map-marker user-profile-icon"></i> <?=@$city; ?></li>
											<li><i class="fa fa-briefcase user-profile-icon"></i> <?=@$kategori; ?></li>
											<li class="m-top-xs">
												<i class="fa fa-external-link user-profile-icon"></i>
												<a href="<?=site_url(); ?>" target="_blank"><?= str_replace('/', '', str_replace('http://', '', site_url())) ; ?></a>
											</li>
										</ul>
										<br />
									</div>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<p>Change status (Current Status: <b><?= $order_status; ?></b>)</p>
										<hr />

										<?php $activekey = count($statusorders) - 1; foreach($statusorders as $k => $v): ?>
										<?php if($k != 0 && $order_status == $statusorders[$k-1]['label'] ): $activekey = $k; ?>
										<a class="btn btn-primary" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?sec=<?=$v['short']; ?>" title="<?=$v['desc']; ?>">
											<i class="fa fa-<?=$v['icon']; ?>"></i> <?=$v['label']; ?>
										</a>
										<?php else: ?>
										<?php $btnalert = ( $activekey >= $k ) ? 'success' : 'default'; ?>
										<button class="btn btn-<?=$btnalert; ?>" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>sec=<?=$v['short']; ?>" title="<?=$v['desc']; ?>"  disabled>
											<i class="fa fa-<?=$v['icon']; ?>"></i> <?=$v['label']; ?>
										</button>
										<?php endif; ?>
										<?php endforeach; ?>
										<br />
										<br />
										<br />
										<div class="" role="tabpanel" data-example-id="togglable-tabs">
											<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
												<li role="presentation" class="active">
													<a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Activity</a>
												</li>
												<li role="presentation" class="">
													<a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Send Email</a>
												</li>
												<li role="presentation" class="">
													<a href="#tab_content3" role="tab" id="ticket-tab" data-toggle="tab" aria-expanded="false">Ticket</a>
												</li>
											</ul>
											<div id="myTabContent" class="tab-content">
												<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
													<ul class="list-unstyled timeline">
														<?php if ($order_pickup != null): ?>
														<li>
															<div class="block">
																<div class="tags">
																	<a href="" class="tag">
																		<span>Venue</span>
																	</a>
																</div>
																<div class="block_content">
																	<h2 class="title">
																		<a>Has been attend to event venue!</a>
																	</h2>
																	<div class="byline">
																		<span><?= $order_pickup; ?></span>
																	</div>
																	<p class="excerpt"></p>
																</div>
															</div>
														</li>
														<?php endif; ?>
														<?php if ($order_paid != null): ?>
														<li>
															<div class="block">
																<div class="tags">
																	<a href="" class="tag">
																		<span>Payment</span>
																	</a>
																</div>
																<div class="block_content">
																	<h2 class="title">
																		<a>Payment is done!</a>
																	</h2>
																	<div class="byline">
																		<span><?= $order_paid; ?></span>
																	</div>
																	<p class="excerpt"></p>
																</div>
															</div>
														</li>
														<?php endif; ?>
														<?php if ($order_date != null): ?>
														<li>
															<div class="block">
																<div class="tags">
																	<a href="" class="tag">
																		<span>Waiting</span>
																	</a>
																</div>
																<div class="block_content">
																	<h2 class="title">
																		<a>Waiting for payment</a>
																	</h2>
																	<div class="byline">
																		<span><?= $order_date; ?></span>
																	</div>
																	<p class="excerpt"></p>
																</div>
															</div>
														</li>
														<li>
															<div class="block">
																<div class="tags">
																	<a href="" class="tag">
																		<span>Register</span>
																	</a>
																</div>
																<div class="block_content">
																	<h2 class="title">
																		<a>Register Done!</a>
																	</h2>
																	<div class="byline">
																		<span><?= $order_date; ?></span>
																	</div>
																	<p class="excerpt"></p>
																</div>
															</div>
														</li>
														<?php endif; ?>
													</ul>
												</div>
												<div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">
													<p>Email confirmation</p>
													<?php if ($this->session->flashdata('info')): ?>
														<div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('info'); ?></div>
													<?php endif ?>
													
													<hr />
													<a class="btn btn-app" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?sec=registration" title="send email register confirmation">
														<i class="fa fa-bookmark"></i> Register
													</a>
													<a class="btn btn-app" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?sec=payment-accepted" title="send payment accepted confirmation">
														<i class="fa fa-money"></i> Payment
													</a>
													<a class="btn btn-app" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?sec=sendticket" title="send ticket">
														<i class="fa fa-qrcode"></i> Ticket
													</a>
													<a class="btn btn-app" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?sec=payment-failed" title="payment failed">
														<i class="fa fa-money"></i> Failed
													</a>
													<br />
													<br />
													<br />
													<p>Email reminder</p>
													<hr />
													<a class="btn btn-app btn-primary" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?sec=payment-reminder" title="send email reminder to pay">
														<i class="fa fa-money"></i> Payment
													</a>
													<a class="btn btn-app" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?sec=venue-reminder" title="send email reminder to go to venue">
														<i class="fa fa-university"></i> Venue
													</a>
												</div>
												<div role="tabpanel" class="tab-pane fade in" id="tab_content3" aria-labelledby="home-tab">
													<?php if ( $order_paid == null ){ ?><p>Cannot download ticket before make payment complete! please to make payment done!</p><?php } else { ?><a class="btn btn-app" href="<?= str_replace('/view/', '/update/', $_SERVER['REQUEST_URI']); ?>?download-ticket=<?=$ticket_code; ?>"><i class="fa fa-download"></i>Download</a> <p>Download Tickets</p><?php } ?>
												</div>
											</div>
										</div>
									</div>
