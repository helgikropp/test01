import { 
  tstFetchPostForm, 
  tstGoToUrl, 
  tstProcessError, 
  //tstOnError, 
  tstOnSuccess
} from "./tst-lib.esm.js";

export class TstLogin {
    constructor() {
        const elBtnShowHidePwd = document.querySelector('.tst-login-pwd-btn');
        const elUname = document.getElementById('uname');
        const elPwd   = document.getElementById('pwd');
        const elForm  = document.getElementById('login-form');

        
        elForm.addEventListener('submit', function (e) {
          e.preventDefault();
          e.stopPropagation();

          tstFetchPostForm(elForm.action, new FormData(elForm))
            .then( jsonRes => { 
                tstOnSuccess(jsonRes.msg || jsonRes.code).then(() => { tstGoToUrl(jsonRes.goto); });
            })
            .catch( error => { 
              tstProcessError(error); 
            });   
        });        

        elBtnShowHidePwd.addEventListener('click', function (e) {
          const type = elPwd.getAttribute('type') === 'password' ? 'text' : 'password';
          elPwd.setAttribute('type', type);
          this.classList.toggle('fa-eye-slash');
        });        
    }
}