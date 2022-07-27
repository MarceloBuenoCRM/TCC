export default {

    data() {
        return {
            dialogVisible: false,
            elemento: '',
            tabAtivo: '',
        };
    },

    methods: {
        show(el = '', tabAtivo = '') {
            let self = this;

            self.elemento = el
            self.tabAtivo = tabAtivo
            this.openModal();
        },

        openModal() {
            let self = this;

            self.dialogVisible = true;
            self.$nextTick(function(){
                if(self.elemento){
                    $('#'+self.elemento).focus();
                }
            })
        },

        closeModal() {
            let self = this;

            if(self.$refs['form']){
                self.$refs['form'].resetFields();
            }

            self.dialogVisible = false;
        },
    }
};
