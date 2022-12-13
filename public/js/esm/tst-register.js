import { 
  tstFetchPostForm, 
  tstGoToUrl, 
  tstProcessError, 
  //tstOnError, 
  tstOnSuccess
} from "./tst-lib.esm.js";

export class TstRegister {
    constructor() {
        const elBtn   = document.getElementById('send');
        const elUname = document.getElementById('uname');
        const elPwd1  = document.getElementById('pwd1');
        const elPwd2  = document.getElementById('pwd2');
        const elEmail = document.getElementById('email');
        const elForm  = document.getElementById('signup-form');

        
        elForm.addEventListener('submit', function (e) {
          e.preventDefault();
          e.stopPropagation();
        });        

        elBtn.addEventListener('click', function (e) {
          if(!elEmail.value.trim() || !elUname.value.trim() || !elPwd1.value.trim() || !elPwd2.value.trim()) {
            tstProcessError('All fields are required'); 
          } else if(elPwd1.value.trim() !== elPwd2.value.trim()) {
            tstProcessError('Passwords don\'t match'); 
          } else {
            tstFetchPostForm(elForm.action, new FormData(elForm))
            .then( jsonRes => { 
                tstOnSuccess(jsonRes.msg || jsonRes.code).then(() => { tstGoToUrl(jsonRes.goto); });
            })
            .catch( error => { 
              tstProcessError(error); 
            });   
          }
        });        
    }
}