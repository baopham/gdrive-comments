(function ($) {
    'use strict';

    var app = {

        initialize: function () {
            this.toggleFileNickName();
        },

        toggleFileNickName: function () {

            $('input[name=save]').click(function () {

                $('.form-group.file-nickname')
                    .toggleClass('hide');

            });
        }

    };

    app.initialize();


})(jQuery);
