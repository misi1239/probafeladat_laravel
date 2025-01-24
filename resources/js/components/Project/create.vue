<script setup>
import { ref } from "vue";
import axios from "axios";

let nameData = ref("");
let errorMessage = ref("");

const saveProject = async () => {
    if (!nameData.value) {
        errorMessage.value = "The project name is required!";
        return;
    }

    try {
        await axios.post("/api/projects/create", {
            name: nameData.value,
        });

        alert("Project successfully saved!");
        nameData.value = "";
        errorMessage.value = "";
    } catch (error) {
        errorMessage.value = "An error occurred while saving the project!";
    }
};
</script>

<template>
    <div class="input-group">
        <input
            type="text"
            v-model="nameData"
            class="form-control"
            placeholder="Add new Project"
            aria-label="add-new-project"
            aria-describedby="basic-addon1"
        />
        <button class="btn btn-success" type="button" id="basic-addon1" @click="saveProject">
            Add
        </button>
    </div>
    <span v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</span>
</template>
