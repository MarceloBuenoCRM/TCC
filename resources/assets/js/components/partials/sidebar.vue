<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3">
                <div class="d-flex justify-content-center">
                    <img src="/images/logo.png" class="img-circle elevation-2" style="height: 60%; width:60%">
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-header" v-if="tipo_usuario == 0">MENU (Admin)</li>
                    <!-- <li class="nav-item"  v-if="tipo_usuario == 0" :class="{'menu-open': isModuloMenu($route.name, 'principal.dashboard')}">
                        <a href="/principal" class="nav-link"
                            :class="{'active': isModuloMenu($route.name, 'principal.dashboard')}">
                            <i class="fas fa-home"></i>
                            <p>
                                Home
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/" class="nav-link"
                                    :class="{'active': isMenu($route, 'principal.dashboard.index')}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li> -->

                    <li class="nav-item" v-if="tipo_usuario == 0" :class="{'menu-open': isModuloMenu($route.name, 'admin.cadastro')}">
                        <a href="/admin/cadastro" class="nav-link" :class="{'active': isModuloMenu($route.name, 'admin.cadastro')}">
                            <i class="fas fa-edit"></i>
                            <p>
                                Cadastro
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/cadastro/usuario/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'admin.cadastro.usuario.index')}">
                                    <i class="fas fa-user-plus"></i>
                                    <p>
                                        Usuários
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/admin/cadastro/sala_aula/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'admin.cadastro.sala_aula.index')}">
                                    <i class="fas fa-school"></i>
                                    <p>
                                        Sala de Aula
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item" v-if="tipo_usuario == 0" :class="{'menu-open': isModuloMenu($route.name, 'admin.solicitacao')}">
                        <a href="/admin/solicitacao" class="nav-link" :class="{'active': isModuloMenu($route.name, 'admin.solicitacao')}">
                            <i class="fas fa-headset"></i>
                            <p>
                                Solicitação
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/solicitacao/intervencao/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'admin.solicitacao.intervencao.index')}">
                                    <i class="fas fa-id-card"></i>
                                    <p>
                                        Intervenção
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header" v-if="tipo_usuario == 1">MENU (Professor)</li>
                    <li class="nav-item" v-if="tipo_usuario == 1" :class="{'menu-open': isModuloMenu($route.name, 'professor.cadastro')}">
                        <a href="/professor/cadastro" class="nav-link" :class="{'active': isModuloMenu($route.name, 'professor.cadastro')}">
                            <i class="fas fa-edit"></i>
                            <p>
                                Cadastro
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/professor/cadastro/aula/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'professor.cadastro.aula.index')}">
                                    <i class="fas fa-spell-check"></i>
                                    <p>
                                        Aula
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item" v-if="tipo_usuario == 1" :class="{'menu-open': isModuloMenu($route.name, 'professor.solicitacao')}">
                        <a href="/professor/solicitacao" class="nav-link" :class="{'active': isModuloMenu($route.name, 'professor.solicitacao')}">
                            <i class="fas fa-headset"></i>
                            <p>
                                Solicitação
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/professor/solicitacao/intervencao/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'professor.solicitacao.intervencao.index')}">
                                    <i class="fas fa-id-card"></i>
                                    <p>
                                        Intervenção
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header" v-if="tipo_usuario == 2">MENU (Aluno)</li>
                    <li class="nav-item" v-if="tipo_usuario == 2" :class="{'menu-open': isModuloMenu($route.name, 'aluno.aulas')}">
                        <a href="/aluno/aulas" class="nav-link" :class="{'active': isModuloMenu($route.name, 'aluno.aulas')}">
                            <i class="fas fa-school"></i>
                            <p>
                                Aulas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/aluno/aulas/aulas_reservadas/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'aluno.aulas.aulas_reservadas.index')}">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <p>
                                        Aulas Reservadas
                                    </p>
                                </a>
                            </li>

                             <li class="nav-item">
                                <a href="/aluno/aulas/historico/index" class="nav-link"
                                    :class="{'active': isMenu($route, 'aluno.aulas.historico.index')}">
                                    <i class="fas fa-history"></i>
                                    <p>
                                        Histórico
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
    export default {
        data() {
            return {
                tipo_usuario: Cookie.get("tipo_usuario")
            }
        },

        methods: {
            isModuloMenu(route, nome) {
                route = route.split('.');

                return route[0] + '.' + route[1] === nome;
            },

            isMenu(route, nome) {
                return route.name == nome;
            }
        }
    }
</script>
