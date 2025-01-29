import axios from "axios";

export const createProjectDetails = async (projectId, data) => {
    try {
        await axios.post(`/api/projects/${projectId}/details/create`, data);
    } catch (error) {
        console.error("Error creating project detail:", error);
    }
};
