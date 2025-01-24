<script setup>
import create from "./create.vue";
import {onMounted, ref} from "vue";

let projects = ref([])

onMounted( ()=> {
    getProjects()
})

const getProjects = async () => {
    try {
        let response = await axios.get("/api/projects");
        projects.value = response.data;
    } catch (error) {
        console.error("Error fetching projects:", error);
    }
};

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

                            <table class="table table-hover text-white mb-0">
                                <thead>
                                <tr>
                                    <td colspan="2">
                                        <create></create>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="project in projects" :key="project.id" class="fw-normal">
                                    <td class="align-middle">
                                        <span>{{ project.name }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="#!" data-bs-toggle="tooltip" title="Remove">
                                            <i class="fas fa-trash-alt fa-lg text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
    @use "../../../sass/Project/list.scss" as *;
</style>
