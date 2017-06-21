/**
 * http://docs.angularjs.org/guide/directive
 * Directives are a way to teach HTML new tricks. During DOM compilation directives are matched against
 * the HTML and executed. This allows directives to register behavior, or transform the DOM.
 */

/**
 * Directive colorpicker.
 * <input colorpicker color="#3C8C09" ng-model="single.flavors.color_background" />
 * <input colorpicker ng-model="single.flavors.color_background" />
 */
app.directive('colorpicker', function ($compile) {
  return {
    require: '?ngModel',
    link   : function (scope, elem, attrs, ngModel) {
      var default_color = elem.attr('color');
      if (default_color) {
        default_color = default_color;
      }
      else {
        default_color = '#fff';
      }

      elem.spectrum({
        flat           : false,
        showInput      : true,
        maxPaletteSize : 10,
        preferredFormat: "hex"
      });

      if (!ngModel) {
        return;
      }
      ngModel.$render = function () {
        elem.spectrum('set', ngModel.$viewValue || default_color);
      };
      elem.on('change', function () {
        scope.$apply(function () {
          ngModel.$setViewValue(elem.val());
        });
      });
    }
  }
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 */

/**
 * Directive cleditor jquery plugin.
 * http://premiumsoftware.net
 *
 * <textarea cleditor ng-model="content"></textarea>
 */
app.directive('cleditor', function () {
  return {
    require: '?ngModel',
    link   : function (scope, elm, attr, ngModel) {

      if (!ngModel) {
        return;
      }

      elm.cleditor().change(function () {
        var value = elm.val();

        if (!scope.$$phase) {
          scope.$apply(function () {
            ngModel.$setViewValue(encodeURIComponent(value));
          });
        }
      });

      ngModel.$render = function () {
        elm.val((ngModel.$viewValue) ? decodeURIComponent(ngModel.$viewValue) : '').blur();
      };
    }
  }
});

/**
 * Directive ckeditor jquery plugin.
 * <textarea ckeditor ng-model="entry.body" value="{{entry.body}}">{{entry.body}}</textarea>
 */
app.directive('ckeditor', function () {
  return {
    require: '?ngModel',
    link   : function (scope, elm, attr, ngModel) {

      var options = {
        enterMode     : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        autoParagraph : false,

        toolbar_Full: [
          {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source']},
          {
            name  : 'clipboard',
            groups: ['clipboard', 'undo'],
            items : ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
          },
          {
            name  : 'basicstyles',
            groups: ['basicstyles', 'cleanup'],
            items : ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
          },
          {name: 'styles', items: ['Format']},
          {name: 'colors', items: ['-']},
          {
            name: 'paragraph', groups: [], items: [
            'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
          }
        ]
      }

      var ck = CKEDITOR.replace(elm[0], options);

      if (!ngModel) {
        return;
      }

      //loaded didn't seem to work, but instanceReady did
      //I added this because sometimes $render would call setData before the ckeditor was ready
      ck.on('instanceReady', function () {
        this.dataProcessor.writer.setRules('p',
          {
            indent          : false,
            breakBeforeOpen : false,
            breakAfterOpen  : false,
            breakBeforeClose: false,
            breakAfterClose : false
          });
        this.dataProcessor.writer.setRules('ol',
          {
            indent          : false,
            breakBeforeOpen : false,
            breakAfterOpen  : false,
            breakBeforeClose: false,
            breakAfterClose : false
          }
        );
        this.dataProcessor.writer.setRules('ul',
          {
            indent          : false,
            breakBeforeOpen : false,
            breakAfterOpen  : false,
            breakBeforeClose: false,
            breakAfterClose : false
          }
        );
        this.dataProcessor.writer.setRules('li',
          {
            indent          : false,
            breakBeforeOpen : false,
            breakAfterOpen  : false,
            breakBeforeClose: false,
            breakAfterClose : false
          }
        );
        this.dataProcessor.writer.setRules('br',
          {
            indent          : false,
            breakBeforeOpen : false,
            breakAfterOpen  : false,
            breakBeforeClose: false,
            breakAfterClose : false
          }
        );
        ck.setData((ngModel.$viewValue) ? decodeURIComponent(ngModel.$viewValue) : '');
      });

      ck.on('pasteState', function () {
        scope.$apply(function () {
          ngModel.$setViewValue(encodeURIComponent(ck.getData()));
        });
      });

      ngModel.$render = function (value) {
        ck.setData((ngModel.$viewValue) ? decodeURIComponent(ngModel.$viewValue) : '');
      };
    }
  };
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 */

/**
 * angular-bootstrap-switch
 * @version v0.3.0 - 2014-06-27
 * @author Francesco Pontillo (francescopontillo@gmail.com)
 * @link https://github.com/frapontillo/angular-bootstrap-switch
 * @license Apache License 2.0
 **/
app.directive('bsSwitch', function ($timeout) {
  return {
    restrict: 'A',
    require : 'ngModel',
    scope   : {
      switchActive  : '@',
      switchOnText  : '@',
      switchOffText : '@',
      switchOnColor : '@',
      switchOffColor: '@',
      switchAnimate : '@',
      switchSize    : '@',
      switchLabel   : '@',
      switchIcon    : '@',
      switchWrapper : '@',
      switchRadioOff: '@'
    },
    link    : function link(scope, element, attrs, controller) {
      /**
       * Return the true value for this specific checkbox.
       * @returns {Object} representing the true view value; if undefined, returns true.
       */
      var getTrueValue = function () {
        var trueValue = attrs.ngTrueValue;
        if (!angular.isString(trueValue)) {
          trueValue = true;
        }
        return trueValue;
      };

      /**
       * Listen to model changes.
       */
      var listenToModel = function () {
        // When the model changes
        controller.$formatters.push(function (newValue) {
          if (newValue !== undefined) {
            $timeout(function () {
              element.bootstrapSwitch('state', (newValue === getTrueValue()), true);
            });
          }
        });

        scope.$watch('switchActive', function (newValue) {
          var active = newValue === true || newValue === 'true' || !newValue;
          element.bootstrapSwitch('disabled', !active);
        });

        scope.$watch('switchOnText', function (newValue) {
          element.bootstrapSwitch('onText', getValueOrUndefined(newValue));
        });

        scope.$watch('switchOffText', function (newValue) {
          element.bootstrapSwitch('offText', getValueOrUndefined(newValue));
        });

        scope.$watch('switchOnColor', function (newValue) {
          attrs.dataOn = newValue;
          element.bootstrapSwitch('onColor', getValueOrUndefined(newValue));
        });

        scope.$watch('switchOffColor', function (newValue) {
          attrs.dataOff = newValue;
          element.bootstrapSwitch('offColor', getValueOrUndefined(newValue));
        });

        scope.$watch('switchAnimate', function (newValue) {
          element.bootstrapSwitch('animate', scope.$eval(newValue || 'true'));
        });

        scope.$watch('switchSize', function (newValue) {
          element.bootstrapSwitch('size', newValue);
        });

        scope.$watch('switchLabel', function (newValue) {
          element.bootstrapSwitch('labelText', newValue ? newValue : '&nbsp;');
        });

        scope.$watch('switchIcon', function (newValue) {
          if (newValue) {
            // build and set the new span
            var spanClass = '<span class=\'' + newValue + '\'></span>';
            element.bootstrapSwitch('labelText', spanClass);
          }
        });

        scope.$watch('switchWrapper', function (newValue) {
          // Make sure that newValue is not empty, otherwise default to null
          if (!newValue) {
            newValue = null;
          }
          element.bootstrapSwitch('wrapperClass', newValue);
        });

        scope.$watch('switchRadioOff', function (newValue) {
          element.bootstrapSwitch('radioAllOff', newValue === true || newValue === 'true');
        });
      };

      /**
       * Listen to view changes.
       */
      var listenToView = function () {
        // When the switch is clicked, set its value into the ngModelController's $viewValue
        element.on('switchChange.bootstrapSwitch', function (e, data) {
          scope.$apply(function () {
            controller.$setViewValue(data);
          });
        });
      };

      /**
       * Returns the value if it is truthy, or undefined.
       *
       * @param value The value to check.
       * @returns the original value if it is truthy, {@link undefined} otherwise.
       */
      var getValueOrUndefined = function (value) {
        return (value ? value : undefined);
      };

      // Wrap in a $timeout to give the ngModelController
      // enough time to resolve the $modelValue
      $timeout(function () {
        var isInitiallyActive = controller.$modelValue === getTrueValue();

        // Bootstrap the switch plugin
        element.bootstrapSwitch({
          state: isInitiallyActive
        });

        // Listen and respond to model changes
        listenToModel();

        // Listen and respond to view changes
        listenToView();

        // Set the initial view value (may differ from the model value)
        controller.$setViewValue(isInitiallyActive);

        // On destroy, collect ya garbage
        scope.$on('$destroy', function () {
          element.bootstrapSwitch('destroy');
        });
      });
    }
  };
})
  .directive('bsSwitch', function () {
    return {
      restrict: 'E',
      require : 'ngModel',
      template: '<input bs-switch>',
      replace : true
    };
  });