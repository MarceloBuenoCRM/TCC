<template>
    <el-dialog :title="edit == true ? $t('message.edit', {msg: $t('message.sala_aula')}) : $t('message.add', {msg: $t('message.sala_aula')})" :visible.sync="dialogVisible"
        :before-close="closeModalForm" append-to-body width="70%">
        <div class="card card-gray-custom">
            <div class="card-header">
                <h3 class="card-title">
                    {{$t('message.sala_aula')}}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <el-form ref="form" :model="form" :rules="rules" label-position="top" class="demo-ruleForm" @submit.native.prevent="submitForm('form')" id="formSalaAula">
                    <div class="row">
                        <el-form-item :label="$t('message.num_sala')" class="col-sm-12 col-md-4" :class="{'is-error': hasError('cad_num_sala')}" size="mini" prop="cad_num_sala">
                            <el-input v-model="form.cad_num_sala" clearable></el-input>
                            <div class="el-form-item__error" v-if="hasError('cad_num_sala')">
                                {{errors['cad_num_sala'][0]}}
                            </div>
                        </el-form-item>

                        <el-form-item :label="$t('message.bloco')" class="col-sm-12 col-md-4" size="mini" prop="cad_bloco">
                            <el-input v-model="form.cad_bloco" clearable>
                            </el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.diametro')" class="col-sm-12 col-md-4" size="mini" prop="cad_diametro">
                            <el-input v-model="form.cad_diametro" clearable>
                            </el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.latitude')" class="col-sm-12 col-md-6" size="mini" prop="cad_latitude">
                            <el-input v-model="form.cad_latitude" clearable disabled>
                                <el-button slot="prepend" @click="getPosition()">
                                   <i class="fas fa-map-marked"></i>
                                </el-button>
                            </el-input>
                        </el-form-item>

                        <el-form-item :label="$t('message.longitude')" class="col-sm-12 col-md-6" size="mini" prop="cad_longitude">
                            <el-input v-model="form.cad_longitude" clearable disabled>
                                <el-button slot="prepend" @click="getPosition()">
                                   <i class="fas fa-map-marked"></i>
                                </el-button>
                            </el-input>
                        </el-form-item>
                    </div>
                </el-form>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button type="button" class="btn btn-light btn-sm" @click="closeModalForm()">
                {{$t('message.cancelar')}}
            </button>
            <button native-type="submit" class="btn btn-primary btn-sm" form="formSalaAula">
                <i class="fas fa-save"></i>
                {{$t('message.gravar')}}
            </button>
        </span>
    </el-dialog>
</template>

<script>
    import funcoes     from '../../../../../components/mixins/funcoes';
    import notify      from '../../../../../components/mixins/notify';
    import modalMixins from '../../../../../components/mixins/modalMixins';

    export default {
        props: {
            edit: Boolean,
        },

        data() {
            return {
                form          : {
                    cad_num_sala : '',
                    cad_bloco    : '',
                    cad_diametro : '',
                    cad_latitude : '',
                    cad_longitude: ''
                },
                rules: {
                    cad_num_sala: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {msg: this.$t('message.num_sala')}),
                        trigger : "change",
                    }],
                    cad_diametro: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {msg: this.$t('message.diametro')}),
                        trigger : "change",
                    }],
                    cad_latitude: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {msg: this.$t('message.latitude')}),
                        trigger : "change",
                    }],
                    cad_longitude: [{
                        required: true,
                        message : this.$t('message.rules.campo_obrigatorio', {msg: this.$t('message.longitude')}),
                        trigger : "change",
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
                        axios.put('/sistema/sala_aula/' + self.form.id, self.form)
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
                        axios.post('/sistema/sala_aula', self.form)
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

            carregaDados(id_sala_aula) {
                let self = this;

                axios.get('/sistema/sala_aula/' + id_sala_aula)
                    .then(function (response) {
                        self.form = response.data.data.data[0];
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            getPosition(){
                navigator.geolocation.getCurrentPosition(this.showPosition)
            },

            showPosition(position){
                let self = this;

                self.form.cad_latitude  = position.coords.latitude;
                self.form.cad_longitude = position.coords.longitude;
            },

            closeModalForm() {
                let self = this;

                self.clearError();
                self.closeModal();
            }
        }
    }
</script>
