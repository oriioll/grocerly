<script setup lang="ts">
import { type Ref, ref, computed, onMounted } from 'vue';
import type { Food } from '../../types/food';
import { FoodService } from '@/services/FoodService';
import { RecipeService } from '@/services/RecipeService';
import type { RecipeFoodInput, RecipeCreationPayload } from '@/types/recipeCreation';

const props = defineProps<{
    type: 'recipe' | 'list',
    show: boolean
}>()
const emit = defineEmits(['close'])

// Services and data used by the food picker.
const foodService: FoodService = new FoodService();
const foods: Ref<Food[]> = ref([]);
const foodError: Ref<boolean> = ref(false);
const foodErrorMsg: Ref<string> = ref('');

//Services data, and UX-UI variables used when managing new recipes or lists
const recipeService: RecipeService = new RecipeService();
const recipeError: Ref<boolean> = ref(false);
const recipeErrorMsg: Ref<string> = ref('');
const isRecipeLoading: Ref<boolean> = ref(false);

// Values entered in the recipe form.
const recipeName = ref('');
const recipeIsPublic = ref(false);
const recipeServings = ref(1);
const recipeFoodIds = ref<number[]>([]);
const recipeFoodGrams = ref<Record<number, number>>({});

// Values entered in the shopping list form.
const shoppingListFoodIds = ref<number[]>([]);

// Search text and foods shown in the picker.
const foodSearch = ref('');
// Foods without an ID cannot be sent back to the API.
const availableFoods = computed(() => foods.value.filter((food): food is Food & { id: number } => food.id !== null));
const filteredFoods = computed(() => {
    const search = foodSearch.value.trim().toLowerCase();

    if (!search) {
        return availableFoods.value;
    }

    return availableFoods.value.filter((food) => food.name.toLowerCase().includes(search));
});
const selectedRecipeFoods = computed<RecipeFoodInput[]>(() => recipeFoodIds.value
    .map((foodId) => {
        const food = availableFoods.value.find((item) => item.id === foodId);
        return food ? { food, grams: recipeFoodGrams.value[foodId] ?? 100 } : null;
    })
    .filter((recipeFood): recipeFood is RecipeFoodInput => recipeFood !== null));


// Load all foods once so the picker can search them locally.
onMounted(async () => {
    try {
        foods.value = await foodService.getFoods();
    } catch (e: any) {
        foodError.value = true;
        foodErrorMsg.value = e.message || 'Cannot get foods, try again later.'
    }
})


/**
 * Handles the recipe creation by calling the recipe service to make and API request and handles possible errors and display them
 */
