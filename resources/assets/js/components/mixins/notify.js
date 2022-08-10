export default {
    methods: {
        notifyAdd(){
            return this.$notify({
                title  : this.$t('message.sucesso'),
                message: this.$t('message.registro_criado'),
                type   : 'success'
            });
        },

        notifyEdit(){
            return this.$notify({
                title  : this.$t('message.sucesso'),
                message: this.$t('message.registro_editado'),
                type   : 'success'
            });
        },

        notifyDelete(){
            return this.$notify({
                title  : this.$t('message.sucesso'),
                message: this.$t('message.registro_excluido'),
                type   : 'success'
            });
        },

        notifyError(message){
            return this.$notify.error({
                title  : this.$tc('message.atencao', 2),
                message: message
            });
        },

        notifyErrorValidation(){
            return this.$notify({
                title  : this.$t('message.ops'),
                message: this.$t('message.erro_formulario'),
                type   : 'error'
            });
        }
    }
}
