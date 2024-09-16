<template>
    <main-layout>
        <v-container>
            <div class="main-container">
                <div class="main-category">
                    {{ data.data.title + " - " + data.data.description }}
                </div>
                <AddCategory />
            </div>
            <v-row>
                <v-col
                    v-for="category in data.data.subcategories"
                    :key="category.id"
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                >
                    <v-card>
                        <v-img
                            :src="
                                category.picture ||
                                'https://via.placeholder.com/400x200'
                            "
                            height="200px"
                            class="white--text"
                            contain
                        ></v-img>
                        <v-card-title>
                            {{ category.title }}
                        </v-card-title>
                        <v-card-subtitle>
                            {{ category.description }}
                        </v-card-subtitle>
                        <v-card-subtitle>
                            Location: {{ category.location }}
                        </v-card-subtitle>
                        <v-card-actions>
                            <v-btn
                                class="details-btn"
                                text
                                @click="showDetails(category.id)"
                                >Details</v-btn
                            >

                            <!-- Spacer to separate Details and Edit buttons -->
                            <v-spacer></v-spacer>

                            <UpdateCategory :category="category" />

                            <!-- Delete Button -->
                            <v-btn
                                class="delete-btn"
                                icon
                                @click="deleteCategory(category.id)"
                            >
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>

            <!-- Files -->
            <div class="section-separator">
                <span class="section-title">Files</span>
            </div>

            <UploadFile class="mb-3" />
            <v-row>
                <v-col
                    v-for="file in data.data.files"
                    :key="file.id"
                    cols="12"
                    sm="4"
                    md="3"
                    lg="3"
                >
                    <v-card class="file-card">
                        <v-card-title>
                            <v-icon class="file-icon" large>mdi-file</v-icon>
                        </v-card-title>
                        <v-card-subtitle>{{ file.title }}</v-card-subtitle>
                        <v-card-subtitle>{{ file.mime }} File</v-card-subtitle>
                        <v-card-subtitle>
                            {{
                                file.size < 1024
                                    ? file.size + "KB"
                                    : file.size + "MB"
                            }}
                        </v-card-subtitle>

                        <v-card-actions>
                            <!-- Open Icon Button -->
                            <v-btn icon @click="fileOpen(file.id)">
                                <v-icon>mdi-open-in-new</v-icon>
                            </v-btn>

                            <!-- Spacer to separate the Open button from the others -->
                            <v-spacer></v-spacer>

                            <!-- Download Icon Button -->
                            <v-btn icon @click="fileDownload(file.id)">
                                <v-icon>mdi-download</v-icon>
                            </v-btn>

                            <!-- Delete Icon Button -->
                            <v-btn icon @click="fileDelete(file.id)">
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </main-layout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { router } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";
import AddCategory from "./AddCategory.vue";
import UpdateCategory from "./UpdateCategory.vue";
import UploadFile from "./UploadFile.vue";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const files = ref(props.data.files || []); // Default to empty array if files are undefined

const showDetails = (id) => {
    router.visit(route("categories.show", { id }));
};

const fileOpen = (id) => {
    window.open(route("file.display", { id }), "_blank");
};

const fileDownload = (id) => {
    window.location.href = route("file.download", { id });
};

const fileDelete = async (id) => {
    if (confirm("Are you sure you want to delete this file?")) {
        try {
            // Send a delete request to the backend
            await router.delete(route("file.delete", { id }), {
                preserveState: true,
            });

            files.value = files.value.filter((file) => file.id !== id);

            alert("File deleted successfully.");
        } catch (error) {
            console.error("Error deleting file:", error);
            alert("Failed to delete the file.");
        }
    }
};

const deleteCategory = async (id) => {
    if (confirm("Are you sure you want to delete this Category?")) {
        try {
            await router.delete(route("categories.destroy", { id }), {
                preserveState: true,
            });

            if (true) {
                //

                categories.value = categories.value.filter(
                    (category) => category.id !== id
                );

                alert("Category deleted successfully.");
            } else {
                alert("Faild delete Category beacuse it not empty.");
            }
        } catch (error) {
            console.error("Error deleting file:", error);
            alert("Faild to delete the Category.");
        }
    }
};
</script>

<style scoped>
.main-category {
    width: 100%;
    font-weight: bold;
    font-size: 25px;
    color: #000;
    margin-bottom: 16px;
}

.v-card {
    margin-bottom: 16px;
}

.details-btn {
    border: 1px solid #000;
    color: #1976d2;
    border-radius: 4px;
}

.details-btn:hover {
    background-color: #000;
    color: white;
}

.section-separator {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    position: relative;
    margin: 20px 0;
}

.section-separator::before,
.section-separator::after {
    content: "";
    flex: 1;
    border-bottom: 2px solid #000;
}

.section-separator::before {
    margin-right: 10px;
}

.section-separator::after {
    margin-left: 10px;
}

.section-title {
    font-weight: bold;
    font-size: 25px;
    color: #000;
    font-weight: 500;
}

.open-folder-btn,
.download-btn,
.open-btn {
    border: 1px solid #000;
    color: #1976d2;
}

.open-folder-btn:hover,
.download-btn:hover,
.open-btn:hover {
    background-color: #000;
    color: white;
}

.main-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
</style>
