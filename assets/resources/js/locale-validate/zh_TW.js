!function(n,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):(n.__vee_validate_locale__zh_TW=n.__vee_validate_locale__zh_TW||{},n.__vee_validate_locale__zh_TW.js=e())}(this,function(){"use strict";var n=function(n){var e=["Byte","KB","MB","GB","TB","PB","EB","ZB","YB"],t=0===(n=1024*Number(n))?0:Math.floor(Math.log(n)/Math.log(1024));return 1*(n/Math.pow(1024,t)).toFixed(2)+" "+e[t]},e={name:"zh_TW",messages:{after:function(n,e){return n+" 必須要晚於 "+e[0]+"。"},alpha_dash:function(n){return n+" 只能以字母、數字及斜線組成。"},alpha_num:function(n){return n+" 只能以字母及數字組成。"},alpha_spaces:function(n){return n+" 只能以字母及空格組成。"},alpha:function(n){return n+" 只能以字母組成。"},before:function(n,e){return n+" 必須要早於 "+e[0]+"。"},between:function(n,e){return n+" 必須介於 "+e[0]+" 至 "+e[1]+"之間。"},confirmed:function(n,e){return n+" 與 "+e[0]+" 輸入的不一致。"},credit_card:function(n){return n+" 的格式錯誤。"},date_between:function(n,e){return n+" 必須在 "+e[0]+" 和 "+e[1]+" 之間。"},date_format:function(n,e){return n+" 不符合 "+e[0]+" 的格式。"},decimal:function(n,e){void 0===e&&(e=["*"]);var t=e[0];return n+" 必須是數字，而且包含 "+("*"===t?"":t)+" 小數點。"},digits:function(n,e){return n+" 必須是 "+e[0]+" 位數字。"},dimensions:function(n,e){return n+" 圖片尺寸不正確。必須是 "+e[0]+" 像素到 "+e[1]+" 像素。"},email:function(n){return n+" 必須是有效的電子郵件地址。"},ext:function(n){return n+" 必須是有效的檔案。"},image:function(n){return n+" 必須是一張圖片。"},in:function(n){return"所選擇的 "+n+" 選項無效。"},ip:function(n){return n+" 必須是一個有效的 IP 位址。"},max:function(n,e){return n+" 不能大於 "+e[0]+" 個字元。"},max_value:function(n,e){return n+" 不得大於 "+e[0]+"。"},mimes:function(n){return n+" 必須是有效的檔案類型."},min:function(n,e){return n+" 不能小於 "+e[0]+" 個字元。"},min_value:function(n,e){return n+" 不得小於 "+e[0]+"。"},not_in:function(n){return"所選擇的 "+n+" 選項無效。"},numeric:function(n){return n+" 必須為一個數字。"},regex:function(n){return n+" 的格式錯誤。"},required:function(n){return n+" 不能留空。"},size:function(e,t){var r=t[0];return e+" 的大小必須小於 "+n(r)+"."},url:function(n){return n+" 的格式錯誤。"}},attributes:{}};return"undefined"!=typeof VeeValidate&&VeeValidate.Validator.addLocale(e),e});