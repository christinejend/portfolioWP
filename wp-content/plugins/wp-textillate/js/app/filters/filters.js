/**
 * Filters.
 */
'use strict';

/**
 * Filters of cfplugin_textillate module.
 *
 * @type {module|*}
 */
var filters = angular.module('cfplugin_textillate');

/**
 * Short string.
 */
filters.filter('shortString', function () {
  var shortFilter = function (input) {
    if (is_mobile) {
      return (input.length > 20) ? input.slice(0, 20) + '...' : input;
    }
    else {
      return input;
    }
  };
  return shortFilter;
});