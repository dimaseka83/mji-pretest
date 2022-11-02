export default {
    methods: {
        isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [day, month, year].join('-');
        },
        formatRupiah(e) {
            if(isNaN(e)){
                return 0;
            }else{
                return `Rp. ${e.toString().split('').reverse().join('').match(/\d{1,3}/g).join('.').split('').reverse().join('')}`;
            }
        },
    },
}