<script setup lang="ts">
import router from '@/router';
import type { Recipe } from '@/types/recipe';

const props = defineProps<{
    recipe: Recipe
}>()

const openList = () => {
    router.push("/recipes/" + props.recipe.id)
}
</script>

<template>
    <div class="card" @click="openList">
        <div class="top">
            <h6>{{ props.recipe.name }}</h6>
            <p>{{ props.recipe.servings }} servings</p>
        </div>
        <p>{{ props.recipe.foods.length }} ingredients</p>
    </div>
</template>

<style scoped>
.card {
    width: 100%;
    min-width: 0;
    padding: 5px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    gap: .25rem;
    border-radius: 4px;
    border: solid 1px var(--border-color);
    cursor: pointer;
    transition: all .2s ease;
}

.card:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.top {
    width: 100%;
    min-width: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .25rem;
}

.top p {
    font-size: .8rem;
    opacity: .7;
    flex: 0 1 auto;
    text-align: right;
}

.card h6,
.card p {
    max-width: 100%;
    overflow-wrap: anywhere;
}
</style>
