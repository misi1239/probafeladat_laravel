<script setup>
import axios from "axios";

const downloadExcel = async () => {
    try {
        const response = await axios.get(`/api/export-closed-project`, {
            responseType: 'blob'
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'closed_project.xlsx');
        document.body.appendChild(link);
        link.click();
    } catch (error) {
        console.error("Error downloading the Excel file:", error);
    }
};
</script>

<template>
    <div>
        <button @click="downloadExcel" class="btn btn-warning">Export closed project to the excel file</button>
    </div>
</template>
