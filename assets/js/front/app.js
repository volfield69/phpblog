// any CSS you require will output into a single css file (app.css in this case)
require('../../scss/front/app.scss');

require('bootstrap');
require('bootstrap4-toggle');

// require jQuery normally
const $ = require('jquery');
// create global $ and jQuery variables
global.$ = global.jQuery = $;

const bsCustomFileInput = require('bs-custom-file-input');
global.bsCustomFileInput = bsCustomFileInput;





