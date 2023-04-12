
require('./helpers');
window.axios = require('axios');

window.Vue = require('vue');

import es from 'vee-validate/dist/locale/es';
import en from 'vee-validate/dist/locale/en';
import VeeValidate, { Validator } from 'vee-validate';

lang = lang == 'pt' || lang == 'br'? 'pt_BR':lang,

Validator.addLocale(es);
Validator.addLocale(en);

Vue.use(VeeValidate, {
	locale: lang,
});

