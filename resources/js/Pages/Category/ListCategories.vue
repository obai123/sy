<template>
    <v-container>
        <!-- Main Container -->
        <div class="main-container">
            <!-- Main Category Title -->
            <div class="main-category">Main Category</div>

            <AddCategory />
        </div>

        <!-- Render categories -->
        <v-row>
            <v-col
                v-for="category in categories"
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
                    <v-card-title>{{ category.title }}</v-card-title>
                    <v-card-subtitle>{{
                        category.description
                    }}</v-card-subtitle>
                    <v-card-subtitle
                        >Location: {{ category.location }}</v-card-subtitle
                    >
                    <v-card-actions>
                        <!-- Details Button -->
                        <v-btn
                            class="details-btn"
                            text
                            @click="showDetails(category.id)"
                        >
                            Details
                        </v-btn>

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
    </v-container>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import AddCategory from "./models/AddCategory.vue";
import UpdateCategory from "./models/UpdateCategory.vue";
import { ref } from "vue";
const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const categories = ref(props.categories || []);

const showDetails = (id) => {
    router.visit(route("categories.show", { id }));
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
            alert("Category to delete the file.");
        }
    }
};
</script>

<style scoped>
.main-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.main-category {
    font-weight: bold;
    font-size: 25px;
    color: #000;
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

.edit-btn {
    color: #000;
}

.edit-btn:hover {
    background-color: #1976d2;
    color: white;
}

.delete-btn {
    color: red;
}

.delete-btn:hover {
    background-color: red;
    color: white;
}
</style>
