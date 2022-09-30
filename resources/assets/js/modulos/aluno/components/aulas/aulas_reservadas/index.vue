<template>
    <div class="d-flex flex-column">
        <div class="content-header col-sm-6 breadcrumb_index">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        {{$t('message.sistema')}}
                    </a>
                </li>
                <li class="breadcrumb-item">Aulas</li>
                <li class="breadcrumb-item active">Aulas Reservadas</li>
            </ol>
        </div>

        <div class="card card_index">
            <div class="card-body">
                <div class="content-header" style="padding: 0px">
                    <div v-if="aulas_reservadas.length == 0">
                        <p style="text-align: center">Nenhuma aula reservada</p>
                    </div>
                    <div class="container-fluid" style="display: flex">
                        <div class="col-lg-4 col-sm-4" v-for="item in aulas_reservadas" :key="item.id">
                            <div class="small-box"
                                :class="{'bg-info': aguardando(item), 'bg-success': liberaAula(item), 'bg-danger': !liberaAula(item) && !aguardando(item)}">
                                <div class="inner">
                                    <h3>{{item.cad_disciplina}}</h3>
                                    <h6 v-if="!liberaAula(item) && aguardando(item)">
                                        <strong>AGUARDANDO</strong>
                                    </h6>
                                    <h6 v-if="!liberaAula(item) && !aguardando(item)">
                                        <strong>ENCERRADO</strong>
                                    </h6>
                                    <span>Início: {{formatDateTime(item.cad_data_hora_inicio)}}</span> <br>
                                    <span>Fim: {{formatDateTime(item.cad_data_hora_fim)}}</span> <br>
                                    <span>Professor: {{item.dsc_professor}}</span> <br>
                                    <span>Sala: {{item.cad_num_sala}}</span> <br>
                                    <span>Bloco: {{item.cad_bloco}}</span>

                                    <div v-if="text">
                                        Tempo Mínimo: {{text}}
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-school"></i>
                                </div>
                                <a href="#" class="small-box-footer" v-if="liberaAula(item)"
                                    @click="verificaLocalizacao(item)">
                                    Confirmar Presença
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>

                                <button @click="pause">Pause</button>
                                <button @click="startTimer(duration)">Continuar</button>
                            </div>
                        </div>

                        <div id="map_area">
                            <div id="note">
                                <span id="title">&raquo;Tempo Mínimo: {{text}}&laquo;</span>
                                <hr />
                                <span class="info">Marker <strong>A</strong>:
                                    <span id="a" class="bool"></span>
                                </span>
                            </div>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <el-dialog :visible.sync="modal" :show-close="false" fullscreen>
            <div v-loading="loading" element-loading-text="Confirmando sua localização...">
                <el-result icon="success" title="Sucesso" subTitle="Localização Válida!" v-if="!loading">
                </el-result>

                <el-result icon="error" title="Atenção" subTitle="Localização Inválida!">
                </el-result>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import funcoes from '../../../../../components/mixins/funcoes';
    import notify from '../../../../../components/mixins/notify.js';

    export default {
        data() {
            return {
                map             : null,
                url             : '',
                cron            : '',
                text            : '',
                aulas_reservadas: [],
                duration        : null,
                modal           : false,
                loading         : false,
                timer           : {
                    minutes: 0,
                    seconds: 0
                },
                latLngCenter: null,
                latLngCMarker: null,
                latLngA: null,
                map: null,
                markerCenter: null,
                infoCenter: null,
                markerA: null,
                infoA: null,
                circle: null,
                bounds: null,
                item: {}
            }
        },

        mixins: [funcoes, notify],

        mounted() {
            let self = this;

            self.submitForm();
        },

        methods: {
            success(position){
                this.latLngA = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
                this.startMap();
            },

            startMap() {
                let self = this;

                var contentCenter = '<span class="infowin">Sala de aula ' + self.item.cad_num_sala + '</span>'
                var contentA      = '<span class="infowin">Eu</span>'

                self.latLngCenter  = new google.maps.LatLng(self.item.cad_latitude, self.item.cad_longitude)
                self.latLngCMarker = new google.maps.LatLng(self.item.cad_latitude, self.item.cad_longitude)

                self.map = new google.maps.Map(document.getElementById('map'), {
                    zoom          : 25,
                    center        : self.latLngCenter,
                    mapTypeId     : 'terrain',
                    mapTypeControl: false
                })

                self.markerCenter = new google.maps.Marker({
                    position: self.latLngCMarker,
                    title   : 'Location',
                    map     : self.map
                })

                self.infoCenter = new google.maps.InfoWindow({
                    content: contentCenter
                })

                self.markerA = new google.maps.Marker({
                    position : self.latLngA,
                    title    : 'Location',
                    map      : self.map,
                    draggable: true
                })

                self.infoA = new google.maps.InfoWindow({
                    content: contentA
                })

                self.startCircle()

                self.circle.bindTo('center', self.markerCenter, 'position');

                self.bounds = self.circle.getBounds()
                var noteA  = jQuery('.bool#a')

                noteA.text(self.bounds.contains(self.latLngA));

                // if(self.bounds.contains(self.latLngA) == true){
                //     this.isValido = true;
                //     setTimeout(() => {
                //         this.start(item.cad_tempo_minimo)
                //         this.modal = false;
                //     }, 2000);
                // }else{
                //     this.isValido = false
                // }
                // this.modal = false;
                // this.loading = false;

                google.maps.event.addListener(self.markerCenter, 'click', function () {
                    self.infoCenter.open(self.map, self.markerCenter);
                });

                google.maps.event.addListener(self.markerA, 'click', function () {
                    self.infoA.open(self.map, self.markerA);
                });
            },

            startCircle(){
                let self = this;

                self.circle = new google.maps.Circle({
                    map      : self.map,
                    clickable: false,
                    // metres
                    radius       : self.item.cad_diametro / 2,
                    fillColor    : '#fff',
                    fillOpacity  : .6,
                    strokeColor  : '#313131',
                    strokeOpacity: .4,
                    strokeWeight : .8
                })
            },

            aguardando(item) {
                let now = moment().format('YYYY-MM-DD HH:mm:ss')

                if (item.cad_data_hora_inicio > now) {
                    return true
                }

                return false
            },

            liberaAula(item) {
                let now = moment().format('YYYY-MM-DD HH:mm:ss')

                if (item.cad_data_hora_inicio <= now && item.cad_data_hora_fim > now) {
                    return true
                }

                return false
            },

            submitForm() {
                let self = this;

                self.resetAulasReservadas();
                self.url = self.mountUrl('/sistema/aulas_reservadas?', '');

                axios.get(self.url)
                    .then(function (response) {
                        self.aulas_reservadas = response.data.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            resetAulasReservadas() {
                let self = this;

                self.aulas_reservadas = [];
            },

            verificaLocalizacao(item) {
                // this.modal   = true;
                // this.loading = true;
                this.item    = item
                this.start(item.cad_tempo_minimo)
                navigator.geolocation.getCurrentPosition(this.success)
            },

            start(timer) {
                var duration = 60 * timer;  // Converter para segundos
                this.resetCronometro();
                this.startTimer(duration); // iniciando o timer
            },

            pause() {
                clearInterval(this.cron)
            },

            resetCronometro() {
                clearInterval(this.cron)
                this.duration = null
                this.timer    = {
                    minutes: 0,
                    seconds: 0
                }
            },

            startTimer(duration) {
                let self  = this;
                let timer = duration

                self.cron = setInterval(function () {
                    self.timer.minutes = parseInt(timer / 60, 10);
                    self.timer.seconds = parseInt(timer % 60, 10);
                    self.timer.minutes = self.timer.minutes < 10 ? "0" + self.timer.minutes : self.timer
                        .minutes;
                    self.timer.seconds = self.timer.seconds < 10 ? "0" + self.timer.seconds : self.timer
                        .seconds;
                    self.text = self.timer.minutes + ":" + self.timer.seconds;

                    if (--timer < 0) {
                        timer = duration;
                    }

                    self.duration = timer
                }, 1000);
            }
        }
    }

</script>
<style>
    .small-box {
        text-align: left !important;
    }

    .small-box .icon {
        display: block;
    }

    div .el-loading-parent--relative {
        position: static !important;
    }

    #map_area{
        height: 30%;
        width : 30%;
    }

    #map {
        position   : absolute;
        height     : 52%;
        width      : 29%;
        font-family: Arial, sans-serif;
        font-size  : .9em;
        color      : #fff;
    }

    #note {
        text-align: center;
        padding   : .3em;
        background: #009ee0;
    }

    .bool {
        font-style: italic;
        color     : #313131;
    }

    .info {
        display         : inline-block;
        width           : 40%;
        text-align      : center;
    }

    .infowin {
        color: #313131;
    }

    #title,
    .bool {
        font-weight: bold;
    }

</style>
