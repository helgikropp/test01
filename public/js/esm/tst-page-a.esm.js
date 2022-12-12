import { 
  tstFetchPostForm, 
  tstOnSuccess
} from "./tst-lib.esm.js";

export class TstPageA {
    constructor() {
        const elBtn = document.getElementById('cow');
        const elTxt = document.getElementById('txt');

        elBtn.addEventListener('click', function (e) {
          elBtn.hidden = true;
          elTxt.hidden = false;
          
          tstFetchPostForm('/routes.php',{ cmd: 'cmd_click', target: 'By a cow'});
        });        
    }
}