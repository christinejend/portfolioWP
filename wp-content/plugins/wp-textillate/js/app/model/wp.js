/**
 * Model for work whit Wordpress API.
 */

app.factory('Wp', ['$http', '$rootScope', function ($http, $rootScope) {

  return {

    /**
     * GET AREA.
     */

    /**
     * POST AREA.
     */

    /**
     * Generic Model to Ajax.
     * It is a model that can enforce several different shows.
     *
     * @param json Data send to Server.
     * @param action Is action to execute in Server by Ajax.
     *               file_exist If some file exist in server.
     * @param callback
     */
    generic_model: function (json, action, callback) {

      $http.post(ajaxurl, {data: encodeURIComponent(JSON.stringify(json))}, {
        params: {
          action: action
        }
      }).success(function (data, status) {
        if (status == 200) {
          callback({
            status: status,
            result: data,
            msg   : '',
            type  : 'success'
          });
        }
        else {
          callback({
            status: status,
            result: '',
            msg   : 'Error: Please refresh page.',
            type  : 'error'
          });
        }
      });
    },

    /**
     * Get Image by ID.
     *
     * @param id
     * @param callback
     */
    getUrlImgById: function (id, callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : {id: id},
          action: 'get_url_img_by_id'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result.type == 'success') {
            callback(result.data);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Get all posts.
     *
     * @param callback
     */
    get_all_posts: function (callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : '',
          action: 'get_all_posts'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Get all Categories.
     *
     * @param callback
     */
    get_all_categories: function (callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : '',
          action: 'get_all_categories'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Get posts by category.
     *
     * @param json
     * @param callback
     */
    get_posts_by_category: function (json, callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : json,
          action: 'get_posts_by_category'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Get post by ID.
     *
     * @param json
     * @param callback
     */
    get_post_by_id: function (json, callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : json,
          action: 'get_post_by_id'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Get options of plugin.
     *
     * @param callback
     */
    get_options: function (callback) {
      $http.post(ajaxurl, '', {
        params: {
          action: 'get_options'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Create new textillate.
     *
     * @param json
     * @param callback
     */
    create_textillate: function (json, callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : json,
          action: 'create_textillate'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Save all options.
     *
     * @param json
     * @param callback
     */
    save: function (json, callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : json,
          action: 'save'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Delete textillate.
     *
     * @param json
     * @param callback
     */
    delete_textillate: function (json, callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : json,
          action: 'delete_textillate'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    },

    /**
     * Delete line of textillate.
     *
     * @param json
     * @param callback
     */
    delete_line_of_textillate: function (json, callback) {
      $http.post(ajaxurl, '', {
        params: {
          data  : json,
          action: 'delete_line_of_textillate'
        }
      }).success(function (result, status) {
        if (status == 200) {
          if (result) {

            callback(result);
          }
          else {
            flashMessageLaunch(result);
          }
        }
        else {
          flashMessageLaunch({type: 'error', msg: 'Error: Please refresh page.'});
        }
      });
    }
  }
}]);