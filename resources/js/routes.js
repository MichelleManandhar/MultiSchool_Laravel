import Vue from "vue";
import VueRouter from "vue-router";
import Home from "@/js/components/Home";
import Sign from "@/js/components/Sign";
import DashboardMain from "@/js/layouts/DashboardMain";
import DashBody from "@/js/components/DashBody";
import RightContent from "@/js/layouts/RightContent";
import AddSubject from "@/js/components/AddSubject";
import "../../node_modules/ag-grid/dist/styles/ag-grid.css";
import "../../node_modules/ag-grid-community/dist/styles/ag-theme-balham.css";
import "../../node_modules/ag-grid-community/dist/styles/ag-theme-blue.css";


const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: "/sign",
        name: "sign",
        component: Sign,
        meta: {
            auth: false
        }
    },
    {
        path: "/dashboard",
        name: "DashboardMain",
        component: DashboardMain,
        meta: {
            auth: true,
            redirect: "/sign",
            forbiddenRedirect: "/403"
        },
        children: [
            {
                path: "",
                name: "mainDashBoard",
                component: DashBody
            },
            {
                path: ":classname/:classid/:sectionname/:sectionid",
                name: "classTab",
                component: RightContent
            },
            {
                path: "add-subject",
                name: "subjectStore",
                component: AddSubject
            }
        ]
    }
];
const router = new VueRouter({
    history: true,
    mode: "history",
    routes
});
export default router;
