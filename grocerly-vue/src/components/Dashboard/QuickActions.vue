<script setup lang="ts">
import type { Ref } from 'vue';
import { ref } from 'vue';
import CreationSidePanel from '../shared/CreationSidePanel.vue';
const showRecipePanel: Ref<boolean> = ref(false);
const showListPanel: Ref<boolean> = ref(false);
</script>

<template>
    <article class="quickActions">
        <h3>What are we gonna cook or buy today?</h3>
        <div class="buttons">
            <!--New recipe button and side panel-->
            <button type="button" @click="showRecipePanel = true">+ New Recipe</button>
            <CreationSidePanel :show="showRecipePanel" :type="'recipe'" @close="showRecipePanel = false" />

            <!--New list button and side panel-->
            <button type="button" @click="showListPanel = true">+ New List</button>
            <CreationSidePanel :show="showListPanel" :type="'list'" @close="showListPanel = false" />
        </div>
    </article>
</template>

<style scoped>
.quickActions {
    width: 100%;
    max-width: 800px;
    padding: 15px 30px;
    background-color: var(--bg-card);
    box-shadow: var(--shadow-md);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
}

.buttons {
    width: 100%;
    padding: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}
</style>
