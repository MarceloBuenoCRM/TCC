export default {
    methods: {
        notifyAdd(){
            return this.$notify({
                title  : self.$t('message.sucesso'),
                message: self.$t('message.registro_criado'),
                type   : 'success'
            });
        },

        notifyEdit(){
            return this.$notify({
                title  : self.$t('message.exclusao_cancelada'),
                message: self.$t('message.registro_editado'),
                type   : 'success'
            });
        },

        notifyDelete(){
            return this.$notify({
                title  : self.$t('message.exclusao_cancelada'),
                message: self.$t('message.registro_exlcuido'),
                type   : 'success'
            });
        },

        notifyError(message){
            return this.$notify.error({
                title  : self.$tc('message.atencao', 2),
                message: message
            });
        },

        notifyErrorValidation(){
            return this.$notify({
                title  : self.$t('message.ops'),
                message: self.$t('message.erro_formulario'),
                type   : 'error'
            });
        }
    }
}
