// any CSS you require will output into a single css file (app.css in this case)
require('../../scss/front/auth.scss');

import bsCustomFileInput from 'bs-custom-file-input';
global.bsCustomFileInput = bsCustomFileInput;

require('bootstrap');

require('mdbootstrap/js/mdb.min');

// require jQuery normally
const $ = require('jquery');
// create global $ and jQuery variables
global.$ = global.jQuery = $;

require('./_security');





