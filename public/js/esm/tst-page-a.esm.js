import { 
  tstFetchPostForm, 
  tstOnSuccess
} from "./tst-lib.esm.js";

export class TstPageA {
    constructor() {
        const elBtn = document.getElementById('cow');
        const elTxt = document.getElementById('txt');

        elBtn.addEventListener('click', function (e) {
          elTxt.classList.toggle('hidden');
          elBtn.classList.toggle('hidden');
          
          tstFetchPostForm('/routes.php',{ cmd: 'cmd_click', target: 'By a cow'});
        });        
    }
}