import vueRouter from 'vue-router';
import Vue from 'vue';
import Index from "./views/Index";
import Members from "./views/Members";

Vue.use(vueRouter);

const routes = [
    {
        path: "/",
        component: Index
    },
    {
        path: "/members",
        component: Members
    },
];

export default new vueRouter({
    mode: "history",
    routes
});
