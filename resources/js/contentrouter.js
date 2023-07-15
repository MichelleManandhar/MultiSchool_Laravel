import Vue from 'vue';
import VueRouter from 'vue-router';
// import Home from '@/js/components/Home';
// import Sign from '@/js/components/Sign';
// import DashboardMain from '@/js/layouts/DashboardMain'
import RightContent from '@/js/layouts/RightContent'
import DashBody from '@/js/components/DashBody'

Vue.use(VueRouter);

const routes = [
    {
        path: 'dashboard/',
        name: 'Dashboard',
        Component: DashBody
    },
    {
        path: 'dashboard/class/:classid/section/:sectionid',
        name: 'Class',
        component: RightContent
    }
];
const ContentRouter = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});
export default ContentRouter