<script setup>
import axios from "axios";
import { onMounted, onUnmounted, ref, watch } from "vue";
import { useDateFormat, useNow } from "@vueuse/core";
import { createProjectDetails } from "./create.js";
import { updateProjectDetail } from "./update.js";
import { debounce } from "lodash";

const latestDetail = ref({});
const closedProjectDetails = ref({});
const elapsedTimeFormatted = ref("00:00:00");
const note = ref("");
let loading = ref(false);
let intervalId = null;
let initialNote = ref("");

const props = defineProps({ selectedProject: Object });

const fetchProjectDetails = async () => {
    loading.value = true;
    try {
        const [latest, closed] = await Promise.all([
            axios.get(`/api/projects/${props.selectedProject.id}/details/latest`),
            axios.get(`/api/projects/${props.selectedProject.id}/details/completed`)
        ]);
        latestDetail.value = latest.data || {};
        closedProjectDetails.value = closed.data || {};

        if (!latestDetail.value.isCompleted) {
            note.value = latestDetail.value.note;
            initialNote.value = latestDetail.value.note;
        }
    } catch (error) {
        console.error("Error fetching project details:", error);
    } finally {
        loading.value = false;
    }
};

const updateTrackState = async (state) => {
    const previousDetail = { ...latestDetail.value };

    if (state.isStopped) {
        clearTrackingInterval();
    }

    if (!latestDetail.value.id || latestDetail.value.isCompleted) {
        if (state.start) {
            await createProjectDetails(props.selectedProject.id, { start: state.start, isStarted: true });
        } else {
            await createProjectDetails(props.selectedProject.id, { note: state.note });
        }
    } else {
        await updateProjectDetail(props.selectedProject.id, latestDetail.value.id, state);
    }

    await fetchProjectDetails();

    if (JSON.stringify(previousDetail) !== JSON.stringify(latestDetail.value)) {
        if (state.start || (state.isStarted && !state.isStopped)) {
            startElapsedTimer();
        }
    }
};

const startTrack = async () => {
    if (latestDetail.value.isStarted && !latestDetail.value.isCompleted) return;
    await updateTrackState({ start: useDateFormat(useNow(), "YYYY-MM-DD HH:mm:ss").value, isStarted: true });
    startElapsedTimer();
};

const stopTrack = async () => {
    if (!latestDetail.value.isStarted || latestDetail.value.isStopped) return;
    await updateTrackState({ finish: useDateFormat(useNow(), "YYYY-MM-DD HH:mm:ss").value, isStopped: true });
    clearTrackingInterval();
};

const completeTrackAndClose = async () => {
    if ((!latestDetail.value.start && !latestDetail.value.note) || latestDetail.value.isCompleted) {
        alert("Please provide a start time or note before closing.");
        return;
    }
    if (latestDetail.value.isStopped) {
        await updateTrackState({ isCompleted: true });
    } else if (latestDetail.value.isStarted) {
        await updateTrackState({ finish: useDateFormat(useNow(), "YYYY-MM-DD HH:mm:ss").value, isStopped: true, isCompleted: true });
    } else {
        await updateTrackState({ isCompleted: true });
    }
    resetTrackingState();
    await fetchProjectDetails();
};

const startElapsedTimer = () => {
    clearTrackingInterval();
    intervalId = setInterval(updateElapsedTime, 1000);
};

const clearTrackingInterval = () => {
    if (intervalId) clearInterval(intervalId);
};

const updateElapsedTime = () => {
    if (!latestDetail.value.start) return;
    const start = new Date(latestDetail.value.start);
    const now = new Date();
    const elapsed = Math.floor((now - start) / 1000);

    elapsedTimeFormatted.value = new Date(elapsed * 1000).toISOString().substr(11, 8);
};

const handleNoteUpdate = debounce(async () => {
    if (note.value === "") return;
    await updateTrackState({ note: note.value });
}, 500);

const resetTrackingState = () => {
    note.value = "";
    elapsedTimeFormatted.value = "00:00:00";
    clearTrackingInterval();
};

const resetOrUpdateTrackingWhenModalIsClosed = () => {
    if (latestDetail.value.isStopped) {
        const finish = new Date(latestDetail.value.finish);
        const elapsed = Math.floor((finish - new Date(latestDetail.value.start)) / 1000);
        elapsedTimeFormatted.value = new Date(elapsed * 1000).toISOString().substr(11, 8);
        if(latestDetail.value.isStopped && latestDetail.value.isCompleted) {
            elapsedTimeFormatted.value = "00:00:00";
        }
    } else {
        startElapsedTimer();
    }
};

watch(note, (newValue) => {
    if (newValue !== initialNote.value) {
        handleNoteUpdate();
    }
});
onMounted(async () => {
    await fetchProjectDetails();
    resetOrUpdateTrackingWhenModalIsClosed();
});

onUnmounted(clearTrackingInterval);
</script>

<template>
    <div v-if="loading" class="loading-container">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-else>
        <p><strong>Project Name:</strong> {{ props.selectedProject.name }}</p>
        <div>
            <label for="time">Time: </label>
            <span id="time"> {{ elapsedTimeFormatted }} </span>
        </div>

        <div class="my-3">
            <button class="btn btn-success me-2" @click="startTrack" :disabled="latestDetail.isStarted && !latestDetail.isCompleted">Start</button>
            <button class="btn btn-danger" @click="stopTrack" :disabled="!latestDetail.isStarted || latestDetail.isStopped">Stop</button>
        </div>

        <div>
            <label for="note">Note:</label>
            <textarea id="note" class="form-control" rows="3" v-model="note"></textarea>
        </div>

        <div>
            <button class="btn btn-warning my-3" @click="completeTrackAndClose">
                Close and start new track or note
            </button>
        </div>

        <div v-if = "!latestDetail.isCompleted">
            <h3>Current project</h3>
            <div class="project-details-container">
                <table class="project-details-table">
                    <thead>
                    <tr>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Note</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ latestDetail.start || '-' }}</td>
                        <td>{{ latestDetail.finish || '-' }}</td>
                        <td><pre>{{ latestDetail.note || '-' }}</pre></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="closedProjectDetails && Object.keys(closedProjectDetails).length > 0">
            <h3>Closed project details</h3>
            <div class="project-details-container">
                <table class="project-details-table">
                    <thead>
                    <tr>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Note</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="detail in closedProjectDetails" :key="detail.id">
                        <td>{{ detail.start || "-" }}</td>
                        <td>{{ detail.finish || "-" }}</td>
                        <td><pre>{{ detail.note || '-' }}</pre></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@use "../../../sass/ProjectDetail/list.scss" as *;
</style>
