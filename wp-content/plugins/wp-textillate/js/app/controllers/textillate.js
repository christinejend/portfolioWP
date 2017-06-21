/**
 * Controllers to working with options theme.
 */
'use strict';

/**
 * Object Options.
 * @type {{}}
 */
var optionsObj = {

  /**
   * Controller Options Index: Show index options.
   *
   * @param $scope
   * @param $rootScope
   * @param Wp
   */
  optionsController: function ($scope, $rootScope, Wp) {
    var $this = this;

    // Show (true/false) page front of plugin.
    $this.show = 'General';

    // Data init. Show this if not exist options in DB.
    $scope.options = [];

    // Only one textillate.
    $scope.textillate = {};

    // Name by default of Textillate.
    $scope.new = {
      name: ''
    };

    // Initial setting of one textillate.
    var initSetting = {
      // Enable looping.
      loop          : true,
      timeTransition: 1,
      // Sets the minimum display time for each text before it is replaced.
      minDisplayTime: 2000,
      // Sets the initial delay before starting the animation
      // (note that depending on the in effect you may need to manually apply
      // visibility: hidden to the element before running this plugin)
      initialDelay  : 0,
      // Set whether or not to automatically start animating
      autoStart     : true,
      autoContent   : true
    };

    // ID textillate preview.
    var idTextillatePreview = '#tlt';

    /**
     * Start textillate.
     */
    $this.startTextillate = function () {
      jQuery(idTextillatePreview).textillate($scope.textillate.setting);
    };

    /**
     * Restart textillate.
     */
    $this.restartTextillate = function () {
      setTimeout(function () {
        jQuery(idTextillatePreview).textillate('stop');
        jQuery(idTextillatePreview).textillate('start');
        $this.startTextillate();
      }, 1000);
    };

    Wp.get_options(function (options) {
      if (options.textillates.length > 0) {
        $scope.options = options;
      }
    });

    /**
     * Reinitialise newText json values.
     *
     * @param json
     */
    $this.reinitialiseNewText = function (json) {
      if (json == null) {
        $scope.newText = {};
        $scope.newText.text = '';
        $scope.newText.inEffect = 'fadeInLeftBig';
        $scope.newText.inAnimation = 'sequence';
        $scope.newText.outEffect = 'fadeOutRightBig';
        $scope.newText.outAnimation = 'sequence';
      }
      else {
        $scope.newText = {};
        $scope.newText.text = '';
        $scope.newText.inEffect = json.inEffect;
        $scope.newText.inAnimation = json.inAnimation;
        $scope.newText.outEffect = json.outEffect;
        $scope.newText.outAnimation = json.outAnimation;
      }
    };

    /**
     * Select Menu when click in url.
     *
     * @param menu
     */
    $this.menuSelectAction = function (menu) {
      // Show option.
      $this.show = menu;
    };

    /**
     * Create new textillate.
     *
     * @param newCreate
     */
    $this.createNew = function (newCreate) {
      if (newCreate.name) {
        Wp.create_textillate(newCreate, function (options) {
          $scope.options = options;

          var length = $scope.options.textillates.length;
          $this.editTextillate($scope.options.textillates[length - 1]);
          $scope.new.name = '';
        });
      }
    };

    /**
     * Edit textillate.
     *
     * @param textillate
     */
    $this.editTextillate = function (textillate) {
      $this.show = 'Edit Textillate';

      textillate.lines = (textillate.lines) ? textillate.lines : [];
      textillate.setting = (textillate.setting) ? textillate.setting : initSetting;

      $this.reinitialiseNewText(null);

      $rootScope.listEffects = [];
      $rootScope.secondAnimations = [];

      var secondAnimations = 'sequence reverse sync shuffle';

      jQuery.each(secondAnimations.split(' '), function (i, value) {
        $rootScope.secondAnimations.push(value);
      });

      var animateClasses = 'flash bounce shake tada swing wobble pulse flip flipInX flipOutX flipInY flipOutY fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig fadeOut fadeOutUp fadeOutDown fadeOutLeft fadeOutRight fadeOutUpBig fadeOutDownBig fadeOutLeftBig fadeOutRightBig bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight bounceOut bounceOutDown bounceOutUp bounceOutLeft bounceOutRight rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut';

      jQuery.each(animateClasses.split(' '), function (i, value) {
        $rootScope.listEffects.push(value);
      });

      $scope.textillate = textillate;

      // Animtation with textillates plugin.
      $this.startTextillate();
    };

    /**
     * Add new text to textillate.
     *
     * @param newText
     */
    $this.addText = function (newText) {

      if (newText.text) {
        newText.id = generateId();
        $scope.textillate.lines.push(newText);

        $this.reinitialiseNewText(newText);
        $this.restartTextillate();

        $this.save();

        flashMessageLaunch({
          msg : 'To complete save press click in "Save Changes" button.',
          type: 'success'
        });
      }
      else {
        flashMessageLaunch({
          msg : 'The New Text field should be filled.',
          type: 'error'
        });
      }
    };

    /**
     * Change value on select option, to get a new effect.
     *
     * @param textillate
     */
    $this.changeEffectOrAnimation = function () {

      if (!$scope.$$phase) {
        $scope.$apply();
      }
      $this.restartTextillate();
    };

    /**
     * Delete textillate.
     *
     * @param textillate
     */
    $this.deleteTextillate = function (textillate) {

      Wp.delete_textillate(textillate, function (options) {
        $scope.options = options;
        flashMessageLaunch({
          msg : 'The textillate ' + textillate.name + ' is delete.',
          type: 'success'
        });
      });
    };

    /**
     * Delete line of textillate.
     *
     * @param line
     */
    $this.deleteLineOfTextillate = function (line) {

      line.idTextillateParent = $scope.textillate.id;

      Wp.delete_line_of_textillate(line, function (options) {
        $scope.options = options;

        var old_lines = $scope.textillate.lines;
        var new_lines = [];

        angular.forEach(old_lines, function (line_check) {
          if (line_check.id !== line.id) {
            new_lines.push(line_check);
          }
        });

        $scope.textillate.lines = new_lines;

        flashMessageLaunch({
          msg : 'The line is delete.',
          type: 'success'
        });
      });
    };

    /**
     * Save options.
     *
     * @param options
     */
    $this.save = function () {

      Wp.save($scope.options, function (options) {
        //$scope.options = options;
        flashMessageLaunch({
          msg : 'The textillate is save.',
          type: 'success'
        });
      });
    };
  }
};