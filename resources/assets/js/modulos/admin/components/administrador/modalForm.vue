<template>
    <el-dialog :title="edit == true ? 'Editar Usuário' : 'Adicionar Usuário'" :visible.sync="dialogVisible"
        :before-close="closeModalForm" append-to-body>
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
                <el-form ref="form" :model="form" :rules="rules" label-position="top" class="demo-ruleForm" @submit.native.prevent="submitForm('form')" id="formUsuarios">
                    <div class="row">
                        <el-form-item label="Nome Completo" class="col-sm col-md-12" size="mini" prop="cad_nome">
                            <el-input v-model="form.cad_nome" clearable></el-input>
                        </el-form-item>

                        <el-form-item label="E-mail" class="col-sm col-md-4" :class="[{'col-sm col-md-12': edit}, {'is-error': hasError('cad_email')}]"
                            size="mini" prop="cad_email">
                            <el-input v-model="form.cad_email" clearable @blur="clearError"></el-input>
                            <div class="el-form-item__error" v-if="hasError('cad_email')">
                                {{errors['cad_email'][0]}}
                            </div>
                        </el-form-item>

                        <el-form-item label="Senha" class="col-sm col-md-4" size="mini" prop="cad_senha" v-if="!edit">
                            <el-input type="password" v-model="form.cad_senha">
                            </el-input>
                        </el-form-item>

                        <el-form-item label="Confirmar Senha" class="col-sm col-md-4" size="mini"
                            prop="cad_confirma_senha" v-if="!edit">
                            <el-input type="password" v-model="form.cad_confirma_senha">
                            </el-input>
                        </el-form-item>
                    </div>
                </el-form>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button type="button" class="btn btn-light btn-sm" @click="closeModalForm()">
                Cancelar
            </button>
            <button native-type="submit" class="btn bg-gradient-success btn-sm" form="formUsuarios">
                <i class="fas fa-save"></i>
                Gravar
            </button>
        </span>
    </el-dialog>
</template>

<script>
    import funcoes     from '../../../../components/mixins/funcoes';
    import notify      from '../../../../components/mixins/notify';
    import modalMixins from '../../../../components/mixins/modalMixins';

    export default {
        props: {
            edit: Boolean,
        },

        data() {
            var validatePass = (rule, value, callback) => {
                if (value !== this.form.cad_senha) {
                    callback(new Error('As senhas não confere.'));
                } else {
                    callback();
                }
            };

            return {
                activeCollpase: 'defeito',
                form          : {
                    cad_nome          : '',
                    cad_email         : '',
                    cad_senha         : '',
                    cad_confirma_senha: ''
                },
                rules: {
                    cad_nome: [{
                        required: true,
                        message : 'O campo Nome Completo é obrigatório.',
                        trigger : "change",
                    }],
                    cad_email: [{
                            required: true,
                            message : 'O campo E-mail é obrigatório.',
                            trigger : "blur",
                        },
                        {
                            type   : 'email',
                            message: 'O campo não contém um e-mail válido.',
                            trigger: "blur",
                        }
                    ],
                    cad_senha: [{
                            required: true,
                            message : 'O campo Senha é obrigatório.',
                            trigger : "change",
                        },
                        {
                            min    : 8,
                            message: 'Deve conter pelo menos 8 caracteres.',
                            trigger: "blur",
                        }
                    ],
                    cad_confirma_senha: [{
                            required: true,
                            message : 'O campo Confirmar Senha é obrigatório.',
                            trigger : "change",
                        },
                        {
                            validator: validatePass,
                            trigger  : 'change'
                        }
                    ],
                },
                errors: []
            }
        },

        mixins: [modalMixins, notify, funcoes],

        methods: {
            submitForm(form) {
                let self = this;

                self.$refs[form].validate((valid) => {
                    if (!valid) {
                        self.notifyErrorValidation();
                        return false;
                    }

                    self.clearError();

                    if (self.edit == true) {
                        axios.put('/sistema/usuario/' + self.form.id, self.form)
                            .then(function () {
                                self.notifyEdit();
                                self.$emit('loadData');
                                self.closeModal();
                            })
                            .catch(function (error) {
                                self.errors = error.response.data.errors ?? [];
                                self.notifyErrorValidation();
                            })
                    } else {
                        axios.post('/sistema/usuario', self.form)
                            .then(function () {
                                self.notifyAdd();
                                self.$emit('loadData');
                                self.closeModal();
                            })
                            .catch(function (error) {
                                self.errors = error.response.data.errors ?? [];
                                self.notifyErrorValidation();
                            })
                    }
                })
            },

            carregaDados(id_usuario) {
                let self = this;

                axios.get('/sistema/usuario/' + id_usuario)
                    .then(function (response) {
                        self.form = response.data.data.data[0];
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            closeModalForm() {
                let self = this;

                self.clearError();
                self.closeModal();
            }
        }
    }
</script>
