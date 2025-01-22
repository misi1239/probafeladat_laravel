import { createRouter, createWebHistory } from "vue-router";
import notFound from "../components/NotFoundPage.vue"
import mainPage from "../components/MainPage/list.vue"

const routes = [
    {
        path: "/",
        component: mainPage
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
