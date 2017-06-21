'use strict';

// Declare app level module which depends on filters, and services.
var app = angular.module('cfplugin_textillate', ['localytics.directives']);

app.config(["$httpProvider", function ($httpProvider) {
  $httpProvider.defaults.headers.post['Content-Type'] = ''
  + 'application/x-www-form-urlencoded; charset=UTF-8';

  $httpProvider.defaults.transformRequest = function (obj) {
    var str = [];
    for (var p in obj)
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    return str.join("&");
  }
}]);

app.run(['$rootScope', function ($rootScope) {

  //------------------------------------------
  //-- Checkbox field. Bootstrap Switch configuration.
  //------------------------------------------

  $rootScope.checkbox = {
    onText  : 'ON',
    offText : 'OFF',
    isActive: true,
    size    : 'small',
    animate : true,
    radioOff: false
  };

  //------------------------------------------
  //-- Widgets Post.
  //------------------------------------------

  // Current url, Eg: http://localhost/wordpress/wp-admin/post.php?post=640&action=edit
  $rootScope.currentUrl = document.URL;

  // Url site, Eg: http://localhost/wordpress
  $rootScope.site = Directory.site;

  // Url to public content, Eg: http://localhost/wordpress/wp-content/themes/superior
  $rootScope.public = Directory.public;

  // Path to loading gif image.
  $rootScope.loadingGif = $rootScope.public + '/js/app/images/loading_storm.gif';

  // Path to not exist image is.
  $rootScope.pathNotExistImage = $rootScope.public + 'images/not_exist.png';

  /**
   * Globals functions.
   */

  /**
   * Function to upload image. HTML should be this.
   *        <div>
              <input type="hidden" class="img-url-input" value="{{ uploadFaviconUrl }}" readonly>
              <input type="hidden" class="img-id-input" ng-model="optionsController.options.uploadFaviconId">

              <br />
              <img class="cf-image-preview cf-img-favicon" src="{{ uploadFaviconUrl }}" />

              <br />
              <a id="cf-media-upload-favicon" href="#" class="btn btn-success cf-btn-upload" ng-click="uploadImage('#cf-media-upload-favicon')">
                Load Image
              </a>

              <br />
              <a class="btn btn-danger" ng-click="resetImage('#cf-media-upload-favicon')">
                Reset Image
              </a>
          </div>
   *
   * @param element
   * @param id
   */
  $rootScope.uploadImage = function (element) {
    var $this_button = jQuery(element);

    var frame = wp.media({
      title   : 'Sidebar Upload',
      library : {
        type: 'image'
      },
      multiple: false,
      button  : {
        text: 'Select Image'
      }
    });

    frame.on('select', function () {
      var attachment = frame.state().get('selection').first().toJSON();
      $this_button.siblings('.img-url-input').attr('value', attachment.url);
      $this_button.siblings('.img-id-input').attr('value', attachment.id);
      $this_button.siblings('img').attr('src', attachment.url);
      jQuery('input').trigger('input');
    });

    frame.open();
    return false;
  }

  /**
   * Function to remove image.
   *
   * @param element
   */
  $rootScope.resetImage = function (element) {
    var $this_button = jQuery(element);

    $this_button.siblings('.img-url-input').val('');
    $this_button.siblings('.img-id-input').val('');
    $this_button.siblings('img').attr('src', $rootScope.pathNotExistImage);
    jQuery('input').trigger('input');
  }
}]);
