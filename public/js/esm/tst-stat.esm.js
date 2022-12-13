import { tstFetchPostForm, tstProcessError } from "./tst-lib.esm.js";

export class TstStat {
    constructor() {
      const elDtFrom = document.getElementById('dtFrom');
      const elDtTo   = document.getElementById('dtTo');
      const elFrom   = document.getElementById('from');
      const elTo     = document.getElementById('to');
      const elBtnReset = document.getElementById('reset');
      const elForm   = document.querySelector('form');

      tempusDominus.extend(window.tempusDominus.plugins.customDateFormat);

      const opt = {
        localization: {
          locale:'en',
          format: 'yyyy-MM-dd HH:mm'
        },
        display: {
          icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-arrow-up',
            down: 'fa fa-arrow-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-calendar-check-o',
            clear: 'fa fa-trash-o',
            close: 'fa fa-times',
          },
          buttons: {
            today: true,
            clear: true,
            close: true,
          },
        }        
      };

      new tempusDominus.TempusDominus(elDtFrom, opt);


      new tempusDominus.TempusDominus(elDtTo, opt);

      elBtnReset.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        elFrom.value = '';
        elTo.value = '';
        document.querySelectorAll('select').forEach(combo => {
          combo.selectedIndex = 0;
        });

        //elForm.submit();
      });
    }
}