const handleRecipeCreation = async () => {
    try {
        const newRecipe: RecipeCreationPayload = {
            name: recipeName.value,
            is_public: recipeIsPublic.value,
            servings: recipeServings.value,
            //Use destructuring to extract only food and grams for the foods
            foods: selectedRecipeFoods.value.map(({ food, grams }) => ({
                food_id: food.id,
                grams,
            })),
        }
        await recipeService.postRecipe(newRecipe)
    } catch (e: any) {
        recipeError.value = true;
        recipeErrorMsg.value = e.message || "Can't create the recipe, try again later."
    } finally {
        isRecipeLoading.value = false;
    }
}
</script>
<template>
    <section class="creation-side-panel" :class="props.show ? 'true' : 'false'">
        <header class="creation-side-panel__header">
            <svg @click="emit('close')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                <path fill="var(--color-text)"
                    d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z" />
            </svg>
        </header>

        <form v-if="props.type === 'recipe'" class="creation-form recipe-form" @submit.prevent="handleRecipeCreation">
            <h2>Create a recipe</h2>

            <div class="recipe-form__details">
                <div class="recipe-form__field recipe-form__field--name">
                    <label for="recipe-name">Name</label>
                    <input id="recipe-name" v-model="recipeName" type="text" required>
                </div>

                <label class="recipe-form__field recipe-form__field--public" for="recipe-public">
                    <span>Public recipe</span>
                    <input id="recipe-public" v-model="recipeIsPublic" type="checkbox">
                </label>

                <div class="recipe-form__field recipe-form__field--servings">
                    <label for="recipe-servings">Servings</label>
                    <input id="recipe-servings" v-model.number="recipeServings" type="number" min="1" required>
                </div>
            </div>

            <!-- Search the loaded foods and select more than one for the recipe. -->
            <fieldset class="food-selector">
                <legend>Foods</legend>
                <input id="recipe-food-search" v-model="foodSearch" class="food-selector__search" type="search"
                    placeholder="Search foods..." aria-label="Search foods">
                <div class="food-selector__options">
                    <label v-for="food in filteredFoods" :key="food.id" class="food-selector__option">
                        <input v-model="recipeFoodIds" type="checkbox" :value="food.id">
                        <span>{{ food.name }}<span class="text-muted">{{ food.kcal ? " - " + food.kcal + "kcal" : ""
                        }}</span></span>
                    </label>
                    <p v-if="filteredFoods.length === 0" class="food-selector__empty">No foods found.</p>
                </div>
                <div v-if="selectedRecipeFoods.length" class="food-selector__selected">
                    <div v-for="recipeFood in selectedRecipeFoods" :key="recipeFood.food.id"
                        class="food-selector__selected-item">
                        <label :for="`recipe-food-grams-${recipeFood.food.id}`">{{ recipeFood.food.name }}
                            (grams)</label>
                        <input :id="`recipe-food-grams-${recipeFood.food.id}`"
                            v-model.number="recipeFoodGrams[recipeFood.food.id]" type="number" min="0" required>
                    </div>
                </div>
            </fieldset>

            <button type="submit">Create recipe</button>
        </form>

        <form v-else class="creation-form" @submit.prevent>
            <h2>Create a shopping list</h2>

            <!-- The same picker is reused here, but its values belong to the list. -->
            <fieldset class="food-selector">
                <legend>Foods</legend>
                <input id="shopping-list-food-search" v-model="foodSearch" class="food-selector__search" type="search"
                    placeholder="Search foods..." aria-label="Search foods">
                <div class="food-selector__options">
                    <label v-for="food in filteredFoods" :key="food.id" class="food-selector__option">
                        <input v-model="shoppingListFoodIds" type="checkbox" :value="food.id">
                        <span>{{ food.name }}<span class="text-muted">{{ food.kcal ? " - " + food.kcal + "kcal" : ""
                        }}</span></span>
                    </label>
                    <p v-if="filteredFoods.length === 0" class="food-selector__empty">No foods found.</p>
                </div>
            </fieldset>

            <button type="submit">Create shopping list</button>
        </form>

        <p v-if="foodError" class="creation-side-panel__error">{{ foodErrorMsg }}</p>
    </section>

</template>

<style scoped>
.creation-side-panel__header {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px;
}

.creation-side-panel {
    background-color: var(--bg-main);
    padding: 1rem 1.5rem;
    width: 100%;
    max-width: 1450px;
    height: 100dvh;
    z-index: 9999;
    position: fixed;
    top: 0;
    right: 0;
    overflow-y: scroll;
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.15);
    transform: translateX(100%);
    transition: transform .3s ease;

}

.creation-form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

.recipe-form__details {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 2rem;
}

.recipe-form__field {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    gap: .25rem;
}

.food-selector {
    width: min(100%, 32rem);
    border: 0;
}

.food-selector legend {
    margin-bottom: 0.5rem;
}

.food-selector__options {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-height: 18rem;
    overflow-y: auto;
    margin-top: 0.75rem;
    padding: 0.75rem;
    border: 3px solid var(--border-color);
    border-radius: 4px;
    background-color: var(--bg-card);
}

.food-selector__option {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.food-selector__empty {
    color: var(--text-muted);
}

.creation-side-panel__error {
    color: var(--color-error, #b42318);
}

.true {
    transform: translateX(0);
}

.false {
    transform: translateX(100%);
}

svg {
    cursor: pointer;
}
</style>