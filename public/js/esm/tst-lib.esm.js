//export const tstBusyStart = () => { WcBusyUI.obj.show(); };
//export const tstBusyStop  = () => { WcBusyUI.obj.hide(); };

export class CustomError extends Error {
    constructor(err) {
        this.name = 'CustomError';
        if(typeof err === 'object') {
            this.message = err.msg || err.code;
            this.redirect = err.goto;
        } else {
            this.message = err;
            this.redirect = '';
        }
    }
}

export function tstRaiseError(code, msg = '') {
    throw new CustomError(msg || code.replace(/^RC_/, 'ERR_'));
}

export function tstOnErrorAlert(title, msg, cbOnClose = null, timer = null) {
  return Swal.fire({
    title: title,
    timer: timer || null,
    icon: 'error',
    html: msg,
  }).then((result) => {
    if (result.isConfirmed && cbOnClose) {
      cbOnClose();
    }
  });
}

export async function tstOnError(msg, timer=null) {
    const opt = {
        title: 'Помилка',
        timer: timer || null,
        icon: 'error',
        html: msg
    };
    const result = await Swal.fire(opt);
    return result.isConfirmed;
}

export async function tstOnSuccess(msg, timer=null) {
    const opt = {
        timer: timer || null,
        icon: 'success',
        html: msg
    };
    const result = await Swal.fire(opt);
    return result.isConfirmed;
}

export async function tstOnConfirm(msg=null, confirmButtonText = 'Так') {
    const result = await Swal.fire({
        title: 'Впевнений?',
        html: msg,
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
        reverseButtons: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText:  'Ні',
        confirmButtonText: confirmButtonText
    });
    return result.isConfirmed;
}
  
  async function tstConfirm(msg=null, confirmButtonText = 'Так') {
    const opt = {
        title: 'Впевнений?',
        html: libMsgVarToStr(msg),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: libMsgVarToStr(confirmButtonText),
        cancelButtonText:  'Ні',
        reverseButtons: false,
        focusCancel: true,
        //onOpen: ()=>{ libBusyStop(); }
    };

    const result_1 = await Swal.fire(opt);
    if (result_1.value) { return new Promise((resolve, reject) => { resolve(true); }); }
    else if (result_1.dismiss === Swal.DismissReason.cancel) { return new Promise((resolve_1, reject_1) => { resolve_1(false); }); }
}

export function tstObjToFormData(obj) {
    return Object.keys(obj)
        .reduce(
            (formData, key) => {
                formData.append(key, obj[key]);
                return formData;
            }, new FormData()
        );
}

export async function tstLoadFileByUrl(url,data) {
    let fileName = '';
    let fileType = 'application/octet-stream';
    try {
        const response = await fetch(url, {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *client
            body: data instanceof FormData ? data : tstObjToFormData(data) // body data type must match "Content-Type" header
        });

        if (response.ok) { // если HTTP-статус в диапазоне 200-299
            const mimeType = response.headers.get('content-type');
            //'application/json; charset=utf-8'
            let hdr = response.headers.get("content-disposition");
            if(hdr) { // це точно файл
                fileName = hdr.match(/filename\*="?([^";]+)[";]?/);
                if (fileName && fileName.length === 2) {
                    fileName = fileName[1];
                    if (fileName.indexOf("UTF-8''") === 0 || fileName.indexOf("utf-8''") === 0) {
                        fileName = fileName.slice(7);
                    }
                } else {
                    fileName = hdr.match(/filename="?([^";]+)[";]?/)[1];
                }
                fileName = decodeURIComponent((fileName + '').replace(/\+/g, '%20'));
                const blob = await response.blob();
                return new File([blob], fileName, {type: mimeType});
            } else { // нежданчик
                if(mimeType.indexOf('application/json') !== -1) { // схоже на коректний формат помилки
                    return response.json()
                        .then(r=>{
                            throw new CustomError(r);
                        });
                } else { // нє, ну це вже ващє якась дурня неочікувана
                    throw new CustomError('Bad response type');
                }
            }
        } else {
            throw new CustomError(response.statusText);
        }
    } catch(error) {
        throw new CustomError(error);
    }
}

export function tstSerialize(obj){ 
    return window.btoa(encodeURIComponent(JSON.stringify(obj))); 
}

export function tstDeserialize(str,parse=true){
    return parse
        ? JSON.parse(decodeURIComponent(window.atob(str)))
        : decodeURIComponent(window.atob(str));
}

export function tstEmptyElement(elem){
    while (elem.firstChild) { elem.removeChild(elem.firstChild); }
}

export function tstRegExpEscape(s) {
    return s.replace(/[-[\]{}()*+!<=:?.\/\\^$|#\s,]/g, '\\$&');
}

export function tstReplaceAll(str, find, replace) {
    return str.replace(new RegExp(tstRegExpEscape(find), 'g'), replace);
}

export async function tstFetchPostForm(url, formData, options={}) {
    const headers = options.hasOwnProperty('noAjax') && options.noAjax === true 
        ? {} 
        : {'X-Requested-With': 'XMLHttpRequest'};
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *client
        headers,
        body: formData instanceof FormData ? formData : tstObjToFormData(formData),
    });

    if (response.ok) {
        if(response.headers.get('content-type').indexOf('application/json') !== -1) {
            const jsonRes = await response.json();
            if(jsonRes.code !== 'RC_OK') {
                throw new CustomError(jsonRes);
            } else {
                return jsonRes;
            }
        } else { // нє, ну це вже ващє якась дурня неочікувана
            throw new CustomError('Bad response type');
        }
    } else {
        throw new CustomError(response.statusText);
    }
}


export async function tstFetchGet(url, options={}) {
    const response = await fetch(url, {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *client
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
        }
    });

    if (response.ok) {
        if(response.headers.get('content-type').indexOf('application/json') !== -1) {
            const jsonRes = await response.json();
            if(jsonRes.code !== 'RC_OK') {
                throw new CustomError(jsonRes);
            } else {
                return jsonRes;
            }
        } else { // нє, ну це вже ващє якась дурня неочікувана
            throw new CustomError('Bad response type');
        }
    } else {
        throw new CustomError(response.statusText);
    }
}

function _goToUrl(path, withHistory, showBusy){
    if(!path) { return; }
    if(showBusy) { libBusyStart(); }
    if(withHistory) {
        window.location = path;
    } else {
        window.location.replace(path);
    }
}

export function tstGoToUrl(path, showBusy=false) { _goToUrl(path, true, showBusy); }

export function tstProcessError(err) {
    if(typeof err === 'string') {
        tstOnError(err.message);
    } else {
        tstOnError(err.message)
            .then(() => { 
                if(err.redirect) { tstGoToUrl(err.redirect); } 
            });
    }
}