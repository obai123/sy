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
                <!-- Edit Button -->
                <v-btn class="edit-btn" icon v-bind="props">
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <div class="head-title mb-4">Update Category</div>
                </v-card-title>
                <v-card-subtitle>
                    <v-form>
                        <v-img
                            :src="
                                category.picture ||
                                'https://via.placeholder.com/400x200'
                            "
                            height="200px"
                            class="white--text mb-4"
                            contain
                        ></v-img>

                        <v-text-field
                            prepend-icon="mdi-text-short"
                            v-model="category.title"
                            label="Title"
                            required
                        ></v-text-field>
                        <v-textarea
                            prepend-icon="mdi-text"
                            v-model="category.description"
                            label="Description"
                            rows="3"
                        ></v-textarea>
                        <v-text-field
                            prepend-icon="mdi-text-short"
                            v-model="category.location"
                            label="Location"
                        ></v-text-field>
                        <v-file-input
                            class="w-50"
                            v-model="category.picture"
                            variant="outlined"
                            label="Update picture"
                            accept="image/*"
                            prepend-icon="mdi-image"
                        ></v-file-input>
                    </v-form>
                </v-card-subtitle>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialog = false">Cancel</v-btn>
                    <v-btn color="#6d8d73" @click="updateCategory"
                        >Update</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const dialog = ref(false);

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
});

const picture = ref(null);
const updateCategory = async () => {
    const formData = new FormData();
    formData.append("id", props.category.id);
    formData.append("title", props.category.title);
    formData.append("description", props.category.description);
    formData.append("location", props.category.location);
    formData.append("picture", props.category.picture);

    // if (picture.value) {
    //     props.category.picture = picture.value;
    //     formData.append("picture", picture.value);
    // }

    try {
        // Implement the logic to save the category using Laravel API
        await router.post(route("categories.edit"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        dialog.value = false;
    } catch (error) {
        console.error("Error saving category:", error);
        alert("Failed to save the category.");
    }
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
