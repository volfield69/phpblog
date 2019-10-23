// ------ jquery and bootstrap basics ------
// create global $ and jQuery variables
const $ = require('jquery');
global.$ = global.jQuery = $;

require('jquery-ui');
require('jquery-ui/ui/widgets/autocomplete.js');
require('bootstrap-sass');
require('jquery-slimscroll');
require('bootstrap-select');
require('datatables.net');
require('datatables.net-bs');
require('@danielfarrell/bootstrap-combobox');


const Moment = require('moment');
global.moment = Moment;
require('daterangepicker');

// ------ AdminLTE framework ------
require('../../scss/back/_admin-lte.scss');
require('admin-lte/dist/css/AdminLTE.min.css');
require('admin-lte/dist/css/skins/_all-skins.css');
// require('../../scss/back/admin-lte-extensions.scss');

global.$.AdminLTE = {};
global.$.AdminLTE.options = {};
require('admin-lte/dist/js/adminlte.min');

// ------ Theme itself ------
require('../../img/back/default_avatar.png');

// ------ icheck for enhanced radio buttons and checkboxes ------
require('icheck');
require('icheck/skins/square/blue.css');



