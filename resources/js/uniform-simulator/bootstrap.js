import jQuery from 'jquery';
import Cleave from 'cleave.js';
import Swal from 'sweetalert2';
import Vue from 'vue';

require('popper.js').default;
require('bootstrap');
require('cleave.js/dist/addons/cleave-phone.br');

window.Vue = Vue;
window.$ = window.jQuery = jQuery;
window.Cleave = Cleave;
window.axios = require('axios');
window.Swal = Swal;
window._ = require('lodash');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
