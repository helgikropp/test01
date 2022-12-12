import { tstGoToUrl, tstOnError, tstOnSuccess, tstProcessError, tstFetchPostForm } from "./tst-lib.esm.js";
import { TstLogin } from "./tst-login.esm.js";
import { TstPageA } from "./tst-page-a.esm.js";
import { TstPageB } from "./tst-page-b.esm.js";
import { TstStat } from "./tst-stat.esm.js";
import { TstReport } from "./tst-report.esm.js";

/* ===  TstApplication  ===================================================== */
/* ========================================================================== */

export class TstApplication {
    constructor() {
        this._body = document.querySelector('body');
        this._dialogsPlace = document.querySelector('#dialogs-place');

        this.init();
    }

    init() {
        window.dispatchEvent(new Event('resize'));

        this.loadPageModule()
            .catch((err) => {
                tstOnError(err);
            });

        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl,{
                trigger: 'hover focus',
                container: 'body'
            });
        });

        document.querySelectorAll('#logout').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
    
                tstFetchPostForm(e.currentTarget.href,{ cmd: 'cmd_logout' })
                    .then( jsonRes => { 
                        tstOnSuccess(jsonRes.code || jsonRes.code).then(() => { tstGoToUrl(jsonRes.goto); });
                    })
                    .catch( error => { 
                        tstProcessError(error); 
                    });   
            });     
        }); 
    }

    async loadPageModule() {
        const $main = document.body.querySelector('main');
        if($main) {
            const pageType = $main.dataset['page'];
            switch (pageType) {
                case 'login':
                    try { new TstLogin(); } catch (err) {/* libCatchError(err); */ }
                    break;
                case 'page-a':
                    try { new TstPageA(); } catch (err) {/* libCatchError(err); */ }
                    break;
                case 'page-b':
                    try { new TstPageB(); } catch (err) {/* libCatchError(err); */ }
                    break;
                case 'stat':
                    try { new TstStat(); } catch (err) {/* libCatchError(err); */ }
                    break;
                case 'report':
                    try { new TstReport(); } catch (err) {/* libCatchError(err); */ }
                    break;
            }
        }
    }
}
