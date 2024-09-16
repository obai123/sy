<template>
    <div>
        <!-- Success Message -->
        <v-alert v-if="successMessage" type="success" dismissible>
            {{ successMessage }}
        </v-alert>

        <!-- Error Message -->
        <v-alert v-if="errorMessage" type="error" dismissible>
            {{ errorMessage }}
        </v-alert>

        <!-- The rest of your dialog -->
        <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ props }">
                <v-btn icon class="mx-2" color="#000" v-bind="props">
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <div class="head-title mb-4">Upload New File</div>
                </v-card-title>
                <v-card-subtitle>
                    <v-form>
                        <v-text-field
                            prepend-icon="mdi-text-short"
                            v-model="newFile.title"
                            label="Title"
                            required
                        ></v-text-field>
                        <v-file-input
                            class="w-75"
                            v-model="newFile.file"
                            variant="outlined"
                            label="Upload File"
                            accept="*/*"
                            prepend-icon="mdi-image"
                        ></v-file-input>
                    </v-form>
                </v-card-subtitle>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        @click="
                            reset();
                            dialog = false;
                        "
                        >Cancel</v-btn
                    >
                    <v-btn color="#6d8d73" @click="uploadFile">Upload</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const dialog = ref(false);
const newFile = ref({
    title: "",
    file: null,
});

const reset = () => {
    newFile.value.title = "";
    newFile.value.file = null;
};

const getParentIdFromUrl = () => {
    const urlSegments = window.location.pathname.split("/");
    return urlSegments[urlSegments.length - 1];
};

const uploadFile = async () => {
    const formData = new FormData();
    formData.append("title", newFile.value.title);
    formData.append("category_id", getParentIdFromUrl());
    formData.append("file", newFile.value.file);

    try {
        await router.post(route("file.upload"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        dialog.value = false;
    } catch (error) {
        console.error("Error upload file:", error);
        alert("Failed to upload file.");
    }

    reset();
};
</script>

<style scoped>
.head-title {
    text-align: center;
    background-color: #6d8d73;
    color: rgb(255, 255, 255);
    font-size: large;
    font-weight: bold;
    border-radius: 1px;
    padding: 10px;
    white-space: normal;
}
</style>
