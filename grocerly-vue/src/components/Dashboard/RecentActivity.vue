<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { onMounted, ref, type Ref } from 'vue'
import type { Recipe } from '@/types/recipe';
import { RecipeService } from '@/services/RecipeService';
import { ListService } from '@/services/ListService';
import type { ShoppingList } from '@/types/shoppingList';
import RecipeCard from './RecipeCard.vue';
import ShoppingListCard from './ShoppingListCard.vue';
//Instance list and recipes services to fetch the API
const recipeService: RecipeService = new RecipeService
const listService: ListService = new ListService

//Reactive arrays with the recipes and lists fetched
const recipes: Ref<Recipe[]> = ref([]);
const lists = ref<ShoppingList[]>([])

//UX-UI auxiliar variables
const recipesLoading = ref(true)
const listsLoading = ref(true)
const recipesError = ref<boolean>(false)
const listsError = ref<boolean>(false)
const recipesErrorMsg = ref<string>('')
const listsErrorMsg = ref<string>('')
onMounted(async () => {
    // RECIPES
    try {
        recipesLoading.value = true
        recipes.value = await recipeService.getMyRecipes()
    } catch (e) {
        recipesError.value = true
        recipesErrorMsg.value = "Can't load recipes, try again later"
    } finally {
        recipesLoading.value = false
    }
    // LISTS
    try {
        listsLoading.value = true
        lists.value = await listService.getMyLists()
    } catch (e) {
        listsError.value = true;
        listsErrorMsg.value = "Can't load lists, try again later"
    } finally {
        listsLoading.value = false
    }
})
</script>

<template>
    <article class="activity">
        <div class="recipes">
            <div class="heading">
                <h4>My Recipes</h4>
                <router-link to="/recipes">See all</router-link>
            </div>
            <RecipeCard v-if="recipes.length > 0" v-for="recipe in recipes" :key="recipe.id!" :recipe="recipe" />
            <p v-else>No recipes created, <span class="cta"> create one now!</span></p>
        </div>
        <div class="lists">
            <div class="heading">
                <h4>Shopping Lists</h4>
                <router-link to="/shopping-lists">See all</router-link>
            </div>
            <ShoppingListCard v-if="lists.length > 0" v-for="list in lists" :key="list.listId!" :list="list" />
            <p v-else>No shopping lists created, <span class="cta"> create one now!</span></p>
        </div>
    </article>
</template>

<style scoped>
.activity {
    width: 100%;
    max-width: 800px;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: flex-start;
    gap: .5rem;
}

.lists,
.recipes {
    box-shadow: var(--shadow-md);
    background-color: var(--bg-card);
    padding: 15px 10px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.recipes {
    width: 55%;
}

.lists {
    width: 45%;
}

.heading {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.cta {
    color: var(--accent-primary);
    cursor: pointer;
    text-decoration: underline;
    transition: all .25s ease;
}

.cta:hover {
    color: var(--accent-primary-hover);
}
</style>
