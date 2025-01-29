<script setup>
import create from "./create.vue";
import modal from "../modal.vue";
import {ref, onMounted} from "vue";
import {useRouter} from "vue-router";
import projectDetails from "../ProjectDetails/list.vue";

const showModal = ref(false);
const selectedProject = ref(null);
const router = useRouter();

let isLoading = ref(false);
let projects = ref({});

const getProjects = async () => {
    isLoading.value = true;
    try {
        projects.value = await axios.get("/api/projects");
    } catch (error) {
        console.error("Error fetching projects:", error);
    } finally {
        isLoading.value = false;
    }
};

const openModal = (project) => {
    selectedProject.value = project;
    showModal.value = true;
    router.push({ path: `/projects/${project.id}` });
};

const closeModal = () => {
    showModal.value = false;
    router.back();
};

onMounted(async () => {
    await getProjects();
});
</script>

<template>
    <section class="vh-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-12 col-xl-10">
                    <div class="card mask-custom">
                        <div class="card-body p-4 text-white">
                            <div class="text-center pt-3 pb-2">
                                <h2 class="my-4">Track Time For Projects</h2>
                            </div>
                            <div v-if="isLoading" class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                <div class="spinner-border text-light" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <table class="table table-hover text-white mb-0 text-center" v-else>
                                <thead>
                                <tr>
                                    <td colspan="3">
                                        <create @getProjects="getProjects"></create>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Project Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="project in projects.data"
                                    :key="project.id"
                                    @click="openModal(project)"
                                    class="fw-normal"
                                    style="cursor: pointer;"
                                >
                                    <td class="align-middle">
                                        <span>{{ project.id }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span>{{ project.name }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Teleport to="body">
            <modal v-if="showModal" :show="showModal" @close="showModal = false">
                <template #header>
                    <h3>Add timer and notes to the project</h3>
                </template>

                <template #body>
                    <project-details :selectedProject="selectedProject"></project-details>
                </template>

                <template #footer>
                    <button class="btn btn-secondary" @click="closeModal">
                        Cancel
                    </button>
                </template>
            </modal>
        </Teleport>
    </section>
</template>

<style scoped lang="scss">
@use "../../../sass/Project/list.scss" as *;
</style>
