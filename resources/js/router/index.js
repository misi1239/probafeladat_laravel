import { createRouter, createWebHistory } from "vue-router";
import notFound from "../components/NotFoundPage.vue"
import projectList from "../components/Project/list.vue"

const routes = [
    {
        path: "/",
        component: projectList
    },
    {
        path: "/projects/:id",
        component: projectList,
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
