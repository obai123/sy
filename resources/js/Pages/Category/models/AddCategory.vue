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
                    <div class="head-title mb-4">Add New Category</div>
                </v-card-title>
                <v-card-subtitle>
                    <v-form>
                        <v-text-field
                            prepend-icon="mdi-text-short"
                            v-model="newCategory.title"
                            label="Title"
                            required
                        ></v-text-field>
                        <v-textarea
                            prepend-icon="mdi-text"
                            v-model="newCategory.description"
                            label="Description"
                            rows="3"
                        ></v-textarea>
                        <v-text-field
                            prepend-icon="mdi-text-short"
                            v-model="newCategory.location"
                            label="Location"
                        ></v-text-field>
                        <v-file-input
                            class="w-50"
                            v-model="picture"
                            variant="outlined"
                            label="Upload picture"
                            accept="image/*"
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
                    <v-btn color="#6d8d73" @click="saveCategory">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const dialog = ref(false);
const newCategory = ref({
    title: "",
    description: "",
    location: "",
});

const reset = () => {
    newCategory.value.title = "";
    newCategory.value.description = "";
    newCategory.value.location = "";
    picture.value = null;
};

const getParentIdFromUrl = () => {
    const urlSegments = window.location.pathname.split("/");
    // Assuming the parent_id is in the last segment of the URL

    return urlSegments[urlSegments.length - 1];
};

const picture = ref(null);
const saveCategory = async () => {
    const formData = new FormData();
    formData.append("title", newCategory.value.title);
    formData.append("description", newCategory.value.description);
    formData.append("location", newCategory.value.location);
    formData.append("parent_category_id", getParentIdFromUrl());

    if (picture.value) {
        formData.append("picture", picture.value);
    }

    try {
        // Implement the logic to save the category using Laravel API
        await router.post(route("categories.store"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        dialog.value = false;
    } catch (error) {
        console.error("Error saving category:", error);
        alert("Failed to save the category.");
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
    border-radius: 10px;
    padding: 10px;
    white-space: normal;
}
</style>
