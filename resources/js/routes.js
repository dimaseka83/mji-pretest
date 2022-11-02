import VueRouter from "vue-router";

import Login from "./Page/Login";
import Inventory from "./Page/Inventory";
import Transaksi from "./Page/Transaksi";

const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/inventory",
        name: "inventory",
        component: Inventory,
    },
    {
        path: "/transaksi",
        name: "transaksi",
        component: Transaksi,
    }
];

const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;