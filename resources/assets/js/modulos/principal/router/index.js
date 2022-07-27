import Vue from 'vue'
import Router from 'vue-router'
import routes from './routes.js'

Vue.use(Router);

let routesModule = [];

routes.forEach(function (route) {
    routesModule.push({
        path: route.path,
        name: route.name,
        component: require("../" + route.component + '.vue').default
    })
});

routesModule.push({path: '*', redirect: {name: 'index'}});

const router = new Router({
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior: () => ({y: 0}),
    base: '/',
    routes: routesModule
});

export default router;
