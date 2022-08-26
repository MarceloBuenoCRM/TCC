<template>
    <el-dialog
        :title="edit == true ? $t('message.edit', {msg: $t('message.aula')}) : $t('message.add', {msg: $t('message.aula')})"
        :visible.sync="dialogVisible" :before-close="closeModalForm" append-to-body>
        <div class="card card-gray-custom">
            <div class="card-header">
                <h3 class="card-title">
                    {{$t('message.aula')}}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <el-form ref="form" :model="form" :rules="rules" label-position="top" class="demo-ruleForm"
                    @submit.native.prevent="submitForm('form')" id="formUsuarios">
                    <div class="row">
                        <el-form-item :label="$t('message.professor')" class="col-sm-12 col-md-4" size="mini" prop="dsc_professor">
                            <el-input v-model="form.dsc_professor" readonly>
                            </el-input>
                        </el-form-item>
                        
                        <el-form-item :label="$t('message.disciplina')" class="col-sm-12 col-md-4" size="mini"
                            prop="cad_disciplina">
                            <el-input v-model="form.cad_disciplina" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.curso')" class="col-sm-12 col-md-4" size="mini"
                            prop="cad_curso">
                            <el-input v-model="form.cad_curso" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.periodo')" class="col-sm-12 col-md-4" size="mini" prop="cad_periodo">
                            <el-input v-model="form.cad_periodo" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.num_sala')" class="col-sm-12 col-md-4" size="mini" prop="cad_num_sala">
                            <el-input v-model="form.cad_num_sala" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.bloco')" class="col-sm-12 col-md-4" size="mini"
                            prop="cad_bloco">
                            <el-input v-model="form.cad_bloco" clearable></el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.data_hora_inicio')" class="col-sm-12 col-md-4" size="mini" prop="cad_data_hora_inicio">
                            <el-date-picker v-model="form.cad_data_hora_inicio" type="datetime" format="dd/MM/yyyy HH:mm:ss" value-format="yyyy-MM-dd HH:mm:ss" v-mask="'##/##/#### ##:##:##'" clearable>
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item :label="$t('message.data_hora_fim')" class="col-sm-12 col-md-4" size="mini" prop="cad_data_hora_fim">
                            <el-date-picker v-model="form.cad_data_hora_fim" type="datetime" format="dd/MM/yyyy HH:mm:ss" value-format="yyyy-MM-dd HH:mm:ss" v-mask="'##/##/#### ##:##:##'" clearable>
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item :label="$t('message.tempo_minimo')" class="col-sm-12 col-md-4" size="mini" prop="cad_tempo_minimo">
                            <el-input-number v-model="form.cad_tempo_minimo" @change="handleChange" :min="1" :max="180" clearable>
                            </el-input-number>
                        </el-form-item>

                        <el-form-item :label="$t('message.tempo_tolerancia')" class="col-sm-12 col-md-4" size="mini" prop="cad_tempo_tolerancia">
                            <el-input-number v-model="form.cad_tempo_tolerancia" @change="handleChange" :min="1" :max="20" clearable>
                            </el-input-number>
                        </el-form-item>
                    </div>
                </el-form>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button type="button" class="btn btn-light btn-sm" @click="closeModalForm()">
                {{$t('message.cancelar')}}
            </button>
            <button native-type="submit" class="btn btn-primary btn-sm" form="formUsuarios">
                <i class="fas fa-save"></i>
                {{$t('message.gravar')}}
            </button>
        </span>
    </el-dialog>
</template>

<script>
    import funcoes from '../../../../../components/mixins/funcoes';
    import notify from '../../../../../components/mixins/notify';
    import modalMixins from '../../../../../components/mixins/modalMixins';

    export default {
        props: {
            edit: Boolean,
        },

        data() {
            var validatePass = (rule, value, callback) => {
                if (value !== this.form.cad_senha) {
                    callback(new Error('As senhas não conferem.'));
                } else {
                    callback();
                }
            };

            return {
                activeCollpase: 'defeito',
                form          : {
                    dsc_professor       : Cookie.get('cad_nome'),
                    cad_disciplina      : '',
                    cad_curso           : '',
                    cad_periodo         : '',
                    cad_num_sala        : '',
                    cad_bloco           : '',
                    cad_data_hora_inicio: moment().format('YYYY-MM-DD 19:10:00'),
                    cad_data_hora_fim   : moment().format('YYYY-MM-DD 22:00:00'),
                    cad_tempo_minimo    : 50,
                    cad_tempo_tolerancia: 20
                },
                rules: {
                    cad_disciplina: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.disciplina')
                        }),
                        trigger: "change",
                    }],
                    cad_curso: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.curso')
                        }),
                        trigger: "change",
                    }],
                    cad_periodo: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.periodo')
                        }),
                        trigger: "change",
                    }],
                    cad_num_sala: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.num_sala')
                        }),
                        trigger: "change",
                    }],
                    cad_bloco: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.bloco')
                        }),
                        trigger: "change",
                    }],
                    cad_data_hora_inicio: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.data_hora_inicio')
                        }),
                        trigger: "change",
                    }],
                    cad_data_hora_fim: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.data_hora_fim')
                        }),
                        trigger: "change",
                    }],
                    cad_tempo_minimo: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.tempo_minimo')
                        }),
                        trigger: "change",
                    }],
                    cad_tempo_tolerancia: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {
                            msg: this.$t('message.tempo_tolerancia')
                        }),
                        trigger: "change"
                    }],
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
