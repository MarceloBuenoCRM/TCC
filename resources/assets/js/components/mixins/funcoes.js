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
        }
    }
}
