/**
 * Notifications messages.
 */

/**
 * Generate random id.
 */
function generateId() {
  var dateRandom = new Date();
  return dateRandom.getTime().toString();
}

var is_mobile = false;
if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i)
  || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)
  || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i)) {
  is_mobile = true;
}

/**
 * Show messages from server.
 * Example:
 * flashMessageLaunch({
 *       msg : 'Problem with browser, please try with google chrome.',
 *       type: 'success'
 * });
 *
 * @param message
 */
function flashMessageLaunch(message) {
  if (message.type == 'error') {
    flashMessage(message.msg, message.type);
  }
  if (message.type == 'success') {
    flashMessage(message.msg, message.type);
  }
};

/**
 * Generate message depending of the type.
 *
 * @param msg String Is the message to show.
 * @param type String Is the type of message (success, notification, alert, error).
 * @param sticky If want it to fade out on its own or just sit there.
 * @param image Path of image to show.
 * @param class_name Class css.
 */
function flashMessage(msg, type, sticky, image, class_name) {
  var title = '';
  var path_default_image = Directory.public + 'js/vendors/gritter/images/023.png';

  switch (type) {
    case 'success':
      title = '<span class="label label-success">' + type.toUpperCase() + '</span>';
      break;
    case 'notification':
      title = '<span class="label label-info">' + type.toUpperCase() + '</span>';
      break;
    case 'alert':
      title = '<span class="label label-warning">' + type.toUpperCase() + '</span>';
      break;
    case 'error':
      title = '<span class="label label-danger">' + type.toUpperCase() + '</span>';
      path_default_image = Directory.public + 'js/vendors/gritter/images/018.png';
      break;
  }

  jQuery.gritter.add({
    title     : title,
    text      : msg,
    image     : (image) ? image : path_default_image,
    sticky    : (sticky) ? sticky : false,
    time      : '',
    class_name: (class_name) ? class_name : ''
  });
};