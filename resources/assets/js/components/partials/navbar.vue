<template>
    <nav class="main-header navbar navbar-expand"
        :class="{'navbar-dark': dark_mode == true, 'navbar-white navbar-light': dark_mode == false}">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

            <li class="nav-item">
                <div class="nav-link">
                    <div class="custom-control custom-switch">
                        <input v-model="dark_mode" type="checkbox" class="custom-control-input" id="customSwitch1"
                            @change="updateDarkMode">
                        <label class="custom-control-label" for="customSwitch1">Modo Escuro</label>
                    </div>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-cog"></i>
                    {{cad_nome}}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="/logout" class="dropdown-item text-center">
                        <i class="fas fa-user"></i>
                        Meu Perfil
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/logout" class="dropdown-item text-center">
                        <i class="fas fa-sign-out-alt"></i>
                        Sair
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                dark_mode: Cookie.get("modo_escuro") == 1 ? true : false,
                cad_nome: Cookie.get("cad_nome")
            }
        },

        watch: {
            dark_mode(val) {
                if (val == true) {
                    Cookie.set("modo_escuro", 1)
                } else {
                    Cookie.set("modo_escuro", 0)
                }
            }
        },

        mounted() {
            this.setDarkMode();
        },

        methods: {
            setDarkMode() {
                let self = this;

                self.dark_mode = Cookie.get("modo_escuro") == 1 ? true : false;

                if (self.dark_mode == 1) {
                    $('#body').addClass('dark-mode');
                } else {
                    $('#body').removeClass('dark-mode');
                }
            },

            updateDarkMode() {
                let self = this;
                let modo_escuro = self.dark_mode ? 1 : 0;

                axios.put('/sistema/usuario/modo_escuro/' + modo_escuro)
                    .then(function () {
                        self.setDarkMode();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>
