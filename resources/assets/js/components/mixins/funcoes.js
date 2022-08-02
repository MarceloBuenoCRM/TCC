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

            self.$confirm('Deseja excluir esse registro?', 'Atenção', {
                confirmButtonText: 'Sim',
                cancelButtonText : 'Cancelar',
                type             : 'warning',
                showClose        : true,
            }).then(() => {
                self.delete(id)
            }).catch(() => {
                self.$notify.info({
                    title  : 'Atenção!',
                    message: 'Exclusão cancelada.'
                });
            });
        },

        resetForm(){
            let self = this;

            self.$refs.form.resetFields();
        }
    }
}
