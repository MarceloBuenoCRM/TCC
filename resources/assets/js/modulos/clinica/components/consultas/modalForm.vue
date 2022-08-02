<template>
    <el-dialog :title="edit == true ? 'Editar Usuário' : 'Adicionar Usuário'" :visible.sync="dialogVisible"
        :before-close="closeModal" append-to-body>
        <div class="card card-gray-custom">
            <div class="card-header">
                <h3 class="card-title">
                    Usuário
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <el-form ref="form" :model="form" :rules="rules" label-position="top" class="demo-ruleForm">
                    <div class="row">
                        <el-form-item label="Nome Completo" class="col-sm col-md-12" size="mini" prop="cad_name">
                            <el-input v-model="form.cad_name" clearable></el-input>
                        </el-form-item>

                        <el-form-item label="E-mail" class="col-sm col-md-4" size="mini" prop="cad_email">
                            <el-input v-model="form.cad_email" clearable></el-input>
                        </el-form-item>

                        <el-form-item label="Senha" class="col-sm col-md-4" size="mini" prop="cad_senha">
                            <el-input type="password" v-model="form.cad_senha" show-password></el-input>
                        </el-form-item>

                        <el-form-item label="Confirmar Senha" class="col-sm col-md-4" size="mini"
                            prop="cad_confirma_senha">
                            <el-input type="password" v-model="form.cad_confirma_senha" show-password></el-input>
                        </el-form-item>
                    </div>
                </el-form>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button type="button" class="btn bg-gradient-danger btn-sm" @click="closeModal()">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="button" class="btn bg-gradient-success btn-sm" @click="submitForm('form')">
                <i class="fas fa-save"></i>
                Gravar
            </button>
        </span>
    </el-dialog>
</template>

<script>
    import modalMixins from '../../../../components/mixins/modalMixins';

    export default {
        props: {
            edit: Boolean,
            id_defeito: Number
        },

        data() {
            var validatePass = (rule, value, callback) => {
                    if (value !== this.form.cad_senha) {
                        callback(new Error('As senhas não confere.'));
                    }
                };

                return {
                    activeCollpase: 'defeito',
                    form: {
                        cad_name: '',
                        cad_email: '',
                        cad_senha: '',
                        cad_confirma_senha: ''
                    },
                    rules: {
                        cad_name: [{
                            required: true,
                            message: 'O campo Nome Completo é obrigatório.',
                            trigger: "change",
                        }],
                        cad_email: [{
                                required: true,
                                message: 'O campo E-mail é obrigatório.',
                                trigger: "change",
                            },
                            {
                                type: 'email',
                                message: 'O campo não contém um e-mail válido.',
                                trigger: "blur",
                            }
                        ],
                        cad_senha: [{
                            required: true,
                            message: 'O campo Senha é obrigatório.',
                            trigger: "change",
                        }],
                        cad_confirma_senha: [{
                            validator: validatePass,
                            trigger: 'blur'
                        }],
                    }
                };
        },

        mixins: [modalMixins],

        methods: {
            submitForm(form) {
                let self = this;

                self.$refs[form].validate((valid) => {
                    if (valid) {
                        /*  if (self.edit == true) {
                             axios.put('/cadastro/sac_defeito/' + self.id_defeito, self.form)
                                 .then(function () {
                                     self.closeModalTab();
                                     self.$notify({
                                         title: messages.notify.sucesso,
                                         message: messages.notify.registro_editado_sucesso,
                                         type: 'success'
                                     });
                                 })
                                 .catch(function (error) {
                                     console.log(error)
                                 })
                         } else {
                             axios.post('/cadastro/sac_defeito', self.form)
                                 .then(function () {
                                     self.closeModalTab();
                                     self.$notify({
                                         title: messages.notify.sucesso,
                                         message: messages.notify.registro_criado_sucesso,
                                         type: 'success'
                                     });
                                 })
                                 .catch(function (error) {
                                     console.log(error)
                                 })
                         } */
                    } else {
                        self.$notify({
                            title: 'Opsss!',
                            message: 'Foram encontrados erros de validações no formulário.',
                            type: 'error'
                        });
                        return false;
                    }
                });
            },
            /*
                        carregaDados(id_defeito) {
                            let self = this;

                            axios.get('/cadastro/sac_defeito/' + id_defeito)
                                .then(function (response) {
                                    self.form = response.data.data
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                        }, */
        },
    }

</script>
