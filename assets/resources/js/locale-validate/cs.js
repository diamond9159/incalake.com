!function(e,n){"object"==typeof exports&&"undefined"!=typeof module?module.exports=n():"function"==typeof define&&define.amd?define(n):(e.__vee_validate_locale__cs=e.__vee_validate_locale__cs||{},e.__vee_validate_locale__cs.js=n())}(this,function(){"use strict";var e=function(e){var n=["Byte","KB","MB","GB","TB","PB","EB","ZB","YB"],t=0===(e=1024*Number(e))?0:Math.floor(Math.log(e)/Math.log(1024));return 1*(e/Math.pow(1024,t)).toFixed(2)+" "+n[t]},n={name:"cs",messages:{_default:function(e){return"Pole "+e+" není vyplněno správně."},after:function(e,n){var t=n[0];return e+" musí být později než "+(n[1]?"nebo se rovnat ":"")+t+"."},alpha_dash:function(e){return"Pole "+e+" může obsahovat pouze alfanumerické znaky, pomlčky nebo podtržítka."},alpha_num:function(e){return"Pole "+e+" může obsahovat pouze alfanumerické znaky."},alpha_spaces:function(e){return"Pole "+e+" může obsahovat pouze alfanumerické znaky a mezery."},alpha:function(e){return"Pole "+e+" může obsahovat pouze písmena."},before:function(e,n){var t=n[0];return e+" musí být dříve než "+(n[1]?"nebo se rovnat ":"")+t+"."},between:function(e,n){return"Pole "+e+" musí být mezi "+n[0]+" a "+n[1]+"."},confirmed:function(e){return"Kontrola pole "+e+" se neshoduje."},credit_card:function(e){return"Pole "+e+" není vyplněno správně."},date_between:function(e,n){return"Pole "+e+" musí být mezi "+n[0]+" a "+n[1]+"."},date_format:function(e,n){return"Pole "+e+" musí být ve formátu "+n[0]+"."},decimal:function(e,n){void 0===n&&(n=["*"]);var t=n[0];return"Pole "+e+" musí být číslo a může obsahovat "+("*"===t?"":t)+" desetinných míst."},digits:function(e,n){return"Pole "+e+" musí být číslo a musí obshovat přesně "+n[0]+" číslic."},dimensions:function(e,n){return e+" musí mít "+n[0]+" pixelů na "+n[1]+" pixelů."},email:function(e){return"Pole "+e+" musí být validní email."},ext:function(e){return e+" musí být validní soubor."},image:function(e){return e+" musí být obrázek."},in:function(e){return e+" musí být správná hodnota."},ip:function(e){return e+" musí být ip addresa."},max:function(e,n){return e+" nesmí být delší než "+n[0]+" znaků."},max_value:function(e,n){return"Pole "+e+" musí být "+n[0]+", nebo mensí."},mimes:function(e){return"Pole "+e+" musí být správný typ souboru."},min:function(e,n){return"Pole "+e+" musí obsahovat alespoň "+n[0]+" znaků."},min_value:function(e,n){return"Pole "+e+" musí být "+n[0]+", nebo více."},not_in:function(e){return e+" musí být správná hodnota."},numeric:function(e){return"Pole "+e+" může obsahovat pouze číslice."},regex:function(e){return"Pole "+e+" není vyplněno správně."},required:function(e){return"Pole "+e+" je povinné."},size:function(n,t){var o=t[0];return n+" musí být menší než "+e(o)+"."},url:function(e){return e+" není platná URL adresa."}},attributes:{}};return"undefined"!=typeof VeeValidate&&VeeValidate.Validator.addLocale(n),n});