import { tstGoToUrl, tstOnError, tstOnSuccess, tstProcessError, tstFetchPostForm } from "./tst-lib.esm.js";
import { TstLogin } from "./tst-login.esm.js";
import { TstPageA } from "./tst-page-a.esm.js";
import { TstPageB } from "./tst-page-b.esm.js";

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

        document.querySelectorAll('a.nav-link[data-cmd]').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
    
                tstFetchPostForm(e.currentTarget.href,{ cmd: el.dataset['cmd'] }, { noAjax: true})
                    .then( jsonRes => { 
                        tstOnSuccess(jsonRes.code || jsonRes.code).then(() => { tstGoToUrl(jsonRes.goto); });
                    })
                    .catch( error => { 
                        tstProcessError(error); 
                    });   
            });     
        });        
            
        return this;
    }
/*
    moveToDlgPlace(dlg) { this._dialogsPlace.appendChild(dlg); }
    initModalWin(queryStr) {
        const modalWin = document.querySelector(queryStr);
        if(modalWin) {
            this.moveToDlgPlace(modalWin);
        }
        return modalWin;
    }
*/    

    async loadPageModule() {
        const $main = document.body.querySelector('main');
        if($main) {
            const pageType = $main.dataset['page'];
            switch (pageType) {
                case 'login':
                    try { new TstLogin(); } catch (err) {/* libCatchError(err); */ }
                    break;
                case 'pageA':
                    try { new TstPageA(); } catch (err) {/* libCatchError(err); */ }
                    break;
                case 'pageB':
                    try { new TstPageB(); } catch (err) {/* libCatchError(err); */ }
                    break;
            }
        }
    }
}