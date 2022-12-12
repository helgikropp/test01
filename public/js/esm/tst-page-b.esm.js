import { tstFetchPostForm, tstProcessError } from "./tst-lib.esm.js";

export class TstPageB {
    constructor() {
        const elBtn = document.getElementById('down');

        elBtn.addEventListener('click', function (e) {
          tstFetchPostForm('/routes.php',{ cmd: 'cmd_click', target: 'By a cow'});

          tstLoadFileByUrl('/files/test01.exe',[])
            .then((file) => {
              tstFetchPostForm('/routes.php',{ cmd: 'cmd_click', target: 'Download'});
              saveAs(file, file.name);
            })
            .catch(err => {
              tstProcessError(err);
            })
        });        
    }
}