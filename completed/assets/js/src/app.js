(function(window, $, undefined) {

    "use strict";

    window.SSDSystem = window.SSDSystem || {};

    window.SSDSystem.Template = {

        pagination: function() {

            "use strict";

            $('.ssd-pagination select').ssdSelect({
                action : 'go-to'
            });

        },

        init: function() {

            "use strict";

            this.pagination();

        }

    };

    window.SSDSystem.Template.init();

})(window, window.jQuery);