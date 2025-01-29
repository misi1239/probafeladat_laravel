import axios from "axios";

export const updateProjectDetail = async (projectId, id, data) => {
    try {
        await axios.patch(`/api/projects/${projectId}/details/update/${id}`, data);
    } catch (error) {
        console.error("Error updating project detail:", error);
    }
};
