export default {
    methods: {
        mountUrl(url, form){
            Object.keys(form).forEach(function (key, i) {
                if (Object.values(form)[i]) {
                    url += key + '=' + Object.values(form)[i] + '&'
                }
            })

            return url;
        },

        mountDataTable(response){
            let data = [];

            Object.keys(response).forEach((key, i) => data[key] = Object.values(response)[i]);

            return data;
        },

        confirmDelete(id) {
            let self = this;

            self.$confirm(self.$t('message.exclusao_confirma'), self.$tc('message.atencao', 1), {
                confirmButtonText: self.$t('message.sim'),
                cancelButtonText : self.$t('message.cancelar'),
                type             : 'warning',
                showClose        : true,
            }).then(() => {
                self.delete(id)
            }).catch(() => {
                self.$notify.info({
                    title  : self.$tc('message.atencao', 2),
                    message: self.$t('message.exclusao_cancelada')
                });
            })

            return true;
        },

        resetForm(){
            let self = this;

            return self.$refs.form.resetFields();
        },

        lookupHandler(fields = [], separator = '-'){
            let result = '';

            fields.filter(field => ![null, ''].includes(field))
                  .map((field, index) => {

                result += (index > 0 ? ' ' + separator + ' ' : '') + field;
            });

            return result
        },

        hasError(campo){
            return Object.keys(this.errors).includes(campo);
        },

        clearError(){
            return this.errors = [];
        },

        formatDate(date){
            return moment(date).format('DD/MM/YYYY')
        },

        formatDateTime(datetime){
            return moment(datetime).format('DD/MM/YYYY HH:mm:ss')
        },
    }
}
