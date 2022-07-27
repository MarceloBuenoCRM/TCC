export default {
    'SHOW_LOADING'(state) {
        state.loading = true;
    },

    'HIDE_LOADING'(state) {
        state.loading = false;
    },

    'LOADING_USUARIOS'(state, usuarios) {
        state.usuarios = usuarios;
    },
}
