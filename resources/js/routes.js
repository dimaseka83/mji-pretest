import VueRouter from "vue-router";

import Login from "./Page/Login";
import Inventory from "./Page/Inventory";
import Penjualan from "./Page/Penjualan";
import Pembelian from "./Page/Pembelian";

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
        path: "/pembelian",
        name: "pembelian",
        component: Pembelian,
    },
    {
        path: "/penjualan",
        name: "penjualan",
        component: Penjualan,
    }
];

const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;