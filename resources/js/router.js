import vueRouter from 'vue-router';
import Vue from 'vue';
import Index from "./views/Index";
import Members from "./views/Members";

Vue.use(vueRouter);

const routes = [
    {
        path: "/",
        component: Index,
        meta: { transition: 'slide-left' },
    },
    {
        path: "/members",
        component: Members,
        meta: { transition: 'slide-right' },
    },
];

export default new vueRouter({
    mode: "history",
    routes,

});
