<?php
	/**
	 * Add action to embeded the panel in to dashboard.
	 *
	 * @package    CFPlugin
	 * @since      CFPlugin 0.1
	 */

	/**
	 * Add action to embedded the panel in to dashboard.
	 *
	 * @since CFPlugin 0.1
	 */
	add_action( 'admin_menu', 'add_admin_panel' );
	function add_admin_panel() {
		$page = add_menu_page( WpTextillate::$plugin_name, WpTextillate::$plugin_name, 'administrator', WpTextillate::$slug_name, 'create_admin_panel' );

		add_action( 'admin_print_scripts-' . $page, 'register_admin_panel_scripts' );
		add_action( 'admin_print_styles-' . $page, 'register_admin_panel_styles' );
	}

	/**
	 * Start creating the admin panel ( by calling function to create menu and elements ).
	 *
	 * @since CFPlugin 0.1
	 */
	function create_admin_panel() {
		?>

		<div ng-app="cfplugin_textillate">
		<form name="form_edit_options" ng-controller="optionsObj.optionsController as optionsController">
		<div class="cf-navbar navbar navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#" ng-click="optionsController.menuSelectAction('General')"><?php _e( 'WP Textillate', WpTextillate::$i18n_prefix ); ?></a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li ng-class="{'active': optionsController.show == 'General'}">
							<a href="#general" ng-click="optionsController.menuSelectAction('General')"><?php _e( 'General', WpTextillate::$i18n_prefix ); ?></a>
						</li>
						<li ng-class="{'active': optionsController.show == 'Edit Textillate'}" ng-show="optionsController.show == 'Edit Textillate'">
							<a href="#edit" ng-click="optionsController.menuSelectAction('Edit Textillate')"><?php _e( 'Edit Textillate', WpTextillate::$i18n_prefix ); ?>:
								<strong class="text-success">{{ textillate.name }}</strong></a>
						</li>
					</ul>
                    <div class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" ng-model="new.name" placeholder="Enter name of new textillate">
                        </div>
                        <button type="submit" class="btn btn-default" ng-click="optionsController.createNew(new)">Create</button>
                    </div>
					<button type="button" class="btn cf-btn btn-success" ng-click="optionsController.save()" ng-show="optionsController.show == 'Edit Textillate'"><?php _e( 'Save Changes', WpTextillate::$i18n_prefix ); ?></button>
				</div>
			</div>
		</div>

		<div class="container">
		<div class="row cf-row">
		<div class="col-xs-12 col-sm-12">
		<div class="row">

		<div class="col-sm-8 col-lg-8">
			<!-- START General Page -->
			<div ng-show="optionsController.show == 'General'">
				<div class="cf-panel cf-panel-default panel panel-default" ng-repeat="textillate in options.textillates">
					<div class="panel-heading">
						<i class="fa fa-bar-chart-o fa-fw"></i>
                        <span class="cf-name-textillate" ng-click="optionsController.editTextillate(textillate)">{{textillate.name | shortString }}</span>
						<div class="pull-right">

							<div class="btn-group">

								<!-- Button trigger modal -->
								<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#{{ textillate.id }}">
									Shortcode
								</button>
								<!-- Modal -->
								<div class="modal fade" id="{{ textillate.id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="myModalLabel">{{ textillate.name }} - Shortcode</h4>
											</div>
											<div class="modal-body">
												<div class="well">
													<p><code>Shortcode</code></p>
													[wptextillate id="{{ textillate.id }}"]
                                                    <br />
                                                    <small>Copy and paste this shortcode into a page or post to display the ticker within the post content.</small>
												</div>
                                                <div class="well">
                                                    <p><code>Direct Function</code></p>
                                                    {{ "\<\?php if ( class_exists(\'WpTextillate\' ) ) { WpTextillate::show_textillates( " }} {{ textillate.id }} {{ "); } ?>" }}
                                                    <br />
                                                    <small>Copy and paste this code directly into one of your theme files to display the ticker any where you want on your site.</small>
                                                </div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
									Actions
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li>
										<a href="#" ng-click="optionsController.editTextillate(textillate)">Edit</a>
									</li>
									<li>
										<a href="#" class="cf-delete" data-toggle="modal" data-target="#delete-{{ textillate.id }}">Delete</a>
									</li>
								</ul>
							</div>

                            <!-- Modal -->
                            <div class="cf-modal-delete modal in" id="delete-{{ textillate.id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">You Sure Delete:
                                                <strong>{{ textillate.name }}</strong></h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm ng-scope" ng-click="optionsController.deleteTextillate(textillate)">Ok</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
						</div>
					</div>

					<!--<div class="panel-body"></div>-->
				</div>
			</div>
			<!-- END General Page -->

			<!-- START Edit Textillate Page -->
			<div ng-show="optionsController.show == 'Edit Textillate'">
				<div class="well cf-show-lines">
					<div id="tlt" ng-show="textillate.lines != ''">
						<ul class="texts">
							<li ng-repeat="showLine in textillate.lines"
								data-in-effect="{{ showLine.inEffect }}"
								data-in-sync="{{ showLine.inAnimation == 'sync' }}"
								data-in-sequence="{{ showLine.inAnimation == 'sequence' }}"
								data-in-reverse="{{ showLine.inAnimation == 'reverse' }}"
								data-in-shuffle="{{ showLine.inAnimation == 'shuffle' }}"
								data-out-effect="{{ showLine.outEffect }}"
								data-out-sync="{{ showLine.outAnimation == 'sync' }}"
								data-out-sequence="{{ showLine.outAnimation == 'sequence' }}"
								data-out-reverse="{{ showLine.outAnimation == 'reverse' }}"
								data-out-shuffle="{{ showLine.outAnimation == 'shuffle' }}"> {{ showLine.text }}
							</li>
						</ul>
					</div>
				</div>

				<div class="cf-panel panel panel-default" ng-repeat="line in textillate.lines">
					<div class="panel-body">
						<label>Text</label>
						<span class="glyphicon glyphicon-remove pull-right text-danger" data-toggle="modal" data-target="#delete-text{{ line.id }}"></span>

                        <!-- Modal -->
                        <div class="cf-modal-delete modal in" id="delete-text{{ line.id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">You Sure Delete</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm ng-scope" ng-click="optionsController.deleteLineOfTextillate(line)">Ok</button>
                                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <textarea class="form-control cf-line-text" rows="3" ng-change="optionsController.changeEffectOrAnimation()" ng-model="line.text" required></textarea>

						<br />
						<div class="col-md-6">
							<label>In Animation</label>

							<br />
							<select chosen ng-change="optionsController.changeEffectOrAnimation()"
									ng-model="line.inEffect"
									ng-options="s for s in listEffects"> </select>

							<select chosen ng-change="optionsController.changeEffectOrAnimation()"
									ng-model="line.inAnimation"
									ng-options="s for s in secondAnimations"> </select>
						</div>

						<div class="col-md-6">
							<label>Out Animation</label>

							<br />
							<select chosen ng-change="optionsController.changeEffectOrAnimation()"
									ng-model="line.outEffect"
									ng-options="s for s in listEffects"> </select>

							<select chosen ng-change="optionsController.changeEffectOrAnimation()"
									ng-model="line.outAnimation"
									ng-options="s for s in secondAnimations"> </select>
						</div>
					</div>
				</div>

				<div class="panel-body cf-panel-body-add-text">
					<div class="form-group">
						<form>
							<div class="panel panel-default">
								<div class="panel-heading">
									New Text
								</div>
								<div class="panel-body">
									<div class="form-group">
										<textarea class="form-control" rows="3" ng-model="newText.text" placeholder="Introduced new text here..." required></textarea>

										<br />
										<div class="col-md-6">
											<label>In Animation</label>

											<br />
											<select chosen
													ng-model="newText.inEffect"
													ng-options="s for s in listEffects"> </select>

											<select chosen
													ng-model="newText.inAnimation"
													ng-options="s for s in secondAnimations"> </select>
										</div>

										<div class="col-md-6">
											<label>Out Animation</label>

											<br />
											<select chosen
													ng-model="newText.outEffect"
													ng-options="s for s in listEffects"> </select>

											<select chosen
													ng-model="newText.outAnimation"
													ng-options="s for s in secondAnimations"> </select>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<button type="button" class="btn btn-primary btn-sm" ng-click="optionsController.addText(newText)">Add Text</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
			<!-- END Edit Textillate Page -->
		</div>

		<div class="col-sm-4 col-lg-4">
			<div ng-show="optionsController.show == 'Edit Textillate'">
				<div class="panel panel-default">
					<div class="panel-heading">
						Setting
					</div>
					<div class="panel-body">
						<form role="form">
							<div class="form-group">
								<label>Loop?</label>
								<br />
								<input type="checkbox" class="form-control" ng-change="optionsController.changeEffectOrAnimation()" ng-model="textillate.setting.loop">

								<p class="help-block">Enable looping.</p>
							</div>

							<div class="form-group">
								<label>Automatically start animating?</label>
								<br />
								<input type="checkbox" class="form-control" ng-change="optionsController.changeEffectOrAnimation()" ng-model="textillate.setting.autoStart">

								<p class="help-block">Set whether or not to automatically start animating.</p>
							</div>

							<div class="form-group">
								<label>Auto Content in Parent Tag?</label>
								<br />
								<input type="checkbox" class="form-control" ng-change="optionsController.changeEffectOrAnimation()" ng-model="textillate.setting.autoContent">

								<p class="help-block">Content the effect in box of parent tag element.</p>
							</div>

							<div class="form-group">
								<label>Time transitions</label>
								<br />
								<input type="number" class="cf-quarter-wide" ng-change="optionsController.changeEffectOrAnimation()" ng-model="textillate.setting.timeTransition"> <small>Seconds</small>
							</div>

							<div class="form-group">
								<label>Minimum display time</label>
								<br />
								<input type="number" class="cf-quarter-wide" ng-change="optionsController.changeEffectOrAnimation()" ng-model="textillate.setting.minDisplayTime"> <small>Mili Seconds</small>

								<p class="help-block">Sets the minimum display time for each text before it is replaced.</p>
							</div>

							<div class="form-group">
								<label>Initial delay</label>
								<br />
								<input type="number" class="cf-quarter-wide" ng-change="optionsController.changeEffectOrAnimation()" ng-model="textillate.setting.initialDelay"> <small>Mili Seconds</small>

								<p class="help-block">Sets the initial delay before starting the animation.</p>
							</div>
						</form>
					</div>
				</div>
			</div>

            <div ng-show="optionsController.show == 'General'">

            </div>

			<!--<div class="panel panel-default">
				<div class="panel-heading">
					Create New
				</div>
				<div class="panel-body">
					<form role="form">
						<div class="form-group">
							<input type="text" class="form-control" ng-model="new.name" placeholder="Enter name of new textillate" required>
						</div>
						<button type="submit" class="btn btn-default" ng-click="optionsController.createNew(new)">Create</button>
					</form>
				</div>
			</div>-->
		</div>
		</div>
		</div>
		</div>
		</div>
		</form>
		</div>

	<?php
	}