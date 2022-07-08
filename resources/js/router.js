import vueRouter from 'vue-router';
import Vue from 'vue';
import Index from "./views/Index";
import Members from "./views/Members";
import Admin from "./views/Admin";
import MemberInfo from "./views/MemberInfo";

Vue.use(vueRouter);

const routes = [
    {
        path: "/",
        component: Index,
        meta: {transition: 'slide-left'},
    },
    {
        path: "/members",
        component: Members,
        meta: {transition: 'slide-right'},
    },
    {
        path: '/admin/dashboard',
        component: Admin,
        meta: {transition: 'slide-right'},
    },
    {
        path: '/admin/member-info/:memberId',
        component: MemberInfo,
        meta: {transition: 'slide-right'},
        props: true
    },
];

export default new vueRouter({
    mode: "history",
    routes,

});
